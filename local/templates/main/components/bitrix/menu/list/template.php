<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}

$sSpritePath = SITE_TEMPLATE_PATH . '/dist/icons/sprite.svg';

//$iPrevLevel = 0;
$bShowNav = $arParams['SHOW_NAV'] === 'Y' || is_bool($arParams['SHOW_NAV']) && $arParams['SHOW_NAV'];
?>
<?php if ($bShowNav): ?><nav <?=$arParams['NAV_CLASS'] ? "class='{$arParams['NAV_CLASS']}'" : '';?>><? endif; ?>
    <ul <?=$arParams['UL_CLASS'] ? "class='{$arParams['UL_CLASS']}'" : ''; ?>>
        <?php foreach ($arResult as $arLink): ?>
            <?
            $sLiClass = trim($arParams['LI_CLASS']. ' ' . ($arLink['SELECTED'] ? $arParams['ACTIVE_CLASS'] : ''));
            $sAClass = $arParams['A_CLASS'];
            ?>
            <li <?=$sLiClass ? "class='{$sLiClass}'" : '';?>>
                <a href="<?=$arLink['LINK']?>" <?=$sAClass ? "class='{$sAClass}'" : '';?>><?=$arLink['TEXT']?></a>
            </li>
        <? endforeach; ?>
    </ul>
<?php if ($bShowNav): ?></nav><? endif; ?>