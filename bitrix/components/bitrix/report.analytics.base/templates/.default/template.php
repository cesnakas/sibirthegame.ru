<?php

\Bitrix\Main\Loader::includeModule('report');
\Bitrix\Main\UI\Extension::load('report.js.dashboard');
\Bitrix\Main\UI\Extension::load('report_visual_constructor');
\Bitrix\Main\UI\Extension::load('loader');
$APPLICATION->SetTitle($arResult['ANALYTIC_BOARD_TITLE']);

$isBitrix24Template = SITE_TEMPLATE_ID === "bitrix24";
if ($isBitrix24Template)
{
	$this->SetViewTarget('inside_pagetitle');
}
?>

<? if (!$isBitrix24Template): ?>
<div class="tasks-interface-filter-container">
	<? endif ?>

	<div class="pagetitle-container<? if (!$isBitrix24Template): ?> pagetitle-container-light<? endif ?> pagetitle-flexible-space">
		<div class="pagetitle-container pagetitle-align-right-container">

		</div>
	</div>
	<? if (!$isBitrix24Template): ?>
</div>
<? endif ?>
<?php
if ($isBitrix24Template)
{
	$this->EndViewTarget();
}

?>
<div id="report-analytics-page" class="report-analytics-page-wrapper">
	<?
	$APPLICATION->IncludeComponent("bitrix:ui.sidepanel.wrappermenu", "", array(
		"ID" => 'report-analytic-left-menu',
		"ITEMS" => $arResult['MENU_ITEMS'],
		"TITLE" => $arResult['ANALYTIC_BOARD_LEFT_TITLE']
	));
	?>
	<div class="report-analytics-content"></div>
</div>

<script>
	new BX.Report.Analytics.Page({
		scope: document.getElementById('report-analytics-page'),
		menuScope: document.getElementById('report-analytic-left-menu'),
		defaultBoardKey: <?=CUtil::PhpToJSObject($arResult['ANALYTIC_BOARD_KEY'])?>,
		defaultBoardTitle: <?=CUtil::PhpToJSObject($arResult['ANALYTIC_BOARD_TITLE'])?>
	})
</script>