<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}

use \CustomBitrix\Tools;

\Bitrix\Main\Loader::includeModule('catalog');

$arLinks = Tools\Iblock::getElements([
    'FILTER' => [
       'IBLOCK_ID' => Tools\Iblock::getIdByCode('social', 'content'), 'ACTIVE' => 'Y',
    ],
    'ORDER' => ['sort' => 'asc', 'name' => 'asc'],
    'ID' => 'NAME',
    'SELECT' => ['ID', 'NAME', 'IBLOCK_ID', 'PREVIEW_PICTURE', 'PREVIEW_TEXT', 'CODE',],
]);

$arValues = Tools\Iblock::getElements([
    'FILTER' => ['IBLOCK_ID' => Tools\Iblock::getIdByCode('values', 'ref'), 'ACTIVE' => 'Y',],
    'ID' => 'CODE',
    'SELECT' => ['ID', 'NAME', 'IBLOCK_ID', 'PREVIEW_PICTURE', 'PREVIEW_TEXT', 'CODE',],
]);

$arPhones = $arValues['phone']['PROPERTIES']['VALUES']['VALUE'];
$arEmails = $arValues['email']['PROPERTIES']['VALUES']['VALUE'];
$sCopyright = (string) str_replace('#YEAR#', date('Y'), $arValues['copyright']['~PREVIEW_TEXT']);
$iCopyrightLogo = $arValues['copyright']['PREVIEW_PICTURE'] ?: current($arValues['copyright']['PROPERTIES']['FILE']['VALUE']);
$iLogo = $arValues['logo']['PREVIEW_PICTURE'] ?: current($arValues['logo']['PROPERTIES']['FILE']['VALUE']);
$iRule = current($arValues['rules']['PROPERTIES']['FILE']['VALUE']);

$arProduct = Tools\Iblock::getElement([
  'FILTER' => ['IBLOCK_ID' => Tools\Iblock::getIdByCode('products', 'catalog'), 'ACTIVE' => 'Y',],
  'SELECT' => ['ID', 'IBLOCK_ID'],
]);
$arPrice = \CCatalogProduct::GetOptimalPrice($arProduct['ID']);
$iPrice = $arPrice['DISCOUNT_PRICE'];
$sCurrency = \CustomBitrix\Tools\Text::declensionOfNouns($iPrice, 'рубль', 'рубля', 'рублей', false);
$sOrderText = (string) $arValues['order_text']['~PREVIEW_TEXT'];
$sPickUpText = (string) $arValues['pick_up']['~PREVIEW_TEXT'];

$arBannersTexts = [];
foreach($arValues['banner_buy']['PROPERTIES']['VALUES']['VALUE'] as $iKey => $_) {
    $arBannersTexts[$arValues['banner_buy']['PROPERTIES']['VALUES']['DESCRIPTION'][$iKey]]
        = $arValues['banner_buy']['PROPERTIES']['VALUES']['~VALUE'][$iKey];
}

$arResult = [
    'logo' => \CFile::GetPath($iLogo),
    'logo_alt' => 'Сибирь. Начало',
    'author_logo' => \CFile::GetPath($iCopyrightLogo),
    'author_logo_alt' => 'НКО Система вечных ценностей',
    'rules' => \CFile::GetPath($iRule),
    'game_price' => $iPrice,
    'game_currency' => $sCurrency,
    'game_preorder' => $arProduct['PROPERTIES']['PREORDER']['VALUE'] === 'Y',
    'contacts' => [
        'phone' => current($arPhones),
        'email' => current($arEmails),
        'whatsApp' => $arLinks['whatsApp']['PROPERTIES']['LINK']['VALUE'],
        'fb' => $arLinks['fb']['PROPERTIES']['LINK']['VALUE'],
        'instagram' => $arLinks['instagram']['PROPERTIES']['LINK']['VALUE'],
        'vk' => $arLinks['vk']['PROPERTIES']['LINK']['VALUE'],
        'youtube' => $arLinks['youtube']['PROPERTIES']['LINK']['VALUE'],
    ],
    'copyright' => $sCopyright,
    'banner' => $arBannersTexts,
    'order_text' => $sOrderText,
    'pick_up_text' => $sPickUpText,
];

header('Content-Type: application/json');

echo json_encode($arResult); die();