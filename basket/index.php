<?
require($_SERVER['DOCUMENT_ROOT'].'/bitrix/header.php');
?>

    <section class="basket__section">
        <div class="container">

        <?$APPLICATION->IncludeComponent(
            "bitrix:sale.basket.basket",
            ".default",
            Array(
                "ACTION_VARIABLE" => "action",
                "ADDITIONAL_PICT_PROP_1" => "-",
                "AUTO_CALCULATION" => "Y",
                "BASKET_IMAGES_SCALING" => "adaptive",
                "COLUMNS_LIST" => array("NAME","DISCOUNT","WEIGHT","DELETE","DELAY","TYPE","PRICE","QUANTITY"),
                "COLUMNS_LIST_EXT" => array("PREVIEW_PICTURE","DISCOUNT","DELETE","DELAY","TYPE","SUM"),
                "COLUMNS_LIST_MOBILE" => array("PREVIEW_PICTURE","DISCOUNT","DELETE","DELAY","TYPE","SUM"),
                "COMPATIBLE_MODE" => "Y",
                "CORRECT_RATIO" => "Y",
                "DEFERRED_REFRESH" => "N",
                "DISCOUNT_PERCENT_POSITION" => "bottom-right",
                "DISPLAY_MODE" => "extended",
                "EMPTY_BASKET_HINT_PATH" => "/",
                "GIFTS_BLOCK_TITLE" => "Выберите один из подарков",
                "GIFTS_CONVERT_CURRENCY" => "Y",
                "GIFTS_HIDE_BLOCK_TITLE" => "N",
                "GIFTS_HIDE_NOT_AVAILABLE" => "N",
                "GIFTS_MESS_BTN_BUY" => "Выбрать",
                "GIFTS_MESS_BTN_DETAIL" => "Подробнее",
                "GIFTS_PAGE_ELEMENT_COUNT" => "4",
                "GIFTS_PLACE" => "BOTTOM",
                "GIFTS_PRODUCT_PROPS_VARIABLE" => "prop",
                "GIFTS_PRODUCT_QUANTITY_VARIABLE" => "",
                "GIFTS_SHOW_DISCOUNT_PERCENT" => "Y",
                "GIFTS_SHOW_IMAGE" => "Y",
                "GIFTS_SHOW_NAME" => "Y",
                "GIFTS_SHOW_OLD_PRICE" => "Y",
                "GIFTS_TEXT_LABEL_GIFT" => "Подарок",
                "HIDE_COUPON" => "N",
                "LABEL_PROP" => array(),
                "OFFERS_PROPS" => array("SIZES_SHOES","SIZES_CLOTHES"),
                "PATH_TO_ORDER" => SITE_DIR."personal/order/make/",
                "PRICE_DISPLAY_MODE" => "Y",
                "PRICE_VAT_SHOW_VALUE" => "N",
                "PRODUCT_BLOCKS_ORDER" => "props,sku,columns",
                "QUANTITY_FLOAT" => "N",
                "SET_TITLE" => "N",
                "SHOW_DISCOUNT_PERCENT" => "N",
                "SHOW_FILTER" => "N",
                "SHOW_RESTORE" => "Y",
                "TEMPLATE_THEME" => "",
                "TOTAL_BLOCK_DISPLAY" => array("bottom"),
                "USE_DYNAMIC_SCROLL" => "Y",
                "USE_ENHANCED_ECOMMERCE" => "N",
                "USE_GIFTS" => "N",
                "USE_PREPAYMENT" => "N",
                "USE_PRICE_ANIMATION" => "Y"
            )
        );?>

        </div>
    </section>

<?
require($_SERVER['DOCUMENT_ROOT'].'/bitrix/footer.php');
?>