<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
$arResult['MENU'] = [];
foreach ($arResult['SECTIONS'] as $arSection){
	$pic = '';
	if($arSection['PICTURE']['ID']){
		$file = CFile::ResizeImageGet($arSection['PICTURE']['ID'], array('width'=>250, 'height'=>350), BX_RESIZE_IMAGE_EXACT, true);
		$pic = $file['src'];
	}
	$arResult['MENU'][$arSection['ID']] = [
		'ID' => $arSection['ID'],
		'NAME' => $arSection['NAME'],
		'SECTION_PAGE_URL' => $arSection['SECTION_PAGE_URL'],
		'IBLOCK_SECTION_ID' => $arSection['IBLOCK_SECTION_ID'],
		'DEPTH_LEVEL' => $arSection['DEPTH_LEVEL'],
		'PICTURE' => $pic,
		'PARENT' => [],
	];
}
foreach ($arResult['SECTIONS'] as $arSection) {
	if($arSection['IBLOCK_SECTION_ID']){
		$arResult['MENU'][$arSection['IBLOCK_SECTION_ID']]['PARENT'][] = $arSection['ID'];
	}
}
?>