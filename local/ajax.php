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


$APPLICATION->IncludeComponent('defa:controller', 'ajax', [
    'CACHE_TYPE' => 'N',
    'CACHE_TIME' => '-1',
    'SEF_FOLDER' => '/api/',
    'SEF_URL_TEMPLATES' => [
        'deliveries' => 'order/delivery/get-list/',
        'make' => 'order/make/',
        'var_global' => 'global/',
        'content_inBox' => 'content/in-box/',
        'content_slovnik' => 'content/slovnik/',
        'content_limitations' => 'content/limitations/',
        'content_mechanics' => 'content/mechanics/',
        'content_help' => 'content/help/',
        'content_publisher' => 'content/publisher/',
    ],]);