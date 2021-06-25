<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}


use CustomBitrix\Tools,
    Bitrix\Main\Loader
    ;

$iIblock = \CustomBitrix\Tools\Iblock::getIdByCode('blocks', 'content');
$sSectionCode = 'in_box';


$arSection = CIBlockSection::GetList(
    [],
    [
        'CODE' => $sSectionCode, 'ACTIVE' => 'Y', 'IBLOCK_ID' => $iIblock
    ], false,
    ['ID', 'CODE', 'IBLOCK_ID', 'DESCRIPTION', 'NAME']
)->Fetch();
$arItems = [];
if ($arSection) {
    $arItems = \CustomBitrix\Tools\Iblock::getElements([
       'FILTER' => ['IBLOCK_ID' => $iIblock, 'ACTIVE' => 'Y', 'ACTIVE_DATE'=> 'Y', 'SECTION_ID' => $arSection['ID'],],
       'ORDER' => ['sort' => 'asc', 'name' => 'asc',],
    ]);
}


$sTitle = $arSection['NAME'];
$sDesc = $arSection['DESCRIPTION'];

$arResult = [
    'descr' => $sDesc,
    'slovnik_list' => array_values(array_map(function($arItem) {
        return [
            'img' => CFile::GetPath($arItem['PREVIEW_PICTURE']),
            'alt' => strip_tags($arItem['~NAME']),
            'title' => $arItem['~NAME'],
            'descr' => $arItem['~PREVIEW_TEXT'],
        ];
    }, $arItems)),
];

header('Content-Type: application/json');

echo json_encode($arResult); die();