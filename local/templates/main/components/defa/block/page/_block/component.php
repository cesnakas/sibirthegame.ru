<?php
/**
 * @var array $arParams
 * @var array $arResult
 * @var array $arBlock
 */

$arComponentParams = [
    'TITLE' => $arBlock['~NAME'],
    'DESCRIPTION' => $arBlock['~PREVIEW_TEXT'],
];
foreach ($arBlock['PROPERTIES']['COMPONENT_PARAMS']['VALUE'] ?: [] as $iKey => $sValue) {
    $arComponentParams[$arBlock['PROPERTIES']['COMPONENT_PARAMS']['~VALUE'][$iKey]] = $arBlock['PROPERTIES']['COMPONENT_PARAMS']['~DESCRIPTION'][$iKey];
}

$APPLICATION->IncludeComponent(
    'defa:block',
    $arBlock['PROPERTIES']['COMPONENT_TEMPLATE']['VALUE'],
    $arComponentParams
);