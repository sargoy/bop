<?php
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

/**
 * @global CMain $APPLICATION
 */

global $APPLICATION;

$itemSize = count($arResult);

if(empty($arResult) or $itemSize == 1) {
	return '';
}
$strReturn = '<ol class="breadcrumb d-none d-md-flex container"  itemscope itemtype="https://schema.org/BreadcrumbList">';

if(!empty($GLOBALS['breadcrumbBack'])){
	$strReturn .= '<li class="back-btn-product" itemprop="itemListElement" itemscope
      itemtype="https://schema.org/ListItem"><a itemprop="item" href="'.$GLOBALS['breadcrumbBack'].'">Назад</a></li>';
}

for($index = 0; $index < $itemSize; $index++)
{
	$title = htmlspecialcharsex($arResult[$index]["TITLE"]);

	if(!$arResult[$index]["LINK"] and $index == $itemSize-2 and $GLOBALS['zloj_session']['prev_item']) {
		$arResult[$index]["LINK"] = $GLOBALS['zloj_session']['prev_item'];
	}

	if($arResult[$index]["LINK"] and $index != $itemSize-1)
	{
		$strReturn .= '<li itemprop="itemListElement" itemscope
      itemtype="https://schema.org/ListItem" class="breadcrumb-item"><a itemprop="item" href="'.$arResult[$index]["LINK"].'" target="_self"><span itemprop="name" aria-current="location">'.$title.'</span></a><meta itemprop="position" content="' . $index .'"></li>';
	}
	else
	{
		$strReturn .= '<li itemprop="itemListElement" itemscope
      itemtype="https://schema.org/ListItem" class="breadcrumb-item active"><span itemprop="name" aria-current="location">'.$title.'</span><meta itemprop="position" content="' . $index .'"></li>';
	}
}

$strReturn .= '</ol>';

return $strReturn;
