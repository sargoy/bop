<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

$url = '';
if(!empty($arResult['SECTION']['SECTION_PAGE_URL'])){
    $url = $arResult['SECTION']['SECTION_PAGE_URL'];
}

\Zloj\Portal\Template::setPageAdult($templateData['CURRENT_ADULT'], $url);

$GLOBALS['zloj_session']['CURRENT_ELEMENT'] = $arResult;

?>
