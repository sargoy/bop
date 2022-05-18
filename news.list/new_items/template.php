<? use Bitrix\Main\Page\Asset;
use Bitrix\Main\Page\AssetLocation;

if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
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

<div class="container mt-5 news_items--min-h">
    <?foreach($arResult["ITEMS"] as $arItem):?>
<?//debug($arItem['DETAIL_PAGE_URL'], false)?>
        <?$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
        $this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM'))); ?>
        <div class="swiper-lazy-preloader swiper-lazy-preloader-cyan"></div>
        <div class="swiper swiper-new-items mb-5" id="swiper-new-items-<?=$arItem['ID']?>" style="display: none">

            <div class="row swiper-header">
                <div class="col-md-10 pl-0">
                    <p class="section-title text-md-left mb-4"><?=$arItem['NAME']?></p>
                </div>
                <div class="col-md-2">
                    <div class="swiper-nav--mob d-md-flex justify-content-end">
                        <div class="swiper-nav swiper-button-prev"></div>
                        <div class="swiper-nav swiper-button-next"></div>
                    </div>
                </div>
            </div>
            <div class="row mb-5">
                <div class="col-12 pl-5 pr-5 pl-md-0 pr-md-0">
                    <div class="row">
                        <div class="swiper-container d-none d-md-block col-md-4 col-lg-3 mr-4 swiper-container-initialized swiper-container-horizontal">
                            <img class="card card-product w-100" src="<?=$arItem['PREVIEW_PICTURE']['SRC']?>" alt="">
                            <p class="card-product__desc"><?=$arItem['PREVIEW_TEXT'] ?></p>
                            <a class="card-product__btn" href="<?=$arItem['DETAIL_PAGE_URL']?>"><?=$arItem['PROPERTIES']["ATT_TEXT_BUTTON"]["VALUE"] ? $arItem['PROPERTIES']["ATT_TEXT_BUTTON"]["VALUE"] : $arItem['PROPERTIES']["ATT_TEXT_BUTTON"]["DEFAULT_VALUE"]?></a>
                        </div>
                        <div class="swiper-container col">
                            <div class="swiper-wrapper">

                                <?foreach($arItem['DISPLAY_PROPERTIES']['ATT_NEW_ELEMS']['LINK_ELEMENT_VALUE'] as $linkItem):?>

                                    <?
                                    if ($linkItem["PREVIEW_PICTURE"]) {
                                        $file = CFile::ResizeImageGet($linkItem["PREVIEW_PICTURE"], ['width' => 400, 'height' => 400], BX_RESIZE_IMAGE_PROPORTIONAL, true);
                                    } else{
                                        $file = [
                                            'src' => '/images/nophoto.svg'
                                        ];
                                    }
                                    ?>
                                    <div class="swiper-slide">
                                        <div class="card card-product" id="<?=$linkItem['ID'];?>">
                                            <div class="card-img-wrapper">

                                                <div class="embed-responsive embed-responsive-4by3">
                                                    <div class="embed-responsive-item d-flex">
                                                        <a href="<?=$linkItem['DETAIL_PAGE_URL']?>" target="_self" class="item-title">
                                                            <img data-src="<?=$file['src']?>" src="/images/spinner.gif" class="card-img lazy" alt="<?=$linkItem["NAME"]?>">
                                                        </a>
                                                        <?if($arParams['~FAV_STYLE'] != 'Y'):?>
                                                            <div class="card-rating">
                                                                <?
                                                                for($i = 1; $i <= 5; $i++) {
                                                                    $rating = null;
                                                                    if($rating >= $i):?>
                                                                        <svg width="11" height="11" xmlns="http://www.w3.org/2000/svg" class="icon-rating icon-rating-full icon sprite-icons">
                                                                            <use href="/local/templates/new/_nuxt/08898a81d88ca4fa3db9dc44bfc54562.svg#i-rating" xlink:href="/local/templates/new/_nuxt/08898a81d88ca4fa3db9dc44bfc54562.svg#i-rating"></use>
                                                                        </svg>
                                                                    <?else:?>
                                                                        <svg width="11" height="11" xmlns="http://www.w3.org/2000/svg" class="icon-rating icon sprite-icons">
                                                                            <use href="/local/templates/new/_nuxt/08898a81d88ca4fa3db9dc44bfc54562.svg#i-rating" xlink:href="/local/templates/new/_nuxt/08898a81d88ca4fa3db9dc44bfc54562.svg#i-rating"></use>
                                                                        </svg>
                                                                    <?
                                                                    endif;
                                                                }
                                                                ?>
                                                            </div>
                                                        <?endif;?>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="card-body">
                                                <a href="<?=$linkItem['DETAIL_PAGE_URL']?>" target="_self" class="item-title"><?=$linkItem['NAME'];?></a>
                                                <div class="item-price">
                                                    <p class="price">
                                                        <?if($linkItem['DISCOUNT_PRICE'] > 0 and $linkItem['BASE_PRICE'] > $linkItem['DISCOUNT_PRICE']):?>
                                                            <span class="mr-4 text-striked">
                                                                <?= number_format($linkItem['BASE_PRICE'], 0, '.', ' ') . ' ₽' ?>
                                                            </span>
                                                            <span class="text-danger">
                                                                <?= number_format($linkItem['DISCOUNT_PRICE'], 0, '.', ' ') . ' ₽' ?>
                                                            </span>
                                                        <?else:?>
                                                            <span><?=number_format($linkItem['BASE_PRICE'], 0, '.', ' ') . ' ₽';?></span>
                                                        <?endif;?>
                                                    </p>
                                                </div>
                                            </div>
                                            <div class="card-footer swiper-no-swiping">
                                                <div class="card-rating">
                                                    <?
                                                    for($i = 1; $i <= 5; $i++) {
                                                        if($rating >= $i):?>
                                                            <svg width="11" height="11" xmlns="http://www.w3.org/2000/svg" class="icon-rating icon-rating-full icon sprite-icons">
                                                                <use href="/local/templates/new/_nuxt/08898a81d88ca4fa3db9dc44bfc54562.svg#i-rating" xlink:href="/local/templates/new/_nuxt/08898a81d88ca4fa3db9dc44bfc54562.svg#i-rating"></use>
                                                            </svg>
                                                        <?else:?>
                                                            <svg width="11" height="11" xmlns="http://www.w3.org/2000/svg" class="icon-rating icon sprite-icons">
                                                                <use href="/local/templates/new/_nuxt/08898a81d88ca4fa3db9dc44bfc54562.svg#i-rating" xlink:href="/local/templates/new/_nuxt/08898a81d88ca4fa3db9dc44bfc54562.svg#i-rating"></use>
                                                            </svg>
                                                        <?
                                                        endif;
                                                    }
                                                    ?>
                                                </div>
                                                <div class="btn-cart element-in-basket" style="display: none" data-element-id="<?=$linkItem['ID']?>">
                                                    <div role="group" tabindex="-1" class="b-form-spinbutton form-control d-flex align-items-stretch" lang="ru">
                                                        <button tabindex="-1" type="button" aria-label="Decrement" aria-keyshortcuts="ArrowDown" class="btn btn-sm btn-cart-action border-0 rounded-0 py-0" data-element-id="<?=$arItem['ID']?>" data-increment="-1">
                                                            <div>
                                                                <svg viewBox="0 0 16 16" width="1em" height="1em" focusable="false" role="img" alt="icon" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="bi-dash b-icon bi">
                                                                    <g transform="translate(8 8) scale(1.25 1.25) translate(-8 -8)">
                                                                        <path fill-rule="evenodd" d="M3.5 8a.5.5 0 0 1 .5-.5h8a.5.5 0 0 1 0 1H4a.5.5 0 0 1-.5-.5z"></path>
                                                                    </g>
                                                                </svg>
                                                            </div>
                                                        </button>
                                                        <input style="border: none; text-align: center; background-color: #04beca; color: white; outline: none" size="1px" dir="ltr" role="spinbutton" tabindex="0" aria-live="off" class="flex-grow-1 align-self-center border-left border-right" data-element-id="<?=$arItem['ID']?>" value="0">
                                                        <button tabindex="-1" type="button" aria-label="Increment" aria-keyshortcuts="ArrowUp" class="btn btn-sm btn-cart-action border-0 rounded-0 py-0" data-element-id="<?=$arItem['ID']?>" data-increment="1">
                                                            <div>
                                                                <svg viewBox="0 0 16 16" width="1em" height="1em" focusable="false" role="img" alt="icon" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="bi-plus b-icon bi">
                                                                    <g transform="translate(8 8) scale(1.25 1.25) translate(-8 -8)">
                                                                        <path fill-rule="evenodd" d="M8 3.5a.5.5 0 0 1 .5.5v4a.5.5 0 0 1-.5.5H4a.5.5 0 0 1 0-1h3.5V4a.5.5 0 0 1 .5-.5z"></path>
                                                                        <path fill-rule="evenodd" d="M7.5 8a.5.5 0 0 1 .5-.5h4a.5.5 0 0 1 0 1H8.5V12a.5.5 0 0 1-1 0V8z"></path>
                                                                    </g>
                                                                </svg>
                                                            </div>
                                                        </button>
                                                    </div>
                                                </div>

                                                <div class="flex-fill element-basket" data-element-id="<?=$linkItem['ID']?>">
                                                    <button type="button" class="btn btn-cart btn-primary btn-cart-action" data-element-id="<?=$linkItem['ID']?>" data-increment="1">
                                                        <svg width="22" height="20" xmlns="http://www.w3.org/2000/svg" class="icon sprite-icons">
                                                            <use href="/local/templates/new/_nuxt/08898a81d88ca4fa3db9dc44bfc54562.svg#i-cart" xlink:href="/local/templates/new/_nuxt/08898a81d88ca4fa3db9dc44bfc54562.svg#i-cart"></use>
                                                        </svg>
                                                        <span class="caption">В корзину</span>
                                                    </button>
                                                </div>
                                                <?if($arParams['~FAV_STYLE'] == 'Y'):?>
                                                    <button type="button" class="btn btn-icon btn-fav ml-2 btn-link element-fav-remove active" data-element-id="<?=$linkItem['ID']?>">
                                                        <svg width="22" height="20" xmlns="http://www.w3.org/2000/svg" class="icon sprite-icons">
                                                            <use href="/local/templates/new/_nuxt/08898a81d88ca4fa3db9dc44bfc54562.svg#i-heart-fill" xlink:href="/local/templates/new/_nuxt/08898a81d88ca4fa3db9dc44bfc54562.svg#i-heart-fill"></use>
                                                        </svg>
                                                    </button>
                                                <?else:?>
                                                    <button type="button" class="btn btn-icon btn-fav ml-2 btn-link element-fav" data-element-id="<?=$linkItem['ID']?>">
                                                        <svg width="22" height="20" xmlns="http://www.w3.org/2000/svg" class="icon sprite-icons">
                                                            <use href="/local/templates/new/_nuxt/08898a81d88ca4fa3db9dc44bfc54562.svg#i-heart-fill" xlink:href="/local/templates/new/_nuxt/08898a81d88ca4fa3db9dc44bfc54562.svg#i-heart-fill"></use>
                                                        </svg>
                                                    </button>
                                                <?endif;?>
                                            </div>
                                            <?if($linkItem['DISCOUNT_PRICE'] > 0 and $linkItem['BASE_PRICE'] > $linkItem['DISCOUNT_PRICE']):?>
                                                <div class="card-badge">
                                                    <?= round($linkItem['DISCOUNT_PRICE'] * 100/$linkItem['BASE_PRICE']) - 100 . '%' ?>
                                                </div>
                                            <?endif;?>
                                        </div>
                                    </div>
                                <?endforeach;?>

                                <script type="text/javascript">
                                    var mainSwiper = new Swiper ('#swiper-new-items-<?=$arItem['ID']?> .swiper-container', {
                                        pagination: {
                                            el: '#swiper-new-items-<?=$arItem['ID']?> .swiper-pagination',
                                        },
                                        navigation: {
                                            nextEl: '#swiper-new-items-<?=$arItem['ID']?> .swiper-button-next',
                                            prevEl: '#swiper-new-items-<?=$arItem['ID']?> .swiper-button-prev',
                                        },
                                        slidesPerView: 1,
                                        slidesPerGroup: 1,
                                        spaceBetween: 0,
                                        breakpoints: {
                                            320: {
                                                spaceBetween: 15,
                                                slidesPerView: 1,
                                                slidesPerGroup: 1,
                                            },
                                            768: {
                                                slidesPerView: 2,
                                                slidesPerGroup: 2,
                                            },
                                            992: {
                                                slidesPerView: 3,
                                                slidesPerGroup: 3,
                                                spaceBetween: 20,
                                            },
                                            1200: {
                                                slidesPerView: 3,
                                                slidesPerGroup: 3,
                                                spaceBetween: 30,
                                            }
                                        },
                                        loop: true
                                    });
                                </script>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    <?endforeach;?>

</div>