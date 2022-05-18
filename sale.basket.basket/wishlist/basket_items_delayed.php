<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die(); ?>
<div class="blocks_delay_items">
    <?
    foreach ($arResult["GRID"]["ROWS"] as $k => $arItem):
        if ($arItem["DELAY"] == "Y" && $arItem["CAN_BUY"] == "Y"):
            ?>
            <?
            foreach ($arResult["GRID"]["HEADERS"] as $id => $arHeader):
                if (in_array($arHeader["id"])) // some values are not shown in columns in this template
                    continue;
                if ($arHeader["id"] == "NAME"):
                    ?>
                    <div class="blocks_item" id="<?= $arItem["ID"] ?>">
                        <div class="over_item">
                            <a class="toitem" href="<?= $arItem["DETAIL_PAGE_URL"] ?>">
                                <? if (strlen($arItem["DETAIL_PICTURE_SRC"]) !== 0) { ?>
                                    <div class="image_item" style="background: url(<?echo $arItem["DETAIL_PICTURE_SRC"]; ?>) no-repeat center; background-size: contain"></div>
                                <? } else { ?>
                                    <div class="image_item" style="background: url(/local/images/nof.jpg) no-repeat center; background-size: contain"></div>
                                <? } ?>
                                <h5><?= $arItem["NAME"] ?></h5>
                            </a>
                            <div class="stars">
                                <? $APPLICATION->IncludeComponent("bitrix:iblock.vote", "starstemp", Array(
                                    "IBLOCK_TYPE" => "yml_import",    // Тип инфоблока
                                    "IBLOCK_ID" => "30",    // Инфоблок
                                    "ELEMENT_ID" => $arItem["ID"],    // ID элемента
                                    "MAX_VOTE" => "5",    // Максимальный балл
                                    "VOTE_NAMES" => array(    // Подписи к баллам
                                        0 => "0",
                                        1 => "1",
                                        2 => "2",
                                        3 => "3",
                                        4 => "4",
                                        5 => "",
                                    ),
                                    "SET_STATUS_404" => "N",    // Устанавливать статус 404
                                    "MESSAGE_404" => "",    // Сообщение для показа (по умолчанию из компонента)
                                    "CACHE_TYPE" => "N",    // Тип кеширования
                                    "CACHE_TIME" => "0",    // Время кеширования (сек.)
                                    "COMPONENT_TEMPLATE" => "stars",
                                    "DISPLAY_AS_RATING" => "vote_avg",    // В качестве рейтинга показывать
                                ),
                                    false
                                ); ?>
                            </div>
                            <div class="price">
                                <?
                                if ($arItem["PRICE_FORMATED"] !== $arItem["FULL_PRICE_FORMATED"]) {
                                    ?>
                                    <strong>
                                        <s><?= $arItem["PRICE_FORMATED"] ?></s>
                                        <?= $arItem["FULL_PRICE_FORMATED"] ?>
                                    </strong>
                                    <?
                                } else {
                                    ?>
                                    <strong><?= $arItem["FULL_PRICE_FORMATED"] ?></strong>
                                    <?
                                } ?>
                                <div class="clb"></div>
                                <a class="tobasket fa" href="<?= str_replace("#ID#", $arItem["ID"], $arUrls["add"]) ?>"> Купить</a>
                                <a class="delitem" href="<?= str_replace("#ID#", $arItem["ID"], $arUrls["delete"]) ?>">Убрать из избранного</a>
                            </div>
                        </div>
                    </div>
                <?
                endif;
            endforeach;
            ?>
        <?
        endif;
    endforeach;
    ?>
    <div class="clb"></div>
</div>
<div class="clb"></div>