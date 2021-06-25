<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}
$arProduct = \CustomBitrix\Tools\Iblock::getElement([
    'FILTER' => ['IBLOCK_ID' => $arParams['IBLOCK_ID'], 'ACTIVE' => 'Y', 'ACTIVE_DATE'=> 'Y',],
]);
$sPhoto = CFile::GetPath($arProduct['PREVIEW_PICTURE']);
$sBg = CFile::GetPath($arProduct['PROPERTIES']['BANNER_BG']['~VALUE']);
$sDesc = $arProduct['PROPERTIES']['BANNER_DESC']['~VALUE'];
$sDescM = $arProduct['PROPERTIES']['BANNER_DESC_MOBILE']['~VALUE'];
$sTitle = $arProduct['PROPERTIES']['BANNER_TITLE']['~VALUE'];
$sBtn = $arProduct['PROPERTIES']['BANNER_BTN_BUY']['~VALUE'];
$arPrice = \CCatalogProduct::GetOptimalPrice($arProduct['ID']);
$iPrice = $arPrice['DISCOUNT_PRICE'];
$sCurrency = \CustomBitrix\Tools\Text::declensionOfNouns($iPrice, 'рубль', 'рубля', 'рублей', false);
?>
<section class="banner">
    <div class="wrap banner-wrap">
        <div class="banner-left">
            <img src="<?= SITE_TEMPLATE_PATH; ?>/assets/img/logo.png" alt class="banner-left__logo">
            <div class="banner-preOrder">
                <div class="banner-preorder__left">
                    <? if($sPhoto): ?><img src="<?=$sPhoto;?>" alt class="banner-preOrder__img" /><? endif; ?>
                </div>
                <div class="banner-preOrder__right">
                    <? if($sTitle): ?><p class="banner-preOrder__title"><?=$sTitle;?></p><? endif; ?>
                    <p class="banner-preOrder__price">
                        <span class="banner-preOrder__price--number"><?=$iPrice;?></span> <?=$sCurrency;?>
                    </p>
                    <? if($sDesc): ?><p class="banner-preOrder__footnote"><?=$sDesc;?></p><? endif; ?>
                    <? if($sPhoto): ?><img src="<?=$sPhoto;?>" alt class="banner-preOrder__img--mobile" /><? endif; ?>
                    <? if($sDescM): ?><p class="banner-preOrder__descr"><?=$sDescM;?></p><? endif; ?>
                    <? if($sBtn): ?><a class="black-btn banner-preOrder__btn"><?=$sBtn;?></a><? endif; ?>
                </div>
            </div>
        </div>
        <? if($sBg): ?><img src="<?=$sBg;?>" alt class="banner-cover" /><? endif; ?>
    </div>
</section>