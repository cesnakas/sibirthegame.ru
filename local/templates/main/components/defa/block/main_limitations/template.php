<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}
$arItems = \CustomBitrix\Tools\Iblock::getElements([
    'FILTER' => ['IBLOCK_ID' => $arParams['IBLOCK_ID'], 'ACTIVE' => 'Y', 'ACTIVE_DATE'=> 'Y',],
    'ORDER' => ['sort' => 'asc', 'name' => 'asc',],
]);

$arItems = array_map(function($arItem) {
    $arItem['PREVIEW_PICTURE'] = CFile::GetPath($arItem['PROPERTIES']['ICON']['VALUE'] ?: $arItem['PREVIEW_PICTURE']);
    return $arItem;
}, $arItems);
?>

<section class="limitations">
    <div class="wrap limitations-wrap">
        <div class="limitations-list">
            <? foreach ($arItems as $arItem): ?>
            <div class="limitations-list__item">
                <img src="<?=$arItem['PREVIEW_PICTURE'];?>" alt
                                                     class="limitations-list__item__img"> <b
                    class="limitations-list__item__title"><?=$arItem['NAME'];?></b>
                <p class="limitations-list__item__descr"><?=$arItem['~PREVIEW_TEXT'];?></p>
            </div>
            <? endforeach; ?>
        </div>
    </div>
</section>