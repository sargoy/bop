<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Highloadblock as HL;

CModule::IncludeModule('highloadblock');

$arResult['REVIEWS'] = [
	'ITEMS' => [],
	'CNT' => [
		'ALL' => 0,
		1 => 0,
		2 => 0,
		3 => 0,
		4 => 0,
		5 => 0,
	],
];
$arResult['USERS'] = [];

$hlblock = HL\HighloadBlockTable::getById(6)->fetch();
$entity = HL\HighloadBlockTable::compileEntity($hlblock);
$entity_data_class = $entity->getDataClass();

$rsData = $entity_data_class::getList([
	"select" => [
		'*'
	],
	"filter" => [
		'UF_ELEMENT' => $arResult['ID']
	],
	"order" => [
		'ID' => 'DESC',
	]
]);

$arUsersIds = $arReviewsIds = [];
while ($arData = $rsData->Fetch()) {
	$arData['COMMENTS'] = [];
	$arResult['REVIEWS']['ITEMS'][$arData['ID']] = $arData;
	$arUsersIds[$arData['UF_USER']] = $arData['UF_USER'];
	$arReviewsIds[$arData['ID']] = $arData['ID'];
	$arResult['REVIEWS']['CNT']['ALL'] ++;
	$arResult['REVIEWS']['CNT'][$arData['UF_RATING']] ++;
}

if($arReviewsIds) {
	$hlblock = HL\HighloadBlockTable::getById(9)->fetch();
	$entity = HL\HighloadBlockTable::compileEntity($hlblock);
	$entity_data_class = $entity->getDataClass();

	$rsData = $entity_data_class::getList([
		"select" => [
			'*'
		],
		"filter" => [
			'UF_REVIEW' => $arReviewsIds
		],
		"order" => [
			'ID' => 'ASC',
		]
	]);

	while ($arData = $rsData->Fetch()) {
		$arResult['REVIEWS']['ITEMS'][$arData['UF_REVIEW']]['COMMENTS'][] = $arData;
		$arUsersIds[$arData['UF_USER']] = $arData['UF_USER'];
	}
}
if($arUsersIds){
	$arFilter = [
		'ID' => implode('|', $arUsersIds)
	];
	$obUsers = CUser::GetList(($by = "personal_country"), ($order = "desc"), $arFilter);

	while ($arUser = $obUsers->GetNext()){
		$arResult['USERS'][$arUser['ID']] = $arUser;
	}
}
