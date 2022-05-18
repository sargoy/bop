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

$arSort = [
    'new' => [
        'TITLE' => 'Новинки',
        'FIELD1' => 'SORT',
        'ORDER1' => 'asc',
        'FIELD2' => 'created_date',
        'ORDER2' => 'desc',
    ],
    'popular' => [
        'TITLE' => 'Популярные',
        'FIELD1' => 'SORT',
        'ORDER1' => 'asc',
        'FIELD2' => 'show_counter',
        'ORDER2' => 'desc',
    ],
    'cheap' => [
        'TITLE' => 'Сначала дешёвые',
        'FIELD1' => 'catalog_PRICE_2',
        'ORDER1' => 'asc',
        'FIELD2' => 'SORT',
        'ORDER2' => 'asc',
    ],
    'expensive' => [
        'TITLE' => 'Сначала дорогие',
        'FIELD1' => 'catalog_PRICE_2',
        'ORDER1' => 'desc',
        'FIELD2' => 'SORT',
        'ORDER2' => 'asc',
    ],
    'discount' => [
        'TITLE' => 'По размеру скидки',
        'FIELD1' => 'PROPERTY_DISCOUNT',
        'ORDER1' => 'desc',
        'FIELD2' => 'SORT',
        'ORDER2' => 'asc',
    ],
    'rating' => [
        'TITLE' => 'Высокий рейтинг',
        'FIELD1' => 'property_rating',
        'ORDER1' => 'desc',
        'FIELD2' => 'SORT',
        'ORDER2' => 'asc',
    ]
];

