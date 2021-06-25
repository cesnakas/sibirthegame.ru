<?php

namespace CustomBitrix\Checkout;

use Bitrix\Main;
use Bitrix\Main\Context;
use Bitrix\Sale;
use CustomBitrix\Tools;
use Bitrix\Sale\Location;

class OrderNew
{
    /** @var string|null */
    protected $sSite = null;
    /** @var Sale\Order|null */
    protected $oOrder = null;
    /** @var Sale\Basket|null */
    protected $oBasket = null;
    /** @var int|null ид пользователя */
    protected $iUser = null;
    /** @var int|null ид профиля */
    protected $iProfile = null;
    /** @var null|array массив всех доступных доставок */
    protected $arDeliveryServiceAll  = null;
    /** @var null|array маассив всех доступных платежных систем */
    protected $arPaymentsServiceAll  = null;

    public function __construct($iUserId = null)
    {
        Main\Loader::includeModule('sale');

        $this->setUserId($iUserId);
        $this->sSite = Context::getCurrent()->getSite();
        $this->oOrder = Sale\Order::create($this->sSite, $this->getUserId());
    }

    public function getOrder()
    {
        return $this->oOrder;
    }

    public function getUserId()
    {
        return $this->iUser;
    }

    private function setUserId($iUserId)
    {
        global $USER;

        if($iUserId){
            if(!\CUser::GetByID($iUserId)->fetch()) {
                throw new \Exception("Пользователь {$iUserId} не найден");
            }
            $this->iUser = $iUserId;
        } else {
            $this->iUser = $USER->GetID() ?: \CSaleUser::GetAnonymousUserID();
        }
    }

    /** Получение последнего профиля пользователя
     * @return int|null
     */
    public function getProfileId()
    {
        $rsProfiles = \CSaleOrderUserProps::GetList(
            ['DATE_UPDATE' => 'DESC'],
            ['USER_ID' => $this->oOrder->getUserId()]
        );
        if ($arUserProfile = $rsProfiles->GetNext())
        {
            return $arUserProfile['ID'];
        }
        return null;
    }

    /** Получаем список профилей пользователя
     * @return array|null
     */
    public function getProfile(){
        if(!$this->iProfile){
            $iProfileId = $this->getProfileID();
            $this->iProfile = Sale\OrderUserProperties::getProfileValues($iProfileId);
        }
        return $this->iProfile;
    }

    /**
     * Установка корзины пользователя
     *
     * @throws Main\ArgumentException
     * @throws Main\ArgumentNullException
     * @throws Main\ArgumentOutOfRangeException
     * @throws Main\ArgumentTypeException
     * @throws Main\NotImplementedException
     * @throws Main\NotSupportedException
     * @throws Main\ObjectNotFoundException
     */
    protected function setCurrentBasket(){
        if(!$this->oBasket){
            $this->setBasket(Sale\Basket::loadItemsForFUser(\CSaleBasket::GetBasketUserID(), $this->sSite)->getOrderableItems());
        }
    }

    /**
     * @return Sale\Basket|null
     * @throws Main\ArgumentException
     * @throws Main\ArgumentNullException
     * @throws Main\ArgumentOutOfRangeException
     * @throws Main\ArgumentTypeException
     * @throws Main\NotImplementedException
     * @throws Main\NotSupportedException
     * @throws Main\ObjectNotFoundException
     */
    public function getBasket()
    {
        if (!$this->oBasket && !$this->oOrder->getBasket())
            $this->setCurrentBasket();

        return $this->oBasket;
    }

    /**
     * @param Sale\Basket $oBasket
     * @throws Main\ArgumentException
     * @throws Main\ArgumentNullException
     * @throws Main\ArgumentOutOfRangeException
     * @throws Main\NotSupportedException
     * @throws Main\ObjectNotFoundException
     */
    public function setBasket(Sale\Basket $oBasket)
    {
        $this->oBasket = $oBasket;
        $this->oOrder->setBasket($this->oBasket);
    }

    /** Применение профиля к заказу
     * @throws Main\ArgumentException
     * @throws Main\ArgumentOutOfRangeException
     * @throws Main\NotImplementedException
     */
    protected function setProfileToOrder(){
        $iProfile = $this->getProfile();
        $propertyCollection = $this->oOrder->getPropertyCollection();
        $propertyCollection->setValuesFromPost(array('PROPERTIES' => $iProfile), array()); //Устанавливает значения данного профиля в заказ
    }

    /** Инициализация доставки
     *
     * @throws Main\ArgumentException
     * @throws Main\ArgumentNullException
     * @throws Main\ArgumentOutOfRangeException
     * @throws Main\ArgumentTypeException
     * @throws Main\NotSupportedException
     * @throws Main\ObjectNotFoundException
     */
    protected function setDefaultShipmentToOrder(){
        Tools\Order::initShipment($this->oOrder);
    }

    /**
     * @throws Main\ArgumentOutOfRangeException
     * @throws Main\NotImplementedException
     */
    protected function setDefaultPaymentToOrder(){
        Tools\Order::initPayment($this->oOrder);
    }

    function init($arParams = []){
        $this->setProfileToOrder();
        $this->setCurrentBasket();
    }
    
