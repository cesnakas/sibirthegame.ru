<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}
use Bitrix\Main\Localization\Loc;
use Bitrix\Main\Page\Asset;

Loc::loadMessages(__FILE__);

$bMainPage = $APPLICATION->GetCurPage(false) === '/';

// $sSpritePath = SITE_TEMPLATE_PATH.'/dist/icons/sprite.svg';
?>
<!DOCTYPE html>
<html lang="<?= LANGUAGE_ID; ?>">
<head>

    <!-- Facebook Pixel Code -->
    <script>!function(f,b,e,v,n,t,s){if(f.fbq)return;n=f.fbq=function(){n.callMethod?n.callMethod.apply(n,arguments):n.queue.push(arguments)};if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';n.queue=[];t=b.createElement(e);t.async=!0;t.src=v;s=b.getElementsByTagName(e)[0];s.parentNode.insertBefore(t,s)}(window, document,'script','https://connect.facebook.net/en_US/fbevents.js');fbq('init', '486890409068007');fbq('track', 'PageView');</script><noscript><img height="1" width="1" style="display:none"src="https://www.facebook.com/tr?id=486890409068007&ev=PageView&noscript=1"/></noscript>
    <!-- End Facebook Pixel Code -->

<?php
    $APPLICATION->ShowHead();
    $asset = Asset::getInstance();
    // Meta
    $asset->addString('<meta name="viewport" content="width=device-width, initial-scale=1">');
    // Fonts
    $asset->addCss('https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700,900&display=swap');
    // CSS
    $asset->addCss(SITE_TEMPLATE_PATH.'/assets/_nuxt/vendors~app.51c570d.css');
    $asset->addCss(SITE_TEMPLATE_PATH.'/assets/_nuxt/app.4b2f544.css');
    $asset->addCss(SITE_TEMPLATE_PATH.'/assets/_nuxt/vendors~pages/index.0d79d52.css');
    $asset->addCss(SITE_TEMPLATE_PATH.'/assets/_nuxt/vendors~app.51c570d.css');
    $asset->addCss(SITE_TEMPLATE_PATH.'/assets/_nuxt/app.4b2f544.css');
    $asset->addCss(SITE_TEMPLATE_PATH.'/assets/_nuxt/vendors~pages/index.0d79d52.css');
    // JS
    $asset->addJs(SITE_TEMPLATE_PATH.'/assets/_nuxt/runtime.9f0d302.js');
    $asset->addJs(SITE_TEMPLATE_PATH.'/assets/_nuxt/commons/app.738ff04.js');
    $asset->addJs(SITE_TEMPLATE_PATH.'/assets/_nuxt/vendors~app.10606dd.js');
    $asset->addJs(SITE_TEMPLATE_PATH.'/assets/_nuxt/app.a2b092c.js');
    $asset->addJs(SITE_TEMPLATE_PATH.'/assets/_nuxt/pages/index.5d11531.js');
    $asset->addJs(SITE_TEMPLATE_PATH.'/assets/_nuxt/vendors~pages/index.8d368ed.js');
    //
    // $asset->addJs(SITE_TEMPLATE_PATH.'/assets/_nuxt/runtime.9f0d302.js');
    // $asset->addJs(SITE_TEMPLATE_PATH.'/assets/_nuxt/pages/index.5d11531.js');
    // $asset->addJs(SITE_TEMPLATE_PATH.'/assets/_nuxt/vendors~pages/index.8d368ed.js');
    // $asset->addJs(SITE_TEMPLATE_PATH.'/assets/_nuxt/commons/app.738ff04.js');
    // $asset->addJs(SITE_TEMPLATE_PATH.'/assets/_nuxt/vendors~app.10606dd.js');
    // $asset->addJs(SITE_TEMPLATE_PATH.'/assets/_nuxt/app.a2b092c.js');

    // jquery
    $asset->addJs('https://code.jquery.com/jquery-3.6.0.min.js');
    // bootstrap
    $asset->addCss('https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css');
    $asset->addJs('https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js');
    // ?
    $asset->addCss('https://cdn.jsdelivr.net/npm/@mdi/font@latest/css/materialdesignicons.min.css');
    // Custom
    $asset->addCss(SITE_TEMPLATE_PATH.'/dist/css/app.css');
    $asset->addCss(SITE_TEMPLATE_PATH.'/dist/css/main.css');
    $asset->addJs(SITE_TEMPLATE_PATH.'/dist/js/main.js');
?>

    <title><?$APPLICATION->ShowTitle(false);?></title>

    <link rel="icon" href="/favicon.ico" type="image/x-icon">
    <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">

</head>
<body>

    <? $APPLICATION->ShowPanel(); ?>

    <div data-server-rendered="true" id="__nuxt">
        <div id="__layout">
            <div data-app="">

                <header class="header" <?= ($USER->IsAdmin()) ? 'style="top: 39px;"' : '' ?>>
                    <div class="container wrap header-wrap">

                        <a class="header-logo" href="<?=SITE_DIR?>">
                            <img src="<?= SITE_TEMPLATE_PATH; ?>/assets/img/logo.png" alt="logo" class="header-logo__img">
                            <span class="header-logo__text"><?=GetMessage('MAIN_LOGO_TEXT');?></span>
                        </a>

                        <?
                        $APPLICATION->IncludeComponent(
                            'bitrix:menu',
                            'list',
                            [
                                "CHILD_MENU_TYPE" => "",
                                "MAX_LEVEL" => "1",
                                "MENU_CACHE_TIME" => "36000000",
                                "MENU_CACHE_TYPE" => "A",
                                "ROOT_MENU_TYPE" => "top",
                                "ALLOW_MULTI_SELECT" => "N",
                                "USE_EXT" => "N",
                                "DELAY" => "N",
                                "SHOW_NAV" => 'Y',
                                "NAV_CLASS" => 'header-nav',
                                "UL_CLASS" => 'header-nav__ul',
                                "LI_CLASS" => 'header-nav__li',
                                "A_CLASS" => 'header-nav__link',
                                "ACTIVE_CLASS" => 'active',
                            ],
                            null, ['HIDE_ICONS' => 'Y']
                        );
                        ?>

                        <?/*<a class="red-outline-btn header__btn"><?=Loc::getMessage('MAIN_BTN_BUY');?></a>*/?>

                        <?/*
                        <a class="header__basket-btn" href="#">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24">
                                <use href="<?=SITE_TEMPLATE_PATH?>/dist/img/icons.svg#basket" xlink:href="<?=SITE_TEMPLATE_PATH?>/dist/img/icons.svg#basket"></use>
                            </svg>
                            <span>Корзина</span>
                        </a>
                        */?>

                        <?$APPLICATION->IncludeComponent(
                            'bitrix:sale.basket.basket.line',
                            '',
                            [
                                "HIDE_ON_BASKET_PAGES" => 'N',
                                "PATH_TO_BASKET" => SITE_DIR.'basket/',
                                "PATH_TO_ORDER" => SITE_DIR.'personal/order/make/',
                                "PATH_TO_PERSONAL" => SITE_DIR.'personal/',
                                "PATH_TO_PROFILE" => SITE_DIR.'personal/',
                                "PATH_TO_REGISTER" => SITE_DIR.'login/',
                                "POSITION_FIXED" => 'N',
                                "POSITION_HORIZONTAL" => 'right',
                                "POSITION_VERTICAL" => 'top',
                                "SHOW_AUTHOR" => 'N',
                                "SHOW_DELAY" => 'N',
                                "SHOW_EMPTY_VALUES" => 'Y',
                                "SHOW_IMAGE" => 'N',
                                "SHOW_NOTAVAIL" => 'N',
                                "SHOW_NUM_PRODUCTS" => 'Y',
                                "SHOW_PERSONAL_LINK" => 'N',
                                "SHOW_PRICE" => 'Y',
                                "SHOW_PRODUCTS" => 'Y',
                                "SHOW_SUMMARY" => 'Y',
                                "SHOW_TOTAL_PRICE" => 'Y'
                            ]
                        );?>

                        <img src="<?= SITE_TEMPLATE_PATH; ?>/assets/img/burger.svg" alt="Меню" class="header-burger js-header-btn">

                        <div class="header-mobileMenu js-mobile-menu">
                            <?
                            $APPLICATION->IncludeComponent('bitrix:menu', 'list', [
                                "CHILD_MENU_TYPE" => "",
                                "MAX_LEVEL" => "1",
                                "MENU_CACHE_TIME" => "36000000",
                                "MENU_CACHE_TYPE" => "A",
                                "ROOT_MENU_TYPE" => "top",
                                "ALLOW_MULTI_SELECT" => "N",
                                "USE_EXT" => "N",
                                "DELAY" => "N",
                                "UL_CLASS" => 'header-mobileMenu__ul',
                                "LI_CLASS" => 'header-mobileMenu__li',
                                "A_CLASS" => 'header-mobileMenu__link',
                                "ACTIVE_CLASS" => 'active',
                            ], null, ['HIDE_ICONS' => 'Y']);
                            ?>

                            <a class="red-outline-btn header-mobileMenu__btn"><?=Loc::getMessage('MAIN_BTN_BUY');?></a>

                        </div>

                    </div>
                </header>

                <main class="content">
