<?php


namespace CustomBitrix\Tools;


use Bitrix\Main\Diag\Debug;
use Bitrix\Main\Loader;
use CustomBitrix\Tools\Cache;

Loader::includeModule('iblock');

class Iblock
{
    public static function getIdByCode($sCode, $sType = '', $sSite = SITE_ID, $bCache = true)
    {
        if ($bCache) {
            return \CustomBitrix\Tools\Cache::getCached(__METHOD__, [$sCode, $sType, $sSite, false]);
        }

        $arFilter = ['ACTIVE' => 'Y', 'CODE' => $sCode, 'SITE_ID' => $sSite];
        if ($sType) {
            $arFilter['TYPE'] = $sType;
        }

        $arIblock = \CIBlock::GetList([], $arFilter)->Fetch();

        return $arIblock['ID'] ?: null;
    }

    public static function getIblockDataByIdBy($iIblock, $bCache = true)
    {
        if ($bCache) {
            return \CustomBitrix\Tools\Cache::getCached(__METHOD__, [$iIblock, false], ["iblock_id_{$iIblock}"]);
        }

        $arFilter = ['ID' => $iIblock];

        $arIblock = \CIBlock::GetList([], $arFilter)->Fetch();

        return $arIblock ?: null;
    }

    /**
     * Получить список элементов
     * @param $arParams
     * @param array $arTags
     * @return array|mixed
     */
    public static function getElements($arParams, $arTags = [])
    {
        $arParams['CACHE'] = is_array($arParams['CACHE']) ? $arParams['CACHE'] : [];
        $arParams['CACHE']['TAGS'] = is_array($arParams['CACHE']['TAGS']) ? $arParams['CACHE']['TAGS'] : [];

        if (count($arTags) > 0) {
            $arParams['CACHE']['TAGS'] = array_merge($arParams['CACHE']['TAGS'], $arTags);
        }

        return static::getList($arParams);
    }

    /**
     * Получить элемент
     * @param $arParams
     * @param array $arTags
     * @return array|null
     */
    public static function getElement($arParams, $arTags = [])
    {
        $arParams['NAV'] = is_array($arParams['NAV']) ? $arParams['NAV'] : [];
        $arParams['NAV']['nTopCount'] = 1;
        $arParams['CACHE'] = is_array($arParams['CACHE']) ? $arParams['CACHE'] : [];
        $arParams['CACHE']['TAGS'] = is_array($arParams['CACHE']['TAGS']) ? $arParams['CACHE']['TAGS'] : [];

        if (count($arTags) > 0) {
            $arParams['CACHE']['TAGS'] = array_merge($arParams['CACHE']['TAGS'], $arTags);
        }

        return current(static::getList($arParams)) ?: null;
    }

    /**
     * @param $arParams
     * @return array
     */
    public static function getList($arParams)
    {
        $arResult = [];

        $bCache = is_array($arParams['CACHE']);

        if ($bCache) {
            $arCacheParams = $arParams['CACHE'];
            $arTags = [];
            if ($arCacheParams['TAGS'] && is_array($arCacheParams['TAGS'])) {
                $arTags = $arParams['CACHE']['TAGS'];
            }
            if ($arParams['FILTER']['IBLOCK_ID']) {
                foreach (is_array($arParams['FILTER']['IBLOCK_ID']) ? $arParams['FILTER']['IBLOCK_ID'] : [$arParams['FILTER']['IBLOCK_ID']] as $iIblock) {
                    $arTags[] = "iblock_id_{$iIblock}";
                }
            }
            $sCacheDir = $arCacheParams['DIR'] ?: Cache::DEFAULT_CACHE_DIR;
            $iTtl = $arCacheParams['TTL'] ?: Cache::DEFAULT_CACHE_TTL;

            unset($arParams['CACHE']);
            return Cache::getCached(__METHOD__, [$arParams, &$arNavResult], $arTags, null, $sCacheDir, $iTtl);
        }

        $arFilter = $arParams['FILTER'] ?: [];
        $arSelect = $arParams['SELECT'] ?: [];
        $arOrder =  $arParams['ORDER'] ?: [];
        $arGroup = $arParams['GROUP'] ?: false;
        $arNav = $arParams['NAV'] ?: false;

        $rs = \CIBlockElement::GetList($arOrder, $arFilter, $arGroup, $arNav, $arSelect);

        while ($rsItem = $rs->GetNextElement()) {
            $arItem = $rsItem->GetFields();
            $arItem['PROPERTIES'] = $rsItem->GetProperties();

            $sKey = $arParams['ID'] ? ($arItem[$arParams['ID']] ? (string) $arItem[$arParams['ID']] : null) : (string) $arItem['ID'];
            $arResult[$sKey] = $arItem;
        }

        return $arResult;
    }

