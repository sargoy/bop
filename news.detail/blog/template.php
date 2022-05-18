<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
$this->setFrameMode(true);
?>
<?//debug($arResult, false)?>

<div class="news-detail">
	<?if($arParams["DISPLAY_NAME"]!="N" && $arResult["NAME"]):?>
        <h1><?=$arResult["NAME"]?></h1>
	<?endif;?>
	<?if($arParams["DISPLAY_DATE"]!="N" && $arResult["DISPLAY_ACTIVE_FROM"]):?>
        <span class="news-date-time"><?=$arResult["DISPLAY_ACTIVE_FROM"]?></span>
	<?endif;?>
    <div class="row mv-15">
        <div class="col-lg-6">
	        <?if($arParams["DISPLAY_PICTURE"]!="N" && is_array($arResult["DETAIL_PICTURE"])):?>
                    <img
                            class="img-fluid"
                            border="0"
                            src="<?=$arResult["DETAIL_PICTURE"]["SRC"]?>"
                            alt="<?=$arResult["DETAIL_PICTURE"]["ALT"]?>"
                            title="<?=$arResult["DETAIL_PICTURE"]["TITLE"]?>"
                    />
	        <?endif?>
        </div>
        <div class="col-lg-6">
            <h3 class="recipe-title recipe-title-mb"><?=$arResult['PROPERTIES']['ATT_SUBTITLE']['VALUE']?></h3>
            <p class="recipe-text">
                <?=$arResult['PREVIEW_TEXT']?>
            </p>
        </div>
    </div>
    <div class="mv-15 p-15">
        <? if($arResult["PROPERTIES"]["ATT_RECEPT"]['VALUE'] !== ''):?>
            <div class="row">
                <div class="col-lg-6 recipe-title">Рецепт: <?=$arResult['PROPERTIES']['ATT_SUBTITLE']['VALUE']?></div>
                <div class="col-lg-6 recipe-download">
                    <a class="" href="<?=$arResult["PROPERTIES"]["ATT_RECEPT"]['SRC']?>" download="Рецепт-<?=$arResult["NAME"]?>">
                        <svg width="37" height="37" viewBox="0 0 37 37" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <g clip-path="url(#clip0)">
                                <path d="M14.9287 19.2708L18.5001 22.8124L22.0716 19.2708" stroke="#5C5C5C" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M18.5 22.8125V9.35413" stroke="#5C5C5C" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M25.6431 20.6875V25.6458H11.3574V20.6875" stroke="#5C5C5C" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                            </g>
                            <circle cx="18.5" cy="18.5" r="18" stroke="#5C5C5C"/>
                            <defs>
                                <clipPath id="clip0">
                                    <rect width="15" height="17" fill="white" transform="translate(11 9)"/>
                                </clipPath>
                            </defs>
                        </svg>

                    </a>
                </div>
            </div>
	    <?endif;?>
	    <?=$arResult["DETAIL_TEXT"];?>
        <p>
            <a href="<?=$_SERVER['HTTP_REFERER']?>">Назад к списку</a>
        </p>
    </div>


	<? foreach($arResult["DISPLAY_PROPERTIES"] as $pid=>$arProperty):?>

		<?=$arProperty["NAME"]?>:&nbsp;
		<?if(is_array($arProperty["DISPLAY_VALUE"])):?>
			<?=implode("&nbsp;/&nbsp;", $arProperty["DISPLAY_VALUE"]);?>
		<?else:?>
			<?=$arProperty["DISPLAY_VALUE"];?>
		<?endif?>
		<br />
	<?endforeach;?>
	<? if(array_key_exists("USE_SHARE", $arParams) && $arParams["USE_SHARE"] == "Y")
	{
		?>
		<div class="news-detail-share">
			<noindex>
			<?
			$APPLICATION->IncludeComponent("bitrix:main.share", "", array(
					"HANDLERS" => $arParams["SHARE_HANDLERS"],
					"PAGE_URL" => $arResult["~DETAIL_PAGE_URL"],
					"PAGE_TITLE" => $arResult["~NAME"],
					"SHORTEN_URL_LOGIN" => $arParams["SHARE_SHORTEN_URL_LOGIN"],
					"SHORTEN_URL_KEY" => $arParams["SHARE_SHORTEN_URL_KEY"],
					"HIDE" => $arParams["SHARE_HIDE"],
				),
				$component,
				array("HIDE_ICONS" => "Y")
			);
			?>
			</noindex>
		</div>
		<?
	}
	?>

</div>