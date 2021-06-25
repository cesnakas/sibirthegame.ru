<?php

namespace CustomBitrix\Tools;

use Bitrix\Main;
use Bitrix\Main\Context;
use Bitrix\Main\Diag\Debug;
use Bitrix\Sale;
use CustomBitrix\Tools;

Main\Loader::includeModule('sale');

class Order
{
    /**
     * Инициализация доставки на корзине
     *
     * @param Sale\Order $oOrder
     * @return Sale\Shipment
     * @throws Main\ArgumentException
     * @throws Main\ArgumentNullException
     * @throws Main\ArgumentOutOfRangeException
     * @throws Main\ArgumentTypeException
     * @throws Main\NotSupportedException
     * @throws Main\ObjectNotFoundException
     */
    public static function initShipment(Sale\Order $oOrder)
    {
        $shipmentCollection = $oOrder->getShipmentCollection();
        $shipment = $shipmentCollection->createItem();
        $shipmentItemCollection = $shipment->getShipmentItemCollection();
        $shipment->setField('CURRENCY', $oOrder->getCurrency());

        /** @var Sale\BasketItem $oBasketItem */
        foreach ($oOrder->getBasket() as $oBasketItem)
        {
            /** @var Sale\ShipmentItem $shipmentItem */
            $shipmentItem = $shipmentItemCollection->createItem($oBasketItem);
            $shipmentItem->setQuantity($oBasketItem->getQuantity());
        }

        return $shipment;
    }

    /**
     * @param Sale\Order $oOrder
     * @return Sale\Payment
     * @throws Main\ArgumentOutOfRangeException
     * @throws Main\NotImplementedException
     */
    public static function initPayment(Sale\Order $oOrder)
    {
        $oPaymentCollection = $oOrder->getPaymentCollection();
        $oPayment = $oPaymentCollection->createItem();
        $oPayment->setField('SUM', $oOrder->getPrice());
        return $oPayment;
    }



    /** Получение текущей доставки
     * @param Sale\Order $oOrder
     * @return Sale\Shipment|null
     * @throws Main\ArgumentException
     * @throws Main\ArgumentNullException
     */
    public static function getCurrentShipment(Sale\Order $oOrder)
    {
        /** @var Sale\Shipment $oShipment */
        foreach ($oOrder->getShipmentCollection() as $oShipment)
        {
            if (!$oShipment->isSystem())
                return $oShipment;
        }

        return null;
    }

    /**
     * @param Sale\Order $oOrder
     * @return Sale\Payment|mixed|null
     */
    public static function getCurrentPayment(Sale\Order $oOrder)
    {
        /** @var Sale\Payment $oPayment */
        foreach ($oOrder->getPaymentCollection() as $oPayment)
        {
            return $oPayment;
        }

        return null;
    }

    /** Значения свойств заказа
     * @param Sale\Order $oOrder
     * @return array
     * @throws Main\ArgumentException
     * @throws Main\NotImplementedException
     */
    public static function getPropertiesValues(Sale\Order $oOrder)
    {
        $arProps = [];
        /** @var Sale\PropertyValue $oProperty */
        foreach ($oOrder->getPropertyCollection() as $oProperty){
            $arProps[$oProperty->getField('CODE')] = $oProperty->getFieldValues();
        }
        return $arProps;
    }

    public static function getPropertiesByOrder(Sale\Order $oOrder)
    {
        return $oOrder->getPropertyCollection()->getArray();
    }

    /** Получение свойст, привязанных к доставки или платежной системе
     * @param Sale\Order $oOrder
     * @return array
     * @throws Main\ArgumentException
     * @throws Main\ArgumentNullException
     * @throws Main\ObjectPropertyException
     * @throws Main\SystemException
     */
    public static function getRelatedPropertiesByOrder(Sale\Order $oOrder)
    {
        $oPayment = static::getCurrentPayment($oOrder);
        $oShipment = static::getCurrentShipment($oOrder);
        $iPayment = $oPayment->getId();
        $iShipment = $oShipment->getId();

        return static::getRelatedProperties($iShipment, $iPayment);
    }

