<?php


namespace CustomBitrix\Events;
use Bitrix\Main;
use Bitrix\Sale\Order;

class EventManager
{
    public static function exec ()
    {
        $oEventManager = \Bitrix\Main\EventManager::getInstance();

        $oEventManager->addEventHandler('iblock', 'OnIBlockPropertyBuildList',
            ['\CustomBitrix\Properties\IBlockPropertyBooleanWithEmpty', 'getUserTypeDescription'], true
        );
        $oEventManager->addEventHandler('iblock', 'OnIBlockPropertyBuildList',
            ['\CustomBitrix\Properties\IBlockPropertyBoolean', 'getUserTypeDescription'], true
        );

        $oEventManager->addEventHandler('sale', 'OnSaleOrderBeforeSaved',
            [__CLASS__, 'OnSaleOrderBeforeSaved']
        );
    }

    /**
     * @param Main\Event $oEvent
     * @throws Main\ArgumentException
     * @throws Main\ArgumentNullException
     * @throws Main\ArgumentOutOfRangeException
     * @throws Main\LoaderException
     * @throws Main\NotImplementedException
     * @throws Main\ObjectPropertyException
     * @throws Main\SystemException
     */
    public static function OnSaleOrderBeforeSaved($oEvent)
    {
        /** @var Order $oOrder */
        $oOrder = $oEvent->getParameter("ENTITY");
        $oDeliviry = \CustomBitrix\Tools\Order::getCurrentShipment($oOrder);

        // Дописывание типа поссылки
        if (is_object($oDeliviry) && get_class($oDeliviry->getDelivery()) === 'Sale\Handlers\Delivery\ElonsoftpostProfile'){
            \Bitrix\Main\Loader::includeModule('russianpost.post');
            $oCollectionProps = $oOrder->getPropertyCollection();
            $oRequest = new \Elonsoft\Post\Request();
            $arAddress = $oCollectionProps->getAddress()->getFieldValues();
            $arZip = $oCollectionProps->getDeliveryLocationZip()->getFieldValues();

            $arResult = $oRequest->PickUpCalculate([
                'ADDRESS' => $arAddress['VALUE'],
                'ZIP' => $arZip['VALUE'],
                'PRICE' => $oOrder->getBasket()->getPrice(),
                'WEIGHT' => $oOrder->getBasket()->getWeight(),
            ]);
            if (is_array($arResult)){
                $sType = array_shift($arResult)['shipment_type'];
                if ($sType){
                    foreach ($oCollectionProps as $oProp) {
                        $sCode = $oProp->getField('CODE');
                        switch ($sCode) {
                            case 'RUSSIANPOST_TYPEDLV':
                                $oProp->setValue($sType);
                                break;
                        }
                    }
                }
            }
        }
    }
}