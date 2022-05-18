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
?>
<?if(count($arResult["ITEMS"])):?>
    <div class="container">
        <div class="row mb-3 mb-lg-5">
			<?
			$i = 0;
			foreach($arResult["ITEMS"] as $arItem):
				$i ++;
				if($i > 3){
					break;
				}
				$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
				$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
				$file = CFile::ResizeImageGet($arItem["PREVIEW_PICTURE"]["ID"], array('width'=>350, 'height'=>211), BX_RESIZE_IMAGE_EXACT, true);
				?>
                <div class="mb-3 mb-md-0 col-md-4" id="<?=$this->GetEditAreaId($arItem['ID']);?>">
                    <a href="<?=$arItem["PROPERTIES"]['LINK']['VALUE'];?>" target="_self" class="card card-banner card-banner-sm" style="<?if($arItem['PROPERTIES']['COLOR']['VALUE']):?>color:#<?=$arItem['PROPERTIES']['COLOR']['VALUE'];?> !important;<?endif;?><?if($arItem['PROPERTIES']['BACKGROUND']['VALUE']):?>background-color:#<?=$arItem['PROPERTIES']['BACKGROUND']['VALUE'];?>;<?endif?>">
                        <img src="<?=$file['src'];?>" class="card-img">
                        <div class="card-body card-img-overlay">
                            <span class="text-white-lazy"><?=$arItem["NAME"];?></span>
                        </div>
                    </a>
                </div>
			<?endforeach;?>
        </div>
    </div>
<?endif;?>
