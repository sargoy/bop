<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
	die();
$arAuthServices = $arPost = array();
if(is_array($arParams["~AUTH_SERVICES"]))
{
	$arAuthServices = $arParams["~AUTH_SERVICES"];
}
if(is_array($arParams["~POST"]))
{
	$arPost = $arParams["~POST"];
}
?>
<?
if($arParams["POPUP"]):
	//only one float div per page
	if(defined("BX_SOCSERV_POPUP"))
		return;
	define("BX_SOCSERV_POPUP", true);
?>
<div style="display:none">
<div id="bx_auth_float" class="bx-auth-float">
<?endif?>

<div class="open-via-social">
    <div class="open-via-social__heading">Войти с помощью</div>
	<form method="post" name="bx_auth_services<?=$arParams["SUFFIX"]?>" target="_top" action="<?=$arParams["AUTH_URL"]?>">

		<div class="open-via-social__btns" id="bx_auth_serv<?=$arParams["SUFFIX"]?>">
			<?foreach($arAuthServices as $service):?>
				<?if(($arParams["~FOR_SPLIT"] != 'Y') || (!is_array($service["FORM_HTML"]))):?>
					<div id="bx_auth_serv_<?=$arParams["SUFFIX"]?><?=$service["ID"]?>">
                        <a href="#" onclick="<?=$service['ONCLICK']?>">
                            <img src="/images/soc_net/<?=$service['ICON']?>.svg" alt="">
                        </a>
                    </div>
				<?endif;?>
			<?endforeach?>
		</div>
		
	</form>
</div>

<?if($arParams["POPUP"]):?>
</div>
</div>
<?endif?>