<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
use Bitrix\Main\Localization\Loc;
?>

    <div class="basket__wrap">
        <img class="basket__empty-img" src="<?=SITE_TEMPLATE_PATH?>/dist/img/basket-empty.png" alt="empty basket">
        <h6 class="mb-4">Ваша корзина пуста</h6>
        <?if (!empty($arParams['EMPTY_BASKET_HINT_PATH'])):?>
        <div>
            <?=Loc::getMessage(
                'SBB_EMPTY_BASKET_HINT',
                [
                    '#A1#' => '<a class="red-btn d-block" href="'.$arParams['EMPTY_BASKET_HINT_PATH'].'">',
                    '#A2#' => '</a>',
                ]
            )?>
        </div>
        <?endif;?>
    </div>
