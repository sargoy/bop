<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?if (!empty($arResult)):?>
    <div role="group" class="header-tags btn-group-pills btn-group">
        <?
        foreach($arResult as $arItem):
            if($arParams["MAX_LEVEL"] == 1 && $arItem["DEPTH_LEVEL"] > 1) {
	            continue;
            }
            ?>
            <div class="item">
                <a href="<?=$arItem["LINK"]?>" target="_self" class="btn rounded-pill btn-outline-gray-700">
                    <?=$arItem["TEXT"]?>
                </a>
            </div>
        <?endforeach?>
    </div>
<?endif?>
