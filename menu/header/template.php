<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<a class="nav-link dropdown-toggle menu-toggle dropdown-toggle-no-caret" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
    <svg width="25" height="5" xmlns="http://www.w3.org/2000/svg" class="icon sprite-icons">
        <use href="<?=SITE_TEMPLATE_PATH?>/_nuxt/08898a81d88ca4fa3db9dc44bfc54562.svg#i-menu-toggle" xlink:href="<?=SITE_TEMPLATE_PATH?>/_nuxt/08898a81d88ca4fa3db9dc44bfc54562.svg#i-menu-toggle">
        </use>
    </svg>
</a>
<ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
    <li role="presentation" class="mr-md-auto">
        <p class="b-dropdown-text">
            <a href="#" class="location-link mr-3">
                <svg width="10" height="16" xmlns="http://www.w3.org/2000/svg" class="icon sprite-icons">
                    <use href="<?=SITE_TEMPLATE_PATH?>/_nuxt/08898a81d88ca4fa3db9dc44bfc54562.svg#i-location" xlink:href="<?=SITE_TEMPLATE_PATH?>/_nuxt/08898a81d88ca4fa3db9dc44bfc54562.svg#i-location">
                    </use>
                </svg>
                <span class="caption">Москва</span>
            </a>
            <a href="<?=$GLOBALS['zloj_config']['links']['appstore'];?>" class="app-link">
                <svg width="12" height="12" xmlns="http://www.w3.org/2000/svg" class="icon sprite-icons">
                    <use href="<?=SITE_TEMPLATE_PATH?>/_nuxt/08898a81d88ca4fa3db9dc44bfc54562.svg#i-app-apple" xlink:href="<?=SITE_TEMPLATE_PATH?>/_nuxt/08898a81d88ca4fa3db9dc44bfc54562.svg#i-app-apple">
                    </use>
                </svg>
            </a>
            <a href="<?=$GLOBALS['zloj_config']['links']['gplay'];?>" class="app-link">
                <svg width="12" height="12" xmlns="http://www.w3.org/2000/svg" class="icon sprite-icons">
                    <use href="<?=SITE_TEMPLATE_PATH?>/_nuxt/08898a81d88ca4fa3db9dc44bfc54562.svg#i-app-google" xlink:href="<?=SITE_TEMPLATE_PATH?>/_nuxt/08898a81d88ca4fa3db9dc44bfc54562.svg#i-app-google">
                    </use>
                </svg>
            </a>
        </p>
    </li>
    <li role="presentation" class="d-md-none">
        <p class="b-dropdown-text">
	        <?$url = $GLOBALS['zloj_config']['user'] ? '/my/' : '/my/login/';?>
            <a href="<?=$url?>" target="_self" class="btn btn-secondary btn-sm">
                <svg width="22" height="20" xmlns="http://www.w3.org/2000/svg" class="icon sprite-icons">
                    <use href="<?=SITE_TEMPLATE_PATH?>/_nuxt/08898a81d88ca4fa3db9dc44bfc54562.svg#i-account" xlink:href="<?=SITE_TEMPLATE_PATH?>/_nuxt/08898a81d88ca4fa3db9dc44bfc54562.svg#i-account">
                    </use>
                </svg>
                <span class="caption">Личный кабинет</span>
            </a>
        </p>
    </li>
	<?if (!empty($arResult)):?>
		<?php foreach ($arResult as $arItem): ?>
			<?php if($arParams["MAX_LEVEL"] == 1 && $arItem["DEPTH_LEVEL"] > 1) continue; ?>
			<?php if($arItem["TEXT"] == 'FAQ'): ?>
                <li role="presentation" class="item-help">
                    <a href="<?=$arItem["LINK"]?>" role="menuitem" target="_self" class="dropdown-item">
                        Помощь
                    </a>
                </li>
			<?php else: ?>
                <li role="presentation">
                    <a href="<?=$arItem["LINK"]?>" role="menuitem" target="_self" class="dropdown-item">
						<?=$arItem["TEXT"]?>
                    </a>
                </li>
			<?php endif; ?>
		<?php endforeach; ?>
	<?php endif; ?>
</ul>

