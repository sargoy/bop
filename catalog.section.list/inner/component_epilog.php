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

$key = count($arResult['SECTION']['PATH']) - (($templateData['CNT'] > 0) ? 1 : 2);
if($key < 0){
	$GLOBALS['zloj_session']['IN_SECTION'] = [
		'ID' => 0
	];
}
elseif(!empty($arResult['SECTION']['PATH'][$key])) {
	$GLOBALS['zloj_session']['IN_SECTION'] = $arResult['SECTION']['PATH'][$key];
}
$GLOBALS['zloj_session']['CURRENT_SECTION'] = $arResult['SECTION'];
$GLOBALS['zloj_session']['SUBSECTIONS'] = ($templateData['CNT'] > 0);
//pr($arResult['SECTION']['PATH']);
//pr($GLOBALS['zloj_session']['IN_SECTION']);
if($GLOBALS['zloj_session']['CURRENT_SECTION']['DEPTH_LEVEL'] == 1){
	foreach($arResult["SECTION"]["PATH"] as $arPath)
	{
		if (isset($arPath["IPROPERTY_VALUES"]["SECTION_PAGE_TITLE"]) && $arPath["IPROPERTY_VALUES"]["SECTION_PAGE_TITLE"] != "")
			$APPLICATION->AddChainItem($arPath["IPROPERTY_VALUES"]["SECTION_PAGE_TITLE"], $arPath["~SECTION_PAGE_URL"]);
		else
			$APPLICATION->AddChainItem($arPath["NAME"], $arPath["~SECTION_PAGE_URL"]);
	}
}
?>