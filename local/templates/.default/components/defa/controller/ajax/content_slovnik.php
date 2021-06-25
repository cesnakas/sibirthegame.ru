<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}


use CustomBitrix\Tools,
    Bitrix\Main\Loader;

$iIblock = \CustomBitrix\Tools\Iblock::getIdByCode('glossary', 'ref');
$arIblock = Tools\Iblock::getIblockDataByIdBy($iIblock);

$arItems = \CustomBitrix\Tools\Iblock::getElements(
    [
        'FILTER' => ['IBLOCK_ID' => $iIblock, 'ACTIVE' => 'Y',],
        'ORDER' => ['sort' => 'asc', 'name' => 'asc',],
        'SELECT' => ['ID', 'NAME', 'IBLOCK_ID', 'PREVIEW_PICTURE', 'PREVIEW_TEXT'],
    ]
);

$sTitle = $arIblock['NAME'];
$sDesc = $arIblock['DESCRIPTION'];

$arResult = [
    'title' => $sDesc,
    'slovnik_list' => array_values(
        array_map(
            function ($arItem) {
                return [
                    'img' => CFile::GetPath($arItem['PREVIEW_PICTURE']),
                    'alt' => strip_tags($arItem['~NAME']),
                    'title' => $arItem['~NAME'],
                    'descr' => $arItem['~PREVIEW_TEXT'],
                ];
            },
            $arItems
        )
    ),
];

header('Content-Type: application/json');

echo json_encode($arResult);
die();