<?php


namespace CustomBitrix\Checkout;

use Bitrix\Catalog\ProductTable;
use Bitrix\Iblock\Elements\ElementProductTable;
use Bitrix\Main\Diag\Debug;
use Bitrix\Main\Loader;
use CustomBitrix\Tools\Cache;
use CustomBitrix\Tools\Iblock;

/**
 * Class Product - класс для определения условий работы с товаром, в зависимости от его настроек
 * @package Dupont\Entity
 */
class Product
{
    /** @var bool Активен */
    private $bActive = false;
    /** @var bool В наличии */
    private $bAvalable = false;
    /** @var array|null Массив все полей */
    private $arItem = null;
    /** @var array|null Массив коллекции */
    private $arCollection = null;
    /** @var array|null Массив цены */
    private $arPrice = null;

    protected static function getIblock() {
        return Iblock::getIdByCode('products', 'catalog');
    }

    protected static function getTags() {
        return [
            'iblock_id_'.static::getIblock(),
        ];
    }

    public function getPropsForBasket()
    {
        return Basket::fillBasketItemProp([
//            'NAME' => $this->getName(),
//            'DESC' => $this->getDescription(),
        ]);
    }

    /**
     * @param $sXmlId
     * @return Product|null
     * @throws \Bitrix\Main\ArgumentException
     * @throws \Bitrix\Main\LoaderException
     * @throws \Bitrix\Main\ObjectPropertyException
     * @throws \Bitrix\Main\SystemException
     */
    public static function initByXmlId($sXmlId){
        if (empty($sXmlId))
            return false;

        $arItem = ElementProductTable::getList([
            'select' => ['ID'],
            'filter' => [
                'XML_ID' => $sXmlId,
            ],
            'limit' => 1,
        ])->Fetch();
        return static::initById($arItem['ID']);
    }

    /**
     * @param $iId
     * @return Product|null
     * @throws \Bitrix\Main\ArgumentException
     * @throws \Bitrix\Main\LoaderException
     * @throws \Bitrix\Main\ObjectPropertyException
     * @throws \Bitrix\Main\SystemException
     */
    public static function initById($iId)
    {
        if ($iId < 1)
            return null;

        Loader::includeModule('iblock');
        Loader::includeModule('catalog');

        $rsItem = \CIBlockElement::GetById($iId)->GetNextElement();

        if (!$rsItem)
            return null;
        $arItem = $rsItem->getFields();

        if ($arItem['IBLOCK_ID'] != static::getIblock())
            return null;

        $arItem['PROPERTIES'] = $rsItem->getProperties();
        $arPrice = \CCatalogProduct::GetOptimalPrice($iId);
        $arItem['PRICE'] = $arPrice['PRICE'];

        $arCatalogProduct = ProductTable::getById($iId)->Fetch();
        $arItem['PRODUCT'] = $arCatalogProduct;

        return static::init($arItem);
    }

    /**
     * @param $arItem
     * @return Product
     */
    public static function init($arItem)
    {
        return new self ([
            'ACTIVE' => $arItem['ACTIVE'],
            'AVAILABLE' => $arItem['PRODUCT']['AVAILABLE'],
            'PRICE' => $arItem['PRICE'] ?: $arItem['PRICES']['BASE'] ?: $arItem['ITEM_PRICES'][0],
            'PRODUCT' => $arItem,
        ]);
    }

    public function __construct($arParams)
    {
        $this->bActive = $arParams['ACTIVE'] == 'Y';
        $this->bAvalable = $arParams['AVAILABLE'] == 'Y';
        $this->arPrice = $arParams['PRICE'] ?: null;
        $this->arItem = $arParams['PRODUCT'];
    }

    /**
     * @return array|null
     */
    public function getItem()
    {
        return $this->arItem;
    }

    /** Можно положить в корзину
     * @return bool
     */
    public function canBuy()
    {
        return $this->bActive && $this->bAvalable;
    }

    /** Доступно сравнение
     * @return bool
     */
    public function canCompare()
    {
        return $this->bAvalable;
    }

    /** Доступно добавление в избранное
     * @return bool
     */
    public function canDelivery()
    {
        return $this->bActive && $this->bAvalable;
    }

    /** Товар новинка
     * @return bool
     */
    public function isNew()
    {
        return false;
    }

    public function getPrice(){
        $fPrice = is_array($this->arPrice)
            ? ($this->arPrice['PRICE'] ?: $this->arPrice['VALUE'])
            : $this->arPrice;

        return $this->allowedToShowPrice() ? $fPrice : null;
    }

    public function getFormatPrice($bShowCurrency = true){
        $fPrice = $this->getPrice();
        return $this->allowedToShowPrice() && $fPrice > 0 ? Content::getFormatPrice($fPrice, $bShowCurrency) : null;
    }

    public function getName()
    {
        return $this->arItem['NAME'];
    }

    public function getDescription()
    {
        return $this->arItem['PREVIEW_TEXT'];
    }

    public function getID()
    {
        return $this->arItem['ID'];
    }
}