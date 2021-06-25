<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}


use Bitrix\Main\Context,
    CustomBitrix\Checkout,
    CustomBitrix\Tools,
    Bitrix\Main\Loader,
    Bitrix\Sale\Location
    ;

global $USER;
Loader::includeModule('iblock');
Loader::includeModule('catalog');
Loader::includeModule('sale');

$oRequest = Context::getCurrent()->getRequest();

$arProduct = Tools\Iblock::getElement([
    'FILTER' => ['IBLOCK_ID' => \CustomBitrix\Tools\Iblock::getIdByCode('products', 'catalog'), 'ACTIVE' => 'Y',],
    'SELECT' => ['ID'],
]);

try {
    $arRequest = json_decode(file_get_contents("php://input"), true);
} catch (Exception $e) {
}

$iProductId = (int) $arProduct['ID'];

$iQuantity = (int) ($oRequest->get('quantity') ?: $arRequest['quantity']);
$sDeliveryZip = (string) ($oRequest->get('zip') ?: $arRequest['zip']);
$sDeliveryCity = (string) ($oRequest->get('city') ?: $arRequest['city']);

$oOrder = new Checkout\OrderFake();
$oOrder->addProduct($iProductId, $iQuantity);
$oOrder->setLocation($sDeliveryCity, $sDeliveryZip);

header('Content-Type: application/json');
echo json_encode(array_values($oOrder->getListAvailableDeliveries())); die();