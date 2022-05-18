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
<h1 class="font-size-2 font-weight-bold mb-3 d-md-none">Каталог</h1>
<?if(count($arResult['SECTIONS_FORMAT'])):?>
    <div class="row">
		<?foreach ($arResult['SECTIONS_FORMAT'] as $arSection):
			$file = CFile::ResizeImageGet($arSection["PICTURE"]["ID"], array('width'=>360, 'height'=>270), BX_RESIZE_IMAGE_EXACT, true);
			?>
            <div class="col-md-4 col-6">
                <div class="card-catalog-category-wrapper">
                    <a href="<?=$arSection['SECTION_PAGE_URL']?>" target="_self" class="card card-catalog-category">
                        <div class="card-img">
                            <img src="<?=(!empty($file['src']) ? $file['src'] : '/images/blank.svg');?>" class="card-img-content">
                        </div>
                        <div class="card-body">
                            <p class="card-title">
                                <span>#<?=ToLower($arSection['NAME']);?></span>
                            </p>
                        </div>
                    </a>
                    <ul class="list-unstyled card-catalog-category-children">
						<?foreach ($arSection['PARENT'] as $k=>$arSubSection):?>
							<?if($k == 5):?>
                                <li class="children-item children-item-all">
                                    <a href="<?=$arSection['SECTION_PAGE_URL']?>" target="_self" class="children-link">ещё категории</a>
                                </li>
								<?
								break;
							endif;?>
                            <li class="children-item">
                                <a href="<?=$arSubSection['SECTION_PAGE_URL']?>" target="_self" class="children-link"><?=$arSubSection['NAME']?></a>
                            </li>
						<?endforeach;?>
                    </ul>
                </div>
            </div>
		<?endforeach;?>
    </div>
<?endif;?>
<?//pr($arResult);?>

