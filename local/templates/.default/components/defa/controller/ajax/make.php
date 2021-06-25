<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}


use Bitrix\Main\Context,
    CustomBitrix\Checkout,
    CustomBitrix\Tools,
    Bitrix\Main\Loader,
    Bitrix\Sale\Location,
    Bitrix\Sale
    ;

global $USER;
Loader::includeModule('iblock');
Loader::includeModule('catalog');
Loader::includeModule('sale');

$arResultOrder = [];
$oRequest = Context::getCurrent()->getRequest();

$arProduct = Tools\Iblock::getElement([
  'FILTER' => ['IBLOCK_ID' => \CustomBitrix\Tools\Iblock::getIdByCode('products', 'catalog'), 'ACTIVE' => 'Y',],
  'SELECT' => ['ID'],
]);
$iProductId = (int) $arProduct['ID'];

try {
    $arRequest = json_decode(file_get_contents("php://input"), true);
} catch (Exception $e) {
}


$iQuantity = (int) ($oRequest->get('quantity') ?: $arRequest['quantity']);
$sBuyerName = (string) ($oRequest->get('name') ?: $arRequest['name']);
$sBuyerEmail = (string) ($oRequest->get('email') ?: $arRequest['email']);
$sBuyerPhone = (string) ($oRequest->get('phone') ?: $arRequest['phone']);
$sDeliveryZip = (string) ($oRequest->get('zip') ?: $arRequest['zip']);
$sDeliveryCity = (string) ($oRequest->get('city') ?: $arRequest['city']);
$sDeliveryAddress = (string) ($oRequest->get('address') ?: $arRequest['address']);

$sDeliveryEntrance = (string) ($oRequest->get('entrance') ?: $arRequest['entrance']);
$sDeliveryFloor = (string) ($oRequest->get('floor') ?: $arRequest['floor']);
$sDeliveryIntercom = (string) ($oRequest->get('intercom') ?: $arRequest['intercom']);

$sDeliveryType = (string) ($oRequest->get('delivery') ?: $arRequest['delivery']);

