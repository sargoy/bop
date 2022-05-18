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

//pr($arResult);
?>
<?if(!empty($arResult['ROOT'])):?>
    <a href="<?=$arResult['ROOT']['SECTION_PAGE_URL'];?>" class="btn backlink mb-3 d-md-flex btn-outline-dark btn-block" target="_self">
        <svg width="19" height="7" xmlns="http://www.w3.org/2000/svg" class="icon sprite-icons">
            <use href="/local/templates/new/_nuxt/e9f276f8f2f8d76658b3ea83098ca231.svg#i-arrow-backlink" xlink:href="/local/templates/new/_nuxt/e9f276f8f2f8d76658b3ea83098ca231.svg#i-arrow-backlink"></use>
        </svg>
        <span class="caption">
            <?if($arResult['ROOT']['DEPTH_LEVEL'] == 1):?>
                <span class="tolower-fix">#<?=ToLower($arResult['ROOT']['NAME']);?></span>
            <?else:?>
                <?=$arResult['ROOT']['NAME'];?>
            <?endif;?>
        </span>
    </a>
<?endif;?>
<?foreach ($arResult['SECTIONS_FORMAT'] as $arSection):
	$cnt = count($arSection['PARENT']);
	?>
    <div class="collapse-catalog-sidebar mb-2">
        <button class="btn collapse-toggle btn-link collapsed<?if($arSection['ACTIVE_LINK']):?> active-text-link<?endif;?>"<?if($cnt):?> data-id="<?=$arSection['ID']?>"<?endif;?> data-href="<?=$arSection['SECTION_PAGE_URL']?>">
            <span class="caption">
                <?if($arSection['DEPTH_LEVEL'] == 1):?>
                    #<?=ToLower($arSection['NAME']);?>
                <?else:?>
	                <?=$arSection['NAME'];?>
                <?endif;?>
            </span>
			<?if($cnt):?>
                <svg width="12" height="12" xmlns="http://www.w3.org/2000/svg" class="icon sprite-icons">
                    <use href="/local/templates/new/_nuxt/e9f276f8f2f8d76658b3ea83098ca231.svg#i-caret" xlink:href="/local/templates/new/_nuxt/e9f276f8f2f8d76658b3ea83098ca231.svg#i-caret"></use>
                </svg>
			<?endif;?>
        </button>
		<?if($cnt):?>
            <div class="collapse" data-root-id="<?=$arSection['ID']?>" style="display: none">
                <div class="collapse-content">
                    <ul class="list-unstyled mb-0">
						<?foreach ($arSection['PARENT'] as $k=>$arSubSection):?>
                            <li class="mb-3">
                                <a href="<?=$arSubSection['SECTION_PAGE_URL']?>" class="font-weight-medium text-reset"><?=$arSubSection['NAME']?></a>
                            </li>
						<?endforeach;?>
                    </ul>
                </div>
            </div>
		<?endif;?>
    </div>
<?endforeach;?>

