<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();
$arResult['SECTIONS_FORMAT'] = [];
foreach ($arResult['SECTIONS'] as $arSection){
	if($arSection['DEPTH_LEVEL'] == 1){
		$arResult['SECTIONS_FORMAT'][$arSection['ID']] = $arSection;
		$arResult['SECTIONS_FORMAT'][$arSection['ID']]['PARENT'] = [];
	}
	if($arSection['DEPTH_LEVEL'] == 2){
		$arResult['SECTIONS_FORMAT'][$arSection['IBLOCK_SECTION_ID']]['PARENT'][] = $arSection;
	}
}
