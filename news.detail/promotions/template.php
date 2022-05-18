<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
    $this->setFrameMode(true);
    //pr($arResult);
?>
<div class="news-detail bonuses-and-promotions-details">
    <?if($arParams["DISPLAY_NAME"]!="N" && $arResult["NAME"]):?>
		<h3 class="d-none"><?=$arResult["NAME"]?></h3>
    <?endif;?>
    <?if($arParams["DISPLAY_DATE"]!="N" && $arResult["DISPLAY_ACTIVE_FROM"]):?>
		<span class="news-date-time"><?=$arResult["DISPLAY_ACTIVE_FROM"]?></span>
    <?endif;?>
    <?if($arParams["DISPLAY_PICTURE"]!="N" && is_array($arResult["DETAIL_PICTURE"])):?>
		<div>
			<img
			  class="img-fluid"
			  border="0"
			  src="<?=$arResult["DETAIL_PICTURE"]["SRC"]?>"
			  alt="<?=$arResult["DETAIL_PICTURE"]["ALT"]?>"
			  title="<?=$arResult["DETAIL_PICTURE"]["TITLE"]?>"
			/>
		</div>
    <?endif?>
   
        <?echo $arResult["DETAIL_TEXT"];?>

	<div style="clear:both"></div>
	<br />
    <?foreach($arResult["FIELDS"] as $code=>$value):
        if ('PREVIEW_PICTURE' == $code || 'DETAIL_PICTURE' == $code)
        {
            ?><?=GetMessage("IBLOCK_FIELD_".$code)?>:&nbsp;<?
            if (!empty($value) && is_array($value))
            {
                ?><img border="0" src="<?=$value["SRC"]?>" width="<?=$value["WIDTH"]?>" height="<?=$value["HEIGHT"]?>"><?
            }
        }
        else
        {
            ?><?=GetMessage("IBLOCK_FIELD_".$code)?>:&nbsp;<?=$value;?><?
        }
        ?><br />
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

    global $recommendedFilter;

    $recommendedFilter = array(
	    "=ID" => $arResult['PROPERTIES']['ITEMS']['VALUE'],
    );



    ?>
<?$APPLICATION->IncludeComponent(
		'bitrix:catalog.section',
		'main',
		array(

			'IBLOCK_TYPE' => "aspro_max_catalog",
			'IBLOCK_ID' => "26",

			'CACHE_TYPE' => 'N',
			'CACHE_TIME' => 0,
			'CACHE_FILTER' => 'N',
			'CACHE_GROUPS' => 'N',

			'BY_LINK' => 'N',
			'DISPLAY_TOP_PAGER' => 'N',
			'DISPLAY_BOTTOM_PAGER' => 'N',
			'HIDE_SECTION_DESCRIPTION' => 'Y',
			'SHOW_ALL_WO_SECTION' => 'Y',

			'FILTER_NAME' => 'recommendedFilter',
			'ACTIONS_STYLE' => 'Y',
			"PRICE_CODE" => array(
				0 => "BASE",
				1 => "DISCOUNT",
			),
			'PAGE_ELEMENT_COUNT' => 400,
		),
		$component
	);?>
    <p>
        <a href="<?=$_SERVER['HTTP_REFERER']?>">Назад к списку</a>
    </p>

</div>