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
\Zloj\Portal\Template::initPageAdult();
//pr($arResult);
?>
<?$this->SetViewTarget('section_title');?>
    <?if($arResult['DEPTH_LEVEL'] == 1):?>
        #<?=ToLower($arResult['NAME']);?>
    <?else:?>
	    <?=$arResult['NAME'];?>
    <?endif;?>
<?$this->EndViewTarget();?>
<?$this->SetViewTarget('section_count');?>
    <?if(!empty($arResult['NAV_RESULT']->NavRecordCount)):?>
        <?
        $ext2 = new Declension('Найдена', 'Найдены', 'Найдено');
        echo $ext2->get($arResult['NAV_RESULT']->NavRecordCount);
        ?>
    <?=$arResult['NAV_RESULT']->NavRecordCount?>
        <?
        $ext = new Declension('позиция', 'позиции', 'позиций');
	    echo $ext->get($arResult['NAV_RESULT']->NavRecordCount);
        ?>
    <?endif;?>
<?$this->EndViewTarget();?>
<div>
    <div class="row catalog-items catalog-items-<?=ZLOJ_VIEW_MODE?>" id="ajax-load-catalog-wrap">
        <?
        if($arParams['ACTIONS_STYLE'] == 'Y' or ($arParams['FAV_STYLE'] == 'Y' and $arParams['FAV_USER'] != 'Y')) {
	        $cssClass = (ZLOJ_VIEW_MODE == 'grid' ? 'col-lg-4 col-xl-3 col-12 mb-3 mb-lg-30' : 'col-lg-12 col-xl-12 col-12 mb-2');
        }else{
	        $cssClass = (ZLOJ_VIEW_MODE == 'grid' ? 'col-lg-6 col-xl-4 col-6 mb-3 mb-lg-30' : 'col-lg-12 col-xl-12 col-12 mb-2');
        }
        ?>
        <?foreach($arResult["ITEMS"] as $arItem):?>
            <div class="<?=$cssClass;?>" id="catalog-item-<?=$arItem['ID']?>">
                <?$APPLICATION->IncludeComponent(
                    'bitrix:catalog.item',
                    '',
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