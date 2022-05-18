<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
$this->setFrameMode(true);
//pr($arResult);
?>
<div class="row mb-4">
    <?if($arParams["DISPLAY_TOP_PAGER"]):?>
        <?=$arResult["NAV_STRING"]?><br />
    <?endif;?>
    <?foreach($arResult["ITEMS"] as $key => $arItem):?>
        <?
        if (!$key) {
            $tag= 'h1';
        } else {
            $tag= 'span';
        }
        $this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
        $this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
        ?>
		<div class="promotions-page__item col-12 col-md-6" id="<?=$this->GetEditAreaId($arItem['ID']);?>">
			<div class="row">
				<div class="col-md-6">
                    <div style="margin-bottom: 15px;">
	                <?if($arParams["DISPLAY_PICTURE"]!="N" && is_array($arItem["PREVIEW_PICTURE"])):
		                $file = CFile::ResizeImageGet($arItem["~PREVIEW_PICTURE"], ['width' => 255, 'height' => 315], BX_RESIZE_IMAGE_EXACT, true);
		                $arItem["PREVIEW_PICTURE"]["SRC"] = $file['src'];
		                ?>
		                <?if(!$arParams["HIDE_LINK_WHEN_NO_DETAIL"] || (($arItem["DETAIL_TEXT"] or $arItem['PROPERTIES']['ITEMS']['VALUE']) && $arResult["USER_HAVE_ACCESS"])):?>
							<a class="d-block" href="<?=$arItem["DETAIL_PAGE_URL"]?>">
								<img
								  class="promotions-page__img"
								  src="<?=$arItem["PREVIEW_PICTURE"]["SRC"]?>"
								  width="<?=$arItem["PREVIEW_PICTURE"]["WIDTH"]?>"
								  height="<?=$arItem["PREVIEW_PICTURE"]["HEIGHT"]?>"
								  alt="<?=$arItem["PREVIEW_PICTURE"]["ALT"]?>"
								  title="<?=$arItem["PREVIEW_PICTURE"]["TITLE"]?>"
								>
							</a>
		                <?else:?>
							<img
							  class="promotions-page__img"
							  src="<?=$arItem["PREVIEW_PICTURE"]["SRC"]?>"
							  width="<?=$arItem["PREVIEW_PICTURE"]["WIDTH"]?>"
							  height="<?=$arItem["PREVIEW_PICTURE"]["HEIGHT"]?>"
							  alt="<?=$arItem["PREVIEW_PICTURE"]["ALT"]?>"
							  title="<?=$arItem["PREVIEW_PICTURE"]["TITLE"]?>"
							/>
		                <?endif;?>
		            <?endif?>
                    </div>
				</div>
				<div class="col-md-6">
		            <?if($arParams["DISPLAY_DATE"]!="N" && $arItem["DISPLAY_ACTIVE_FROM"]):?>
						<span class="promotions-page-date-time"><?echo $arItem["DISPLAY_ACTIVE_FROM"]?></span>
		            <?endif?>
		            <?if($arParams["DISPLAY_NAME"]!="N" && $arItem["NAME"]):?>
		                <?if(!$arParams["HIDE_LINK_WHEN_NO_DETAIL"] || (($arItem["DETAIL_TEXT"] or $arItem['PROPERTIES']['ITEMS']['VALUE']) && $arResult["USER_HAVE_ACCESS"])):?>
							<a class="promotions-page__name d-none d-md-block" href="<?echo $arItem["DETAIL_PAGE_URL"]?>"><?echo $arItem["NAME"]?></a><br />
		                <?else:?>
				            <<?=$tag?> class="promotions-page__name"><b><?echo $arItem["NAME"]?></b></<?=$tag?>><br />
		                <?endif;?>
		            <?endif;?>
		            <?if($arParams["DISPLAY_PREVIEW_TEXT"]!="N" && $arItem["PREVIEW_TEXT"]):?>
						<p class="promotions-page__desc"><?echo TruncateText($arItem["PREVIEW_TEXT"], 500);?></p>
		            <?endif;?>
				</div>
			</div>
		</div>
    <?endforeach;?>
    <?if($arParams["DISPLAY_BOTTOM_PAGER"]):?>
		<br /><?=$arResult["NAV_STRING"]?>
    <?endif;?>
</div>
