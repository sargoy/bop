<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */
$this->setFrameMode(true);

$sNextHref = $iNext = '';
if ($arResult["NavPageNomer"] < $arResult["NavPageCount"]){
	$bNextDisabled = false;
	$sNextHref = $arResult["sUrlPath"].'?'.$strNavQueryString.'PAGEN_'.$arResult["NavNum"].'='.($arResult["NavPageNomer"]+1);
	$iNext = ($arResult["NavPageNomer"]+1);
}else{
	$bNextDisabled = true;
}

if(!$bNextDisabled):
?>
	<div class="my-4 text-center">
		<button type="button" class="btn btn-show-more btn-link" data-href="<?=$sNextHref?>" id="ajax-load-orders-button">
			Показать ещё
			<svg width="20" height="20" xmlns="http://www.w3.org/2000/svg" class="ml-2 icon sprite-icons">
				<use href="/local/templates/new/_nuxt/e9f276f8f2f8d76658b3ea83098ca231.svg#i-refresh" xlink:href="/local/templates/new/_nuxt/e9f276f8f2f8d76658b3ea83098ca231.svg#i-refresh"></use>
			</svg>
		</button>
	</div>
<?
endif;
?>