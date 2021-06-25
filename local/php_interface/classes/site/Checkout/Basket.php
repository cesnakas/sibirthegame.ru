<?php


namespace CustomBitrix\Checkout;

use Bitrix\Main;
use Bitrix\Main\Context;
use Bitrix\Main\Diag\Debug;
use Bitrix\Main\Loader;
use Bitrix\Sale;
use CIBlockElement;
use CustomBitrix\Constant\Catalog;
use CustomBitrix\Tools\File;
use Exception;
use Bitrix\Currency\CurrencyManager;

class Basket
{

//    const MAX_SUM_ITEMS = 10;

    /** @var Sale\Basket  */
    protected static $oBasket = null;

    /**
     * @param null $oBasket
     */
    public static function setBasket(Sale\Basket $oBasket)
    {
        self::$oBasket = $oBasket;
    }

    /**
     * @return Sale\Basket|Sale\BasketBase
     * @throws Main\ArgumentException
     * @throws Main\ArgumentTypeException
     * @throws Main\LoaderException
     * @throws Main\NotImplementedException
     */
    public static function getBasket()
    {
        if (!self::$oBasket){
            self::$oBasket = static::getDefaultBasket();
        }
        return self::$oBasket;
    }

    public static function getDefaultBasket()
    {
        Loader::includeModule('sale');
        return Sale\Basket::loadItemsForFUser(Sale\Fuser::getId(), Context::getCurrent()->getSite());
    }

