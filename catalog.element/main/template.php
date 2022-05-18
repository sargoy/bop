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

$APPLICATION->SetTitle($arResult['NAME']);

$arOffers = \Zloj\Portal\Functions::tradeOffers($arResult['ID']);

//pr($arOffers);

$rating = intval($arResult['PROPERTIES']['rating']['VALUE']);
?>
<script type="text/javascript" data-skip-moving="true">
    var tradeOffersConf = <?=json_encode($arOffers['JS']);?>;
</script>
<div class="catalog-item-content" id="<?echo $this->GetEditAreaId($arResult['ID'])?>">
    <div class="container" itemscope itemtype="https://schema.org/Product">
        <div class="row mb-md-2" id="inlineGallery">
            <div class="mb-3 d-none d-xl-block col-xl-1">
                <div class="swiper swiper-catalog-thumbs">
                    <div class="swiper-container">
                        <div class="swiper-wrapper">
                            <?foreach ($arResult['ZLOJ']['PICS'] as $img):?>
                                <div class="swiper-slide">
                                    <span class="slide-link">
                                        <img itemprop="image" src="<?=$img[0]?>" alt="" class="slide-img">
                                    </span>
                                </div>
                            <?endforeach;?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="mb-3 col-md-6 col-lg-5">
                <div class="item-gallery-wrapper">
                    <div class="swiper swiper-catalog">
                        <div class="swiper-container">
                            <?=\Zloj\Portal\Template::getDivisionCard($arResult['PROPERTIES'], true);?>
                            <div class="swiper-wrapper">
                                <?foreach ($arResult['ZLOJ']['PICS'] as $img):?>
                                    <div class="swiper-slide">
                                        <a href="<?=$img[2]?>" target="_self" class="embed-responsive embed-responsive-5by4 link-lightbox" data-toggle="modal" data-target="#modalGallery">
                                            <img itemprop="image" alt="" src="<?=$img[1]?>" class="embed-responsive-item">
                                        </a>
                                    </div>
                                <?endforeach;?>
                            </div>
                            <div class="swiper-pagination swiper-catalog-pagination"></div>
                        </div>
                    </div>
                    <?if(empty($arOffers['OFFERS']) and $arResult['PRICES']['DISCOUNT']['VALUE'] > 0 and $arResult['PRICES']['BASE']['VALUE'] > $arResult['PRICES']['DISCOUNT']['VALUE']):?>
                        <div class="card-badge">
                            <?= round($arResult['PRICES']['DISCOUNT']['VALUE'] * 100/$arResult['PRICES']['BASE']['VALUE']) - 100 . '%';?>
                        </div>
                    <?endif;?>
                    <button type="button" class="btn btn-icon btn-fav btn-link element-fav element-offer-<?=$arResult['ID']?>" data-offer-id="0" data-element-id="<?=$arResult['ID']?>">
                        <svg width="22" height="20" xmlns="http://www.w3.org/2000/svg" class="icon sprite-icons">
                            <use href="/local/templates/new/_nuxt/e9f276f8f2f8d76658b3ea83098ca231.svg#i-heart-fill" xlink:href="/local/templates/new/_nuxt/e9f276f8f2f8d76658b3ea83098ca231.svg#i-heart-fill"></use>
                        </svg>
                    </button>
                </div>
            </div>
            <div class="mb-3 col-md-6 col-lg-7 col-xl-6">
                <div class="row mb-3">
                    <div class="mb-3 mb-lg-0 col-lg-6">
                        <div class="rating-wrapper">
                            <?if(!empty($arResult['PROPERTIES']['CML2_ARTICLE']['VALUE'])):?>
                                <p class="vendor-code">
                                    Артикул <?=$arResult['PROPERTIES']['CML2_ARTICLE']['VALUE'];?>
                                </p>
                            <?else:?>
                                <p class="vendor-code">
                                    Номер товара <?=$arResult['ID'];?>
                                </p>
                            <?endif;?>
                            <?if(\Zloj\Portal\Functions::ENABLE_RATING):?>
                                <?if($arResult['PROPERTIES']['EXTENDED_REVIEWS_COUNT']['VALUE'] > 0):?>
                                    <a href="#reviewsTab" target="_self" class="text-dark mx-auto d-lg-none">
                                        <?=zlojPriceFrom($arResult['PROPERTIES']['EXTENDED_REVIEWS_COUNT']['VALUE'], -1)?>
                                    </a>
                                <?endif;?>
                                <div class="card-rating d-lg-none">
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
                        <h1 class="item-header" itemprop="name">
                            <?=$arResult['NAME'];?>
                        </h1>
                        <div class="item-controls">
                            <div class="item-price">
                                <p class="caption element-price-from-<?=$arResult['ID']?>">
                                    Цена за <?=zlojPriceFrom($arResult['ITEM_MEASURE_RATIOS'][$arResult['ITEM_MEASURE_RATIO_SELECTED']]['RATIO'], $arResult['ITEM_MEASURE']['ID']);?>
                                </p>
                                <div class="price">
                                    <?if(empty($arOffers['OFFERS'])):?>
                                        <?if($arResult['PRICES']['DISCOUNT']['VALUE'] > 0 and $arResult['PRICES']['BASE']['VALUE'] > $arResult['PRICES']['DISCOUNT']['VALUE']):?>
                                            <div itemprop="offers" itemscope itemtype="https://schema.org/AggregateOffer">
                                                <span class="mr-4 text-striked" itemprop="highPrice"  content="<?=$arResult['PRICES']['BASE']['VALUE']?>">
                                                    <?= $arResult['PRICES']['BASE']['PRINT_VALUE']; ?>
                                                </span><br>
                                                <span class="text-danger" itemprop="lowPrice" content="<?=$arResult['PRICES']['DISCOUNT']['VALUE']?>">
                                                    <?= $arResult['PRICES']['DISCOUNT']['PRINT_VALUE']; ?>
                                                </span>
                                            </div>
                                        <?else:?>
                                            <div itemprop="offers" itemscope itemtype="https://schema.org/Offer">
                                                <span itemprop="price"  content="<?=$arResult['PRICES']['BASE']['VALUE']?>"><?=$arResult['PRICES']['BASE']['PRINT_VALUE'];?></span>
                                            </div>
                                        <?endif;?>
                                    <?else:?>
                                        <div itemprop="offers" class="element-price-block-2-<?=$arResult['ID']?>">
                                            <span class="mr-4 text-striked element-price-old-<?=$arResult['ID']?>"></span><br>
                                            <span class="text-danger element-price-new-<?=$arResult['ID']?>"></span>
                                        </div>
                                        <div itemprop="offers" class="element-price-block-1-<?=$arResult['ID']?>">
                                            <span class="element-price-new-<?=$arResult['ID']?>"></span>
                                        </div>
                                    <?endif;?>
                                </div>
                            </div>
                            <div class="row mb-3 d-lg-none">
                                <div class="col-12 count-cart-container element-count-cart-<?=$arResult['ID']?>">
                                    <button type="button" class="btn btn-cart btn-primary btn-cart-action main-cart-button btn-cart-default element-offer-<?=$arResult['ID']?>" data-offer-id="0" data-element-id="<?=$arResult['ID']?>" data-increment="1">
                                        <svg width="22" height="20" xmlns="http://www.w3.org/2000/svg" class="icon sprite-icons">
                                            <use href="/local/templates/new/_nuxt/e9f276f8f2f8d76658b3ea83098ca231.svg#i-cart" xlink:href="/local/templates/new/_nuxt/e9f276f8f2f8d76658b3ea83098ca231.svg#i-cart"></use>
                                        </svg>
                                        <span class="caption d-inline-block">В корзину</span>
                                    </button>
                                    <div class="count-cart px-1 d-none">
                                        <div role="group" lang="ru-RU" tabindex="-1" class="b-form-spinbutton form-control d-flex align-items-stretch detail-cart-cnt element-in-basket element-offer-<?=$arResult['ID']?>" data-offer-id="0" data-element-id="<?=$arResult['ID']?>">
                                            <button tabindex="-1" type="button" aria-label="Decrement" aria-keyshortcuts="ArrowDown" class="btn btn-sm btn-cart-action border-0 rounded-0 py-0 element-offer-<?=$arResult['ID']?>" data-offer-id="0" data-element-id="<?=$arResult['ID']?>" data-increment="-1">
                                                <div>
                                                    <svg viewBox="0 0 16 16" width="1em" height="1em" focusable="false" role="img" alt="icon" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="bi-dash b-icon bi">
                                                        <g transform="translate(8 8) scale(1.25 1.25) translate(-8 -8)">
                                                            <path fill-rule="evenodd" d="M3.5 8a.5.5 0 0 1 .5-.5h8a.5.5 0 0 1 0 1H4a.5.5 0 0 1-.5-.5z"></path>
                                                        </g>
                                                    </svg>
                                                </div>
                                            </button>
                                            <input style="border: none; text-align: center; outline: none" size="1px" dir="ltr" role="spinbutton" tabindex="0" aria-live="off" class="flex-grow-1 align-self-center border-left border-right element-offer-<?=$arResult['ID']?>" data-offer-id="0" data-element-id="<?=$arResult['ID']?>" value="0">
                                            <button tabindex="-1" type="button" aria-label="Increment" aria-keyshortcuts="ArrowUp" class="btn btn-sm btn-cart-action border-0 rounded-0 py-0 element-offer-<?=$arResult['ID']?>" data-offer-id="0" data-element-id="<?=$arResult['ID']?>" data-increment="1">
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
                                </div>
                            </div>
                        </div>
                        <div class="row align-items-center">
                            <!--<div class="col-lg-12 col-5">
                                <p class="stock-info text-success">В наличии</p>
                            </div>-->
                            <?if(0):?>
                                <div class="d-lg-none col-7">
                                    <p class="bonus-info">15 баллов за покупку</p>
                                </div>
                            <?endif;?>
                        </div>
                        <button type="button" class="btn btn-info-toggle btn-outline-dark btn-block" data-loaded="0" id="btn-load-props">
                            Информация о товаре
                        </button>
                        <?if(!empty($arOffers['OPTIONS'])):?>
                            <div class="item-characteristics">
                                <div class="d-flex">
                                    <label class="item-characteristics__label" for="item-size">Выберите размер:</label>
                                    <a href="#">Таблица размеров</a>
                                </div>
                                <div class="item-characteristics__select-container mb-4">
                                    <select class="item-characteristics__select" name="item-size" id="trade-offers-options" data-element-id="<?=$arResult['ID']?>">
                                        <?foreach ($arOffers['OPTIONS'] as $name=>$id):?>
                                            <option value="<?=$id?>"><?=$name?></option>
                                        <?endforeach;?>
                                    </select>
                                </div>
                            </div>
                        <?endif;?>
                        <div class="delivery-info mb-4">
                            <div>
                                <?php
                                    $date1 = strtotime('+1 day');
                                    $date2 = strtotime('+2 day');
                                    $month = (int)date('m', $date2);
                                ?>
                                Доставим <span class="range_style"><?= (date('m', $date1) != date('m', $date2)) ? (int)(date('d', $date1)) . ' ' . month_verbose_rus(date('m', $date1)) . '-' . (int)(date('d', $date2)) . ' ' . month_verbose_rus($month) : (int)(date('d', $date1)) . '-' . (int)(date('d', $date2)) . ' ' . month_verbose_rus($month) ?></span>
                            </div>
                            <?/*if( $arResult['IBLOCK_SECTION_ID'] == 4773 or $arResult['IBLOCK_SECTION_ID'] == 4766):?>
	                            <?if($arResult['DETAIL_TEXT']):?>
                                    <p>
			                            <?=$arResult['DETAIL_TEXT'];?>
                                    </p>
	                            <?endif;?>
                            <?endif;*/?>
                            <!--<p class="stock-info">
                                <a href="/delivery/">Доставка</a> в течение 48 часов
                            </p>-->
                            <!--
                            <p>
                                <span class="text-muted">Самовывоз,</span> 20 мая
                            </p>
                            <p>
                                <span class="text-muted">Доставка курьером,</span> 22 мая
                            </p>
                            -->
                        </div>
                        <div class="dropdown b-dropdown dropdown-share mx-auto mt-auto dropright btn-group">
                            <button aria-haspopup="true" aria-expanded="false" type="button" class="btn dropdown-toggle btn-outline-dark btn-share dropdown-toggle-no-caret">
                                <span class="caption">Поделиться</span>
                                <svg width="17" height="9" xmlns="http://www.w3.org/2000/svg" class="icon sprite-icons">
                                    <use href="/local/templates/new/_nuxt/e9f276f8f2f8d76658b3ea83098ca231.svg#i-share" xlink:href="/local/templates/new/_nuxt/e9f276f8f2f8d76658b3ea83098ca231.svg#i-share"></use>
                                </svg>
                            </button>
                            <ul role="menu" tabindex="-1" class="dropdown-menu dropdown-menu--share">
                                <li class="ya-share2" data-curtain data-shape="round" data-services="vkontakte,facebook,odnoklassniki,twitter,whatsapp"></li>
                            </ul>
                        </div>
                    </div>
                    <div class="mb-3 mb-lg-0 d-none d-lg-block col-lg-6">
                        <div class="card card-white card-catalog-item-controls">
                            <div class="card-body">
                                <div class="rating-wrapper">
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
                                        <a href="#reviewsTab" target="_self" class="text-dark ml-auto"><?=zlojPriceFrom($arResult['REVIEWS']['CNT']['ALL'], -1)?></a>
                                    <?endif;?>
                                </div>
                                <div class="item-price">
                                    <p class="caption">
                                        Цена за <?=zlojPriceFrom($arResult['ITEM_MEASURE_RATIOS'][$arResult['ITEM_MEASURE_RATIO_SELECTED']]['RATIO'], $arResult['ITEM_MEASURE']['ID']);?>
                                    </p>
                                    <div class="price">
                                        <?if(empty($arOffers['OFFERS'])):?>
                                            <?if($arResult['PRICES']['DISCOUNT']['VALUE'] > 0 and $arResult['PRICES']['BASE']['VALUE'] > $arResult['PRICES']['DISCOUNT']['VALUE']):?>
                                                <div itemprop="offers" itemscope itemtype="https://schema.org/AggregateOffer">
                                                    <span class="mr-4 text-striked" itemprop="highPrice" content="<?=$arResult['PRICES']['BASE']['VALUE']?>">
                                                        <?= $arResult['PRICES']['BASE']['PRINT_VALUE']; ?>
                                                    </span> <br>
                                                    <span class="text-danger" itemprop="lowPrice" content="<?=$arResult['PRICES']['DISCOUNT']['VALUE']?>">
                                                        <?= $arResult['PRICES']['DISCOUNT']['PRINT_VALUE']; ?>
                                                    </span>
                                                </div>
                                            <?else:?>
                                                <div itemprop="offers" itemscope itemtype="https://schema.org/Offer">
                                                    <span itemprop="price" content="<?=$arResult['PRICES']['BASE']['VALUE']?>"><?= $arResult['PRICES']['BASE']['PRINT_VALUE']; ?></span>
                                                </div>
                                            <?endif;?>
                                        <?else:?>
                                            <div itemprop="offers" class="element-price-block-2-<?=$arResult['ID']?>">
                                                <span class="mr-4 text-striked element-price-old-<?=$arResult['ID']?>"></span><br>
                                                <span class="text-danger element-price-new-<?=$arResult['ID']?>"></span>
                                            </div>
                                            <div itemprop="offers" class="element-price-block-1-<?=$arResult['ID']?>">
                                                <span class="element-price-new-<?=$arResult['ID']?>"></span>
                                            </div>
                                        <?endif;?>
                                    </div>
                                </div>
                                <div class="btn-cart-wrapper count-cart-container element-count-cart-<?=$arResult['ID']?>">
                                    <button type="button" class="btn btn-cart btn-primary btn-cart-action main-cart-button btn-cart-default element-offer-<?=$arResult['ID']?>" data-offer-id="0" data-element-id="<?=$arResult['ID']?>" data-increment="1">
                                        <svg width="22" height="20" xmlns="http://www.w3.org/2000/svg" class="icon sprite-icons">
                                            <use href="/local/templates/new/_nuxt/e9f276f8f2f8d76658b3ea83098ca231.svg#i-cart" xlink:href="/local/templates/new/_nuxt/e9f276f8f2f8d76658b3ea83098ca231.svg#i-cart"></use>
                                        </svg>
                                        <span class="caption d-inline-block">В корзину</span>
                                    </button>
                                    <div class="d-none px-1 count-cart">
                                        <div role="group" lang="ru-RU" tabindex="-1" class="b-form-spinbutton form-control d-flex align-items-stretch element-in-basket element-offer-<?=$arResult['ID']?>" data-offer-id="0" data-element-id="<?=$arResult['ID']?>">
                                            <button tabindex="-1" type="button" aria-label="Decrement" aria-keyshortcuts="ArrowDown" class="btn btn-sm btn-cart-action border-0 rounded-0 py-0 element-offer-<?=$arResult['ID']?>" data-offer-id="0" data-element-id="<?=$arResult['ID']?>" data-increment="-1">
                                                <div>
                                                    <svg viewBox="0 0 16 16" width="1em" height="1em" focusable="false" role="img" alt="icon" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="bi-dash b-icon bi">
                                                        <g transform="translate(8 8) scale(1.25 1.25) translate(-8 -8)">
                                                            <path fill-rule="evenodd" d="M3.5 8a.5.5 0 0 1 .5-.5h8a.5.5 0 0 1 0 1H4a.5.5 0 0 1-.5-.5z"></path>
                                                        </g>
                                                    </svg>
                                                </div>
                                            </button>
                                            <input type="number" style="border: none; text-align: center; outline: none; border-radius: 0" maxlength="3" size="3px" dir="ltr" role="spinbutton" tabindex="0" aria-live="off" class="flex-grow-1 align-self-center border-left border-right btn-no-text element-offer-<?=$arResult['ID']?>" data-offer-id="0" data-element-id="<?=$arResult['ID']?>" value="0">
                                            <button tabindex="-1" type="button" aria-label="Increment" aria-keyshortcuts="ArrowUp" class="btn btn-sm btn-cart-action border-0 rounded-0 py-0 element-offer-<?=$arResult['ID']?>" data-offer-id="0" data-element-id="<?=$arResult['ID']?>" data-increment="1">
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
                                    <button type="button" class="btn btn-fav btn-link element-fav element-offer-<?=$arResult['ID']?>" data-offer-id="0" data-element-id="<?=$arResult['ID']?>">
                                        <svg width="22" height="20" xmlns="http://www.w3.org/2000/svg" class="icon sprite-icons">
                                            <use href="/local/templates/new/_nuxt/e9f276f8f2f8d76658b3ea83098ca231.svg#i-heart-fill" xlink:href="/local/templates/new/_nuxt/e9f276f8f2f8d76658b3ea83098ca231.svg#i-heart-fill"></use>
                                        </svg>
                                    </button>
                                </div>
                                <?if(0):?>
                                    <p class="bonus-info">15 баллов за покупку</p>
                                <?endif;?>
                                <!--<p class="stock-info">
                                    Скидка 5% при оплате картой онлайн
                                </p>-->
