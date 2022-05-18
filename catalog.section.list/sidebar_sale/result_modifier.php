<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

$arResult['SECTIONS_FORMAT'] = [];
foreach ($arResult['SECTIONS'] as $arSection){
	if($arSection['ID'] == $arParams['CURRENT_SECTION']){
		$arSection['ACTIVE_LINK'] = 1;
	}
	if($arSection['DEPTH_LEVEL'] == $arResult['SECTION']['DEPTH_LEVEL'] + 1){
		$arResult['SECTIONS_FORMAT'][$arSection['ID']] = $arSection;
		$arResult['SECTIONS_FORMAT'][$arSection['ID']]['PARENT'] = [];
	}
	if($arSection['DEPTH_LEVEL'] == $arResult['SECTION']['DEPTH_LEVEL'] + 2){
		$arResult['SECTIONS_FORMAT'][$arSection['IBLOCK_SECTION_ID']]['PARENT'][] = $arSection;
	}
}

$arResult['ROOT'] = [];
$key = count($arResult['SECTION']['PATH']) - intval($arParams['IN_STEP']);
if(!empty($arResult['SECTION']['PATH'][$key])) {
	$arResult['ROOT'] = $arResult['SECTION']['PATH'][$key];
}