    public static function createAbstract()
    {
        self::$oBasket = Sale\Basket::create(SITE_ID);
        self::$oBasket->setFUserId(null);
    }

//    public static function createAbstract($arProductsIds, &$sError = '')
//    {
//        if (empty($arProductsIds)){
//            return false;
//        }
//
//        self::$oBasket = Sale\Basket::create(SITE_ID);
//        self::$oBasket->setFUserId(null);
//        return self::addByProductsById($arProductsIds, 1, $sError, false);
//    }

//    /**
//     * @param int $iId
//     */
//    public static function deletePhoto($iId)
//    {
//        $sFile = static::getPhoto($iId, false);
//        if ($sFile)
//            unlink($sFile);
//    }
//
//    /**
//     * @param int $iId
//     * @param bool $bRelative
//     * @return string|null
//     */
//    public static function getPhoto($iId, $bRelative = true)
//    {
//        $sDir = '/upload/basket_photo';
//        $sFile = $_SERVER['DOCUMENT_ROOT'].$sDir."/{$iId}.jpg";
//        $sFileRelativePath = $sDir."/{$iId}.jpg";
//        return file_exists($sFile) ? ($bRelative ? $sFileRelativePath : $sFile) : null;
//    }
//
//    /**
//     * @param int $iId
//     * @param string $sData - base64
//     */
//    private static function savePhoto($iId, $sData)
//    {
//        $sDir = $_SERVER['DOCUMENT_ROOT'].'/upload/basket_photo';
//        if (!is_dir($sDir)){
//            mkdir($sDir);
//        }
//        File::saveBase64ToFile($sData, $sDir."/{$iId}.jpg");
//    }

//    /**
//     * Есть ли в корзине товары с органиченной серией, не путать с лимитироваванными
//     *
//     * @return bool
//     * @throws Main\ArgumentException
//     * @throws Main\ArgumentNullException
//     * @throws Main\ArgumentTypeException
//     * @throws Main\LoaderException
//     * @throws Main\NotImplementedException
//     * @throws Main\ObjectNotFoundException
//     */
//    public static function hasLimitedEditionItems()
//    {
//        $bLimited = false;
//        $arArts = static::getListProductsXmlIds();
//
//        if (count($arArts > 0)){
//            Loader::includeModule('iblock');
//            $bLimited = !!\CIBlockElement::GetList(
//                [],
//                ['IBLOCK_ID' => Catalog::IB_ID_CATALOG, 'XML_ID' => $arArts, '!PROPERTY_COUNT_LIMIT' => false],
//                false,
//                ['nTopCount' => 1],
//                ['ID']
//            )->Fetch();
//        }
//        return $bLimited;
//    }
//
//    /**
//     * Есть ли в корзине лимитированные товары
//     *
//     * @return bool
//     * @throws Main\ArgumentException
//     * @throws Main\ArgumentNullException
//     * @throws Main\ArgumentTypeException
//     * @throws Main\LoaderException
//     * @throws Main\NotImplementedException
//     * @throws Main\ObjectNotFoundException
//     */
//    public static function hasLimitedItems()
//    {
//        $bLimited = false;
//        $arArts = static::getListProductsXmlIds();
//
//        if (count($arArts > 0)){
//            Loader::includeModule('iblock');
//            $bLimited = !!\CIBlockElement::GetList(
//                [],
//                ['IBLOCK_ID' => Catalog::IB_ID_CATALOG, 'XML_ID' => $arArts, 'PROPERTY_IS_LIMITED' => 'Да'],
//                false,
//                ['nTopCount' => 1],
//                ['ID']
//            )->Fetch();
//        }
//        return $bLimited;
//    }
//
//    /**
//     * Есть ли в корзине эксклюзивные товары
//     *
//     * @return bool
//     * @throws Main\ArgumentException
//     * @throws Main\ArgumentNullException
//     * @throws Main\ArgumentTypeException
//     * @throws Main\LoaderException
//     * @throws Main\NotImplementedException
//     * @throws Main\ObjectNotFoundException
//     */
//    public static function hasExceptionalItems()
//    {
//        $bLimited = false;
//        $arArts = static::getListProductsXmlIds();
//
//        if (count($arArts > 0)){
//            Loader::includeModule('iblock');
//            $bLimited = !!\CIBlockElement::GetList(
//                [],
//                ['IBLOCK_ID' => Catalog::IB_ID_CATALOG, 'XML_ID' => $arArts, 'PROPERTY_IS_EXCEPTIONAL' => 'Да'],
//                false,
//                ['nTopCount' => 1],
//                ['ID']
//            )->Fetch();
//        }
//        return $bLimited;
//    }
//
//    /**
//     * Есть финмониторинг
//     * @return bool
//     * @throws Main\ArgumentException
//     * @throws Main\ArgumentNullException
//     * @throws Main\ArgumentTypeException
//     * @throws Main\LoaderException
//     * @throws Main\NotImplementedException
//     * @throws Main\ObjectNotFoundException
//     */
//    public static function hasFinmonitoring()
//    {
//        $bLimited = false;
//        $arArts = static::getListProductsXmlIds();
//
//        if (count($arArts > 0)){
//            Loader::includeModule('iblock');
//            $bLimited = !!\CIBlockElement::GetList(
//                [],
//                ['IBLOCK_ID' => Catalog::IB_ID_CATALOG, 'XML_ID' => $arArts, 'PROPERTY_FIN_MONITORING' => 'Да'],
//                false,
//                ['nTopCount' => 1],
//                ['ID']
//            )->Fetch();
//        }
//        return $bLimited;
//    }

//    /**
//     * @return array
//     * @throws Main\ArgumentException
//     * @throws Main\ArgumentNullException
//     * @throws Main\ArgumentTypeException
//     * @throws Main\LoaderException
//     * @throws Main\NotImplementedException
//     * @throws Main\ObjectNotFoundException
//     */
//    public static function getListProductsXmlIds()
//    {
//        $arArts = [];
//        $oBasket = static::getBasket();
//        /** @var Sale\BasketItem $oBasketItem */
//        foreach ($oBasket as $oBasketItem){
//            $arItemProps = $oBasketItem->getPropertyCollection()->getPropertyValues();
//            $arArts[] = $arItemProps['XML_ID']['VALUE'];
//        }
//
//        return array_diff($arArts, ['']);
//    }

//    public static function addAxProducts($arProducts)
//    {
//        $oBasket = static::getBasket();
//        foreach ($arProducts as $arProduct){
//            $arNewItem = [
//                'BASKET_ITEM' => [
//                    'CURRENCY' => CurrencyManager::getBaseCurrency(),
//                    'PRICE' => $arProduct['priceRUR'],
//                    'CUSTOM_PRICE' => 'Y',
//                    'QUANTITY' => 1,
//                ],
//                'PROPS' => [],
//            ];
//            $sXmlId = $arProduct['articleId'];
//            $oProduct = Product::initByXmlId($sXmlId);
//
//            if($oProduct){
//                $arCollection = $oProduct->getCollection();
//                $arNewItem['PRODUCT_ID'] = $oProduct->getId();
//                $arNewItem['PROPS'] = [
//                    'XML_ID' => $oProduct->getAXCode() ?: $arProduct['articleId'],
//                    'COLLECTION' => $arCollection['NAME'] ?: $arProduct['collection'],
//                    'NAME' => $oProduct->getName() ?: $arProduct['production'],
//                    'ARTICLE' => $oProduct->getSellerCode() ?: $arProduct['nameAlias'],
//                ];
//            } else {
//                $arNewItem['PRODUCT_ID'] = Catalog::IB_ID_CUSTOM_CATALOG_ITEM;
//                $arNewItem['PROPS'] = [
//                    'XML_ID' => $arProduct['articleId'],
//                    'COLLECTION' => $arProduct['collection'],
//                    'NAME' => $arProduct['production'],
//                    'ARTICLE' => $arProduct['nameAlias'],
//                ];
//            }
//            $arNewItem['PROPS']['HASH'] = md5(serialize($arProduct));
//            $arNewItem['PROPS'] = static::fillBasketItemProp($arNewItem['PROPS']);
//
//            /** @var Sale\BasketItem $oItem */
//            if ($oBasketItem = $oBasket->getExistsItem('catalog', $arNewItem['PRODUCT_ID'], $arNewItem['PROPS'])){
//                // Товар уже в корзине, ничего не делаем, просто переход в корзину
//                $oBasketItem->setField('QUANTITY', $oBasketItem->getQuantity() + 1);
//            } else {
//                $oBasketItem = $oBasket->createItem('catalog', $arNewItem['PRODUCT_ID']);
//                $oBasketItem->setFields($arNewItem['BASKET_ITEM']);
//                $oPropBasketCollection = $oBasketItem->getPropertyCollection();
//                foreach ($arNewItem['PROPS'] as $arProp){
//                    $oProp = $oPropBasketCollection->createItem();
//                    $oProp->setFields($arProp);
//                }
//            }
//            $oBasketItem->setField('NAME', $arProduct['articleId']);
//            if ($arProduct['photo']){
//                $oBasketItem->save();
//                static::savePhoto($oBasketItem->getId(), $arProduct['photo']);
//            }
//        }
//        $oBasket->save();
//    }

