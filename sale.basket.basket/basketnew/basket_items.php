<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
use Bitrix\Sale\DiscountCouponsManager;
if (!empty($arResult["ERROR_MESSAGE"]))
    ShowError($arResult["ERROR_MESSAGE"]);
$bDelayColumn = false;
$bDeleteColumn = false;
$bWeightColumn = false;
$bPropsColumn = false;
$bPriceType = false;

if ($normalCount > 0):
    ?>
    <div id="basket_items_list">
        <div class="bx_ordercart_order_table_container">
            <table id="basket_items">


                <thead style="display: none;">
                <tr>
                    <td>
                        <?
                        foreach ($arResult["GRID"]["HEADERS"] as $id => $arHeader):
                            $arHeaders[] = $arHeader["id"];
                            if (in_array($arHeader["id"], array("TYPE"))) {
                                $bPriceType = true;
                                continue;
                            } elseif ($arHeader["id"] == "PROPS") {
                                $bPropsColumn = true;
                                continue;
                            } elseif ($arHeader["id"] == "DELAY") {
                                $bDelayColumn = true;
                                continue;
                            } elseif ($arHeader["id"] == "DELETE") {
                                $bDeleteColumn = true;
                                continue;
                            } elseif ($arHeader["id"] == "WEIGHT") {
                                $bWeightColumn = true;
                            }

                        endforeach;
                        ?>
                    </td>
                </tr>
                </thead>


                <tbody>
                <?
                $skipHeaders = array('PROPS', 'DELAY', 'DELETE', 'TYPE');
                foreach ($arResult["GRID"]["ROWS"] as $k => $arItem):
                    $is = 1;
                    if ($arItem["DELAY"] == "N" && $arItem["CAN_BUY"] == "Y"):
                        ?>
                        <tr id="<?= $arItem["ID"] ?>"
                            data-item-name="<?= $arItem["NAME"] ?>"
                            data-item-brand="<?= $arItem[$arParams['BRAND_PROPERTY'] . "_VALUE"] ?>"
                            data-item-price="<?= $arItem["PRICE"] ?>"
                            data-item-currency="<?= $arItem["CURRENCY"] ?>"
                        >
                            <?
                            foreach ($arResult["GRID"]["HEADERS"] as $id => $arHeader):
                                if (in_array($arHeader["id"], $skipHeaders))
                                    continue;
                                if ($arHeader["name"] == '')
                                    $arHeader["name"] = GetMessage("SALE_" . $arHeader["id"]);
                                if ($arHeader["id"] == "NAME"):
                                    ?>

                                    <td class="photo">
                                        <? if (strlen($arItem["DETAIL_PICTURE_SRC"]) !== 0) { ?>
                                            <div class="image_item"
                                                 style="background: url(<? echo $arItem["DETAIL_PICTURE_SRC"]; ?>) no-repeat center; background-size: contain"></div>
                                        <? } else { ?>
                                            <div class="image_item"
                                                 style="background: url(/local/images/nof.jpg) no-repeat center; background-size: contain"></div>
                                        <? } ?>
                                    </td>


                                    <td class="title">
                                        <a href="<?= $arItem["DETAIL_PAGE_URL"] ?>">
                                            <h5><?= $arItem["NAME"] ?></h5>
                                        </a>
                                    </td>


                                    <td class="price">
                                        <div class="current_price" id="current_price_<?= $arItem["ID"] ?>">
                                            <?= $arItem["PRICE_FORMATED"] ?>
                                        </div>
                                    </td>



                                    <td class="custom quant">
                                        <?
                                        $ratio = isset($arItem["MEASURE_RATIO"]) ? $arItem["MEASURE_RATIO"] : 0;
                                        $useFloatQuantity = ($arParams["QUANTITY_FLOAT"] == "Y") ? true : false;
                                        $useFloatQuantityJS = ($useFloatQuantity ? "true" : "false");
                                        ?>
                                        <?
                                        if (!isset($arItem["MEASURE_RATIO"])) {
                                            $arItem["MEASURE_RATIO"] = 1;
                                        }
                                        if (
                                            floatval($arItem["MEASURE_RATIO"]) != 0
                                        ):
                                            ?>
                                            <div class="basket_quantity_control">
                                                <a href="javascript:void(0);" class="minus"
                                                   onclick="setQuantity(<?= $arItem["ID"] ?>, <?= $arItem["MEASURE_RATIO"] ?>, 'down', <?= $useFloatQuantityJS ?>);">-</a>
                                            </div>
                                        <?
                                        endif;
                                        ?>
                                        <input type="text"
                                               size="3"
                                               id="QUANTITY_INPUT_<?= $arItem["ID"] ?>"
                                               name="QUANTITY_INPUT_<?= $arItem["ID"] ?>"
                                               maxlength="18"
                                               value="<?= $arItem["QUANTITY"] ?>"
                                               onchange="updateQuantity('QUANTITY_INPUT_<?= $arItem["ID"] ?>', '<?= $arItem["ID"] ?>', <?= $ratio ?>, <?= $useFloatQuantityJS ?>)"
                                        >

                                        <?
                                        if (!isset($arItem["MEASURE_RATIO"])) {
                                            $arItem["MEASURE_RATIO"] = 1;
                                        }
                                        if (
                                            floatval($arItem["MEASURE_RATIO"]) != 0
                                        ):
                                            ?>
                                            <div class="basket_quantity_control">
                                                <a href="javascript:void(0);" class="plus"
                                                   onclick="setQuantity(<?= $arItem["ID"] ?>, <?= $arItem["MEASURE_RATIO"] ?>, 'up', <?= $useFloatQuantityJS ?>);">+</a>
                                            </div>
                                        <?
                                        endif;
                                        ?>
                                        <input type="hidden" id="QUANTITY_<?= $arItem['ID'] ?>"
                                               name="QUANTITY_<?= $arItem['ID'] ?>" value="<?= $arItem["QUANTITY"] ?>"/>
                                    </td>





                                <?
                                else:
                                    ?>
                                    <td class="custom summ summ_<?echo $is++?>">
                                        <?
                                        if ($arHeader["id"] == "SUM"):
                                        ?>
                                        <div id="sum_<?= $arItem["ID"] ?>">
                                            <?
                                            endif;
                                            echo $arItem[$arHeader["id"]];
                                            if ($arHeader["id"] == "SUM"):
                                            ?>
                                        </div>
                                    <?
                                    endif;
                                    ?>
                                    </td>
                                <?
                                endif;
                            endforeach;
                            ?>


                            <td class="control">
                                <a href="<?= str_replace("#ID#", $arItem["ID"], $arUrls["delete"]) ?>"
                                   onclick="return deleteProductRow(this)"><?= GetMessage("SALE_DELETE") ?></a>
                                </td>


                        </tr>
                    <?
                    endif;
                endforeach;
                ?>
                </tbody>
            </table>
        </div>
    </div>


    <input type="hidden" id="column_headers" value="<?= htmlspecialcharsbx(implode($arHeaders, ",")) ?>"/>
    <input type="hidden" id="offers_props" value="<?= htmlspecialcharsbx(implode($arParams["OFFERS_PROPS"], ",")) ?>"/>
    <input type="hidden" id="action_var" value="<?= htmlspecialcharsbx($arParams["ACTION_VARIABLE"]) ?>"/>
    <input type="hidden" id="quantity_float" value="<?= ($arParams["QUANTITY_FLOAT"] == "Y") ? "Y" : "N" ?>"/>
    <input type="hidden" id="price_vat_show_value" value="<?= ($arParams["PRICE_VAT_SHOW_VALUE"] == "Y") ? "Y" : "N" ?>"/>
    <input type="hidden" id="hide_coupon" value="<?= ($arParams["HIDE_COUPON"] == "Y") ? "Y" : "N" ?>"/>
    <input type="hidden" id="use_prepayment" value="<?= ($arParams["USE_PREPAYMENT"] == "Y") ? "Y" : "N" ?>"/>
    <input type="hidden" id="auto_calculation" value="<?= ($arParams["AUTO_CALCULATION"] == "N") ? "N" : "Y" ?>"/>





    <div class="bx_ordercart_order_pay">







        <div class="bx_ordercart_order_pay_left" id="coupons_block">
            <?
            if ($arParams["HIDE_COUPON"] != "Y") {
                ?>
                <div class="bx_ordercart_coupon">
                <span><?= GetMessage("STB_COUPON_PROMT") ?></span>
                <input type="text" id="coupon" name="COUPON" value="" onchange="enterCoupon();">&nbsp;<a class="bx_bt_button bx_big" href="javascript:void(0)" onclick="enterCoupon();" title="<?= GetMessage('SALE_COUPON_APPLY_TITLE'); ?>"><?= GetMessage('SALE_COUPON_APPLY'); ?></a>
                </div>
                <?
                if (!empty($arResult['COUPON_LIST'])) {
                    foreach ($arResult['COUPON_LIST'] as $oneCoupon) {
                        $couponClass = 'disabled';
                        switch ($oneCoupon['STATUS']) {
                            case DiscountCouponsManager::STATUS_NOT_FOUND:
                            case DiscountCouponsManager::STATUS_FREEZE:
                                $couponClass = 'bad';
                                break;
                            case DiscountCouponsManager::STATUS_APPLYED:
                                $couponClass = 'good';
                                break;
                        }
                        ?>
                        <div class="bx_ordercart_coupon">
                        <input disabled readonly type="text" name="OLD_COUPON[]" value="<?= htmlspecialcharsbx($oneCoupon['COUPON']); ?>" class="<? echo $couponClass; ?>"><span class="<? echo $couponClass; ?>" data-coupon="<? echo htmlspecialcharsbx($oneCoupon['COUPON']); ?>"></span>
                        <div class="bx_ordercart_coupon_notes"><?
                            if (isset($oneCoupon['CHECK_CODE_TEXT'])) {
                                echo(is_array($oneCoupon['CHECK_CODE_TEXT']) ? implode('<br>', $oneCoupon['CHECK_CODE_TEXT']) : $oneCoupon['CHECK_CODE_TEXT']);
                            }
                            ?></div></div><?
                    }
                    unset($couponClass, $oneCoupon);
                }
            } else {
            }
            ?>
        </div>





        <div class="bx_ordercart_order_pay_right">
            <table class="bx_ordercart_order_sum">
                <?
                if ($bWeightColumn && floatval($arResult['allWeight']) > 0):?>
                    <tr>
                        <td class="custom_t1"><?= GetMessage("SALE_TOTAL_WEIGHT") ?></td>
                        <td class="custom_t2" id="allWeight_FORMATED"><?= $arResult["allWeight_FORMATED"] ?>
                        </td>
                    </tr>
                <? endif; ?>
                <?
                if ($arParams["PRICE_VAT_SHOW_VALUE"] == "Y"):?>
                    <tr>
                        <td><?
                            echo GetMessage('SALE_VAT_EXCLUDED') ?></td>
                        <td id="allSum_wVAT_FORMATED"><?= $arResult["allSum_wVAT_FORMATED"] ?></td>
                    </tr>
                    <?
                    $showTotalPrice = (float)$arResult["DISCOUNT_PRICE_ALL"] > 0;
                    ?>
                    <tr style="display: <?= ($showTotalPrice ? 'table-row' : 'none'); ?>;">
                        <td class="custom_t1"></td>
                        <td class="custom_t2" style="text-decoration:line-through; color:#828282;"
                            id="PRICE_WITHOUT_DISCOUNT">
                            <?= ($showTotalPrice ? $arResult["PRICE_WITHOUT_DISCOUNT"] : ''); ?>
                        </td>
                    </tr>
                    <?
                    if (floatval($arResult['allVATSum']) > 0):
                        ?>
                        <tr>
                            <td><?
                                echo GetMessage('SALE_VAT') ?></td>
                            <td id="allVATSum_FORMATED"><?= $arResult["allVATSum_FORMATED"] ?></td>
                        </tr>
                    <?
                    endif;
                    ?>
                <? endif; ?>
                <tr>
                    <td class="fwb"><?= GetMessage("SALE_TOTAL") ?></td>
                    <td class="fwb"
                        id="allSum_FORMATED"><?= str_replace(" ", "&nbsp;", $arResult["allSum_FORMATED"]) ?></td>
                </tr>


            </table>
        </div>





        <div class="clb"></div>


    </div>
    </div>


    <div class="bx_ordercart_order_pay_center">
        <?
        if ($arParams["USE_PREPAYMENT"] == "Y" && strlen($arResult["PREPAY_BUTTON"]) > 0):?>
            <?= $arResult["PREPAY_BUTTON"] ?>
            <span><?= GetMessage("SALE_OR") ?></span>
        <? endif; ?>
        <?
        if ($arParams["AUTO_CALCULATION"] != "Y") {
            ?>
            <a href="javascript:void(0)" onclick="updateBasket();"
               class="checkout refresh"><?= GetMessage("SALE_REFRESH") ?></a>
            <?
        }
        ?>
        <a href="javascript:void(0)" onclick="checkOut();" class="checkout"><?= GetMessage("SALE_ORDER") ?></a>
    </div>

<?
else:
    ?>
    <p>В Вашей корзине, пока, ничего нет</p>

<?
endif;?>
<div class="clb"></div>
