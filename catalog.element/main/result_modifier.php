<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

include ($_SERVER['DOCUMENT_ROOT'].'/local/templates/new/components/bitrix/catalog/main/include/reviews_init.php');

$arResult['ZLOJ'] = [
	'PICS' => [],
	'PROPS' => [
		[],
		[]
	],
];

if($arResult['~DETAIL_PICTURE']){
	$arResult['ZLOJ']['PICS'][] = $arResult['~DETAIL_PICTURE'];
} elseif ($arResult['~PREVIEW_PICTURE'] && !$arResult['PROPERTIES']['MORE_PHOTO']['~VALUE']) {
    $arResult['ZLOJ']['PICS'][] = $arResult['~PREVIEW_PICTURE'];
}
if(!empty($arResult['PROPERTIES']['MORE_PHOTO']['~VALUE']) and is_array($arResult['PROPERTIES']['MORE_PHOTO']['~VALUE'])){
	foreach ($arResult['PROPERTIES']['MORE_PHOTO']['~VALUE'] as $id){
		$arResult['ZLOJ']['PICS'][] = $id;
	}
}
if(count($arResult['ZLOJ']['PICS'])){
	foreach ($arResult['ZLOJ']['PICS'] as $key=>$id){
		$file1 = CFile::ResizeImageGet($id, ['width' => 75, 'height' => 75], BX_RESIZE_IMAGE_EXACT, true);
		$file2 = CFile::ResizeImageGet($id, ['width' => 500, 'height' => 400], BX_RESIZE_IMAGE_PROPORTIONAL, true);
		$file3 = CFile::ResizeImageGet($id, ['width' => 1900, 'height' => 1900], BX_RESIZE_IMAGE_PROPORTIONAL, true);
		$arResult['ZLOJ']['PICS'][$key] = [
            \Zloj\Portal\Template::censoreImage($file1['src'], $arResult['PROPERTIES'][\Zloj\Portal\Functions::PROPERTY_ADULT]['VALUE'], $arParams['SHOW_ADULT']),
            \Zloj\Portal\Template::censoreImage($file2['src'], $arResult['PROPERTIES'][\Zloj\Portal\Functions::PROPERTY_ADULT]['VALUE'], $arParams['SHOW_ADULT']),
            \Zloj\Portal\Template::censoreImage($file3['src'], $arResult['PROPERTIES'][\Zloj\Portal\Functions::PROPERTY_ADULT]['VALUE'], $arParams['SHOW_ADULT']),
		];
	}
}else{
	$arResult['ZLOJ']['PICS'][] = [
		'/images/nophoto.svg',
		'/images/nophoto.svg',
		'',
	];
}
if(!empty($arResult['DISPLAY_PROPERTIES'])){
	$i = 1;
	foreach ($arResult['DISPLAY_PROPERTIES'] as $arProp){
		if(strpos($arProp['DISPLAY_VALUE'], '}}') !== false){
			continue;
		}
		$i = ($i) ? 0 : 1;
		$code = $arProp['CODE'] ? : $arProp['ID'];
		$arResult['ZLOJ']['PROPS'][$i][$code] = [
			'NAME' => $arProp['NAME'],
			'VALUE' => $arProp['DISPLAY_VALUE'],
		];
	}
}

if ($APPLICATION->GetCurDir() != $arResult['DETAIL_PAGE_URL']) {
    header("LOCATION: {$arResult['DETAIL_PAGE_URL']}");
}

// Создаем изображение для превью соц.сетей
$image_social = CFile::ResizeImageGet($arResult["PREVIEW_PICTURE"], array('width'=>'1200', 'height'=>'630'), BX_RESIZE_IMAGE_EXACT, true);
$arResult["PREVIEW_PICTURE"]["SOCIAL"] = $image_social["src"];

$cp = $this->__component; // объект компонента

// Передаем данные в результат после кеширования
if (is_object($cp)) {
    $cp->SetResultCacheKeys(array('TIMESTAMP_X'));
    $cp->SetResultCacheKeys(array("PREVIEW_PICTURE"));
}

