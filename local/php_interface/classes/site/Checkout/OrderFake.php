<?php


namespace CustomBitrix\Checkout;

class OrderFake extends OrderNew
{
    public function __construct($iUserId = null)
    {
        Basket::createAbstract();
        parent::__construct($iUserId);
        $this->setBasket(Basket::getBasket());
    }

    public function addProduct($iProductId, $iQuantity)
    {
        return Basket::addByProductById([$iProductId => $iQuantity], false, false);
    }

    public function getListAvailableDeliveries()
    {
        $arDeliveries = [];
        foreach ($this->getAvailableDeliveries() as $oDelivery) {
            // Инач Почта РФ не считает
            $this->setDeliveryByID($oDelivery->getId());
            $fPrice = $this->getDeliveryPrice($oDelivery->getId());
            $arDelivery = \Bitrix\Sale\Delivery\Services\Table::getById($oDelivery->getId())->Fetch();
            $arDeliveries[$arDelivery['XML_ID']] = [
                'ID' => $oDelivery->getId(),
                'CODE' => $arDelivery['XML_ID'],
                'NAME' => $oDelivery->getNameWithParent(),
                'DESCRIPTION' => $oDelivery->getDescription(),
                'PRICE' => $fPrice,
            ];
        }
        return $arDeliveries;
    }
}