    /** Получение свойст, привязанных к доставки или платежной системе
     *
     * @param int $iShipment
     * @param int $iPayment
     * @return array
     * @throws Main\ArgumentException
     * @throws Main\ObjectPropertyException
     * @throws Main\SystemException
     */
    public static function getRelatedProperties($iShipment = 0, $iPayment = 0)
    {
        $arProps = $arPropsIds = [];

        $iShipment = $iShipment > 0 ? $iShipment : 0;
        $iPayment = $iPayment > 0 ? $iPayment : 0;
        if (!$iPayment && !$iShipment)
            return $arProps;

        $arQuery = [
            'select' => ['ID'],
            'filter' => [],
            'runtime' => [],
            'group' => ['ID'],
            'order' => ['ID' => 'DESC'],
        ];

        if ($iPayment){
            $arQuery['filter']['REL_PS.ENTITY_ID'] = $iPayment;
            $arQuery['runtime'][] = new Main\Entity\ReferenceField(
                'REL_PS',
                '\Bitrix\Sale\Internals\OrderPropsRelationTable',
                ['=ref.PROPERTY_ID' => 'this.ID', '=ref.ENTITY_TYPE' => new \Bitrix\Main\DB\SqlExpression('?', 'P')],
                ['join_type' => 'left']
            );
        }
        if ($iShipment){
            $arQuery['filter']['REL_DLV.ENTITY_ID'] = $iShipment;
            $arQuery['runtime'][] = new Main\Entity\ReferenceField(
                'REL_DLV',
                '\Bitrix\Sale\Internals\OrderPropsRelationTable',
                ['=ref.PROPERTY_ID' => 'this.ID', '=ref.ENTITY_TYPE' => new \Bitrix\Main\DB\SqlExpression('?', 'D')],
                ['join_type' => 'left']
            );
        }

        $rsProps = Sale\Property::getList($arQuery);

        while($arProp = $rsProps->fetch()){
            $arPropsIds[] = $arProp['ID'];
        }

        return $arPropsIds;
    }

    public static function getProperiesList()
    {
        $arAllProps = [];

        $rsProps = \CSaleOrderProps::GetList();

        while($arProp = $rsProps->Fetch()){
            $arAllProps[(string) $arProp['ID']] = $arProp;
        }

        return $arAllProps;
    }

    /**
     * @param Sale\Order $oOrder
     * @param $iDeliveryId
     * @throws Main\ArgumentException
     * @throws Main\ArgumentNullException
     * @throws Main\ArgumentOutOfRangeException
     * @throws Main\ArgumentTypeException
     * @throws Main\NotSupportedException
     * @throws Main\ObjectNotFoundException
     * @throws Main\SystemException
     */
    public static function setShipment(Sale\Order $oOrder, $iDeliveryId)
    {
        /** @var Sale\ShipmentCollection $oCollection */
        $oCollection = $oOrder->getShipmentCollection();
        $oService = Sale\Delivery\Services\Manager::getObjectById($iDeliveryId);
        $oShipment = Tools\Order::getCurrentShipment($oOrder);

        if ($oShipment){
            $oShipment->setFields([
                'DELIVERY_ID' => $oService->getId(),
                'DELIVERY_NAME' => $oService->getName(),
            ]);
        } else {
            /** @var Sale\Shipment $oShipment */
            $oShipment = $oCollection->createItem($oService);

            $oItemCollection = $oShipment->getShipmentItemCollection();

            foreach ($oOrder->getBasket() as $oBasketItem){
                $oItem = $oItemCollection->createItem($oBasketItem);
                $oItem->setQuantity($oBasketItem->getQuantity());
            }
        }
    }

    /**
     * @param Sale\Order $oOrder
     * @param $iPaymentId
     * @throws Main\ArgumentOutOfRangeException
     * @throws Main\NotImplementedException
     */
    public static function setPayment(Sale\Order $oOrder, $iPaymentId)
    {
        /** @var Sale\PaymentCollection $oCollection */
        $oCollection = $oOrder->getPaymentCollection();
        $oService = Sale\PaySystem\Manager::getObjectById($iPaymentId);
        $oPayment = $oCollection->createItem($oService);

        $oPayment->setField('SUM', $oOrder->getPrice());
        $oPayment->setField('CURRENCY', $oOrder->getCurrency());
    }

    /**
     * @param Sale\Order $oOrder
     * @return array|null
     */
    public static function fillMailFields(Sale\Order $oOrder)
    {
        $arProps = [];
        try {

            foreach($oOrder->getPropertyCollection()->getArray()['properties'] as $arProp) {
                $value = is_array($arProp['VALUE']) ? current($arProp['VALUE']) : $arProp['VALUE'];
                $arProps[$arProp['CODE']] = $value;
            }
        } catch (\Exception $e) {
            Debug::writeToFile($e, date('H:i:s'), 'local/logs/error_send_mail_'.date('Y-m-d').'.log');
            return null;
        }
        $arPhone = Tools\Iblock::getElement([
            'FILTER' => ['IBLOCK_ID' => Tools\Iblock::getIdByCode('values', 'ref'), 'ACTIVE' => 'Y', 'CODE' => 'phone',],
            'SELECT' => ['ID', 'NAME', 'IBLOCK_ID', 'PREVIEW_PICTURE', 'PREVIEW_TEXT', 'CODE',],
        ]);

        $arFields = [
            'EMAIL' => $arProps['EMAIL'],
            'NAME' => $arProps['NAME'],
            'ORDER_ID' => $oOrder->getId(),
            'CONTACTS' => implode(', ', $arPhone['PROPERTIES']['VALUES']['VALUE']),
        ];

        return $arFields;
    }
}