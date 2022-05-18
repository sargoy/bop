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
\Bitrix\Main\UI\Extension::load("ui.vue");
\Bitrix\Main\UI\Extension::load("ui.vue.directives.lazyload");
$this->setFrameMode(true);
$cnt = count($arResult['SECTIONS']);
$templateData['CNT'] = $cnt;
?>
<h1 class="font-size-2 font-weight-bold mb-3 d-md-none">Каталог</h1>
<?$this->SetViewTarget('section_list_inner');?>
<?if($cnt):?>
    <div class="row mx-n3 mx-md-n15 mb-3 mb-md-0">
		<?foreach ($arResult['SECTIONS'] as $arSection):
			$file = CFile::ResizeImageGet($arSection["PICTURE"], array('width'=>360, 'height'=>270), BX_RESIZE_IMAGE_EXACT, true);
			?>
            <div class="col-lg-6 col-xl-4">
                <a href="<?=$arSection['SECTION_PAGE_URL']?>" class="card card-catalog-subcategory">
                    <div class="card-img">
                        <img data-src="<?= $file['src'] ?>" src="/images/spinner.gif" class="card-img-content lazy preloader-custom-temp" alt="<?= $arSection["NAME"] ?>">
                    </div>
                    <div class="card-body">
                        <p class="card-title">
                            <span><?=$arSection['NAME'];?></span>
                        </p>
                        <div>
                            <svg width="12" height="12" xmlns="http://www.w3.org/2000/svg" class="icon sprite-icons">
                                <use href="/local/templates/new/_nuxt/08898a81d88ca4fa3db9dc44bfc54562.svg#i-catalog-next" xlink:href="/local/templates/new/_nuxt/08898a81d88ca4fa3db9dc44bfc54562.svg#i-catalog-next">
                                </use>
                            </svg>
                        </div>
                    </div>
                </a>
            </div>
		<?endforeach;?>
    </div>
<?endif;?>
<?$this->EndViewTarget();?>
<?//pr($arResult);?>

