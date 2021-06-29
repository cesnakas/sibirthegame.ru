<?if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true) die();
/**
 * @global array $arParams
 * @global CUser $USER
 * @global CMain $APPLICATION
 * @global string $cartId
 */
$compositeStub = (isset($arResult['COMPOSITE_STUB']) && $arResult['COMPOSITE_STUB'] == 'Y');
?>

<? if(!$arResult['DISABLE_USE_BASKET']): ?>
    <a class="header__basket-btn" href="<?=$arParams['PATH_TO_BASKET']?>">

        <? if($arResult['NUM_PRODUCTS'] > 0): ?>
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor">
            <use href="<?=SITE_TEMPLATE_PATH?>/dist/img/icons.svg#bag-order" xlink:href="<?=SITE_TEMPLATE_PATH?>/dist/img/icons.svg#bag-order"></use>
        </svg>
        <span>
            <?=($arResult['NUM_PRODUCTS'] > 0) ? $arResult['NUM_PRODUCTS'] : ''?>
            <?/*
            if ($arResult['NUM_PRODUCTS'] > 0) {
                echo $arResult['BASKET_COUNT_DESCRIPTION'];
            } else {
                echo '';
            }
            */?>
        </span>
        <? else: ?>
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor">
            <use href="<?=SITE_TEMPLATE_PATH?>/dist/img/icons.svg#bag" xlink:href="<?=SITE_TEMPLATE_PATH?>/dist/img/icons.svg#bag"></use>
        </svg>
        <span><?=GetMessage('TSB1_CART')?></span>
        <? endif; ?>

    </a>
<? endif; ?>


<?/*
<div class="bx-hdr-profile">
<?if (!$compositeStub && $arParams['SHOW_AUTHOR'] == 'Y'):?>
	<div class="bx-basket-block">
		<i class="fa fa-user"></i>
		<?if ($USER->IsAuthorized()):
			$name = trim($USER->GetFullName());
			if (! $name)
				$name = trim($USER->GetLogin());
			if (mb_strlen($name) > 15)
				$name = mb_substr($name, 0, 12).'...';
			?>
			<a href="<?=$arParams['PATH_TO_PROFILE']?>"><?=htmlspecialcharsbx($name)?></a>
			&nbsp;
			<a href="?logout=yes&<?=bitrix_sessid_get()?>"><?=GetMessage('TSB1_LOGOUT')?></a>
		<?else:
			$arParamsToDelete = array(
				"login",
				"login_form",
				"logout",
				"register",
				"forgot_password",
				"change_password",
				"confirm_registration",
				"confirm_code",
				"confirm_user_id",
				"logout_butt",
				"auth_service_id",
				"clear_cache",
				"backurl",
			);

			$currentUrl = urlencode($APPLICATION->GetCurPageParam("", $arParamsToDelete));
			if ($arParams['AJAX'] == 'N')
			{
				?><script type="text/javascript"><?=$cartId?>.currentUrl = '<?=$currentUrl?>';</script><?
			}
			else
			{
				$currentUrl = '#CURRENT_URL#';
			}
			
			$pathToAuthorize = $arParams['PATH_TO_AUTHORIZE'];
			$pathToAuthorize .= (mb_stripos($pathToAuthorize, '?') === false ? '?' : '&');
			$pathToAuthorize .= 'login=yes&backurl='.$currentUrl;
			?>
			<a href="<?=$pathToAuthorize?>">
				<?=GetMessage('TSB1_LOGIN')?>
			</a>
			<?
			if ($arParams['SHOW_REGISTRATION'] === 'Y')
			{
				$pathToRegister = $arParams['PATH_TO_REGISTER'];
				$pathToRegister .= (mb_stripos($pathToRegister, '?') === false ? '?' : '&');
				$pathToRegister .= 'register=yes&backurl='.$currentUrl;
				?>
				<a href="<?=$pathToRegister?>">
					<?=GetMessage('TSB1_REGISTER')?>
				</a>
				<?
			}
			?>
		<?endif?>
	</div>
<?endif?>
	<div class="bx-basket-block"><?
		if (!$arResult["DISABLE_USE_BASKET"])
		{
			?><i class="fa fa-shopping-cart"></i>
			<a href="<?= $arParams['PATH_TO_BASKET'] ?>"><?= GetMessage('TSB1_CART') ?></a><?
		}

		if (!$compositeStub)
		{
			if ($arParams['SHOW_NUM_PRODUCTS'] == 'Y' && ($arResult['NUM_PRODUCTS'] > 0 || $arParams['SHOW_EMPTY_VALUES'] == 'Y'))
			{
				echo $arResult['BASKET_COUNT_DESCRIPTION'];

				if ($arParams['SHOW_TOTAL_PRICE'] == 'Y')
				{
					?>
					<br <? if ($arParams['POSITION_FIXED'] == 'Y'): ?>class="hidden-xs"<? endif; ?>/>
					<span>
						<?=GetMessage('TSB1_TOTAL_PRICE')?> <strong><?=$arResult['TOTAL_PRICE']?></strong>
					</span>
					<?
				}
			}
		}

		if ($arParams['SHOW_PERSONAL_LINK'] == 'Y'):?>
			<div style="padding-top: 4px;">
			<span class="icon_info"></span>
			<a href="<?=$arParams['PATH_TO_PERSONAL']?>"><?=GetMessage('TSB1_PERSONAL')?></a>
			</div>
		<?endif?>
	</div>
</div>
*/?>