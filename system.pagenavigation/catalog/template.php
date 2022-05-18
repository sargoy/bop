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

if(!$arResult["NavShowAlways"])
{
	if ($arResult["NavRecordCount"] == 0 || ($arResult["NavPageCount"] == 1 && $arResult["NavShowAll"] == false))
		return;
}

$strNavQueryString = ($arResult["NavQueryString"] != "" ? $arResult["NavQueryString"]."&amp;" : "");
$strNavQueryStringFull = ($arResult["NavQueryString"] != "" ? "?".$arResult["NavQueryString"] : "");

$arResult["nStartPage"] = 1;
$arResult["nEndPage"] = $arResult["NavPageCount"];

$sPrevHref = '';
if ($arResult["NavPageNomer"] > 1){
	$bPrevDisabled = false;

	if ($arResult["bSavePage"] || $arResult["NavPageNomer"] > 2){
		$sPrevHref = $arResult["sUrlPath"].'?'.$strNavQueryString.'PAGEN_'.$arResult["NavNum"].'='.($arResult["NavPageNomer"]-1);
	}else{
		$sPrevHref = $arResult["sUrlPath"].$strNavQueryStringFull;
	}
}else{
	$bPrevDisabled = true;
}

$sNextHref = $iNext = '';
if ($arResult["NavPageNomer"] < $arResult["NavPageCount"]){
	$bNextDisabled = false;
	$sNextHref = $arResult["sUrlPath"].'?'.$strNavQueryString.'PAGEN_'.$arResult["NavNum"].'='.($arResult["NavPageNomer"]+1);
	$iNext = ($arResult["NavPageNomer"]+1);
}else{
	$bNextDisabled = true;
}

$strReturn = '<div class="row mb-4 align-items-center">';

$strReturn .= '<div class="col-lg-4 offset-lg-4">';
if(!$bNextDisabled) {
	$strReturn .=
		'<div class="text-center">' .
		'<button type="button" class="btn btn-show-more btn-link" data-href="'.$sNextHref.'" id="ajax-load-catalog-button">' .
		'Показать ещё' .
		'<svg width="20" height="20" xmlns="http://www.w3.org/2000/svg" class="ml-2 icon sprite-icons">' .
		'<use href="/local/templates/new/_nuxt/e9f276f8f2f8d76658b3ea83098ca231.svg#i-refresh" xlink:href="/local/templates/new/_nuxt/e9f276f8f2f8d76658b3ea83098ca231.svg#i-refresh"></use>' .
		'</svg>' .
		'</button>' .
		'</div>';
}
$strReturn .= '</div>';

$strReturn .=
	'<div class="d-none d-lg-block col-lg-12 mt-4" id="ajax-load-catalog-pager">#LINK_TO_NEXT_CAT#'.
	'<nav aria-hidden="false" aria-label="Pagination">'.
	'<ul aria-disabled="false" class="pagination b-pagination justify-content-end">';
$strReturn .=
	'<li'.($bPrevDisabled ? ' aria-hidden="true"' : '').' class="page-item'.($bPrevDisabled ? ' disabled' : '').' page-item-prev">'.
	'<'.($bPrevDisabled ? 'span' : 'a').' aria-label="Go to previous page"'.(!$bPrevDisabled ? ' href="'.$sPrevHref.'" target="_self"' : '').($bPrevDisabled ? ' aria-disabled="true"' : '').' class="page-link">'.
	'<svg width="14" height="14" xmlns="http://www.w3.org/2000/svg" class="icon sprite-icons">'.
	'<use href="/local/templates/new/_nuxt/e9f276f8f2f8d76658b3ea83098ca231.svg#i-page-prev" xlink:href="/local/templates/new/_nuxt/e9f276f8f2f8d76658b3ea83098ca231.svg#i-page-prev"></use>'.
	'</svg>'.
	'</'.($bPrevDisabled ? ' aria-hidden="true"' : '').'>'.
	'</li>';

$bFirst = true;
$bPoints = false;
do
{
	if ($arResult["nStartPage"] <= 2 || $arResult["nEndPage"]-$arResult["nStartPage"] <= 1 || abs($arResult['nStartPage']-$arResult["NavPageNomer"])<=2)
	{
        $get = $strNavQueryStringFull;
        if ($arResult["nStartPage"] != 1) {
            $get = '?'.$strNavQueryString.'PAGEN_'.$arResult["NavNum"].'='.$arResult["nStartPage"];
        }
		if ($arResult["nStartPage"] == $arResult["NavPageNomer"]){
			$strReturn .=
				'<li class="page-item active">'.
				'<span style="margin: 0 2px 0 2px" aria-label="Go to page '.$arResult["nStartPage"].'" aria-current="page" aria-posinset="'.$arResult["nStartPage"].'" aria-setsize="10" class="page-link">'.$arResult["nStartPage"].'</span>'.
				'</li>';
		}else{
			$strReturn .=
				'<li class="page-item">'.
				'<a  style="margin: 0 2px 0 2px" aria-label="Go to page '.$arResult["nStartPage"].'" aria-current="page" aria-posinset="1" aria-setsize="10" href="'.$arResult["sUrlPath"].$get.'" target="_self" class="page-link">'.$arResult["nStartPage"].'</a>'.
				'</li>';
		}
		$bFirst = false;
		$bPoints = true;
	}
	else
	{
		if ($bPoints)
		{
			$strReturn .=
				'<li role="separator" class="page-item disabled bv-d-xs-down-none">'.
				'<span class="page-link">…</span>'.
				'</li>';
			$bPoints = false;
		}
	}
	$arResult["nStartPage"]++;
}
while($arResult["nStartPage"] <= $arResult["nEndPage"]);

$strReturn .=
	'<li'.($bNextDisabled ? ' aria-hidden="true"' : '').' class="page-item'.($bNextDisabled ? ' disabled' : '').' page-item-next">'.
	'<'.($bNextDisabled ? 'span' : 'a').' aria-label="Go to next page"'.(!$bNextDisabled ? ' href="'.$sNextHref.'" target="_self"' : '').($bNextDisabled ? ' aria-disabled="true"' : '').' class="page-link">'.
	'<svg width="14" height="14" xmlns="http://www.w3.org/2000/svg" class="icon sprite-icons">'.
	'<use href="/local/templates/new/_nuxt/e9f276f8f2f8d76658b3ea83098ca231.svg#i-page-next" xlink:href="/local/templates/new/_nuxt/e9f276f8f2f8d76658b3ea83098ca231.svg#i-page-next"></use>'.
	'</svg>'.
	'</'.($bNextDisabled ? 'span' : 'a').'>'.
	'</li>';
$strReturn .=
	'</ul>'.
	'</nav>'.
	'</div>';

$strReturn .= '</div>';

echo $strReturn;
?>