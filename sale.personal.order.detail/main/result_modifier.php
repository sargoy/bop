<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

CModule::IncludeModule("iblock");

$arIds = [];
foreach($arResult['BASKET'] as $arItem){
	$arIds[$arItem['PRODUCT_ID']] = $arItem['PRODUCT_ID'];
}

$arResult['IBLOCK_ELEMENTS'] = [];
if($arIds){
	$arSelect = Array("ID", "IBLOCK_ID", "NAME", "PREVIEW_PICTURE", "DETAIL_PAGE_URL", "PROPERTY_rating");
	$arFilter = Array("ID" => $arIds, "IBLOCK_ID" => 26, "ACTIVE_DATE"=>"Y", "ACTIVE"=>"Y");
	$obElements = CIBlockElement::GetList(Array(), $arFilter, false, false, $arSelect);
	while($arElement = $obElements->GetNext()){
		$arResult['IBLOCK_ELEMENTS'][$arElement['ID']] = $arElement;
	}
}

