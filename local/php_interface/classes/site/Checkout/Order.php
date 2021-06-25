<?php
namespace CustomBitrix\Checkout;

use Bitrix\Currency\CurrencyManager;
use Bitrix\Iblock\ElementTable;
use Bitrix\Main\Context;
use Bitrix\Main\Diag\Debug;
use Bitrix\Main\Loader;
use Bitrix\Sale;
use CustomBitrix\AX\Response;
use CustomBitrix\Constant\Catalog;
use CustomBitrix\Entity\Product;
use CustomBitrix\Logger;
use CustomBitrix\Tools\Shop;


class Order
{
    /**
     * @var Sale\Order $oOrder объект заказа
     */
    private $oOrder = null;

    /**
     * @return Sale\Order
     */
    public function getOrder()
    {
        return $this->oOrder;
    }

    /**
     * @param Sale\Order $oOrder
     * @return array
     */
    public static function getProperties($oOrder)
    {
        $arProps = [];
        /** @var Sale\PropertyValue $oProperty */
        foreach ($oOrder->getPropertyCollection() as $oProperty){
            $arProps[$oProperty->getField('CODE')] = $oProperty->getFieldValues();
        }
        return $arProps;
    }

    public function getPropertiesList()
    {
        return static::getProperties($this->oOrder);
    }

//    public function canceledOrder()
//    {
//        $this->setStatus('25');
//    }
//
//    public static function statusComparison($sStatusId)
//    {
//        switch ($sStatusId){
//            case '0': // Ожидает звонка оператора
//                return 'N';
//            case '5': // Ожидает оплаты
//                return 'AP';
//            case '10': // Оплачен, доставляется в бутик
//                return 'P';
//            case '12': // Оплачен, комплектуется
//                return 'PC';
//            case '15': // Доставлен в бутик
//                return 'DB';
//            case '17': // Оплачен, передан курьеру
//                return 'PD';
//            case '20': // Выкуплен
//                return 'PU';
//            case '25': // Отменен
//                return 'C';
//            case '30': // Завершен
//                return 'F';
//            case '40': // Доставлен
//                return 'DO';
//            case '50': // Отказ
//                return 'RF';
//            case '99': // Ожидает оплаты, срок ссылки истек
//                return 'AE';
//        }
//    }

    /**
    1.	Ожидает звонка оператора – значение 0 => сайтом отправлен JSON-запрос onlineOrder.
    2.	Ожидает оплаты – значение 5 => сайтом получен JSON-запрос, в котором имеется атрибут «Статус заказа» со значением 5.
    3.	Оплачен, доставляется в бутик – значение 10 => сайтом получен JSON-запрос, в котором должен быть атрибут «Статус заказа» со значением 10.
    4.	Доставлен в бутик – значение 15 => сайтом получен JSON-запрос, в котором должен быть атрибут «Статус заказа» со значением 15.
    5.	Выкуплен – значение 20 => сайтом получен JSON-запрос, в котором должен быть атрибут «Статус заказа» со значением 20.
    6.	Отменен – значение 25 => сайтом получен JSON-запрос, в котором должен быть атрибут «Статус заказа» со значением 25 . Статус присваивается заказу двумя вариантами:
    посредством присланного из нашей уч.системы JSON-запроса  со значением 25.
    на основании кнопки на сайте «Отменить», при нажатии на которую Заказу присваивается статус «Отменен».
    7.	Завершен – значение 30 => сайтом получен JSON-запрос, в котором должен быть атрибут «Статус заказа» со значением 30.
     * @param $sNewStatus
     * @throws \Bitrix\Main\ArgumentException
     * @throws \Bitrix\Main\ArgumentNullException
     * @throws \Bitrix\Main\ArgumentOutOfRangeException
     * @throws \Bitrix\Main\NotSupportedException
     */
//    public function setStatus($sNewStatus)
//    {
//        $sStatusId = static::statusComparison($sNewStatus);
//        switch ($sStatusId){
//            case 'N': // Ожидает звонка оператора
//            case 'AP': // Ожидает оплаты
//            case 'P':  // Оплачен, доставляется в бутик
//            case 'PC': // Оплачен, комплектуется
//            case 'DB': // Доставлен в бутик
//            case 'PD': // Оплачен, передан курьеру
//            case 'PU': // Выкуплен
//            case 'DO': // Доставлен
//            case 'AE': // Ожидает оплаты, срок ссылки истек
//                break;
//            case 'RF': // Отказ
//            case 'F':  // Завершен
//                break;
//            case 'C': // Отменен
//                $this->oOrder->setFields('CANCELED', 'Y');
//                break;
//            default:
//                throw new \Exception('Неизвестный статус: '.$sNewStatus);
//
//        }
//        $this->oOrder->setFields('STATUS_ID', $sStatusId);
//        $oResult = $this->oOrder->save();
//        if (!$oResult->isSuccess()){
//            throw new \Exception($oResult->getErrorMessages());
//        }
//        $oResult = $this->oOrder->save();
//        if (!$oResult->isSuccess()){
//            throw new \Exception($oResult->getErrorMessages());
//        }
//    }

