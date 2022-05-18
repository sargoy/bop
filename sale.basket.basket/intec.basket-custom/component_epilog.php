<?php if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die() ?>
<?php

use intec\Core;
use Bitrix\Main\Loader;
use Bitrix\Main\Page\Asset;

/**
 * @var array $arParams
 * @var array $arResult
 */

if (!Loader::includeModule('intec.core'))
    return;

if (!empty($arParams['SCHEME'])) {
    $assets = Asset::getInstance();
    $assets->addString('<style type="text/css">'.Core::$app->web->getScss()->compile('
        $color: #0065ff !default;
    
        .bx_ordercart .bx_sort_container a.current {
            border-bottom: 2px solid darken($color, 10);
        }
    
        .bx_ordercart .intec-ordercart-button.intec-ordercart-button-colored {
            background-color: $color;
            border-color: $color;
            color: #fff;
        }
        
        .bx_ordercart .intec-ordercart-button.intec-ordercart-button-colored:hover {
            border-color: lighten($color, 10);
            background-color: lighten($color, 10);
        }
        
        .bx_ordercart .intec-ordercart-button.intec-ordercart-button-colored.intec-ordercart-button-transparent:hover {
            background: lighten($color, 10);
        }
    ', ['color' => $arParams['SCHEME']]).'</style>');
}

?>
<?if (!empty($_GET['delay']) && $_GET['delay']=='y'):?>
	<script>showBasketItemsList(2);</script>
<?endif;?>