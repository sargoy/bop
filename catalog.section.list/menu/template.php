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
<ul class="navbar-nav">
    <li class="nav-item" id="catalog-tree">
        <button class="nav-link catalog-toggle">
            <svg width="28" height="20" xmlns="http://www.w3.org/2000/svg" class="icon sprite-icons">
                <use href="<?=SITE_TEMPLATE_PATH?>/_nuxt/08898a81d88ca4fa3db9dc44bfc54562.svg#i-catalog-toggle" xlink:href="<?=SITE_TEMPLATE_PATH?>/_nuxt/08898a81d88ca4fa3db9dc44bfc54562.svg#i-catalog-toggle">
                </use>
            </svg>
        </button>
        <a href="/catalog/" id="top-catalog-link">Каталог</a>
        <div class="catalog-dropdown level-0" style="display:none;">
            <div class="catalog-wrapper">
                <div class="catalog-level catalog-level-0">
                    <ul class="list-unstyled">
						<?
						foreach ($arResult['MENU'] as $arSection){
							if($arSection['DEPTH_LEVEL'] == 1):
								?>
                                <li>
                                    <div class="catalog-item">
                                    <a class="catalog-link" data-id="<?=$arSection['ID'];?>" data-level="<?=$arSection['DEPTH_LEVEL'];?>" data-picture="<?=$arSection['PICTURE'];?>">#<?=ToLower($arSection['NAME']);?></a>
										<?if(count($arSection['PARENT'])):?>
                                            <div class="catalog-next">
                                                <svg width="12" height="12" xmlns="http://www.w3.org/2000/svg" class="icon sprite-icons">
                                                    <use href="<?=SITE_TEMPLATE_PATH?>/_nuxt/08898a81d88ca4fa3db9dc44bfc54562.svg#i-catalog-next" xlink:href="<?=SITE_TEMPLATE_PATH?>/_nuxt/08898a81d88ca4fa3db9dc44bfc54562.svg#i-catalog-next">
                                                    </use>
                                                </svg>
                                                <button type="button" class="btn catalog-btn btn-link"></button>
                                            </div>
										<?endif;?>
                                    </div>
                                </li>
							<?
							endif;
						}
						?>
                    </ul>
                </div>
				<?
				foreach ($arResult['MENU'] as $arSection){
					if($arSection['DEPTH_LEVEL'] == 1 and count($arSection['PARENT'])):
						?>
                        <div class="catalog-level catalog-level-1 catalog-subsection catalog-subsection-2" style="display:none;" id="catalog-subsection-<?=$arSection['ID'];?>">
                            <ul class="list-unstyled">
                                <li class="catalog-item catalog-item-header">
                                    <button class="catalog-link catalog-level-up" data-root-id="<?=$arSection['IBLOCK_SECTION_ID']?>" data-level-to="1">
                                        <span class="mx-auto catalog-up-title"><?=$arSection['NAME'];?></span>
                                        <span class="mx-auto catalog-up-link">В список разделов</span>
                                    </button>
                                </li>
                                <li class="catalog-item catalog-item-all">
                                    <a href="<?=$arSection['SECTION_PAGE_URL'];?>" class="catalog-link">
                                        Открыть весь раздел
                                    </a>
                                </li>
                                <li class="mobile-btn-subcatalog">
                                    <div class="back-btn_category">Назад</div>
                                    <div class="name-category-heading"><?=$arSection['NAME'];?></div>
                                </li>
								<?foreach ($arSection['PARENT'] as $secId):?>
                                    <li>
                                        <div class="catalog-item">
                                            <a href="<?=$arResult['MENU'][$secId]['SECTION_PAGE_URL'];?>" class="catalog-link" data-id="<?=$arResult['MENU'][$secId]['ID'];?>" data-level="<?=$arResult['MENU'][$secId]['DEPTH_LEVEL'];?>">
												<?=$arResult['MENU'][$secId]['NAME'];?>
                                            </a>
											<?if(count($arResult['MENU'][$secId]['PARENT'])):?>
                                                <div class="catalog-next">
                                                    <svg width="12" height="12" xmlns="http://www.w3.org/2000/svg" class="icon sprite-icons">
                                                        <use href="<?=SITE_TEMPLATE_PATH?>/_nuxt/08898a81d88ca4fa3db9dc44bfc54562.svg#i-catalog-next" xlink:href="<?=SITE_TEMPLATE_PATH?>/_nuxt/08898a81d88ca4fa3db9dc44bfc54562.svg#i-catalog-next">
                                                        </use>
                                                    </svg>
                                                    <button type="button" class="btn catalog-btn btn-link"></button>
                                                </div>
											<?endif;?>
                                        </div>
                                    </li>
								<?endforeach;?>
                            </ul>
                        </div>
					<?
					endif;
				}
				?>
                <div class="flex-fill" style="display:none;">
					<?
					foreach ($arResult['MENU'] as $arSection){
                        if($arSection['DEPTH_LEVEL'] >= 2 and count($arSection['PARENT'])):
							?>
                            <div class="catalog-level catalog-level-2 catalog-subsection catalog-subsection-3" style="display:none;" id="catalog-subsection-<?=$arSection['ID'];?>">
                                <ul class="list-unstyled">
                                    <li class="catalog-item catalog-item-header">
                                        <button class="catalog-link catalog-level-up" data-root-id="<?=$arSection['IBLOCK_SECTION_ID']?>" data-level-to="2">
                                            <span class="mx-auto catalog-up-title"><?=$arSection['NAME'];?></span>
                                            <span class="mx-auto catalog-up-link">Назад в меню</span>
                                        </button>
                                    </li>
									<?foreach ($arSection['PARENT'] as $secId):?>
                                        <li class="catalog-item">
                                            <a href="<?=$arResult['MENU'][$secId]['SECTION_PAGE_URL'];?>" class="catalog-link main-catalog-link">
												<?=$arResult['MENU'][$secId]['NAME'];?>
                                            </a>
                                            <?if(count($arResult['MENU'][$secId]['PARENT'])):?>
                                                <!-- <div class="catalog-next">
                                                    <svg width="12" height="12" xmlns="http://www.w3.org/2000/svg" class="icon sprite-icons">
                                                        <use href="<?=SITE_TEMPLATE_PATH?>/_nuxt/08898a81d88ca4fa3db9dc44bfc54562.svg#i-catalog-next" xlink:href="<?=SITE_TEMPLATE_PATH?>/_nuxt/08898a81d88ca4fa3db9dc44bfc54562.svg#i-catalog-next">
                                                        </use>
                                                    </svg>
                                                    <button type="button" class="btn catalog-btn btn-link"></button>
                                                </div> -->
                                                <?foreach ($arResult['MENU'][$secId]['PARENT'] as $secId):?>
                                                    <a href="<?=$arResult['MENU'][$secId]['SECTION_PAGE_URL'];?>" class="catalog-link">
												        <?=$arResult['MENU'][$secId]['NAME'];?>
                                                    </a>
                                                <?endforeach;?>
											<?endif;?>
                                            <ul></ul>
                                        </li>
									<?endforeach;?>
                                </ul>
                            </div>
						<?
						endif;
					}
					?>
                </div>
                <div class="catalog-banner-wrapper" style="display: none;">
                    <a href="" class="catalog-banner catalog-banner-link">
                        <img src="" class="img-fluid catalog-banner-img">
                    </a>
                </div>
                <button type="button" aria-label="Close" class="close catalog-close">
                    <svg width="14" height="14" xmlns="http://www.w3.org/2000/svg" class="icon sprite-icons">
                        <use href="<?=SITE_TEMPLATE_PATH?>/_nuxt/08898a81d88ca4fa3db9dc44bfc54562.svg#i-close" xlink:href="<?=SITE_TEMPLATE_PATH?>/_nuxt/08898a81d88ca4fa3db9dc44bfc54562.svg#i-close">
                        </use>
                    </svg>
                </button>
            </div>
        </div>
    </li>
</ul>
