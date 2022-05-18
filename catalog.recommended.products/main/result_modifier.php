<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

if (empty($arResult['RECOMMENDED_IDS']) and !empty($GLOBALS['zloj_session']['CURRENT_ELEMENT'])) {
	CModule::IncludeModule('iblock');

	$resElements = CIBlockElement::GetList(
		[],
		[
			"!ID" => $GLOBALS['zloj_session']['CURRENT_ELEMENT']['ID'],
			"IBLOCK_ID" => $GLOBALS['zloj_session']['CURRENT_ELEMENT']['IBLOCK_ID'],
			"SECTION_ID" => $GLOBALS['zloj_session']['CURRENT_ELEMENT']['IBLOCK_SECTION_ID'],
			'ACTIVE' => 'Y'
		],
		false,
		['nPageSize' => $arParams['PAGE_ELEMENT_COUNT']],
		["ID"]
	);
	while($arElement = $resElements->GetNext()) {
		$arResult['RECOMMENDED_IDS'][$arElement['ID']] = $arElement['ID'];
	}
}
?>
