<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use \Bitrix\Main;

/**
 * @global CMain $APPLICATION
 * @var array $arParams
 * @var array $arResult
 * @var CatalogProductsViewedComponent $component
 * @var CBitrixComponentTemplate $this
 * @var string $templateName
 * @var string $componentPath
 * @var string $templateFolder
 */

$this->setFrameMode(true);

\Zloj\Portal\Template::checkAdultParam($arParams);

if (isset($arResult['ITEM'])):
	$arItem = $arResult['ITEM'];

    $arOffer = \Zloj\Portal\Functions::tradeOffersList($arItem);

    \Zloj\Portal\Template::changePageAdult($arItem['PROPERTIES'][\Zloj\Portal\Functions::PROPERTY_ADULT]['VALUE']);
    $arItem['NAME'] = \Zloj\Portal\Functions::txtReplaceSpace($arItem['NAME']);
    if($arItem["PREVIEW_PICTURE"]["ID"]) {
	    $file = CFile::ResizeImageGet($arItem["PREVIEW_PICTURE"], ['width' => 400, 'height' => 400], BX_RESIZE_IMAGE_PROPORTIONAL, true);
        $file['src'] = \Zloj\Portal\Template::censoreImage($file['src'], $arItem['PROPERTIES'][\Zloj\Portal\Functions::PROPERTY_ADULT]['VALUE'], $arParams['SHOW_ADULT']);
    }else{
        $file = [
            'src' => '/images/nophoto.svg'
        ];
    }
	$rating = intval($arItem['PROPERTIES']['rating']['VALUE']);
	?>
    <div class="card card-product" id="<?=$arResult['AREA_ID'];?>" itemscope itemtype="https://schema.org/Product">
        <div class="card-img-wrapper">
            <?=\Zloj\Portal\Template::getDivisionCard($arItem['PROPERTIES']);?>
            <div class="embed-responsive embed-responsive-4by3">
                <div class="embed-responsive-item d-flex">
                    <a href="<?=$arItem['DETAIL_PAGE_URL']?>" target="_self" class="item-title">
                        <img itemprop="image" data-src="<?=$file['src']?>" src="/images/spinner.gif" class="card-img lazy" alt="<?=$arItem["NAME"]?>">
                    </a>
	                <?if(\Zloj\Portal\Functions::ENABLE_RATING and $arParams['~FAV_STYLE'] != 'Y'):?>
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
                    <?endif;?>
                </div>
            </div>
        </div>
        <div class="card-body">
            <a itemprop="url" href="<?=$arItem['DETAIL_PAGE_URL']?>" target="_self" class="item-title"><span itemprop="name"><?=$arItem['NAME'];?></span></a>
            <div class="item-price">
                <p class="caption">
                    Цена за <?=zlojPriceFrom($arOffer['ITEM_MEASURE_RATIOS'][$arOffer['ITEM_MEASURE_RATIO_SELECTED']]['RATIO'], $arOffer['ITEM_MEASURE']['ID']);?>
                </p>
                <div class="price">
	                <?if($arOffer['PRICES']['DISCOUNT']['VALUE'] > 0 and $arOffer['PRICES']['BASE']['VALUE'] > $arOffer['PRICES']['DISCOUNT']['VALUE']):?>
                        <div itemprop="offers" itemscope itemtype="https://schema.org/AggregateOffer">
                            <span class="mr-4 text-striked" itemprop="highPrice" content="<?=$arOffer['PRICES']['BASE']['VALUE']?>">
                                <?= $arOffer['PRICES']['BASE']['PRINT_VALUE'] ;?>
                            </span>
                            <span class="text-danger" itemprop="lowPrice" content="<?=$arResult['PRICES']['DISCOUNT']['VALUE']?>">
                                <?= $arOffer['PRICES']['DISCOUNT']['PRINT_VALUE']; ?>
                            </span>
                        </div>
                    <?else:?>
                        <div itemprop="offers" itemscope itemtype="https://schema.org/Offer">
                            <span itemprop="price" content="<?=$arOffer['PRICES']['BASE']['VALUE']?>"><?=$arOffer['PRICES']['BASE']['PRINT_VALUE'];?></span>
                        </div>
	                <?endif;?>
                </div>
            </div>
        </div>
        <div class="card-footer swiper-no-swiping">
            <?if(\Zloj\Portal\Functions::ENABLE_RATING):?>
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
            <?endif;?>
            <div class="btn-cart element-in-basket" style="display: none" data-element-id="<?=$arItem['ID']?>"<?if($arItem['ID'] != $arOffer['ID']):?> data-offer-id="<?=$arOffer['ID'];?>"<?endif;?>>
                <div role="group" tabindex="-1" class="b-form-spinbutton form-control d-flex align-items-stretch" lang="ru">
                    <button tabindex="-1" type="button" aria-label="Decrement" aria-keyshortcuts="ArrowDown" class="btn btn-sm btn-cart-action border-0 rounded-0 py-0" data-element-id="<?=$arItem['ID']?>"<?if($arItem['ID'] != $arOffer['ID']):?> data-offer-id="<?=$arOffer['ID'];?>"<?endif;?> data-increment="-1">
                        <div>
                            <svg viewBox="0 0 16 16" width="1em" height="1em" focusable="false" role="img" alt="icon" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="bi-dash b-icon bi">
                                <g transform="translate(8 8) scale(1.25 1.25) translate(-8 -8)">
                                    <path fill-rule="evenodd" d="M3.5 8a.5.5 0 0 1 .5-.5h8a.5.5 0 0 1 0 1H4a.5.5 0 0 1-.5-.5z"></path>
                                </g>
                            </svg>
                        </div>
                    </button>
                    <input type="number" style="border: none; text-align: center; background-color: #04beca; color: white; outline: none; border-radius: 0;" maxlength="3" size="5px" dir="ltr" role="spinbutton" tabindex="0" aria-live="off" class="flex-grow-1 align-self-center border-left border-right btn-no-text" data-element-id="<?=$arItem['ID']?>"<?if($arItem['ID'] != $arOffer['ID']):?> data-offer-id="<?=$arOffer['ID'];?>"<?endif;?> value="0" >
                    <button tabindex="-1" type="button" aria-label="Increment" aria-keyshortcuts="ArrowUp" class="btn btn-sm btn-cart-action border-0 rounded-0 py-0" data-element-id="<?=$arItem['ID']?>"<?if($arItem['ID'] != $arOffer['ID']):?> data-offer-id="<?=$arOffer['ID'];?>"<?endif;?> data-increment="1">
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

            <div class="flex-fill element-basket" data-element-id="<?=$arItem['ID']?>"<?if($arItem['ID'] != $arOffer['ID']):?> data-offer-id="<?=$arOffer['ID'];?>"<?endif;?>>
                <button type="button" class="btn btn-cart btn-primary btn-cart-action" data-element-id="<?=$arItem['ID']?>" data-increment="1">
                    <svg width="22" height="20" xmlns="http://www.w3.org/2000/svg" class="icon sprite-icons">
                        <use href="/local/templates/new/_nuxt/08898a81d88ca4fa3db9dc44bfc54562.svg#i-cart" xlink:href="/local/templates/new/_nuxt/08898a81d88ca4fa3db9dc44bfc54562.svg#i-cart"></use>
                    </svg>
                    <span class="caption">В корзину</span>
                </button>
            </div>
            <?if($arParams['~FAV_STYLE'] == 'Y'):?>
                <button type="button" class="btn btn-icon btn-fav ml-2 btn-link element-fav-remove active" data-element-id="<?=$arItem['ID']?>"<?if($arItem['ID'] != $arOffer['ID']):?> data-offer-id="<?=$arOffer['ID'];?>"<?endif;?>>
                    <svg width="22" height="20" xmlns="http://www.w3.org/2000/svg" class="icon sprite-icons">
                        <use href="/local/templates/new/_nuxt/08898a81d88ca4fa3db9dc44bfc54562.svg#i-heart-fill" xlink:href="/local/templates/new/_nuxt/08898a81d88ca4fa3db9dc44bfc54562.svg#i-heart-fill"></use>
                    </svg>
                </button>
            <?else:?>
                <button type="button" class="btn btn-icon btn-fav ml-2 btn-link element-fav" data-element-id="<?=$arItem['ID']?>">
                    <svg width="22" height="20" xmlns="http://www.w3.org/2000/svg" class="icon sprite-icons">
                        <use href="/local/templates/new/_nuxt/08898a81d88ca4fa3db9dc44bfc54562.svg#i-heart-fill" xlink:href="/local/templates/new/_nuxt/08898a81d88ca4fa3db9dc44bfc54562.svg#i-heart-fill"></use>
                    </svg>
                </button>
            <?endif;?>
        </div>
	    <?if($arOffer['PRICES']['DISCOUNT']['VALUE'] > 0 and $arOffer['PRICES']['BASE']['VALUE'] > $arOffer['PRICES']['DISCOUNT']['VALUE']):?>
            <div class="card-badge">
                <?= round($arOffer['PRICES']['DISCOUNT']['VALUE'] * 100/$arOffer['PRICES']['BASE']['VALUE']) - 100 . '%';?>
            </div>
	    <?endif;?>
    </div>
<?endif;?>