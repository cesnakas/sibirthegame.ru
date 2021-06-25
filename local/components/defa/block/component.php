<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

if(strlen($arParams["FILTER_NAME"])<=0 || !preg_match("/^[A-Za-z_][A-Za-z01-9_]*$/", $arParams["FILTER_NAME"]))
{
	$arrFilter = array();
}
else
{
	$arrFilter = $GLOBALS[$arParams["FILTER_NAME"]];
	if(!is_array($arrFilter))
		$arrFilter = array();
}

$arResult["FILTER"] = array_merge(
	array(
		"IBLOCK_ID" => intval($arParams["IBLOCK_ID"]),
		"ACTIVE" => "Y"
	),
	$arrFilter
);

if($this->StartResultCache(false, array(($arParams["CACHE_GROUPS"]==="N"? false: $USER->GetGroups()), serialize($arrFilter))))
{
	$this->SetResultCacheKeys(array());
	$this->IncludeComponentTemplate();
}
?>