    /** Получение списка доставок
     *
     * @return Sale\Delivery\Services\Base[]|null
     * @throws Main\ArgumentException
     * @throws Main\ArgumentNullException
     * @throws Main\ArgumentOutOfRangeException
     * @throws Main\ArgumentTypeException
     * @throws Main\NotSupportedException
     * @throws Main\ObjectNotFoundException
     * @throws Main\SystemException
     */
    public function getAvailableDeliveries(){
        if(!$this->arDeliveryServiceAll){
            $this->setDefaultShipmentToOrder();
            $oCurrentShipment = Tools\Order::getCurrentShipment($this->oOrder);
            $this->arDeliveryServiceAll = Sale\Delivery\Services\Manager::getRestrictedObjectsList($oCurrentShipment);
        }
        return $this->arDeliveryServiceAll;
    }

    public function getAvailablePayments()
    {
        if(!$this->arPaymentsServiceAll){
            $this->setDefaultPaymentToOrder();
            $oCurrentPayment = Tools\Order::getCurrentPayment($this->oOrder);
            $this->arPaymentsServiceAll = Sale\PaySystem\Manager::getListWithRestrictions($oCurrentPayment);
        }
        return $this->arPaymentsServiceAll;
    }

    /**
     * @param $iDeliveryId
     * @throws Main\ArgumentException
     * @throws Main\ArgumentNullException
     * @throws Main\ArgumentOutOfRangeException
     * @throws Main\ArgumentTypeException
     * @throws Main\NotSupportedException
     * @throws Main\ObjectNotFoundException
     * @throws Main\SystemException
     */
    public function setDeliveryByID($iDeliveryId)
    {
        $this->arDeliveryServiceAll = null;
        Tools\Order::setShipment($this->oOrder, $iDeliveryId);
    }

    public function setPaymentByID($iPaymentId)
    {
        $this->arPaymentsServiceAll = null;
        Tools\Order::setPayment($this->oOrder, $iPaymentId);
    }

    public function getDeliveryPrice($iDeliveryId)
    {
        if (empty($iDeliveryId))
            return null;

        $oCurrentShipment = Tools\Order::getCurrentShipment($this->oOrder);
        $oService = Sale\Delivery\Services\Manager::getObjectById($iDeliveryId);

        if (!$oService){
            return null;
        }
        /** @var Sale\Delivery\CalculationResult $oCacl */
        $oCacl = Sale\Delivery\Services\Manager::calculateDeliveryPrice($oCurrentShipment, $iDeliveryId, []);
        return $oCacl->getDeliveryPrice();
    }

    public function getAvailableProperties($bGroup = true)
    {
        $arResult = Tools\Order::getPropertiesByOrder($this->oOrder);
        if ($bGroup){
            $arGroups = [];
            foreach ($arResult['groups'] as $arGroup){
                $arGroup['ITEMS'] = [];
                $arGroups[$arGroup['ID']] = $arGroup;
            }
            foreach ($arResult['properties'] as $arProp){
                if ($arProp['UTIL'] == 'Y') continue;
                $arGroups[$arProp['PROPS_GROUP_ID']]['ITEMS'][$arProp['CODE']] = $arProp;
            }
            return $arGroups;
        } else {
            $arProps = [];
            foreach ($arResult['properties'] as $arProp){
                if ($arProp['UTIL'] == 'Y') continue;
                $arProps[$arProp['CODE']] = $arProp;
            }
            return $arProps;
        }
    }

    protected function getLocationByZip($sDeliveryZip)
    {
        return $sDeliveryZip ? Location\ExternalTable::getList(array(
            'filter' => array(
                '=LOCATION.NAME.LANGUAGE_ID' => LANGUAGE_ID,
                [
                    'LOGIC' => 'OR',
                    ['=XML_ID' => $sDeliveryZip, '=SERVICE.CODE' => 'ZIP',],
                    ['=XML_ID' => $sDeliveryZip, '=SERVICE.CODE' => 'ZIP_LOWER',],
                ]
            ),
            'select' => array('LOCATION_ID', 'LOCATION_CODE' => 'LOCATION.CODE', 'LOCATION_NAME' => 'LOCATION.NAME.NAME'),
        ))->Fetch() : null;
    }

    protected function getLocationByName($sDeliveryCity)
    {
        return $sDeliveryCity ? Location\LocationTable::getList(array(
            'select' => ['LOCATION_ID' => 'ID', 'LOCATION_NAME' => 'NAME.NAME', 'LOCATION_CODE' => 'CODE',],
            'filter' => [
                '=NAME.LANGUAGE_ID' => LANGUAGE_ID,
                '=NAME.NAME' => $sDeliveryCity,
            ],
        ))->Fetch() : null;
    }

    public function setLocation($sCity = '', $iZip = '')
    {
        $arLoc = $this->getLocationByZip($iZip) ?: $this->getLocationByName($sCity);

        foreach ($this->oOrder->getPropertyCollection() as $oProp) {
            $sCode = $oProp->getField('CODE');
            switch ($sCode) {
                case 'LOCATION':
                    $oProp->setValue($arLoc['LOCATION_CODE']);
                    break;
                case 'ZIP':
                    $oProp->setValue($iZip);
                    break;
            }
        }
    }
}