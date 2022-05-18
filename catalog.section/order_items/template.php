<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

//pr($arResult['ITEMS']);
?>
<div class="account-section-header">
    <span class="text-primary">
        <?=$arParams['TITLE'];?>
    </span>
</div>
<div class="swiper swiper-account" id="swiper-account-<?=$arParams['IDID']?>">
    <div class="swiper-nav swiper-button-prev swiper-buy-again-prev"></div>
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
                    <a href="<?=$arItem['DETAIL_PAGE_URL']?>" rel="noopener" target="_blank" class="text-reset text-decoration-none">
                        <div class="embed-responsive embed-responsive-1by1 border border-light mb-2">
                            <img src="<?=$file['src']?>" class="embed-responsive-item">
                        </div>
                        <p class="font-size-1">
                            <?=$arItem['NAME']?>
                        </p>
                    </a>
                </div>
            <?endforeach;?>
        </div>
        <div class="swiper-pagination swiper-buy-again-pagination d-lg-none"></div>
    </div>
    <div class="swiper-nav swiper-button-next swiper-buy-again-next"></div>
</div>
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
            slidesPerView: 2,
            slidesPerGroup: 2,
            spaceBetween: 10,
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
            loop: false
        });
    });
</script>