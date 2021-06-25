<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}


use CustomBitrix\Tools,
    Bitrix\Main\Loader
    ;

$iIblock = \CustomBitrix\Tools\Iblock::getIdByCode('blocks', 'content');
$sSectionCode = 'publisher';


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
        'ID' => 'CODE',
    ]);
}


$sTitle = $arSection['NAME'];
$sDesc = $arSection['DESCRIPTION'];

$arLinks = [];
if (count(array_diff($arItems['links']['PROPERTIES']['VALUES']['VALUE'], [''])) > 0) {
    $arDescs = $arItems['links']['PROPERTIES']['VALUES']['~DESCRIPTION'];
    $arValues = $arItems['links']['PROPERTIES']['VALUES']['~VALUE'];

    if (count(array_diff($arDescs, [''])) > 0) {
        foreach ($arValues as $iKey => $_) {
            $arLinks[] = [
                'text' => $arDescs[$iKey],
                'link' => $arValues[$iKey],
            ];
        }
    }
}

$arResult = [
    'title' => $sTitle,
    'desc' => $sDesc,
    'links_list' => $arLinks,
];

header('Content-Type: application/json');

echo json_encode($arResult); die();