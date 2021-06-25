<?php


namespace CustomBitrix\Tools;


use Bitrix\Main\Diag\Debug;

class Cache
{
    const DEFAULT_CACHE_TTL = 3600;
    const DEFAULT_CACHE_DIR = 'vebinfra';

    public static function getCached($sMethod, $arParams, $arTags = [], $arKeyParams = null, $sCacheDir = self::DEFAULT_CACHE_DIR, $iTtl = self::DEFAULT_CACHE_TTL)
    {
        $sCacheKey = is_array($sMethod) ? implode('::', $sMethod) : $sMethod;
        $sCacheKey .= '(';
        $sCacheKey .= is_array($arParams) ? md5(json_encode($arParams)) : '';
        $sCacheKey .= is_array($arKeyParams) ? '_'.md5(json_encode($arKeyParams)) : '';
        $sCacheKey .= ')';
        $cache = \Bitrix\Main\Data\Cache::createInstance(); // получаем экземпляр класса
        if ($cache->initCache($iTtl, $sCacheKey, $sCacheDir)) { // проверяем кеш и задаём настройки
            $arResult = $cache->getVars(); // достаем переменные из кеша
        }
        else {
            global $CACHE_MANAGER;
            $CACHE_MANAGER->StartTagCache($sCacheDir);

            $bStartCache = $cache->startDataCache();
            if (is_callable($sMethod)) {
                $arResult = call_user_func_array($sMethod, $arParams);
            }
            foreach ($arTags as $sTag) {
                $CACHE_MANAGER->RegisterTag($sTag);
            }
            if ($bStartCache) {
                $cache->endDataCache($arResult); // записываем в кеш
            }

        }

        return $arResult;
    }
}