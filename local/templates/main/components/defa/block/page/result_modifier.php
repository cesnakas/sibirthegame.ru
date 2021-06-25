<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}

use Bitrix\Main\Loader;
use Bitrix\Iblock\Elements\ElementPageBuilderTable;

Loader::includeModule('iblock');

$iIblock = \CustomBitrix\Tools\Iblock::getIdByCode('page_builder');

$arSection = CIBlockSection::GetList([], ['CODE' => $arParams['PAGE'], 'ACTIVE' => 'Y', 'IBLOCK_ID' => $iIblock], false, ['ID', 'CODE', 'IBLOCK_ID'])->Fetch();
$arResult['BLOCKS'] = [];
$arResult['SEO'] = [];
if ($arSection) {
    $oSeo = new \Bitrix\Iblock\InheritedProperty\SectionValues($arSection['IBLOCK_ID'], $arSection['ID']);
    $arResult['SEO'] = $oSeo->getValues();

    $arBlocks = [];

    $rs = CIBlockElement::GetList(
        ['sort' => 'asc'],
        ['IBLOCK_ID' => $iIblock, 'ACTIVE' => 'Y', 'SECTION_ID' => $arSection['ID']],
        false,
        false,
        ['ID', 'NAME', 'PREVIEW_PICTURE', 'PREVIEW_TEXT', 'IBLOCK_ID']
    );

    while ($rsElement = $rs->GetNextElement()) {
        $arBlock = $rsElement->GetFields();
        $arBlock['PROPERTIES'] = $rsElement->GetProperties();
        $sType = $arBlock['PROPERTIES']['TYPE_BLOCK']['VALUE_XML_ID'];
        $arBlock['FILE'] = __DIR__."/_block/{$sType}.php";
        if (!file_exists($arBlock['FILE'] )) {
            continue;
        }

        $arBlocks[] = $arBlock;
    }

    $arResult['BLOCKS'] = $arBlocks;
}

$this->__component->setResultCacheKeys(['SEO']);