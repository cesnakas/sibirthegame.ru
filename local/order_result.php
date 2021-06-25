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

$iOrderNum = (int) $oRequest->get('InvId'); // 29
$iPaySystem = (int) $oRequest->get('SHP_BX_PAYSYSTEM_CODE'); // 1901.00
$sPayHandler = (string) $oRequest->get('ROBOXCHANGE');
$sPaySign = (string) $oRequest->get('SignatureValue');
$fOrderSum = (float) $oRequest->get('OutSum');
$bSuccess = $oRequest->get('result') === 'success';
\Bitrix\Main\Loader::includeModule('sale');
$sSuccess = 'n';
$sMsg = '';

if ($iOrderNum && ($oOrder = \Bitrix\Sale\Order::load($iOrderNum))) {
    if ($bSuccess && $oOrder->isPaid()) {
        $sSuccess = 'y';
        $sMsg = 'Оплачено';
    } else {
        $sMsg = 'Оплата отклонена';
    }
} else {
    $sMsg = 'Заказ не найден';
}

LocalRedirect("/?orderId={$iOrderNum}&success={$sSuccess}&msg={$sMsg}");

/**
 * success
 * OutSum: 1901.00
InvId: 29
SHP_BX_PAYSYSTEM_CODE: 2
SHP_HANDLER: ROBOXCHANGE
SignatureValue: 086aed639b7c0b1336dbebc3747f57e5
IsTest: 1
Culture: ru
 */

/**
 * fail
 * OutSum: 1901.00
InvId: 29
SHP_BX_PAYSYSTEM_CODE: 2
SHP_HANDLER: ROBOXCHANGE
IsTest: 1
Culture: ru
 */