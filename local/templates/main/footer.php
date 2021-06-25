<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}

use Bitrix\Main\Localization\Loc;

Loc::loadMessages(__FILE__);
?>

                    <div role="dialog" class="v-dialog__container" data-v-658abb72><!----></div>
                    <div role="dialog" class="v-dialog__container"><!----></div>

                </main>

                <footer class="footer">
                    <div class="wrap footer-wrap">
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
                            "SHOW_NAV" => 'Y',
                            "NAV_CLASS" => 'footer-nav',
                            "UL_CLASS" => 'footer-nav__ul',
                            "LI_CLASS" => 'footer-nav__li',
                            "A_CLASS" => 'footer-nav__link',
                            "ACTIVE_CLASS" => 'active',
                        ], null, ['HIDE_ICONS' => 'Y']); ?>
                        <div class="footer-bottom">
                            <div class="footer-copyrigh">
                                <img src="<?=SITE_TEMPLATE_PATH;?>/assets/img/author.svg" alt class="footer-copyrigh__img">
                                <p class="footer-copyrigh__text">Copyright &copy;<?=date('Y');?> <?=Loc::getMessage('MAIN_COPYRIGTH_TEXT');?></p>
                            </div>
                            <img src="<?=SITE_TEMPLATE_PATH;?>/assets/img/logo.png" alt class="footer__logo">
                            <div class="footer-social">
                                <?php
                                /*
                                $APPLICATION->IncludeComponent(
                                    'defa:block',
                                    'social_links', [
                                        "CACHE_TIME" => "36000000",
                                        "CACHE_TYPE" => "A",
                                        "CACHE_GROUPS" => "N",
                                        "IBLOCK_ID" => \CustomBitrix\Tools\Iblock::getIdByCode('social', 'content'),
                                        "IBLOCK_TYPE" => 'content',
                                        "A_CLASS" => 'footer-social__link',
                                    ],
                                    false);
                                */
                                ?>
                            </div>
                        </div>
                    </div>
                </footer>

            </div>
        </div>
    </div>

<?php
/*
$APPLICATION->IncludeComponent('defa:block', 'global_script', [
    "CACHE_TIME" => "36000000",
    "CACHE_TYPE" => "A",
    "CACHE_GROUPS" => "N",
], false);
*/?>