try {
    if ($iQuantity < 1) {
        throw new Exception('Некорректные данные');
    }

    $iUserId = $USER->IsAuthorized() ? $USER->GetID() : null;
    if (!$iUserId) {
        $arUser = \Bitrix\Main\UserTable::getList([
            'filter' => ['EMAIL' => $sBuyerEmail], 'select' => ['ID'],
        ])->Fetch();
        if ($arUser) {
            $iUserId = $arUser['ID'];
        } else {
            $oUser = new \CUser;
            $sConfirmCode = md5(CMain::GetServerUniqID().uniqid());
            $sTmpPass = md5(time());
            $arFields = [
                'ACTIVE' => 'Y',
                'LID' => SITE_ID,
                'ADMIN_NOTES' => 'Создан при заказе',
                'CONFIRM_CODE' => $sConfirmCode,
                'LOGIN' => $sBuyerEmail,
                'NAME' => $sBuyerName,
                'PERSONAL_PHONE' => $sBuyerPhone,
                'EMAIL' => $sBuyerEmail,
            ];
            $arFields['CONFIRM_PASSWORD'] = $arFields['PASSWORD'] = CUser::GeneratePasswordByPolicy([2]);

            $iUserId = $oUser->add($arFields);

            if ($iUserId < 1) {
                \Bitrix\Main\Diag\Debug::writeToFile(
                    ['USER_CREATE' => $oUser->LAST_ERROR],
                    date('H:i:s'),
                    '/local/logs/' . date('Y-m-d') . '_order_errors.log'
                );
                throw new Exception('Пользователь не создан');
            }

            // Раскоментировать если нужно оповещение пользователя
//            $arEventFields = [
//                'USER_ID' => $iUserId, // #USER_ID# - ID пользователя
//                'LOGIN' => $arFields['LOGIN'], // #LOGIN# - Логин
//                'EMAIL' => $arFields['EMAIL'], // #EMAIL# - EMail
//                'NAME' => $arFields['NAME'], // #NAME# - Имя
//                'LAST_NAME' => $arFields['LAST_NAME'], // #LAST_NAME# - Фамилия
//                'USER_IP' => $_SERVER["REMOTE_ADDR"], // #USER_IP# - IP пользователя
//                'USER_HOST' =>  @gethostbyaddr($_SERVER["REMOTE_ADDR"]), // #USER_HOST# - Хост пользователя
//                'CONFIRM_CODE' => $sConfirmCode, // #CONFIRM_CODE# - Код подтверждения
//            ];
//            $oEvent = new \CEvent();
//            $oEvent->SendImmediate("NEW_USER", SITE_ID, $arEventFields);
        }
    }

    Checkout\Basket::clearBasket();
    Checkout\Basket::addByProductById([$iProductId => $iQuantity]);
    $oOrder = new Checkout\OrderNew($iUserId);
    $oOrder->getOrder()->setPersonTypeId(1);
    $oOrder->setBasket(Checkout\Basket::getBasket());
    $oOrder->setLocation($sDeliveryCity, $sDeliveryZip);

    foreach ($oOrder->getOrder()->getPropertyCollection() as $oProp) {
        $sCode = $oProp->getField('CODE');
        switch ($sCode) {
            case 'NAME':
                $oProp->setValue($sBuyerName);
                break;
            case 'EMAIL':
                $oProp->setValue($sBuyerEmail);
                break;
            case 'PHONE':
                $oProp->setValue($sBuyerPhone);
                break;
            case 'ADDRESS':
                $oProp->setValue($sDeliveryAddress);
                break;
            case 'ENTRANCE':
                $oProp->setValue($sDeliveryEntrance);
                break;
            case 'FLOOR':
                $oProp->setValue($sDeliveryFloor);
                break;
            case 'INTERCOM':
                $oProp->setValue($sDeliveryIntercom);
                break;
        }
    }

    $arDelivery = \Bitrix\Sale\Delivery\Services\Table::getList([
        'filter' => ['XML_ID' => $sDeliveryType],
        'select' => ['ID'],
    ])->Fetch();
    $oOrder->setDeliveryByID($arDelivery['ID']);

    $arPayment = current($oOrder->getAvailablePayments());
    $oOrder->setPaymentByID($arPayment['ID']);


    $oOrder->getOrder()->doFinalAction(true);
    $oResult = $oOrder->getOrder()->save();

    if (!$oResult->isSuccess()) {
        \Bitrix\Main\Diag\Debug::writeToFile(
            ['ORDER' => $oResult->getErrorMessages()],
            date('H:i:s'),
            '/local/logs/'.date('Y-m-d').'_order_errors.log'
        );
        throw new Exception('Заказ не создан');
    }

    $oNewOrder = Sale\Order::load($oOrder->getOrder()->getId());
    $arResultOrder['success'] = true;
    $arResultOrder['data']['order_id'] = $oNewOrder->getId();
    $arResultOrder['data']['order_num'] =$oNewOrder->getField('ACCOUNT_NUMBER');

    // Проверка стоимости доставки
    $oDeliviry = $oNewOrder->getShipmentCollection()->current();
    if (is_object($oDeliviry) && get_class($oDeliviry->getDelivery()) === 'Sale\Handlers\Delivery\ElonsoftpostProfile'){
        if ($oNewOrder->getDeliveryPrice() <= 0) {
            $oNewOrder->setField('REASON_CANCELED', 'Некорректный расчет доставки: цена=' . $oNewOrder->getDeliveryPrice());
            $oNewOrder->setField('CANCELED', 'Y');
            $oNewOrder->save();
            throw new Exception('Системная ошибка');
        }
    }

    $paymentCollection = $oNewOrder->getPaymentCollection();
    $oPayment = $paymentCollection[0];

    /** @var \Sale\Handlers\PaySystem\RoboxchangeHandler  $oPaymentService */
    $oPaymentService = $oPayment->getPaySystem();

    ob_start();
    $oPaymentService->initiatePay($oPayment);
    $arResultOrder['data']['pay_form'] = ob_get_contents();
    ob_end_clean();
} catch (Exception $e) {
    $arResultOrder['success'] = false;
    $arResultOrder['data'] = ['error' => $e->getMessage()];
}




header('Content-Type: application/json');
echo json_encode($arResultOrder);
die();