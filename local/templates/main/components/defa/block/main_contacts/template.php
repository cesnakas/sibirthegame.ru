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

$sTitle = $arSection['NAME'];
$sDesc = $arSection['DESCRIPTION'];
?>
<section class="preOrder">
    <div id="contacts" class="contacts">
        <div class="wrap contacts-wrap">
            <h2 class="h2 contacts__h2"><?=$sTitle;?></h2>
            <div class="contacts-content">
                <div class="contacts-content__list"><?=$sDesc;?></div>
<!--                <div class="contacts-content__info">-->
<!--                    <img src="img/whatsapp.svg" alt class="contacts-content__info__img">-->
<!--                    <p class="contacts-content__info__text">Также вы можете заказать игру,-->
<!--                        связавшись с нами в <a class="red-link">WhatsApp</a></p>-->
<!--                </div>-->
            </div>
        </div>
    </div>
</section>