//pr($arResult);
?>
<?$APPLICATION->IncludeComponent(
    "bitrix:catalog.section.list",
    "inner",
    array(
        "IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
        "IBLOCK_ID" => $arParams["IBLOCK_ID"],
        "SECTION_ID" => $arResult["VARIABLES"]["SECTION_ID"],
        "SECTION_CODE" => $arResult["VARIABLES"]["SECTION_CODE"],
        "CACHE_TYPE" => $arParams["CACHE_TYPE"],
        "CACHE_TIME" => $arParams["CACHE_TIME"],
        "CACHE_GROUPS" => $arParams["CACHE_GROUPS"],
        "COUNT_ELEMENTS" => "N",
        "TOP_DEPTH" => "1",
        "ADD_SECTIONS_CHAIN" => "N",
        "SECTION_URL" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["section"],
        'SHOW_ADULT' => \Zloj\Portal\Functions::getAdult(),
    ),
    $component
);?>
<div class="row">
    <div class="col-md-6 col-lg-4 col-xl-3">
	    <?if($GLOBALS['zloj_session']['CURRENT_SECTION']['DEPTH_LEVEL'] > 0):?>
        <div class="row mb-3 d-md-none align-items-center">
            <div class="col-2">
                <a href="<?=$GLOBALS['zloj_session']['CURRENT_SECTION']['DEPTH_LEVEL'] > 1 ? $GLOBALS['zloj_session']['CURRENT_SECTION']['PATH'][count($GLOBALS['zloj_session']['CURRENT_SECTION']['PATH']) - 2]['SECTION_PAGE_URL'] : '/catalog/'?>" class="btn text-left mb-2 px-0 btn-link btn-block" target="_self">
                    <svg width="19" height="7" xmlns="http://www.w3.org/2000/svg" class="icon sprite-icons">
                        <use href="<?=SITE_TEMPLATE_PATH?>/_nuxt/e9f276f8f2f8d76658b3ea83098ca231.svg#i-arrow-backlink"
                             xlink:href="<?=SITE_TEMPLATE_PATH?>/_nuxt/e9f276f8f2f8d76658b3ea83098ca231.svg#i-arrow-backlink"></use>
                    </svg>
                </a>
            </div>
            <div class="col-8">
                <p class="catalog-controls-header text-center mb-2">
                    <?$APPLICATION->ShowViewContent('section_title');?>
                </p>
            </div>
            <div class="col-2 text-center">
                <button type="button" aria-label="Close" class="close catalog-sidebar-close float-none">
                    <svg width="14" height="14" xmlns="http://www.w3.org/2000/svg" class="icon sprite-icons">
                        <use href="<?=SITE_TEMPLATE_PATH?>/_nuxt/e9f276f8f2f8d76658b3ea83098ca231.svg#i-close"
                             xlink:href="<?=SITE_TEMPLATE_PATH?>/_nuxt/e9f276f8f2f8d76658b3ea83098ca231.svg#i-close"></use>
                    </svg>
                </button>
            </div>
            <?endif;?>
            <?if($GLOBALS['zloj_session']['CURRENT_SECTION']['DEPTH_LEVEL'] > 1):?>
            <div class="col-8">
                <div class="catalog-mobile-control">
                    <div class="dropdown b-dropdown dropdown-catalog-sort">
                        <?
                        if(empty($_SESSION['zloj']['sort']) or !is_array($_SESSION['zloj']['sort'])){
                            $_SESSION['zloj']['sort'] = [];
                        }
                        $id = intval($GLOBALS['zloj_session']['CURRENT_SECTION']['ID']);
                        if(empty($_REQUEST['sort']) or !isset($arSort[$_REQUEST['sort']])){
                            if(!empty($_SESSION['zloj']['sort'][$id]) and isset($arSort[$_SESSION['zloj']['sort'][$id]])){
                                $sortKey = $_SESSION['zloj']['sort'][$id];
                            }else{
                                $sortKey = 'popular';
                            }
                        }else{
                            $_SESSION['zloj']['sort'][$id] = $sortKey = $_REQUEST['sort'];
                        }
                        $uri = current(explode('?', $_SERVER['REQUEST_URI'], 2));
                        ?>
                        <button aria-haspopup="true" aria-expanded="false" type="button" class="btn dropdown-toggle btn-link btn-block dropdown-toggle-no-caret">
                            <span class="caption"><?=$arSort[$sortKey]['TITLE']?></span>
                            <svg width="12" height="12" xmlns="http://www.w3.org/2000/svg" class="icon sprite-icons">
                                <use href="/local/templates/new/_nuxt/e9f276f8f2f8d76658b3ea83098ca231.svg#i-caret" xlink:href="/local/templates/new/_nuxt/e9f276f8f2f8d76658b3ea83098ca231.svg#i-caret"></use>
                            </svg>
                        </button>
                        <ul role="menu" tabindex="-1" class="dropdown-menu">
                            <?foreach ($arSort as $key=>$arItem):?>
                                <li role="presentation">
                                    <a role="menuitem" href="<?=$uri?>?sort=<?=$key?>" target="_self" class="dropdown-item"><?=$arItem['TITLE']?></a>
                                </li>
                            <?endforeach;?>
                        </ul>
                    </div>
                    <div role="radiogroup" tabindex="-1" class="catalog-view-controls btn-group-toggle btn-group bv-no-focus-ring">
                        <label class="btn btn-link <?= ZLOJ_VIEW_MODE == 'grid' ? 'active' : '' ?>">
                            <input type="radio" autocomplete="off" value="grid" name="catalog-view-controls" <?= ZLOJ_VIEW_MODE == 'grid' ? 'checked' : '' ?>>
                            <svg width="16" height="16" xmlns="http://www.w3.org/2000/svg" class="icon sprite-icons">
                                <use href="/local/templates/new/_nuxt/e9f276f8f2f8d76658b3ea83098ca231.svg#i-catalog-view-grid" xlink:href="/local/templates/new/_nuxt/e9f276f8f2f8d76658b3ea83098ca231.svg#i-catalog-view-grid"></use>
                            </svg>
                        </label>
                        <label class="btn btn-link <?= ZLOJ_VIEW_MODE == 'table' ? 'active' : '' ?>">
                            <input type="radio" autocomplete="off" value="table" name="catalog-view-controls" <?= ZLOJ_VIEW_MODE == 'grid' ? 'checked' : '' ?>>
                            <svg width="16" height="16" xmlns="http://www.w3.org/2000/svg" class="icon sprite-icons">
                                <use href="/local/templates/new/_nuxt/e9f276f8f2f8d76658b3ea83098ca231.svg#i-catalog-view-table" xlink:href="/local/templates/new/_nuxt/e9f276f8f2f8d76658b3ea83098ca231.svg#i-catalog-view-table"></use>
                            </svg>
                        </label>
                    </div>
                </div>
            </div>
            <div class="col-4">

                <button type="button" class="btn catalog-sidebar-toggle btn-link btn-sm btn-block">
                    Фильтры
                </button>
            </div>
            <?endif;?>
        </div>
        <div class="catalog-sidebar catalog-sidebar-collapsible">
            <?if(!empty($GLOBALS['zloj_session']['IN_SECTION']) ):?>
                <?$APPLICATION->IncludeComponent(
                    "bitrix:catalog.section.list",
                    "sidebar",
                    array(
                        "IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
                        "IBLOCK_ID" => $arParams["IBLOCK_ID"],
                        "SECTION_ID" => $GLOBALS['zloj_session']['CURRENT_SECTION']['DEPTH_LEVEL'] == 1 ? '0' : $GLOBALS['zloj_session']['IN_SECTION']['ID'],
                        "SECTION_CODE" => $GLOBALS['zloj_session']['CURRENT_SECTION']['DEPTH_LEVEL'] == 1 ? '' : $GLOBALS['zloj_session']['IN_SECTION']['CODE'],
                        "CACHE_TYPE" => $arParams["CACHE_TYPE"],
                        "CACHE_TIME" => $arParams["CACHE_TIME"],
                        "CACHE_GROUPS" => $arParams["CACHE_GROUPS"],
                        "COUNT_ELEMENTS" => "N",
                        "TOP_DEPTH" => $GLOBALS['zloj_session']['CURRENT_SECTION']['DEPTH_LEVEL'] == 1 ? '1' : '2',
                        "ADD_SECTIONS_CHAIN" => "N",
                        "SECTION_URL" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["section"],
                        "IN_STEP" => $GLOBALS['zloj_session']['SUBSECTIONS'] ? 2 : 1,
                        "CURRENT_SECTION" => $GLOBALS['zloj_session']['CURRENT_SECTION']['ID'],
                        'SHOW_ADULT' => \Zloj\Portal\Functions::getAdult(),
                    ),
                    $component
                );?>
            <?endif;?>
            <?if($GLOBALS['zloj_session']['CURRENT_SECTION']['DEPTH_LEVEL'] > 1):?>
                <?$APPLICATION->IncludeComponent(
                    "bitrix:catalog.smart.filter",
                    "main",
                    array(
                        "IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
                        "IBLOCK_ID" => $arParams["IBLOCK_ID"],
                        "SECTION_CODE" => $arResult['VARIABLES']['SECTION_CODE'],
                        "FILTER_NAME" => $arParams["FILTER_NAME"],
                        "PRICE_CODE" => $arParams["~PRICE_CODE"],
                        "CACHE_TYPE" => $arParams["CACHE_TYPE"],
                        "CACHE_TIME" => $arParams["CACHE_TIME"],
                        "CACHE_GROUPS" => $arParams["CACHE_GROUPS"],
                        "SAVE_IN_SESSION" => "N",
                        "FILTER_VIEW_MODE" => $arParams["FILTER_VIEW_MODE"],
                        "XML_EXPORT" => "N",
                        "POPUP_POSITION" => "right",
                        "SECTION_TITLE" => "NAME",
                        "SECTION_DESCRIPTION" => "DESCRIPTION",
                        'HIDE_NOT_AVAILABLE' => $arParams["HIDE_NOT_AVAILABLE"],
                        "TEMPLATE_THEME" => $arParams["TEMPLATE_THEME"],
                        'CONVERT_CURRENCY' => $arParams['CONVERT_CURRENCY'],
                        'CURRENCY_ID' => $arParams['CURRENCY_ID'],
                        "SEF_MODE" => $arParams["SEF_MODE"],
                        "SEF_RULE" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["smart_filter"],
                        "SMART_FILTER_PATH" => $arResult["VARIABLES"]["SMART_FILTER_PATH"],
                        "PAGER_PARAMS_NAME" => $arParams["PAGER_PARAMS_NAME"],
                        "INSTANT_RELOAD" => $arParams["INSTANT_RELOAD"],
                        'SHOW_ADULT' => \Zloj\Portal\Functions::getAdult(),
                    ),
                    $component,
                    array('HIDE_ICONS' => 'Y')
                );?>
            <?endif;?>
        </div>
    </div>
    <div class="overflow-hidden col-md-6 col-lg-8 col-xl-9">
        <?if($GLOBALS['zloj_session']['CURRENT_SECTION']['DEPTH_LEVEL'] == 1):?>
            <?$APPLICATION->ShowViewContent('section_list_inner');?>
        <?else:?>
            <div class="catalog-controls">
                <h1 class="catalog-controls-header mb-0">
                    <?$APPLICATION->ShowViewContent('section_title');?>
                </h1>
                <p class="ml-xl-auto mr-auto mr-xl-30 mb-0 text-gray-500">
                    <?$APPLICATION->ShowViewContent('section_count');?>
                </p>
                <div class="dropdown b-dropdown dropdown-catalog-sort">
                    <?
                    if(empty($_SESSION['zloj']['sort']) or !is_array($_SESSION['zloj']['sort'])){
                        $_SESSION['zloj']['sort'] = [];
                    }
                    $id = intval($GLOBALS['zloj_session']['CURRENT_SECTION']['ID']);
                    if(empty($_REQUEST['sort']) or !isset($arSort[$_REQUEST['sort']])){
                        if(!empty($_SESSION['zloj']['sort'][$id]) and isset($arSort[$_SESSION['zloj']['sort'][$id]])){
                            $sortKey = $_SESSION['zloj']['sort'][$id];
                        }else{
                            $sortKey = 'new';
                        }
                    }else{
                        $_SESSION['zloj']['sort'][$id] = $sortKey = $_REQUEST['sort'];
                    }
                    $uri = current(explode('?', $_SERVER['REQUEST_URI'], 2));
                    ?>
                    <button aria-haspopup="true" aria-expanded="false" type="button" class="btn dropdown-toggle btn-link btn-block dropdown-toggle-no-caret">
                        <span class="caption"><?=$arSort[$sortKey]['TITLE']?></span>
                        <svg width="12" height="12" xmlns="http://www.w3.org/2000/svg" class="icon sprite-icons">
                            <use href="/local/templates/new/_nuxt/e9f276f8f2f8d76658b3ea83098ca231.svg#i-caret" xlink:href="/local/templates/new/_nuxt/e9f276f8f2f8d76658b3ea83098ca231.svg#i-caret"></use>
                        </svg>
                    </button>
                    <ul role="menu" tabindex="-1" class="dropdown-menu">
                        <?foreach ($arSort as $key=>$arItem):?>
                            <li role="presentation">
                                <a role="menuitem" href="<?=$uri?>?sort=<?=$key?>" target="_self" class="dropdown-item"><?=$arItem['TITLE']?></a>
                            </li>
                        <?endforeach;?>
                    </ul>
                </div>
                <div role="radiogroup" tabindex="-1" class="catalog-view-controls btn-group-toggle btn-group bv-no-focus-ring">
                    <label class="btn btn-link <?= ZLOJ_VIEW_MODE == 'grid' ? 'active' : '' ?>">
                        <input type="radio" autocomplete="off" value="grid" name="catalog-view-controls" <?= ZLOJ_VIEW_MODE == 'grid' ? 'checked' : '' ?>>
                        <svg width="16" height="16" xmlns="http://www.w3.org/2000/svg" class="icon sprite-icons">
                            <use href="/local/templates/new/_nuxt/e9f276f8f2f8d76658b3ea83098ca231.svg#i-catalog-view-grid" xlink:href="/local/templates/new/_nuxt/e9f276f8f2f8d76658b3ea83098ca231.svg#i-catalog-view-grid"></use>
                        </svg>
                    </label>
                    <label class="btn btn-link <?= ZLOJ_VIEW_MODE == 'table' ? 'active' : '' ?>">
                        <input type="radio" autocomplete="off" value="table" name="catalog-view-controls" <?= ZLOJ_VIEW_MODE == 'table' ? 'checked' : '' ?>>
                        <svg width="16" height="16" xmlns="http://www.w3.org/2000/svg" class="icon sprite-icons">
                            <use href="/local/templates/new/_nuxt/e9f276f8f2f8d76658b3ea83098ca231.svg#i-catalog-view-table" xlink:href="/local/templates/new/_nuxt/e9f276f8f2f8d76658b3ea83098ca231.svg#i-catalog-view-table"></use>
                        </svg>
                    </label>
                </div>
            </div>
            <?
            //pr($arSort[$sortKey]);
            ?>
            <?$APPLICATION->IncludeComponent(
                "bitrix:catalog.section",
                "main",
                array(
                    "IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
                    "IBLOCK_ID" => $arParams["IBLOCK_ID"],
                    "ELEMENT_SORT_FIELD" => $arSort[$sortKey]['FIELD1'],
                    "ELEMENT_SORT_ORDER" => $arSort[$sortKey]['ORDER1'],
                    "ELEMENT_SORT_FIELD2" => $arSort[$sortKey]['FIELD2'],
                    "ELEMENT_SORT_ORDER2" => $arSort[$sortKey]['ORDER2'],
                    "PROPERTY_CODE" => (isset($arParams["LIST_PROPERTY_CODE"]) ? $arParams["LIST_PROPERTY_CODE"] : []),
                    "PROPERTY_CODE_MOBILE" => $arParams["LIST_PROPERTY_CODE_MOBILE"],
                    "META_KEYWORDS" => $arParams["LIST_META_KEYWORDS"],
                    "META_DESCRIPTION" => $arParams["LIST_META_DESCRIPTION"],
                    "BROWSER_TITLE" => $arParams["LIST_BROWSER_TITLE"],
                    "SET_LAST_MODIFIED" => $arParams["SET_LAST_MODIFIED"],
                    "INCLUDE_SUBSECTIONS" => $arParams["INCLUDE_SUBSECTIONS"],
                    "BASKET_URL" => $arParams["BASKET_URL"],
                    "ACTION_VARIABLE" => $arParams["ACTION_VARIABLE"],
                    "PRODUCT_ID_VARIABLE" => $arParams["PRODUCT_ID_VARIABLE"],
                    "SECTION_ID_VARIABLE" => $arParams["SECTION_ID_VARIABLE"],
                    "PRODUCT_QUANTITY_VARIABLE" => $arParams["PRODUCT_QUANTITY_VARIABLE"],
                    "PRODUCT_PROPS_VARIABLE" => $arParams["PRODUCT_PROPS_VARIABLE"],
                    "FILTER_NAME" => $arParams["FILTER_NAME"],
                    "CACHE_TYPE" => $arParams["CACHE_TYPE"],
                    "CACHE_TIME" => $arParams["CACHE_TIME"],
                    "CACHE_FILTER" => $arParams["CACHE_FILTER"],
                    "CACHE_GROUPS" => $arParams["CACHE_GROUPS"],
                    "SET_TITLE" => $arParams["SET_TITLE"],
                    "MESSAGE_404" => $arParams["~MESSAGE_404"],
                    "SET_STATUS_404" => $arParams["SET_STATUS_404"],
                    "SHOW_404" => $arParams["SHOW_404"],
                    "FILE_404" => $arParams["FILE_404"],
                    "DISPLAY_COMPARE" => $arParams["USE_COMPARE"],
                    "PAGE_ELEMENT_COUNT" => $arParams["PAGE_ELEMENT_COUNT"],
                    "LINE_ELEMENT_COUNT" => $arParams["LINE_ELEMENT_COUNT"],
                    "PRICE_CODE" => $arParams["~PRICE_CODE"],
                    "USE_PRICE_COUNT" => $arParams["USE_PRICE_COUNT"],
                    "SHOW_PRICE_COUNT" => $arParams["SHOW_PRICE_COUNT"],

                    "PRICE_VAT_INCLUDE" => $arParams["PRICE_VAT_INCLUDE"],
                    "USE_PRODUCT_QUANTITY" => $arParams['USE_PRODUCT_QUANTITY'],
                    "ADD_PROPERTIES_TO_BASKET" => (isset($arParams["ADD_PROPERTIES_TO_BASKET"]) ? $arParams["ADD_PROPERTIES_TO_BASKET"] : ''),
                    "PARTIAL_PRODUCT_PROPERTIES" => (isset($arParams["PARTIAL_PRODUCT_PROPERTIES"]) ? $arParams["PARTIAL_PRODUCT_PROPERTIES"] : ''),
                    "PRODUCT_PROPERTIES" => (isset($arParams["PRODUCT_PROPERTIES"]) ? $arParams["PRODUCT_PROPERTIES"] : []),

                    "DISPLAY_TOP_PAGER" => $arParams["DISPLAY_TOP_PAGER"],
                    "DISPLAY_BOTTOM_PAGER" => $arParams["DISPLAY_BOTTOM_PAGER"],
                    "PAGER_TITLE" => $arParams["PAGER_TITLE"],
                    "PAGER_SHOW_ALWAYS" => $arParams["PAGER_SHOW_ALWAYS"],
                    "PAGER_TEMPLATE" => $arParams["PAGER_TEMPLATE"],
                    "PAGER_DESC_NUMBERING" => $arParams["PAGER_DESC_NUMBERING"],
                    "PAGER_DESC_NUMBERING_CACHE_TIME" => $arParams["PAGER_DESC_NUMBERING_CACHE_TIME"],
                    "PAGER_SHOW_ALL" => $arParams["PAGER_SHOW_ALL"],
                    "PAGER_BASE_LINK_ENABLE" => $arParams["PAGER_BASE_LINK_ENABLE"],
                    "PAGER_BASE_LINK" => $arParams["PAGER_BASE_LINK"],
                    "PAGER_PARAMS_NAME" => $arParams["PAGER_PARAMS_NAME"],
                    "LAZY_LOAD" => $arParams["LAZY_LOAD"],
                    "MESS_BTN_LAZY_LOAD" => $arParams["~MESS_BTN_LAZY_LOAD"],
                    "LOAD_ON_SCROLL" => $arParams["LOAD_ON_SCROLL"],

                    "OFFERS_CART_PROPERTIES" => (isset($arParams["OFFERS_CART_PROPERTIES"]) ? $arParams["OFFERS_CART_PROPERTIES"] : []),
                    "OFFERS_FIELD_CODE" => $arParams["LIST_OFFERS_FIELD_CODE"],
                    "OFFERS_PROPERTY_CODE" => (isset($arParams["LIST_OFFERS_PROPERTY_CODE"]) ? $arParams["LIST_OFFERS_PROPERTY_CODE"] : []),
                    "OFFERS_SORT_FIELD" => $arParams["OFFERS_SORT_FIELD"],
                    "OFFERS_SORT_ORDER" => $arParams["OFFERS_SORT_ORDER"],
                    "OFFERS_SORT_FIELD2" => $arParams["OFFERS_SORT_FIELD2"],
                    "OFFERS_SORT_ORDER2" => $arParams["OFFERS_SORT_ORDER2"],
                    "OFFERS_LIMIT" => (isset($arParams["LIST_OFFERS_LIMIT"]) ? $arParams["LIST_OFFERS_LIMIT"] : 0),

                    "SECTION_ID" => $arResult["VARIABLES"]["SECTION_ID"],
                    "SECTION_CODE" => $arResult["VARIABLES"]["SECTION_CODE"],
                    "SECTION_URL" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["section"],
                    "DETAIL_URL" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["element"],
                    "USE_MAIN_ELEMENT_SECTION" => $arParams["USE_MAIN_ELEMENT_SECTION"],
                    'CONVERT_CURRENCY' => $arParams['CONVERT_CURRENCY'],
                    'CURRENCY_ID' => $arParams['CURRENCY_ID'],
                    'HIDE_NOT_AVAILABLE' => $arParams["HIDE_NOT_AVAILABLE"],
                    'HIDE_NOT_AVAILABLE_OFFERS' => $arParams["HIDE_NOT_AVAILABLE_OFFERS"],

                    'LABEL_PROP' => $arParams['LABEL_PROP'],
                    'LABEL_PROP_MOBILE' => $arParams['LABEL_PROP_MOBILE'],
                    'LABEL_PROP_POSITION' => $arParams['LABEL_PROP_POSITION'],
                    'ADD_PICT_PROP' => $arParams['ADD_PICT_PROP'],
                    'PRODUCT_DISPLAY_MODE' => $arParams['PRODUCT_DISPLAY_MODE'],
                    'PRODUCT_BLOCKS_ORDER' => $arParams['LIST_PRODUCT_BLOCKS_ORDER'],
                    'PRODUCT_ROW_VARIANTS' => $arParams['LIST_PRODUCT_ROW_VARIANTS'],
                    'ENLARGE_PRODUCT' => $arParams['LIST_ENLARGE_PRODUCT'],
                    'ENLARGE_PROP' => isset($arParams['LIST_ENLARGE_PROP']) ? $arParams['LIST_ENLARGE_PROP'] : '',
                    'SHOW_SLIDER' => $arParams['LIST_SHOW_SLIDER'],
                    'SLIDER_INTERVAL' => isset($arParams['LIST_SLIDER_INTERVAL']) ? $arParams['LIST_SLIDER_INTERVAL'] : '',
                    'SLIDER_PROGRESS' => isset($arParams['LIST_SLIDER_PROGRESS']) ? $arParams['LIST_SLIDER_PROGRESS'] : '',

                    'OFFER_ADD_PICT_PROP' => $arParams['OFFER_ADD_PICT_PROP'],
                    'OFFER_TREE_PROPS' => (isset($arParams['OFFER_TREE_PROPS']) ? $arParams['OFFER_TREE_PROPS'] : []),
                    'PRODUCT_SUBSCRIPTION' => $arParams['PRODUCT_SUBSCRIPTION'],
                    'SHOW_DISCOUNT_PERCENT' => $arParams['SHOW_DISCOUNT_PERCENT'],
                    'DISCOUNT_PERCENT_POSITION' => $arParams['DISCOUNT_PERCENT_POSITION'],
                    'SHOW_OLD_PRICE' => $arParams['SHOW_OLD_PRICE'],
                    'SHOW_MAX_QUANTITY' => $arParams['SHOW_MAX_QUANTITY'],
                    'MESS_SHOW_MAX_QUANTITY' => (isset($arParams['~MESS_SHOW_MAX_QUANTITY']) ? $arParams['~MESS_SHOW_MAX_QUANTITY'] : ''),
                    'RELATIVE_QUANTITY_FACTOR' => (isset($arParams['RELATIVE_QUANTITY_FACTOR']) ? $arParams['RELATIVE_QUANTITY_FACTOR'] : ''),
                    'MESS_RELATIVE_QUANTITY_MANY' => (isset($arParams['~MESS_RELATIVE_QUANTITY_MANY']) ? $arParams['~MESS_RELATIVE_QUANTITY_MANY'] : ''),
                    'MESS_RELATIVE_QUANTITY_FEW' => (isset($arParams['~MESS_RELATIVE_QUANTITY_FEW']) ? $arParams['~MESS_RELATIVE_QUANTITY_FEW'] : ''),
                    'MESS_BTN_BUY' => (isset($arParams['~MESS_BTN_BUY']) ? $arParams['~MESS_BTN_BUY'] : ''),
                    'MESS_BTN_ADD_TO_BASKET' => (isset($arParams['~MESS_BTN_ADD_TO_BASKET']) ? $arParams['~MESS_BTN_ADD_TO_BASKET'] : ''),
                    'MESS_BTN_SUBSCRIBE' => (isset($arParams['~MESS_BTN_SUBSCRIBE']) ? $arParams['~MESS_BTN_SUBSCRIBE'] : ''),
                    'MESS_BTN_DETAIL' => (isset($arParams['~MESS_BTN_DETAIL']) ? $arParams['~MESS_BTN_DETAIL'] : ''),
                    'MESS_NOT_AVAILABLE' => (isset($arParams['~MESS_NOT_AVAILABLE']) ? $arParams['~MESS_NOT_AVAILABLE'] : ''),
                    'MESS_BTN_COMPARE' => (isset($arParams['~MESS_BTN_COMPARE']) ? $arParams['~MESS_BTN_COMPARE'] : ''),

                    'USE_ENHANCED_ECOMMERCE' => (isset($arParams['USE_ENHANCED_ECOMMERCE']) ? $arParams['USE_ENHANCED_ECOMMERCE'] : ''),
                    'DATA_LAYER_NAME' => (isset($arParams['DATA_LAYER_NAME']) ? $arParams['DATA_LAYER_NAME'] : ''),
                    'BRAND_PROPERTY' => (isset($arParams['BRAND_PROPERTY']) ? $arParams['BRAND_PROPERTY'] : ''),

                    'TEMPLATE_THEME' => (isset($arParams['TEMPLATE_THEME']) ? $arParams['TEMPLATE_THEME'] : ''),
                    "ADD_SECTIONS_CHAIN" => "Y",
                    'ADD_TO_BASKET_ACTION' => $basketAction,
                    'SHOW_CLOSE_POPUP' => isset($arParams['COMMON_SHOW_CLOSE_POPUP']) ? $arParams['COMMON_SHOW_CLOSE_POPUP'] : '',
                    'COMPARE_PATH' => $arResult['FOLDER'].$arResult['URL_TEMPLATES']['compare'],
                    'COMPARE_NAME' => $arParams['COMPARE_NAME'],
                    'USE_COMPARE_LIST' => 'Y',
                    'BACKGROUND_IMAGE' => (isset($arParams['SECTION_BACKGROUND_IMAGE']) ? $arParams['SECTION_BACKGROUND_IMAGE'] : ''),
                    'COMPATIBLE_MODE' => (isset($arParams['COMPATIBLE_MODE']) ? $arParams['COMPATIBLE_MODE'] : ''),
                    'DISABLE_INIT_JS_IN_COMPONENT' => (isset($arParams['DISABLE_INIT_JS_IN_COMPONENT']) ? $arParams['DISABLE_INIT_JS_IN_COMPONENT'] : ''),

                    'ZLOJ_VIEW_MODE' => ZLOJ_VIEW_MODE,
                    'SHOW_ADULT' => \Zloj\Portal\Functions::getAdult(),
                ),
                $component
            );?>
        <?endif;?>
    </div>
</div>
<?//pr($GLOBALS['zloj_session']['CURRENT_SECTION']);?>
