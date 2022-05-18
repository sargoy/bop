<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();
use Bitrix\Main\Grid\Declension;

$elementEdit = CIBlock::GetArrayByID($arParams['IBLOCK_ID'], 'ELEMENT_EDIT');
$elementDelete = CIBlock::GetArrayByID($arParams['IBLOCK_ID'], 'ELEMENT_DELETE');
$elementDeleteParams = array('CONFIRM' => GetMessage('CT_BCS_TPL_ELEMENT_DELETE_CONFIRM'));

$areaIds = [];
foreach ($arResult['ITEMS'] as $item)
{

	$uniqueId = $item['ID'].'_'.md5($this->randString().$component->getAction());
	$areaIds[$item['ID']] = $this->GetEditAreaId($uniqueId);
	$this->AddEditAction($uniqueId, $item['EDIT_LINK'], $elementEdit);
	$this->AddDeleteAction($uniqueId, $item['DELETE_LINK'], $elementDelete, $elementDeleteParams);
}
//debug($GLOBALS['arrFilter1']);

\Zloj\Portal\Template::initPageAdult();

?>
<?//$this->SetViewTarget('section_title');?>
<?//if($arResult['DEPTH_LEVEL'] == 1):?>
<!--    #--><?//=ToLower($arResult['NAME']);?>
<?//else:?>
<!--	--><?//=$arResult['NAME'];?>
<?//endif;?>
<?//$this->EndViewTarget();?>
<?//$this->SetViewTarget('section_count');?>
<?//if(!empty($arResult['NAV_RESULT']->NavRecordCount)):?>
<!--	--><?//
//	$ext2 = new Declension('Найдена', 'Найдены', 'Найдено');
//	echo $ext2->get($arResult['NAV_RESULT']->NavRecordCount);
//	?>
<!--	--><?//=$arResult['NAV_RESULT']->NavRecordCount?>
<!--	--><?//
//	$ext = new Declension('позиция', 'позиции', 'позиций');
//	echo $ext->get($arResult['NAV_RESULT']->NavRecordCount);
//	?>
<?//endif;?>
<?//$this->EndViewTarget();?>

<div class="row">
    <div class="col-lg-4 col-xl-3">
        <button type="button" class="btn catalog-sidebar-toggle btn-link btn-sm btn-block mb-2 d-block d-md-none">
            Фильтр
        </button>

        <div class="catalog-sidebar catalog-sale-sidebar catalog-sidebar-collapsible">
<?$APPLICATION->IncludeComponent(
	"bitrix:catalog.section.list",
	"sidebar_sale",
	array(
		"IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
		"IBLOCK_ID" => $arParams["IBLOCK_ID"],
//		"SECTION_ID" => $GLOBALS['zloj_session']['CURRENT_SECTION']['DEPTH_LEVEL'] == 2 ? '0' : $GLOBALS['zloj_session']['IN_SECTION']['ID'],
//		"SECTION_CODE" => $GLOBALS['zloj_session']['CURRENT_SECTION']['DEPTH_LEVEL'] == 2 ? '' : $GLOBALS['zloj_session']['IN_SECTION']['CODE'],
		"CACHE_TYPE" => $arParams["CACHE_TYPE"],
		"CACHE_TIME" => $arParams["CACHE_TIME"],
		"CACHE_GROUPS" => $arParams["CACHE_GROUPS"],
		"COUNT_ELEMENTS" => "N",
//		"TOP_DEPTH" => $GLOBALS['zloj_session']['CURRENT_SECTION']['DEPTH_LEVEL'] == 2 ? '1' : '2',
		"ADD_SECTIONS_CHAIN" => "N",
//		"SECTION_URL" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["section"],
//		"IN_STEP" => $GLOBALS['zloj_session']['SUBSECTIONS'] ? 2 : 1,
//		"CURRENT_SECTION" => $GLOBALS['zloj_session']['CURRENT_SECTION']['ID'],
        "FILTER_NAME" => isset($_GET['q']) ? 'searchChain' : "navChain",
	),
	$component
);?>
</div>
    </div>
<div class="overflow-hidden col-lg-8 col-xl-9">
    <div class="row catalog-items catalog-items-<?=ZLOJ_VIEW_MODE?>" id="ajax-load-catalog-wrap">
        <?
        if($arParams['ACTIONS_STYLE'] == 'Y' or ($arParams['FAV_STYLE'] == 'Y' and $arParams['FAV_USER'] != 'Y')) {
	        $cssClass = (ZLOJ_VIEW_MODE == 'grid' ? 'col-lg-4 col-12 mb-3 mb-lg-30' : 'col-lg-12 col-xl-12 col-12 mb-2');
        }else{
	        $cssClass = (ZLOJ_VIEW_MODE == 'grid' ? 'col-lg-4 col-12 mb-3 mb-lg-30' : 'col-lg-12 col-xl-12 col-12 mb-2');
        }
        ?>
        <?foreach($arResult["ITEMS"] as $arItem):?>
            <div class="<?=$cssClass;?>" id="catalog-item-<?=$arItem['ID']?>">
                <?$APPLICATION->IncludeComponent(
                    'bitrix:catalog.item',
                    'sale',
                    array(
                        'SHOW_ADULT' => $arParams['SHOW_ADULT'],
                        'RESULT' => array(
                            'ITEM' => $arItem,
                            'AREA_ID' => $areaIds[$arItem['ID']],
                            'BIG_LABEL' => 'N',
                            'BIG_DISCOUNT_PERCENT' => 'N',
                            'BIG_BUTTONS' => 'N',
                            'SCALABLE' => 'N'
                        ),
                        'PARAMS' => $arParams
                            + array('SKU_PROPS' => $arResult['SKU_PROPS'][$arItem['IBLOCK_ID']])
                    ),
                    $component,
                    array('HIDE_ICONS' => 'Y')
                );?>
            </div>
        <?endforeach;?>
    </div>
    <?if($arParams["DISPLAY_BOTTOM_PAGER"]):?>
        <?=$arResult["NAV_STRING"]?>
    <?endif?>
</div>
<?
$templateData['CURRENT_ADULT'] = \Zloj\Portal\Template::getPageAdult();
?>