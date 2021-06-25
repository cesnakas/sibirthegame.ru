<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}

$arSection = CIBlockSection::GetList(
    [],
    [
        'CODE' => $arParams['SECTION_CODE'], 'ACTIVE' => 'Y', 'IBLOCK_ID' => $arParams['IBLOCK_ID']
    ], false,
    ['ID', 'CODE', 'IBLOCK_ID', 'DESCRIPTION', 'NAME']
)->Fetch();
$arItems = [];
if ($arSection) {
    $arItems = \CustomBitrix\Tools\Iblock::getElements([
        'FILTER' => ['IBLOCK_ID' => $arParams['IBLOCK_ID'], 'ACTIVE' => 'Y', 'ACTIVE_DATE'=> 'Y', 'SECTION_ID' => $arSection['ID'],],
        'ORDER' => ['sort' => 'asc', 'name' => 'asc',],
    ]);
    $arItems = array_map(function($arItem) {
        $arItem['PREVIEW_PICTURE'] = CFile::GetPath($arItem['PREVIEW_PICTURE']);
        return $arItem;
    }, $arItems);
}

$arRule = \CustomBitrix\Tools\Iblock::getElement([
    'FILTER' => ['IBLOCK_ID' => \CustomBitrix\Tools\Iblock::getIdByCode('values', 'ref'), 'ACTIVE' => 'Y',],
]);

$arRuleFile = CFile::GetFileArray(current($arRule['PROPERTIES']['FILE']['VALUE']));

$sTitle = $arSection['NAME'];
$sDesc = $arSection['DESCRIPTION'];

?>

<section id="inBox" class="inBox">
    <div class="wrap inBox-wrap">
        <h2 class="h2 inBox__h2"><?=$sTitle;?></h2>
        <div class="inBox-list">
            <? foreach ($arItems as $arItem): ?>
            <div class="inBox-item">
                <img src="<?=$arItem['PREVIEW_PICTURE'];?>" alt class="inBox-item__img">
                <h4 class="inBox-item__title"><?=$arItem['~NAME'];?></h4>
                <p class="inBox-item__descr"><?=$arItem['~PREVIEW_TEXT'];?></p>
            </div>
            <? endforeach; ?>
        </div>
        <div class="swiper-container inBox-slider">
            <div class="swiper-wrapper">
                <? foreach ($arItems as $arItem): ?>
                <div class="swiper-slide">
                    <img src="<?=$arItem['PREVIEW_PICTURE'];?>" alt class="inBox-item__img">
                    <h4 class="inBox-item__title"><?=$arItem['~NAME'];?></h4>
                    <p class="inBox-item__descr"><?=$arItem['~PREVIEW_TEXT'];?></p>
                </div>
                <? endforeach; ?>
            </div>
            <div class="swiper-button-next"></div>
            <div class="swiper-button-prev"></div>
        </div>
    </div>
    <? if($arRuleFile): ?>
    <a href="<?=$arRuleFile['SRC'];?>" target="_blank" class="red-btn inBox-btn">Скачать правила .pdf </a>
    <? endif; ?>
</section>