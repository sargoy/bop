<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();
/**
 * @global CMain $APPLICATION
 * @var array $arParams
 * @var array $arResult
 * @var CatalogSectionComponent $component
 * @var CBitrixComponentTemplate $this
 * @var string $templateName
 * @var string $componentPath
 * @var string $templateFolder
 */
$this->setFrameMode(true);

\Zloj\Portal\Template::checkAdultParam($arParams);
$templateData['CURRENT_ADULT'] = \Zloj\Portal\Template::checkElementAdult($arResult['PROPERTIES'][\Zloj\Portal\Functions::PROPERTY_ADULT]['VALUE'], $arParams['SHOW_ADULT']);

$arResult['NAME'] = \Zloj\Portal\Functions::txtReplaceSpace($arResult['NAME']);

//pr($arResult);

$rating = intval($arResult['PROPERTIES']['rating']['VALUE']);
?>
<div class="row catalog-items catalog-items-table mb-4 mb-lg-5" itemscope itemtype="https://schema.org/Product">
    <div class="col-lg-10 col-xl-9">
        <div class="card card-product">
            <div class="card-img-wrapper">
                <div class="embed-responsive embed-responsive-4by3">
                    <div class="embed-responsive-item d-flex">
                        <img itemprop="image" src="/images/products/pasta.jpg" alt="" class="card-img">
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
                    </div>
                </div>
            </div>
            <div class="card-body">
                <a href="<?=$arResult['DETAIL_PAGE_URL'];?>" class="item-title" target="_self">
                    <?=$arResult['NAME'];?>
                </a>
                <div class="item-price">
                    <p class="caption">
                        Цена за <?=zlojPriceFrom($arResult['ITEM_MEASURE_RATIOS'][$arResult['ITEM_MEASURE_RATIO_SELECTED']]['RATIO'], $arResult['ITEM_MEASURE']['ID']);?>
                    </p>
                    <div class="price">
                        <?if($arResult['PRICES']['DISCOUNT']['VALUE'] > 0 and $arResult['PRICES']['BASE']['VALUE'] > $arResult['PRICES']['DISCOUNT']['VALUE']):?>
                            <div itemprop="offers" itemscope itemtype="https://schema.org/AggregateOffer">
                                <span class="mr-4 text-striked" itemprop="highPrice" content="<?=$arResult['PRICES']['BASE']['VALUE']?>">
                                    <?=zlojPriceFormat($arResult['PRICES']['BASE']['VALUE']);?>
                                </span>
                                <span class="text-danger" itemprop="lowPrice" content="<?=$arResult['PRICES']['DISCOUNT']['VALUE']?>">
                                    <?=zlojPriceFormat($arResult['PRICES']['DISCOUNT']['VALUE']);?>
                                </span>
                            </div>
                        <?else:?>
                            <div itemprop="offers" itemscope itemtype="https://schema.org/Offer">
                                <span itemprop="price" content="<?=$arResult['PRICES']['BASE']['VALUE']?>"><?=zlojPriceFormat($arResult['PRICES']['BASE']['VALUE']);?></span>
                            </div>
                        <?endif;?>
                    </div>
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
                    <div class="btn-cart element-in-basket" style="display: none" data-element-id="<?=$arResult['ID']?>">
                        <div role="group" tabindex="-1" class="b-form-spinbutton form-control d-flex align-items-stretch" lang="ru">
                            <button tabindex="-1" type="button" aria-label="Decrement" aria-keyshortcuts="ArrowDown" class="btn btn-sm btn-cart-action border-0 rounded-0 py-0" data-element-id="<?=$arResult['ID']?>" data-increment="-1">
                                <div>
                                    <svg viewBox="0 0 16 16" width="1em" height="1em" focusable="false" role="img" alt="icon" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="bi-dash b-icon bi">
                                        <g transform="translate(8 8) scale(1.25 1.25) translate(-8 -8)">
                                            <path fill-rule="evenodd" d="M3.5 8a.5.5 0 0 1 .5-.5h8a.5.5 0 0 1 0 1H4a.5.5 0 0 1-.5-.5z"></path>
                                        </g>
                                    </svg>
                                </div>
                            </button>
                            <output dir="ltr" role="spinbutton" tabindex="0" aria-live="off" class="flex-grow-1 align-self-center border-left border-right" data-element-id="<?=$arResult['ID']?>">
                                <bdi>0</bdi>
                            </output>
                            <button tabindex="-1" type="button" aria-label="Increment" aria-keyshortcuts="ArrowUp" class="btn btn-sm btn-cart-action border-0 rounded-0 py-0" data-element-id="<?=$arResult['ID']?>" data-increment="1">
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
                    <div class="flex-fill element-basket" data-element-id="<?=$arResult['ID']?>">
                        <button type="button" class="btn btn-cart btn-primary btn-cart-action" data-element-id="<?=$arResult['ID']?>" data-increment="1">
                            <svg width="22" height="20" xmlns="http://www.w3.org/2000/svg" class="icon sprite-icons">
                                <use href="/local/templates/new/_nuxt/08898a81d88ca4fa3db9dc44bfc54562.svg#i-cart" xlink:href="/local/templates/new/_nuxt/08898a81d88ca4fa3db9dc44bfc54562.svg#i-cart"></use>
                            </svg>
                            <span class="caption">В корзину</span>
                        </button>
                    </div>
                    <button type="button" class="btn btn-icon btn-fav ml-2 btn-link element-fav" data-element-id="<?=$arResult['ID']?>">
                        <svg width="22" height="20" xmlns="http://www.w3.org/2000/svg" class="icon sprite-icons">
                            <use href="/local/templates/new/_nuxt/08898a81d88ca4fa3db9dc44bfc54562.svg#i-heart-fill" xlink:href="/local/templates/new/_nuxt/08898a81d88ca4fa3db9dc44bfc54562.svg#i-heart-fill"></use>
                        </svg>
                    </button>
                </div>
                <?if($arResult['PRICES']['DISCOUNT']['VALUE'] > 0 and $arResult['PRICES']['BASE']['VALUE'] > $arResult['PRICES']['DISCOUNT']['VALUE']):?>
                    <div class="card-badge">
                        <?=zlojPriceFormat($arResult['PRICES']['DISCOUNT']['VALUE'] - $arResult['PRICES']['BASE']['VALUE'], true);?>
                    </div>
                <?endif;?>
            </div>
        </div>
    </div>
    <?
    $fullReviews = true;
    include ($_SERVER['DOCUMENT_ROOT'].'/local/templates/new/components/bitrix/catalog/main/include/reviews.php');

    ?>