<!--                                <p class="price-delivery stock-info"></p>-->

                                <div class="dropdown b-dropdown dropdown-share mx-auto mt-auto dropright btn-group">
                                    <button aria-haspopup="true" aria-expanded="false" type="button" class="btn dropdown-toggle btn-outline-dark dropdown-toggle-no-caret">
                                        <span class="caption">Поделиться</span>
                                        <svg width="17" height="9" xmlns="http://www.w3.org/2000/svg" class="icon sprite-icons">
                                            <use href="/local/templates/new/_nuxt/e9f276f8f2f8d76658b3ea83098ca231.svg#i-share" xlink:href="/local/templates/new/_nuxt/e9f276f8f2f8d76658b3ea83098ca231.svg#i-share"></use>
                                        </svg>
                                    </button>
                                    <ul role="menu" tabindex="-1" class="dropdown-menu dropdown-menu--share">
                                        <script src="https://yastatic.net/share2/share.js"></script>
                                        <li class="ya-share2" data-curtain data-shape="round" data-services="vkontakte,facebook,odnoklassniki,twitter,whatsapp"></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class='mb-3 col-md-12 col-lg-6'>
                       <div class="stock-banner stock-banner_delivery">
                           <img src="/upload/static/stock-banner-delivery.svg" alt="Акция">
                           <div class="stock-banner__text"><strong>БЕСПЛАТНАЯ ДОСТАВКА</strong>при заказе от 1000 р.</div>
                       </div>
                    </div>
                <div class='mb-3 col-md-12 col-lg-6'>
                   <div class="stock-banner stock-banner_sale">
                       <img src="/upload/static/stock-banner-sale.svg" alt="Акция">
                       <div class="stock-banner__text"><strong>СКИДКА -5%</strong>при оплате картой на сайте</div>
                   </div>
                </div>
                </div>
            </div>
            <!--<div class='mb-3 col-md-12 offset-lg-5 col-lg-7 offset-xl-6 col-xl-6 d-flex justify-content-between flex-column flex-md-row'>
                <div class="stock-banner stock-banner_delivery">
                    <img src="/upload/static/stock-banner-delivery.svg" alt="Акция">
                    <div class="stock-banner__text"><strong>БЕСПЛАТНАЯ ДОСТАВКА</strong>при заказе от 1000 р.</div>
                </div>
                <div class="stock-banner stock-banner_sale">
                    <img src="/upload/static/stock-banner-sale.svg" alt="Акция">
                    <div class="stock-banner__text"><strong>СКИДКА -5%</strong>при оплате картой на сайте</div>
                </div>
            </div>-->
        </div>
        <div class="row d-none d-md-block">
            <div class="col-xl-11 offset-xl-1">
                <div role="radiogroup" tabindex="-1" class="product-tabs btn-group-toggle btn-group bv-no-focus-ring">
                    <label class="btn btn-outline-light active">
                        <input id="specsTab" type="radio" autocomplete="off" value="1" checked="checked">
                        Характеристики
                    </label>
                    <label class="btn btn-outline-light">
                        <input id="aboutTab" type="radio" autocomplete="off" value="2">
                        О товаре
                    </label>
                    <?if(\Zloj\Portal\Functions::ENABLE_RATING):?>
                        <label class="btn btn-outline-light">
                            <input id="reviewsTab" type="radio" autocomplete="off" value="3">
                            Отзывы
                        </label>
                    <?endif;?>
                    <label class="btn btn-outline-light">
                        <input id="deliveryTab" type="radio" autocomplete="off" value="4">
                        Доставка
                    </label>
                    <?/*
                    <label class="btn btn-outline-light">
                        <input id="documentationTab" type="radio" autocomplete="off" value="4">
                        Документация
                    </label>
                    */?>
                </div>
            </div>
        </div>
        <div class="tab-content product-tabs-content">
            <div class="tab-pane fade active show tab-1">
                <div class=" tab-inner in-content">
                    <table class="table table-striped table-borderless">
                        <tbody>
                        <?for($i = 0; $i <= 1; $i++):?>
                            <?foreach ($arResult['ZLOJ']['PROPS'][$i] as $arProp):?>
                                <tr>
                                    <td class="prop-title"><?=$arProp['NAME']?></td>
                                    <td class="prop-value"><?=$arProp['VALUE']?></td>
                                </tr>
                            <?endforeach;?>
                        <?endfor;?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="tab-pane fade tab-2">
                <div class="row tab-inner">
                    <div class="col-lg-10 col-xl-7 offset-xl-1 in-content">
                        <?=$arResult['DETAIL_TEXT']?>
                    </div>
                </div>
            </div>
            <?if(\Zloj\Portal\Functions::ENABLE_RATING):?>
                <div class="tab-pane fade show-xs tab-3">
                    <div class="row tab-inner">
                        <div class="col">
                            <p class="font-size-4 font-weight-medium mb-4 d-md-none">
                                Отзывы
                            </p>
                            <?
                            $fullReviews = false;
                            include ($_SERVER['DOCUMENT_ROOT'].'/local/templates/new/components/bitrix/catalog/main/include/reviews.php');
                            ?>
                        </div>
                    </div>
                </div>
            <?endif;?>
            <div class="tab-pane fade tab-4">
                <div class="row tab-inner">
                    <div class="mb-3 col-sm-4 col-xl-3 offset-xl-1">
                        <div class="card card-white h-100">
                            <div class="card-body d-flex flex-column p-3">
                                <p class="font-size-4 font-weight-bold mb-4 delivery__card-title">
                                    По&nbsp;Москве
                                </p>
                                <p class="font-size-6 font-weight-bold text-primary">
                                    150 <small class="font-weight-bold">₽</small>
                                </p>
                                <p class="text-gray-700 border-top border-gray-300 mb-2 pt-2 delivery__card-desc">
                                    При заказе на&nbsp;сумму от 1&nbsp;000 ₽
                                </p>
                                <p class="font-size-6 font-weight-bold text-primary mb-0 mb-sm-4">
                                    Бесплатно <br>
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3 col-sm-4 col-xl-3">
                        <div class="card card-white h-100">
                            <div class="card-body d-flex flex-column p-3">
                                <p class="font-size-4 font-weight-bold mb-4 delivery__card-title">
                                    По Московской области
                                </p>
                                <p class="font-size-6 font-weight-bold text-primary">
                                    300 <small class="font-weight-bold">₽</small> - 500 <small class="font-weight-bold">₽</small>
                                </p>
                                <p class="text-gray-700 border-top border-gray-300 mb-2 pt-2 delivery__card-desc">
                                    При заказе на&nbsp;сумму от 1&nbsp;000 ₽
                                </p>
                                <p class="font-size-6 font-weight-bold text-primary mb-0 mb-sm-4">
                                    Бесплатно <br>
                                </p>
                            </div>
                        </div>
                    </div>