    /**
     * @return bool
     */
//    public function paymentAvailable()
//    {
//        return $this->oOrder->getField('STATUS_ID') == 'AP' && !$this->linkExpired();
//    }
//
//    public function linkExpired()
//    {
//        $arProps = $this->getPropertiesList();
//        $sDateTime = $arProps['LINK_EXPIRY']['VALUE'];
//        if (empty($sDateTime))
//            return true;
//        $iTimeStamp = \MakeTimeStamp($sDateTime, 'DD.MM.YYYY HH:MI:SS');
//        return $iTimeStamp < time();
//    }

    /**
     * @return bool
     */
//    public function cancellationAvailable()
//    {
//        switch ($this->oOrder->getField('STATUS_ID')){
//            case 'N':
//                return true;
//            case 'AP':
//                return $this->linkExpired();
//            default:
//                return false;
//        }
//    }

    /**
     * Order constructor.
     * @param int | $iUser
     * @param null|int|string $mId
     * @param bool $bThrowError
     *
     * @throws \Bitrix\Main\ArgumentException
     * @throws \Bitrix\Main\ArgumentNullException
     * @throws \Bitrix\Main\ArgumentOutOfRangeException
     * @throws \Bitrix\Main\LoaderException
     * @throws \Bitrix\Main\NotImplementedException
     * @throws \Bitrix\Main\ObjectException
     */
    public function __construct($iUser, $mId = null, $bThrowError = true)
    {
        Loader::includeModule('sale');

        global $USER;
        if ($mId){
            $oOrder = preg_match('#^(\d+)$#', $mId)
                ? Sale\Order::load($mId)
                : Sale\Order::loadByAccountNumber($mId);
            if (!$oOrder){
                if ($bThrowError)
                 throw new \Exception("Заказ {$mId} не найден");
                else
                    return false;
            }

            if (!!$iUser && $oOrder->getUserId() != $iUser){
                if ($bThrowError)
                    throw new \Exception( "Заказ с номером {$mId} не пренадлежит пользователю {$iUser}");
                else
                    return false;
            }
        } else {
            $oOrder = Sale\Order::create(SITE_ID, $iUser);
        }
        $this->oOrder = $oOrder;
    }

    /**
     * Были ли в заказе товары из огр.серии
     * @return bool
     * @throws \Bitrix\Main\ArgumentException
     * @throws \Bitrix\Main\ArgumentNullException
     * @throws \Bitrix\Main\ArgumentTypeException
     * @throws \Bitrix\Main\LoaderException
     * @throws \Bitrix\Main\NotImplementedException
     * @throws \Bitrix\Main\ObjectNotFoundException
     */
//    public function hasLimitedItems()
//    {
//        $oBasket = $this->oOrder->getBasket();
//
//        Basket::setBasket($oBasket);
//
//        return Basket::hasLimitedEditionItems();
//    }

    public function isExternal()
    {
        return $this->oOrder->getField('EXTERNAL_ORDER') == 'Y';
    }

//    public function isFastOrder()
//    {
//        return $this->getProperty('IS_FAST_ORDER') == 'Y';
//    }

