<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
/** @global CMain $APPLICATION */

use Bitrix\Main\Loader,
//    CComponentEngine,
    \Bitrix\Iblock\Component\Tools;


$arDefaultVariableAliases404 = array();
$arVariables = array();


$arUrlTemplates = CComponentEngine::makeComponentUrlTemplates([], $arParams["SEF_URL_TEMPLATES"]);
$arVariableAliases = CComponentEngine::makeComponentVariableAliases($arDefaultVariableAliases404, $arParams["VARIABLE_ALIASES"]);

$componentPage = CComponentEngine::ParseComponentPath(
    $arParams["SEF_FOLDER"],
    $arUrlTemplates,
    $arVariables
);


if(!$componentPage && isset($_REQUEST["q"]))
    $componentPage = "search";

//var_dump($componentPage);

if(!$componentPage && Loader::includeModule('iblock')){
    Tools::process404(
        ""
        ,($arParams["SET_STATUS_404"] === "Y")
        ,($arParams["SET_STATUS_404"] === "Y")
        ,($arParams["SHOW_404"] === "Y")
        ,$arParams["FILE_404"]
    );
}

CComponentEngine::initComponentVariables($componentPage, $arComponentVariables, $arVariableAliases, $arVariables);
$arResult = array(
    "FOLDER" => $arParams["SEF_FOLDER"],
    "URL_TEMPLATES" => $arUrlTemplates,
    "VARIABLES" => $arVariables,
    "ALIASES" => $arVariableAliases
);

//p($componentPage);
$this->IncludeComponentTemplate($componentPage);