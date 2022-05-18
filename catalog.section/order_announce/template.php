<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();
//pr($arParams['ORDER_DATA']);
//pr($arResult['ITEMS']);
if($arParams['ORDER_DATA']['ID']):
?>
    <div class="account-section-header d-lg-none">
        <div class="row align-items-center">
            <div class="col-6">
                <span class="text-primary">
                    Последний заказ:
                </span>
            </div>
            <div class="text-right col-6">
                <span class="text-success">
                    <?=zlojStatusFormat($arParams['ORDER_DATA']['STATUS_ID']);?>
                </span>
            </div>
        </div>
    </div>
    <div class="row mb-3 mx-n1">
        <div class="px-1 col-lg-4 col-6">
            <p class="mb-2">
                <span class="d-inline-block mr-1">
                    Заказ
                    <a href="/my/orders/detail/<?=$arParams['ORDER_DATA']['ID']?>/" class="font-weight-medium" target="_self">
                        №&nbsp;<?=$arParams['ORDER_DATA']['ID']?>
                    </a>
                </span>
                <span class="d-inline-block font-weight-light text-gray-500">
                    от&nbsp;<?=date('d.m.Y', strtotime($arParams['ORDER_DATA']['DATE_INSERT']));?>
                </span>
            </p>
        </div>
        <div class="text-right text-lg-left px-1 col-lg-5 col-6">
            <span class="d-inline-block mr-lg-1">
                Сумма:
                <span class="font-weight-medium"><?=zlojPriceFormat($arParams['ORDER_DATA']['PRICE'], false);?></span>
            </span>
            <span class="d-inline-block ml-1 ml-lg-0">
            </span>
        </div>
        <div class="text-right d-none d-lg-block px-1 col-lg-3">
            <span class="font-weight-medium text-success">
                <?=zlojStatusFormat($arParams['ORDER_DATA']['STATUS_ID']);?>
            </span>
        </div>
    </div>
    <?if(count($arResult['ITEMS'])):?>
        <div class="swiper swiper-account" id="swiper-account-<?=$arParams['IDID']?>">
            <div class="swiper-nav swiper-button-prev swiper-order-prev"></div>
            <div class="swiper-container">
                <div class="swiper-wrapper">
                    <?
                    foreach ($arResult['ITEMS'] as $arItem):
	                    if($arItem["PREVIEW_PICTURE"]["ID"]) {
		                    $file = CFile::ResizeImageGet($arItem["PREVIEW_PICTURE"]["ID"], ['width' => 400, 'height' => 400], BX_RESIZE_IMAGE_PROPORTIONAL, true);
	                    }else{
		                    $file = [
			                    'src' => '/images/nophoto.svg'
		                    ];
	                    }
	                    ?>
                        <div class="swiper-slide">
                            <a href="<?=$arItem["DETAIL_PAGE_URL"]?>" rel="noopener" target="_blank" class="embed-responsive embed-responsive-1by1 border border-light">
                                <img src="<?=$file['src'];?>" class="embed-responsive-item">
                            </a>
                        </div>
                    <?endforeach;?>
                </div>
                <div class="swiper-pagination swiper-order-pagination d-lg-none"></div>
            </div>
            <div class="swiper-nav swiper-button-next swiper-order-next"></div>
        </div>
    <?endif;?>
    <div class="row d-none d-lg-flex mb-3 row-cols-9">
        <div class="col-lg-3 col-xl-2 offset-lg-3 offset-xl-5">
            <a href="/my/orders/?ID=<?=$arParams['ORDER_DATA']['ID']?>&amp;COPY_ORDER=Y" class="btn d-flex flex-center px-1 btn-outline-primary btn-block">
                <svg width="20" height="20" xmlns="http://www.w3.org/2000/svg" class="mr-2 icon sprite-icons">
                    <use href="/local/templates/new/_nuxt/e9f276f8f2f8d76658b3ea83098ca231.svg#i-refresh" xlink:href="/local/templates/new/_nuxt/e9f276f8f2f8d76658b3ea83098ca231.svg#i-refresh"></use>
                </svg>
                Повторить заказ
            </a>
        </div>
        <div class="col-lg-3 col-xl-2">
            <a href="/my/orders/" class="btn btn-primary btn-block">
                Все заказы
            </a>
        </div>
    </div>
<?
endif;
?>
<script>
    $(document).ready(function () {
        var mainSwiper = new Swiper ('.swiper-account[id="swiper-account-<?=$arParams['IDID']?>"] .swiper-container', {
            pagination: {
                el: '.swiper-account[id="swiper-account-<?=$arParams['IDID']?>"] .swiper-pagination',
            },
            navigation: {
                nextEl: '.swiper-account[id="swiper-account-<?=$arParams['IDID']?>"] .swiper-button-next',
                prevEl: '.swiper-account[id="swiper-account-<?=$arParams['IDID']?>"] .swiper-button-prev',
            },
            slidesPerView: 3,
            slidesPerGroup: 3,
            spaceBetween: 10,
            breakpoints: {
                768: {
                    slidesPerView: 4,
                    slidesPerGroup: 4,
                    spaceBetween: 15,
                },
                992: {
                    slidesPerView: 6,
                    slidesPerGroup: 6,
                    spaceBetween: 20,
                },
                1200: {
                    slidesPerView: 8,
                    slidesPerGroup: 8,
                    spaceBetween: 30,
                }
            },
            loop: false
        });
    });
</script>
<?
$templateData['CURRENT_ADULT'] = \Zloj\Portal\Template::getPageAdult();
?>