    public function getProperty($sProp)
    {
        $arProps = $this->getPropertiesList();
        return $arProps[$sProp]['VALUE'];
    }

//    public function getDeliveryInfo() {
//        $arInfo = [];
//        /** @var Sale\Shipment $oShipment */
//        $oShipment = \CustomBitrix\Tools\Order::getCurrentShipment($this->oOrder);
//
//        switch(get_class($oShipment->getDelivery())) {
//            case 'Sale\Handlers\Delivery\PickupHandler':
//                $sBoutique = $this->getProperty('BOUTIQUE');
//                $arBoutique = Shop::getStoreByName($sBoutique);
//                $arInfo['CITY'] = Shop::getCityByStoreName($sBoutique) ?: $this->getProperty('CITY');
//                $arInfo['BOUTIQUE'] = $arBoutique['NAME'] ?: $sBoutique;
//                $arInfo['ADDRESS'] = $arBoutique['PROPERTIES']['ADDRESS']['VALUE'] ?: '';
//                $arInfo['PHONE'] = $arBoutique['PROPERTIES']['PHONE']['VALUE'] ? 'Т: '.implode(', ', $arBoutique['PROPERTIES']['PHONE']['VALUE']) : '';
//
//                $arInfo['ADDRESS_FORMAT'] = implode('', array_map(function($el) { return "<p>{$el}</p>"; }, array_diff([
//                    $arInfo['BOUTIQUE'],
//                    $arInfo['CITY'],
//                    $arInfo['ADDRESS'],
//                    $arInfo['PHONE'],
//                ], [''])));
//
//                break;
//            case 'Sale\Handlers\Delivery\CustomBitrixHandler':
//                $arInfo['CITY'] = $this->getProperty('CITY');
//                $arInfo['ADDRESS'] = implode(', ', array_diff([
//                    $this->getProperty('STREET'),
//                    $this->getProperty('HOUSE') ? 'д. '.$this->getProperty('HOUSE') : '',
//                    $this->getProperty('FLAT') ? 'кв./офис '.$this->getProperty('FLAT') : '',
//                ], ['']));
//
//                $arInfo['ADDRESS_FORMAT'] = implode('', array_map(function($el) { return "<p>{$el}</p>"; }, array_diff([
//                    $arInfo['CITY'],
//                    $arInfo['ADDRESS'],
//                    $arInfo['PHONE'],
//                ], [''])));
//                break;
//        }
//        $arInfo['DATE'] = $this->getProperty('DELIVERY_DATE');
//        $arInfo['TIME'] = $this->getProperty('DELIVERY_TIME');
//        return $arInfo;
//    }

//    public function getRecipientFullName() {
//        return implode(' ', array_diff([
//            $this->getProperty('RECEIVER_NAME'),
//            $this->getProperty('RECEIVER_LAST_NAME'),
//        ], [''])) ?:
//            implode(' ', array_diff([
//            $this->getProperty('NAME'),
//            $this->getProperty('LAST_NAME'),
//        ], ['']));
//    }

    public function getOrderNum()
    {
        return $this->oOrder ? $this->oOrder->getField('ACCOUNT_NUMBER') : null;
    }

    /**
     * Доступна мгновенная оплата, без сбора паспортных данных
     */
//    public function instantPaymentAvailable()
//    {
//        return $this->getProperty('REQUEST_PASSPORT_DATA') == 'N';
//    }

//    public function getPayLinkSite($iUserId){
//        if (!$iUserId){
//            $iUserId = $this->oOrder->getUserId();
//        }
//        $iOrderId = $this->oOrder->getField('ACCOUNT_NUMBER');
//        return /*$this->instantPaymentAvailable()
//            ? $this->getPayLinkAx()
//            :*/ "/personal/order/{$iUserId}/pay/{$iOrderId}/";
//    }
//
//    public function getPayLinkAx()
//    {
//        $arProps = $this->getPropertiesList();
//        return $arProps['PAY_LINK']['VALUE'];
//    }

//    public static function createOrderFromAX($iUser, $sOrderId)
//    {
//        $oOrder = new static($iUser);
//        $oOrder->getOrder()->setField('ACCOUNT_NUMBER', $sOrderId);
//        return $oOrder;
//    }

