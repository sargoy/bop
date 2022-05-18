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
    <div class="swiper swiper-main">
        <div class="swiper-container">
            <div class="swiper-wrapper">
                <?
                foreach($arResult["ITEMS"] as $arItem):
	                $this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
                    $this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
	                $file1 = CFile::ResizeImageGet($arItem["PREVIEW_PICTURE"]["ID"], array('width'=>635, 'height'=>415), BX_RESIZE_IMAGE_EXACT, true);
	                $file2 = CFile::ResizeImageGet($arItem["PREVIEW_PICTURE"]["ID"], array('width'=>459, 'height'=>300), BX_RESIZE_IMAGE_EXACT, true);
	                $file3 = CFile::ResizeImageGet($arItem["PREVIEW_PICTURE"]["ID"], array('width'=>283, 'height'=>185), BX_RESIZE_IMAGE_EXACT, true);
                    ?>
                    <div class="swiper-slide" id="<?=$this->GetEditAreaId($arItem['ID']);?>">
                        <div class="slide-wrapper" style="color:#<?=$arItem['PROPERTIES']['COLOR']['VALUE'];?>; background-color:#<?=$arItem['PROPERTIES']['BACKGROUND']['VALUE'];?>;">
                            <div class="slide-wrapper-container container" onclick="window.location.href = '<?=$arItem["PROPERTIES"]['LINK']['VALUE'];?>';">
                                <img srcset="<?=$file3['src'];?> 767w, <?=$file2['src'];?> 991w, <?=$file1['src'];?>" src="<?=$file1['src'];?>" class="slide-img swiper-lazy">
                                <div class="slide-content">
                                    <div class="slide-text">
                                        <p><?=$arItem['NAME'];?></p>
                                        <?if($arItem['PROPERTIES']['TEXT']['VALUE']):?>
                                            <p><?=$arItem['PROPERTIES']['TEXT']['VALUE'];?></p>
                                        <?endif;?>
                                    </div>
                                    <a href="<?=$arItem["PROPERTIES"]['LINK']['VALUE'];?>" target="_self" class="btn slide-link btn-white">
	                                    <?=($arItem["PROPERTIES"]['BUTTON_TEXT']['VALUE'] ? : 'Подробнее');?>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?endforeach;?>
            </div>
            <div class="swiper-pagination swiper-main-pagination"></div>
            <div class="swiper-nav swiper-button-prev"></div>
            <div class="swiper-nav swiper-button-next"></div>
        </div>
    </div>
<?endif;?>
