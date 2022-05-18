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
        <div class="mb-5">
			<?if($arParams['TITLE']):?>
                <p class="section-title"><?=$arParams['TITLE']?></p>
			<?endif;?>
            <div class="row">
				<?
				$i = 0;
				foreach($arResult["ITEMS"] as $arItem):
					$i ++;
					//pr($arItem);
					$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
					$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
					?>
                    <div class="col-md-4" id="<?=$this->GetEditAreaId($arItem['ID']);?>">
                        <a href="<?=$arItem["PROPERTIES"]['LINK']['VALUE'];?>" class="home-benefit">
                            <div class="row align-items-center">
                                <div class="mb-3 text-right text-md-center col-md-12 col-3"<?/* style="height: <?=($arParams['HEIGHT'] ? : 60);?>px"*/?>>
									<?=$arItem["PROPERTIES"]['SVG']['~VALUE'];?>
                                </div>
                                <div class="mb-3 text-md-center col-md-12 col-9">
                                    <p class="font-weight-medium text-uppercase mb-1">
										<?=$arItem["NAME"];?>
                                    </p>
                                    <p class="mb-1">
										<?=$arItem["PROPERTIES"]['DESCRIPTION']['VALUE'];?>
                                    </p>
                                </div>
                            </div>
                        </a>
                    </div>
				<?endforeach;?>
            </div>
        </div>
    </div>
<?endif;?>
