<?php if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
die();
}

if (!empty($arResult['SEO'])) {
    if ($sSeo = $arResult['SEO']['SECTION_META_TITLE']) {
        $APPLICATION->SetTitle($sSeo);
    }
    if ($sSeo = $arResult['SEO']['SECTION_META_KEYWORDS']) {
        $APPLICATION->SetPageProperty('keywords', $sSeo);
    }
    if ($sSeo = $arResult['SEO']['SECTION_META_DESCRIPTION']) {
        $APPLICATION->SetPageProperty('description', $sSeo);
    }
}
