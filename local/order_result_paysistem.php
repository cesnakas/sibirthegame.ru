<?php
define('STOP_STATISTICS', true);
define('NO_KEEP_STATISTIC', 'Y');
define('NO_AGENT_STATISTIC','Y');
define('DisableEventsCheck', true);
define('BX_SECURITY_SHOW_MESSAGE', true);
define('NOT_CHECK_PERMISSIONS', true);

$siteId = isset($_REQUEST['SITE_ID']) && is_string($_REQUEST['SITE_ID']) ? $_REQUEST['SITE_ID'] : '';
$siteId = mb_substr(preg_replace('/[^a-z0-9_]/i', '', $siteId), 0, 2);
if (!empty($siteId) && is_string($siteId))
{
    define('SITE_ID', $siteId);
}

require_once($_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/main/include/prolog_before.php');

use \CustomBitrix\Tools;

$oRequest = \Bitrix\Main\Context::getCurrent()->getRequest();
$fOrderSum = (float) $oRequest->getPost('OutSum'); // Сумма, оплаченная покупателем
$iOrderNum = (int) $oRequest->getPost('InvId'); // Номер счета
$iOrderEmail = (string) $oRequest->getPost('EMail'); // EMail, указанный покупателем в процессе оплаты.
$fFee = (float) $oRequest->getPost('Fee'); // Комиссия
$sPaySign = (string) $oRequest->getPost('SignatureValue');


$iPaySystem = (int) $oRequest->get('SHP_BX_PAYSYSTEM_CODE');
$sPayHandler = (string) $oRequest->get('SHP_HANDLER');

\Bitrix\Main\Loader::includeModule('sale');
try {
    if (!$iOrderNum) {
        throw new Exception('Пустой номер заказа');
    }
    $oOrder = \Bitrix\Sale\Order::load($iOrderNum);
    if (!$oOrder) {
        throw new Exception('Номер заказа не найден в системе');
    }
    if ($oOrder->isPaid()) {
        throw new Exception('Уже оплачено');
    }
    if ($fOrderSum != $oOrder->getPrice()) {
        throw new Exception('Оплата не соотвествует стоимости заказа');
    }
    if ($iPaySystem !== $oOrder->getPaySystemIdList()[0]) {
        throw new Exception('Некорректная платежная система');
    }

    $oPayment = ($oOrder->getPaymentCollection())[0];
    $oPayment->setPaid("Y");
    $oOrder->save();

    if ($arFields = CustomBitrix\Tools\Order::fillMailFields($oOrder)) {
        CEvent::Send('SUCCESS_ORDER', SITE_ID, $arFields);
    }
    echo 'OK'.$iOrderNum;
} catch (Exception $e) {
    echo $e->getMessage();
}