<!--                    <div class="mb-3 col-sm-4 col-xl-3"><div class="card card-white h-100"><div class="card-body d-flex flex-column p-3"><p class="font-size-4 font-weight-bold mb-4">-->
<!--                                    За&nbsp;пределами МКАД и&nbsp;Московская область-->
<!--                                </p> <p class="font-size-6 font-weight-bold text-primary mt-auto">-->
<!--                                    850&nbsp;р.-->
<!--                                </p> <p class="text-gray-700 border-top border-gray-300 mb-2 pt-2">-->
<!--                                    При заказе на&nbsp;сумму от&nbsp;<span class="font-weight-medium">4000</span>&nbsp;руб.-->
<!--                                </p>-->
<!--                                <p class="font-size-4 font-weight-bold text-primary mb-0 mb-sm-4">-->
<!--                                    Бесплатно-->
<!--                                </p></div></div>-->
<!--                    </div> -->
                    <div class="mb-3 col-sm-4 col-xl-3">
                        <div class="card card-white h-100">
                            <div class="card-body d-flex flex-column p-3">
                                <p class="font-size-4 font-weight-bold mb-4 delivery__card-title">
                                    Самовывоз
                                </p>
                                <p class="font-size-6 font-weight-bold text-primary">
                                    Бесплатно
                                </p>
                                <p class="text-gray-700 border-top border-gray-300 mb-2 pt-2 delivery__card-desc">
                                    ПВЗ по адресу: Москва, ул.Шелепихинская наб., 8А, пом.12
                                </p>
                                <p class="font-size-4 font-weight-bold text-primary mb-0 mb-sm-4">

                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            <?/*<div class="tab-pane fade tab-4">
                <div class="row tab-inner">
                    <div class="col-xl-11 offset-xl-1 in-content">
                        <ul class="list-unstyled">
                            <li class="mb-2">
                                <a href="/uploads/certificate.pdf" class="media align-items-center text-reset font-weight-medium">
                                    <div class="align-self-start mr-3">
                                        <svg width="18" height="23" xmlns="http://www.w3.org/2000/svg" class="icon sprite-filetypes">
                                            <use href="/local/templates/new/_nuxt/0c050a9463f25aefb92e1f3a773929b7.svg#i-pdf" xlink:href="/local/templates/new/_nuxt/0c050a9463f25aefb92e1f3a773929b7.svg#i-pdf"></use>
                                        </svg>
                                    </div>
                                    <div class="media-body">
                                        Сертификат
                                    </div>
                                </a>
                            </li>
                            <li class="mb-2">
                                <a href="/uploads/manual.pdf" class="media align-items-center text-reset font-weight-medium">
                                    <div class="align-self-start mr-3">
                                        <svg width="18" height="23" xmlns="http://www.w3.org/2000/svg" class="icon sprite-filetypes">
                                            <use href="/local/templates/new/_nuxt/0c050a9463f25aefb92e1f3a773929b7.svg#i-pdf" xlink:href="/local/templates/new/_nuxt/0c050a9463f25aefb92e1f3a773929b7.svg#i-pdf"></use>
                                        </svg>
                                    </div>
                                    <div class="media-body">
                                        Инструкция
                                    </div>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            */?>
        </div>
    </div>
