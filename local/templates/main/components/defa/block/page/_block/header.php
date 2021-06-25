<?php
/**
 * @var array $arParams
 * @var array $arResult
 * @var array $arBlock
 */

$sBanner = CFile::GetPath($arBlock['PREVIEW_PICTURE']);
$sTitle = $arBlock['~NAME'];
$sDesc = $arBlock['~PREVIEW_TEXT'];
$bShowMenu = $arBlock['PROPERTIES']['HEADER_SHOW_MENU']['VALUE'] === 'Y' && !empty($arBlock['PROPERTIES']['HEADER_TYPE_MENU']['VALUE']);
$sTitleParent = $arBlock['PROPERTIES']['HEADER_PARENT_TITLE']['~VALUE'];
$sSubTitle = $arBlock['PROPERTIES']['HEADER_SUB_TITLE']['~VALUE'];
$sClassBanner = $arBlock['PROPERTIES']['HEADER_CSS_CLASS']['VALUE'];
$sClassBanner .= $arBlock['PROPERTIES']['HEADER_THIN_BANNER']['VALUE'] === 'Y' ? ' hero--small' : ' hero--big';
$sTitleClass = '';
switch ($arBlock['PROPERTIES']['HEADER_ALIGN_TITLE']['VALUE_XML_ID']) {
    case 'center':
        $sTitleClass .= ' hero--title__center';
        break;
}
?>
<div class="hero hero--main<?=$sClassBanner;?>" style="background-image: url('<?=$sBanner;?>')">
    <div class="wrap">
        <? if ($sTitleParent): ?>
        <h2 class="title hero--parent__title"><?=$sTitleParent;?></h2>
        <? endif; ?>
        <h1 class="title hero--title<?=$sTitleClass;?>"><?=$sTitle;?></h1>
        <? if ($sSubTitle): ?>
            <p class="title hero--title__small"><?=$sSubTitle;?></p>
        <? endif; ?>

        <? if ($sDesc): ?>
        <p class="description hero--description"><?=$sDesc;?></p>
        <? endif; ?>

        <? if ($bShowMenu): ?>
        <div class="submenu hero--submenu">
            <? $APPLICATION->IncludeComponent('bitrix:menu', 'submenu', [
                "CHILD_MENU_TYPE" => "",
                "MAX_LEVEL" => "1",
                "MENU_CACHE_TIME" => "36000000",
                "MENU_CACHE_TYPE" => "A",
                "USE_EXT" => "Y",
                "ROOT_MENU_TYPE" => $arBlock['PROPERTIES']['HEADER_TYPE_MENU']['VALUE'],
            ], null, ['HIDE_ICONS' => 'Y']) ?>
        </div>
        <? endif; ?>
    </div>
</div>