    public static function fillBasketItemProp($arFields)
    {
        $arProps = [];
//        foreach ($arFields as $sField => $mValue){
//            $sName = '';
//            switch ($sField){
//                case 'XML_ID':
//                    $sName = 'АРТ';
//                    break;
//                case 'COLLECTION': $sName = 'Коллекция'; break;
//                case 'NAME': $sName = 'Название'; break;
//                case 'ARTICLE': $sName = 'Артикул'; break;
//                case 'PHOTO': $sName = 'Фото'; break;
//                case 'DESC': $sName = 'Описание'; break;
//                case 'HASH': $sName = 'Хеш значения'; break;
//            }
//            $arProps[] = [
//                'NAME' => $sName,
//                'CODE' => $sField,
//                'VALUE' => $mValue,
//            ];
//        }
        return $arProps;
    }

    public static function clearBasket()
    {
        $oBasket = self::getBasket();
        /** @var Sale\BasketItem $oBasketItem */
        foreach ($oBasket as $oBasketItem){
            $oBasketItem->delete();
        }
    }

    /**
     * @param Product $oProduct
     * @param int $iQuantity
     * @return Sale\BasketItemBase
     * @throws Main\ArgumentException
     * @throws Main\ArgumentNullException
     * @throws Main\ArgumentOutOfRangeException
     * @throws Main\ArgumentTypeException
     * @throws Main\LoaderException
     * @throws Main\NotImplementedException
     * @throws Main\NotSupportedException
     * @throws Main\ObjectNotFoundException
     */
    protected static function createItem(Product $oProduct, $iQuantity = 1)
    {
        $oBasket = static::getBasket();
        $oItem = $oBasket->createItem('catalog', $oProduct->getID());
        $oItem->setFields([
            'QUANTITY' => $iQuantity,
            'CURRENCY' => CurrencyManager::getBaseCurrency(),
            'LID' => Context::getCurrent()->getSite(),
            'PRODUCT_PROVIDER_CLASS' => 'CCatalogProductProvider',
        ]);
        $oItem->setField('NAME', $oProduct->getName());
        $oProps = $oItem->getPropertyCollection();
        foreach ($oProduct->getPropsForBasket() as $arProp){
            $oProp = $oProps->createItem();
            $oProp->setFields($arProp);
        }
        return $oItem;
    }

