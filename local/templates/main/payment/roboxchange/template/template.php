<?php
	use Bitrix\Main\Localization\Loc;
	Loc::loadMessages(__FILE__);
	$arRequestParams = [
        'MerchantLogin' => htmlspecialcharsbx($params['ROBOXCHANGE_SHOPLOGIN']),
        'OutSum' => htmlspecialcharsbx($params['PAYMENT_SHOULD_PAY']),
	    'InvId' => htmlspecialcharsbx($params['PAYMENT_ID']),
	    'Description' => htmlspecialcharsbx($params['ROBOXCHANGE_ORDERDESCR']),
	    'SignatureValue' => $params['SIGNATURE_VALUE'],
	    'Email' => htmlspecialcharsbx($params['BUYER_PERSON_EMAIL']),

	    'FinalStep' => 1,
	    'SHP_HANDLER' => 'ROBOXCHANGE',
	    'SHP_BX_PAYSYSTEM_CODE' => $params['BX_PAYSYSTEM_CODE'],
    ];
	if ($params['PS_MODE'] != "0") {
	    $arRequestParams['IncCurrLabel'] = htmlspecialcharsbx($params['PS_MODE']);
	}
	if ($params['PS_IS_TEST'] == 'Y') {
	    $arRequestParams['IsTest'] = 1;
	}

	echo $params['URL'].(strpos($params['URL'], '?') === false ? '?' : ':').http_build_query($arRequestParams);