</div>
<div tabindex="-1" class="b-sidebar-outer sidebar-product-info">
    <div tabindex="-1" role="dialog" aria-modal="false" class="b-sidebar b-sidebar-right bg-white text-dark" style="width: 100%; display: none;" aria-hidden="true" id="sidebar-load-props">
        <div class="b-sidebar-body">
            <header class="b-sidebar-header">
                <span class="sidebar-title">Информация о товаре</span>
                <button type="button" aria-label="Close" class="close">
                    <svg width="14" height="14" xmlns="http://www.w3.org/2000/svg" class="icon sprite-icons">
                        <use href="/local/templates/new/_nuxt/e9f276f8f2f8d76658b3ea83098ca231.svg#i-close" xlink:href="/local/templates/new/_nuxt/e9f276f8f2f8d76658b3ea83098ca231.svg#i-close"></use>
                    </svg>
                </button>
            </header>
            <div class="mb-4 to-tab-2"></div>
            <div class="mb-4 to-tab-1"></div>
            <div class="mb-4 to-tab-4"></div>
        </div>
    </div>
</div>
</div>
<div id="modalGallery" role="dialog" class="modal fade show modal-gallery" style="display: none; padding-left: 0px;" aria-modal="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-body">
                <div class="row">
                    <div class="d-none d-xl-block col-xl-1">
                        <div class="swiper swiper-catalog-thumbs">
                            <div class="swiper-container swiper-container-vertical">
                                <div class="swiper-wrapper">
                                    <?foreach ($arResult['ZLOJ']['PICS'] as $img):?>
                                        <div class="swiper-slide">
                                            <span class="slide-link">
                                                <img src="<?=$img[0]?>" class="slide-img">
                                            </span>
                                        </div>
                                    <?endforeach;?>
                                </div>
                                <span class="swiper-notification" aria-live="assertive" aria-atomic="true"></span>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-11">
                        <div class="item-gallery-wrapper">
                            <div class="swiper swiper-catalog swiper-catalog-fullsize">
                                <div class="swiper-container swiper-container-horizontal">
                                    <div class="swiper-wrapper">
                                        <?foreach ($arResult['ZLOJ']['PICS'] as $img):?>
                                            <div class="swiper-slide">
                                                <img src="<?=$img[1]?>" class="slide-img">
                                            </div>
                                        <?endforeach;?>
                                    </div>
                                    <div class="swiper-nav swiper-button-prev"></div>
                                    <div class="swiper-nav swiper-button-next"></div>
                                    <span class="swiper-notification" aria-live="assertive" aria-atomic="true"></span>
                                </div>
                            </div>
                        </div>
                        <button type="button" aria-label="Close" class="close">
                            <svg width="14" height="14" xmlns="http://www.w3.org/2000/svg" class="icon sprite-icons">
                                <use href="/local/templates/new/_nuxt/e9f276f8f2f8d76658b3ea83098ca231.svg#i-close" xlink:href="/_nuxt/e9f276f8f2f8d76658b3ea83098ca231.svg#i-close"></use>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
