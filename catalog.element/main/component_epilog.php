<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

$url = '';
if(!empty($arResult['SECTION']['SECTION_PAGE_URL'])){
    $url = $arResult['SECTION']['SECTION_PAGE_URL'];
}

\Zloj\Portal\Template::setPageAdult($templateData['CURRENT_ADULT'], $url);

//для передачи в метатег Open Graph
$APPLICATION->SetPageProperty("og:image", !empty($_SERVER['HTTPS']) ? 'https://' : 'http://' . SITE_SERVER_NAME . $arResult['PREVIEW_PICTURE']['SOCIAL']);
//!для передачи в метатег Open Graph

GLOBAL $lastModified;
if (!$lastModified) {
    $lastModified = MakeTimeStamp($arResult['TIMESTAMP_X']);
} else {
    $lastModified = max($lastModified, MakeTimeStamp($arResult['TIMESTAMP_X']));
}

$GLOBALS['zloj_session']['CURRENT_ELEMENT'] = $arResult;

$GLOBALS['breadcrumbBack'] = $arResult['SECTION']['SECTION_PAGE_URL'];

$dbBasketItems = CSaleBasket::GetList(
    [
        "NAME" => "ASC",
        "ID" => "ASC"
    ],
    [
        "FUSER_ID" => CSaleBasket::GetBasketUserID(),
        "LID" => SITE_ID,
        'PRODUCT_ID' => $arResult['ID'],
        "ORDER_ID" => "NULL",
        "DELAY" => "N"
    ],
    false,
    false,
    ['PRODUCT_ID']
);
if ($arItems = $dbBasketItems->Fetch()): ?>
    <script>
        let name = $('span.caption.d-inline-block');
        name.removeClass('d-inline-block').addClass('d-none');
        let el = $('.btn-cart-default');
        el.addClass('action-cart');
        let cnt = $('.count-cart');
        cnt.removeClass('d-none').addClass('d-inline-block');
    </script>
<?endif;?>
