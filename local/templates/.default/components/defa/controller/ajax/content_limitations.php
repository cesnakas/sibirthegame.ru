<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}
$sSectionCode = 'limitations';
$iIblockRef = \CustomBitrix\Tools\Iblock::getIdByCode('limitations', 'ref');
$iIblockBlock = \CustomBitrix\Tools\Iblock::getIdByCode('limitations', 'content');

$arItems = \CustomBitrix\Tools\Iblock::getElements([
    'FILTER' => ['IBLOCK_ID' => $iIblockRef, 'ACTIVE' => 'Y'],
    'ORDER' => ['sort' => 'asc', 'name' => 'asc',],
    'SELECT' => ['ID', 'NAME', 'IBLOCK_ID', 'PREVIEW_PICTURE', 'PREVIEW_TEXT'],
]);

$arSection = CIBlockSection::GetList(
    [],
    [
        'CODE' => $sSectionCode, 'ACTIVE' => 'Y', 'IBLOCK_ID' => $iIblockBlock
    ], false,
    ['ID', 'CODE', 'IBLOCK_ID', 'DESCRIPTION', 'NAME']
)->Fetch();

$arResult = [
    'desc' => $arSection['DESCRIPTION'],
    'limitations_list' => array_values(array_map(function($arItem) {
        return [
            'img' => CFile::GetPath($arItem['PROPERTIES']['ICON']['VALUE'] ?: $arItem['PREVIEW_PICTURE']),
            'alt' => strip_tags($arItem['~NAME']),
            'title' => $arItem['~NAME'],
            'descr' => $arItem['~PREVIEW_TEXT'],
        ];
    }, $arItems)),
];

header('Content-Type: application/json');

echo json_encode($arResult); die();