<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();
$elementEdit = CIBlock::GetArrayByID($arParams['IBLOCK_ID'], 'ELEMENT_EDIT');
$elementDelete = CIBlock::GetArrayByID($arParams['IBLOCK_ID'], 'ELEMENT_DELETE');
$elementDeleteParams = array('CONFIRM' => GetMessage('CT_BCS_TPL_ELEMENT_DELETE_CONFIRM'));

$areaIds = [];
foreach ($arResult['ITEMS'] as $item)
{
	$uniqueId = $item['ID'].'_'.md5($this->randString().$component->getAction());
	$areaIds[$item['ID']] = $this->GetEditAreaId($uniqueId);
	$this->AddEditAction($uniqueId, $item['EDIT_LINK'], $elementEdit);
	$this->AddDeleteAction($uniqueId, $item['DELETE_LINK'], $elementDelete, $elementDeleteParams);
}
\Zloj\Portal\Template::initPageAdult();
?>
<div class="container">
    <div class="swiper swiper-products mb-5" id="swiper-products-<?=$arParams['IDID']?>">
		<?if($arParams['TITLE']):?>
            <div class="row swiper-header">
                <div class="col-md-9 col-xl-10">
                    <p class="section-title text-md-left mb-0"><?=$arParams['TITLE']?></p>
                </div>
                <div class="col-md-3 col-xl-2">
                    <div class="d-none d-md-flex justify-content-end">
                        <div class="swiper-nav swiper-button-prev"></div>
                        <div class="swiper-nav swiper-button-next"></div>
                    </div>
                </div>
            </div>
		<?endif;?>
        <div class="row">
            <div class="col-md-12 offset-md-0 col-10 offset-1">
                <div class="swiper-container">
                    <div class="swiper-wrapper">
                        <?foreach($arResult["ITEMS"] as $arItem):?>
                            <div class="swiper-slide">
                                <?$APPLICATION->IncludeComponent(
                                    'bitrix:catalog.item',
                                    '',
                                    array(
                                        'SHOW_ADULT' => $arParams['SHOW_ADULT'],
                                        'RESULT' => array(
                                            'ITEM' => $arItem,
                                            'AREA_ID' => $areaIds[$arItem['ID']],
                                            'BIG_LABEL' => 'N',
                                            'BIG_DISCOUNT_PERCENT' => 'N',
                                            'BIG_BUTTONS' => 'N',
                                            'SCALABLE' => 'N'
                                        ),
                                        'PARAMS' => $arParams
                                            + array('SKU_PROPS' => $arResult['SKU_PROPS'][$arItem['IBLOCK_ID']])
                                    ),
                                    $component,
                                    array('HIDE_ICONS' => 'Y')
                                );?>
                            </div>
                        <?endforeach;?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function () {
        var mainSwiper = new Swiper ('.swiper-products[id="swiper-products-<?=$arParams['IDID']?>"] .swiper-container', {
            pagination: {
                el: '.swiper-products[id="swiper-products-<?=$arParams['IDID']?>"] .swiper-pagination',
            },
            navigation: {
                nextEl: '.swiper-products[id="swiper-products-<?=$arParams['IDID']?>"] .swiper-button-next',
                prevEl: '.swiper-products[id="swiper-products-<?=$arParams['IDID']?>"] .swiper-button-prev',
            },
            slidesPerView: 1,
            slidesPerGroup: 1,
            spaceBetween: 0,
            breakpoints: {
                768: {
                    slidesPerView: 2,
                    slidesPerGroup: 2,
                    spaceBetween: 15,
                },
                992: {
                    slidesPerView: 3,
                    slidesPerGroup: 3,
                    spaceBetween: 20,
                },
                1200: {
                    slidesPerView: 4,
                    slidesPerGroup: 4,
                    spaceBetween: 30,
                }
            },
            loop: true,
            loopFillGroupWithBlank: true,
            on: {
                slideChangeTransitionEnd: function () {
                    lazyLoad();
                },
            },
            preloadImages: false,
            // lazy: true
        });
    });
</script>
<?
$templateData['CURRENT_ADULT'] = \Zloj\Portal\Template::getPageAdult();
?>