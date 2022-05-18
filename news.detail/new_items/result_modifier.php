<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
$arResult["PROPERTIES"]["ATT_RECEPT"]['SRC'] = CFile::GetPath((int)$arResult["PROPERTIES"]["ATT_RECEPT"]["VALUE"]);

/** @var array $arResult */

$arrIdElem = null;
foreach ($arResult["PROPERTIES"]["ATT_NEW_ELEMS"]["VALUE"] as $itemId) {
		$arrIdElem[] = $itemId;
}

$arSelect = [
	"ID",
	"PRICE_1",
	"PRICE_2",
];
$arFilter = ["ID" => $arrIdElem];

$res = CIBlockElement::GetList([], $arFilter,false, false, $arSelect);
//debug($arResult);
while ($ar_fields = $res->fetch()) {
//	debug($ar_fields, 0);
//	foreach ($arResult['DISPLAY_PROPERTIES']['ATT_NEW_ELEMS']['LINK_ELEMENT_VALUE'] as &$arItems) {

//		debug($arItems, 0);
//		$arItems['BASE_PRICE'] = $ar_fields['PRICE_1'];
//		debug($ar_fields,0);
	if ($arResult['DISPLAY_PROPERTIES']['ATT_NEW_ELEMS']['LINK_ELEMENT_VALUE'][$ar_fields['ID']]) {

		$arResult['DISPLAY_PROPERTIES']['ATT_NEW_ELEMS']['LINK_ELEMENT_VALUE'][$ar_fields['ID']]['BASE_PRICE'] = $ar_fields['PRICE_1'];
		$arResult['DISPLAY_PROPERTIES']['ATT_NEW_ELEMS']['LINK_ELEMENT_VALUE'][$ar_fields['ID']]['DISCOUNT_PRICE'] = $ar_fields['PRICE_2'];
	}

//	}
}
//debug($arResult['DISPLAY_PROPERTIES']['ATT_NEW_ELEMS']['LINK_ELEMENT_VALUE']);
?>