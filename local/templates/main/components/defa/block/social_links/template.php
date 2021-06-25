<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}

$sSvgPath = SITE_TEMPLATE_PATH.'/assets/_nuxt/8a3f1b6fa0b73b4157a362fba094a178.svg';
$arLinks = \CustomBitrix\Tools\Iblock::getElements([
    'FILTER' => [
        'IBLOCK_ID' => \CustomBitrix\Tools\Iblock::getIdByCode('social', 'content'), 'ACTIVE' => 'Y',
    ],
    'ORDER' => ['sort' => 'asc', 'name' => 'asc'],
]);
?>
<?php foreach ($arLinks as $arLink): ?>
    <a href="<?=$arLink['PROPERTIES']['LINK']['VALUE'];?>" <?=$arParams['A_CLASS'] ? "class='{$arParams['A_CLASS']}'" : '';?> target="_blank">
        <svg xmlns="http://www.w3.org/2000/svg" class="footer-social__img icon sprite-icons">
            <use href="<?=$sSvgPath;?>#<?=$arLink['PROPERTIES']['ICON']['VALUE'];?>"
                 xlink:href="<?=$sSvgPath;?>#<?=$arLink['PROPERTIES']['ICON']['VALUE'];?>"></use>
        </svg>
    </a>
<?php endforeach; ?>