    /**
     * @param Sale\Order $oOrder
     * @return Order
     * @throws \Bitrix\Main\ArgumentException
     * @throws \Bitrix\Main\ArgumentNullException
     * @throws \Bitrix\Main\ArgumentOutOfRangeException
     * @throws \Bitrix\Main\LoaderException
     * @throws \Bitrix\Main\NotImplementedException
     * @throws \Bitrix\Main\ObjectException
     */
    public static function createByOrder($oOrder)
    {
        $oOrder = new static($oOrder->getUserId(), $oOrder->getId());

        return $oOrder;
    }

    public function upgradeByUser($iUserId)
    {
        $arUser = CUser::getByID($iUserId->Fetch());
        $oPropCollection = $this->oOrder->getPropertyCollection();
        $arOrderProps = $this->getPropertiesList();
        foreach ([
                     'NAME' => 'NAME',
                     'LAST_NAME' => 'LAST_NAME',
                     'PERSONAL_PHONE' => 'PERSONAL_PHONE',
                 ] as $sUserFieldName => $sOrderFieldName){

            $oField = $oPropCollection->getItemByOrderPropertyId($arOrderProps[$sOrderFieldName]['ORDER_PROPS_ID']);
            if ($oField)
                $oField->setField('VALUE', $arUser[$sUserFieldName]);
        }
    }

    private function setPropertyValue($sCode, $mValue)
    {
        $arOrderProps = $this->getPropertiesList();
        $oPropCollection = $this->oOrder->getPropertyCollection();

        $oProp = $oPropCollection->getItemByOrderPropertyId($arOrderProps[$sCode]['ORDER_PROPS_ID']);
        if ($oProp){
            $oProp->setField('VALUE', $mValue);
            return true;
        }

        return false;
    }

    /**
     * @param Sale\Basket $oBasket
     * @throws \Bitrix\Main\ArgumentException
     * @throws \Bitrix\Main\ArgumentNullException
     * @throws \Bitrix\Main\ArgumentOutOfRangeException
     * @throws \Bitrix\Main\NotSupportedException
     * @throws \Bitrix\Main\ObjectNotFoundException
     */
    public function setBasket($oBasket)
    {
        $this->oOrder->setBasket($oBasket);
    }

    /**
     * @param string $sDeliveryCode
     * @throws \Bitrix\Main\ArgumentException
     * @throws \Bitrix\Main\ArgumentNullException
     * @throws \Bitrix\Main\ArgumentOutOfRangeException
     * @throws \Bitrix\Main\ArgumentTypeException
     * @throws \Bitrix\Main\NotSupportedException
     * @throws \Bitrix\Main\ObjectNotFoundException
     * @throws \Bitrix\Main\SystemException
     */
    public function setDelivery($sDeliveryCode)
    {
        $oShipmentCollection = $this->oOrder->getShipmentCollection();
        $oShipment = $oShipmentCollection->createItem(
            Sale\Delivery\Services\Manager::getObjectByCode($sDeliveryCode)
        );
        $oShipmentItemCollection = $oShipment->getShipmentItemCollection();

        /**
         * @var Sale\BasketItem $oBasketItem
         */
        foreach ($this->oOrder->getBasket() as $oBasketItem){
            $oItem = $oShipmentItemCollection->createItem($oBasketItem);
            $oItem->setQuantity($oBasketItem->getQuantity());
        }
    }

    /**
     * @param string $sPaymentCode
     * @throws \Bitrix\Main\ArgumentOutOfRangeException
     * @throws \Bitrix\Main\NotImplementedException
     */
    public function setPayment($sPaymentCode)
    {
        $oPaymentCollection = $this->oOrder->getPaymentCollection();
        $oPayment = $oPaymentCollection->createItem(
            Sale\PaySystem\Manager::getByCode($sPaymentCode)
        );
        $oPayment->setField('SUM', $this->oOrder->getPrice());
        $oPayment->setField('CURRENCY', $this->oOrder->getCurrency());
    }

    /**
     * @return bool
     * @throws \Bitrix\Main\ArgumentException
     * @throws \Bitrix\Main\ArgumentNullException
     * @throws \Bitrix\Main\ArgumentOutOfRangeException
     */
    public function saveOrder()
    {
        $oResult = $this->oOrder->save();
        if (!$oResult->isSuccess()){
            throw new \Exception($oResult->getErrorMessages());
        }
        return true;
    }
}