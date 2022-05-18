<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

/** @var array $arResult */

$arrIdElem = null;
foreach ($arResult['ITEMS'] as $item) {
	foreach ($item['PROPERTIES']['ATT_NEW_ELEMS']['VALUE'] as $id) {
		$arrIdElem[] = $id;
	}
}

$arSelect = [
	"ID",
	"PRICE_1",
	"PRICE_2",
];
$arFilter = ["ID" => $arrIdElem];

$res = CIBlockElement::GetList([], $arFilter,false, false, $arSelect);

while ($ar_fields = $res->fetch()) {
	foreach ($arResult['ITEMS'] as &$arItems) {
	    if ($arItems['DISPLAY_PROPERTIES']['ATT_NEW_ELEMS']['LINK_ELEMENT_VALUE'][$ar_fields['ID']]) {
		    $arItems['DISPLAY_PROPERTIES']['ATT_NEW_ELEMS']['LINK_ELEMENT_VALUE'][$ar_fields['ID']]['BASE_PRICE'] = $ar_fields['PRICE_1'];
		    $arItems['DISPLAY_PROPERTIES']['ATT_NEW_ELEMS']['LINK_ELEMENT_VALUE'][$ar_fields['ID']]['DISCOUNT_PRICE'] = $ar_fields['PRICE_2'];
        }
	}
}