    public static function getElementsWithNav($arParams, &$arNavResult = null, $arCacheParams = [])
    {
        $arResult = [];

        $bCache = is_array($arCacheParams);

        if ($bCache) {
            $arTags = [];
            if ($arCacheParams['TAGS'] && is_array($arCacheParams['TAGS'])) {
                $arTags = $arParams['CACHE']['TAGS'];
            }
            if ($arParams['FILTER']['IBLOCK_ID']) {
                foreach (is_array($arParams['FILTER']['IBLOCK_ID']) ? $arParams['FILTER']['IBLOCK_ID'] : [$arParams['FILTER']['IBLOCK_ID']] as $iIblock) {
                    $arTags[] = "iblock_id_{$iIblock}";
                }
            }
            $sCacheDir = $arCacheParams['DIR'] ?: Cache::DEFAULT_CACHE_DIR;
            $iTtl = $arCacheParams['TTL'] ?: Cache::DEFAULT_CACHE_TTL;
            if (isset($arCacheParams['NAV']) && $arParams['NAV']) {
                $arCacheParams['NAV'] = \CDBResult::GetNavParams($arParams['NAV']);
            }
            $arKeyParams = $arCacheParams['NAV'] ?: null;

            unset($arParams['CACHE']);
            return Cache::getCached(__METHOD__, [$arParams, &$arNavResult, false], $arTags, $arKeyParams, $sCacheDir, $iTtl);
        }

        $arFilter = $arParams['FILTER'] ?: [];
        $arSelect = $arParams['SELECT'] ?: [];
        $arOrder =  $arParams['ORDER'] ?: [];
        $arGroup = $arParams['GROUP'] ?: false;
        $arNav = $arParams['NAV'] ?: false;
        $arParams["COMPONENT_NAV_PARAM"] = $arParams["COMPONENT_NAV_PARAM"] ?: [];

        $rs = \CIBlockElement::GetList($arOrder, $arFilter, $arGroup, $arNav, $arSelect);

        while ($rsItem = $rs->GetNextElement()) {
            $arItem = $rsItem->GetFields();
            $arItem['PROPERTIES'] = $rsItem->GetProperties();

            $sKey = $arParams['ID'] ? ($arItem[$arParams['ID']] ? (string) $arItem[$arParams['ID']] : null) : (string) $arItem['ID'];
            $arResult[$sKey] = $arItem;
        }

        $arNavResult["NAV_STRING"] = $rs->GetPageNavStringEx(
            $navComponentObject,
            $arParams["PAGER_TITLE"],
            $arParams["PAGER_TEMPLATE"],
            $arParams["PAGER_SHOW_ALWAYS"],
            $arParams["COMPONENT"],
            $arParams["COMPONENT_NAV_PARAM"]
        );
        $arNavResult["NAV_CACHED_DATA"] = null;
        $arNavResult["NAV_RESULT"] = $rs;
        $arNavResult["NAV_PARAM"] = $arParams["COMPONENT_NAV_PARAM"];

        return ['ITEMS' => $arResult, 'NAV' => $arNavResult];
    }
}