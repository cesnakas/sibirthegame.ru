<?php

use CustomBitrix\Tools;

$iIblock = \CustomBitrix\Tools\Iblock::getIdByCode('blocks', 'content');
$sSectionCode = 'help';

$arSection = CIBlockSection::GetList(
    [],
    [
        'CODE' => $sSectionCode, 'ACTIVE' => 'Y', 'IBLOCK_ID' => $iIblock
    ], false,
    ['ID', 'CODE', 'IBLOCK_ID', 'NAME']
)->Fetch();

$arMenu = [];
$arData = [];
if ($arSection) {
    $sTitle = $arSection['NAME'];
    $rsSections = CIBlockSection::GetList(
        [],
        [
            'SECTION_ID' => $arSection['ID'], 'ACTIVE' => 'Y', 'IBLOCK_ID' => $iIblock
        ], false,
        ['ID', 'CODE', 'IBLOCK_ID', 'NAME']
    );
    $arSubSections = [];
    while ($arSubSection = $rsSections->Fetch()) {
        $arMenu[] = [
            'name' => $arSubSection['NAME'],
            'code' => $arSubSection['CODE'],
        ];
        $arSubSections[$arSubSection['ID']] = $arSubSection['CODE'];
        $arData[$arSubSection['CODE']] = [];
    }
    $arItems = \CustomBitrix\Tools\Iblock::getElements([
        'FILTER' => ['IBLOCK_ID' => $iIblock, 'ACTIVE' => 'Y', 'ACTIVE_DATE'=> 'Y', 'SECTION_ID' => array_keys($arSubSections),],
        'ORDER' => ['sort' => 'asc', 'name' => 'asc',],
        'SELECT' => ['IBLOCK_SECTION_ID', 'IBLOCK_ID', 'ID', 'CODE', 'PREVIEW_TEXT'],
    ]);
    foreach($arItems as $arItem){
        $value = $arItem['~PREVIEW_TEXT'];
        if (count(array_diff($arItem['PROPERTIES']['VALUES']['VALUE'], [''])) > 0) {
            $value = [];
            $arDescs = $arItem['PROPERTIES']['VALUES']['~DESCRIPTION'];
            $arValues = $arItem['PROPERTIES']['VALUES']['~VALUE'];

            if (count(array_diff($arDescs, [''])) > 0 ) {
                foreach ($arValues as $iKey => $_) {
                    $value[] = [
                        'label' => $arDescs[$iKey],
                        'text' => $arValues[$iKey],
                    ];
                }
            } else {
                $value = $arValues;
            }
        }


        $arData[$arSubSections[$arItem['IBLOCK_SECTION_ID']]][$arItem['CODE']] = $value;
    }
}

$arResult = [
    'title' => $sTitle,
    'menu' => $arMenu,
    'data' => $arData,
];

header('Content-Type: application/json');

echo json_encode($arResult);
die();