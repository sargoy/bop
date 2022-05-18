<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
$arResult['USERS'] = [];
foreach ($arResult['rows'] as &$arItem){
	if($arItem['UF_USER'] > 0) {
		$arResult['USERS'][$arItem['UF_USER']] = $arItem['UF_USER'];
	}
	$arItem['UF_TEXT'] = TruncateText($arItem['UF_TEXT'], 50);
}
unset($arItem);
if(count($arResult['USERS'])) {
	$arFilter = ['ID' => implode(' | ', $arResult['USERS'])];
	$resUsers = CUser::GetList(($by = "ID"), ($order = "asc"), $arFilter);
	while ($arUser = $resUsers->GetNext()) {
		$arResult['USERS'][$arUser['ID']] = $arUser;
	}
}


?>