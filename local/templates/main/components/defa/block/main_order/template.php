<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}
$arProducts = \CustomBitrix\Tools\Iblock::getElements([
    'FILTER' => ['IBLOCK_ID' => $arParams['IBLOCK_ID'], 'ACTIVE' => 'Y', 'ACTIVE_DATE'=> 'Y',],
    'ID' => 'CODE',
]);
$arProducts = array_map(function ($arProduct) {
    $arProduct['PREVIEW_PICTURE'] = CFile::GetPath($arProduct['PREVIEW_PICTURE']);
    $arPrice = \CCatalogProduct::GetOptimalPrice($arProduct['ID']);
    $arProduct['PRICE'] = $arPrice['DISCOUNT_PRICE'];
    return $arProduct;
}, $arProducts);

$arProduct = array_shift($arProducts);
$arProductFull = $arProduct['CODE'] == 'pre-order' ? current($arProducts) : null;
$sImg = CFile::GetPath($arProduct['PROPERTIES']['BLOCK_IMG']['VALUE']);
$sDesc = $arProduct['PROPERTIES']['BLOCK_DESC']['~VALUE'];
$sTitle = $arProduct['PROPERTIES']['BLOCK_TITLE']['~VALUE'];
$sBtn = $arProduct['PROPERTIES']['BLOCK_BTN_BUY']['~VALUE'];
$iPrice = $arProduct['PRICE'];
$sCurrency = \CustomBitrix\Tools\Text::declensionOfNouns($iPrice, 'рубль', 'рубля', 'рублей', false);
?>
<section id="preorder" class="preOrder">
    <div class="wrap preOrder-wrap">
        <div class="preOrder-left">
            <img src="<?=$sImg;?>" alt class="preOrder-left__img">
            <div class="preOrder-left-content">
                <h3 class="preOrder-left-content__title"><?=$sTitle;?></h3>
                <p class="preOrder-left-content__descr"><?=$sDesc;?></p>
                <a class="black-btn preOrder-left-content__btn"><?=$sBtn;?></a>
            </div>
        </div>
        <div class="preOrder-right">
            <? if($arProductFull): ?><p class="red-text preOrder-right__text">Цена по предзаказу*</p><?endif;?>
            <p class="preOrder-right__price"><span class="preOrder-right__price--number"><?=$iPrice;?></span><?=$sCurrency;?></p>
            <? if($arProductFull): ?>
                <p class="preOrder-right__descr">* Цена после выпуска тиража – <br> <b><?=$arProductFull['PRICE'];?> руб.</b></p>
            <?endif;?>
        </div>
    </div>
</section>