    /**
     * Получение элемента корзины
     * @param Product $oProduct
     * @return Sale\BasketItem|null
     * @throws Main\ArgumentException
     * @throws Main\ArgumentNullException
     * @throws Main\ArgumentTypeException
     * @throws Main\LoaderException
     * @throws Main\NotImplementedException
     */
    protected static function getItem(Product $oProduct){
        $oBasket = static::getBasket();
        $arProps = $oProduct->getPropsForBasket();
        return $oBasket->getExistsItem('catalog', $oProduct->getID(), $arProps);
    }

    public static function addByProductById($mProduct, $bAddQuantity = false, $bSave = true){
        $oBasket = static::getBasket();
        if (is_array($mProduct)){
            foreach ($mProduct as $iProductId => $iQuantity){}
        } else {
            $iProductId = $mProduct;
            $iQuantity = 1;
        }

        if (empty($iProductId) || $iProductId < 1)
            throw new Exception('Некорректный ид товара');

        $oProduct = Product::initById($iProductId);

        if (!$oProduct){
            throw new Exception('Товар не найден');
        }
        if (!$oProduct->canBuy()){
            throw new Exception('Товар нельзя купить');
        }


        $arProps = $oProduct->getPropsForBasket();

        /** @var Sale\BasketItem $oItem */
        if ($oItem = static::getItem($oProduct)){
            // Товар уже в корзине, ничего не делаем, просто переход в корзину
            $iQuantity = $oItem->getQuantity();
            if ($bAddQuantity){
                $iQuantity++;
                $oItem->setField('QUANTITY', $iQuantity);
            }
        } else {
            static::createItem($oProduct, $iQuantity);
        }

        if ($bSave)
            $oBasket->save();
    }
    public static function addByProductsById($arIds, $bAddQuantity = false, &$sError = '', $bSave = true)
    {
        try {
            Loader::includeModule('sale');

            if (empty($arIds))
                throw new \Exception('Не переданы ид товаров');

            foreach (is_array($arIds) ? $arIds : [$arIds => 1] as $iProductId => $iQuantity){
                try {
                    static::addByProductById([$iProductId => $iQuantity], $bAddQuantity, $bSave);
                } catch (Exception $e) {

                }
            }

        } catch (\Exception $e) {
            $sError = $e->getMessage();
            return false;
        }

        return true;
    }

    public static function getTotalQuantity()
    {
        $iQuantity = 0;

        /** @var \Bitrix\Sale\BasketItem $oBasketItem */
        foreach (static::getBasket() as $oBasketItem) {
            $arBasketItem = $oBasketItem->getFieldValues();
            $oProduct =  \CustomBitrix\Entity\Product::initByIdCached($arBasketItem['PRODUCT_ID']);

            if ($oProduct->canBuy()){
                $iQuantity += $arBasketItem['QUANTITY'];
            }
        }

        return $iQuantity;
    }

    public static function getTotalAmount()
    {
        $iSum = 0;

        /** @var \Bitrix\Sale\BasketItem $oBasketItem */
        foreach (static::getBasket() as $oBasketItem) {
            $arBasketItem = $oBasketItem->getFieldValues();
            $oProduct =  \CustomBitrix\Entity\Product::initByIdCached($arBasketItem['PRODUCT_ID']);

            if ($oProduct->canBuy()){
                $iSum += $arBasketItem['QUANTITY'] * $arBasketItem['PRICE'];
            }
        }

        return $iSum;
    }
}