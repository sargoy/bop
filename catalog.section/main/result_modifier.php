<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

if(!empty($arParams['CUSTOM_SORT']) and is_array($arParams['CUSTOM_SORT'])){
    $arItems = [];
    foreach ($arResult['ITEMS'] as $arItem) {
        $arItems[$arItem['ID']] = $arItem;
    }
    $arResult['ITEMS'] = [];
    foreach ($arParams['CUSTOM_SORT'] as $id){
        if(isset($arItems[$id])){
            $arResult['ITEMS'][] = $arItems[$id];
        }
    }
}

//pr($arResult['ITEMS']);

?>