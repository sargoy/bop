<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */
$this->setFrameMode(true);
reset($arResult["ITEMS"]);
?>
<?if(count($arResult["ITEMS"])):?>
    <div class="container">
        <div class="mb-5">
			<?if($arParams['TITLE']):?>
                <p class="section-title">
					<?=$arParams['TITLE']?>
                </p>
			<?endif;?>
			<?
			$arItem = current($arResult["ITEMS"]);
			if($arItem):
				//pr($arItem);
				$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
				$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
				$file = CFile::ResizeImageGet($arItem["PREVIEW_PICTURE"]["ID"], array('width'=>1110, 'height'=>500), BX_RESIZE_IMAGE_EXACT, true);
				?>
                <a href="<?=$arItem["PROPERTIES"]['LINK']['VALUE'];?>" target="_self" class="card card-banner card-banner-lg" id="<?=$this->GetEditAreaId($arItem['ID']);?>" style="<?if($arItem['PROPERTIES']['COLOR']['VALUE']):?>color:#<?=$arItem['PROPERTIES']['COLOR']['VALUE'];?> !important;<?endif;?><?if($arItem['PROPERTIES']['BACKGROUND']['VALUE']):?>background-color:#<?=$arItem['PROPERTIES']['BACKGROUND']['VALUE'];?>;<?endif?>">
                    <img src="<?=$file['src']?>" class="card-img">
                    <div class="card-body card-img-overlay text-white-lazy">
                        <div class="h-100 d-flex flex-column">
                            <div class="row no-gutters">
                                <div class="col-8">
                                    <p class="h3 mb-1"><?echo $arItem["NAME"]?></p>
									<?if($arItem["PROPERTIES"]['TEXT']['VALUE']):?>
                                        <p><?=$arItem["PROPERTIES"]['TEXT']['VALUE'];?></p>
									<?endif;?>
                                </div>
                            </div>
                            <button type="button" class="btn card-link mt-auto mr-auto btn-white"><?=($arItem["PROPERTIES"]['BUTTON_TEXT']['VALUE'] ? : '??????????????????');?></button>
                        </div>
                    </div>
                </a>
			<?endif;?>
        </div>
    </div>
<?endif;?>
