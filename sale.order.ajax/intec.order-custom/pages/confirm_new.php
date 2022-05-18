<?php if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die() ?>
<?php

use Bitrix\Main\Localization\Loc;
use intec\core\helpers\ArrayHelper;
use intec\core\helpers\Html;

global $USER;

//debug($request->get('ORDER_ID'), false);

$arOrder = CSaleOrder::GetByID($arResult['ORDER']['ID']);
$arDeliv = CSaleDelivery::GetByID($arOrder['DELIVERY_ID']);
$dbOrderProps = CSaleOrderPropsValue::GetList(
	array("SORT" => "ASC"),
	array("ORDER_ID" =>$arResult['ORDER']['ID'], "CODE"=>array("ADDRESS"))
);
$arOrderProps = $dbOrderProps->fetch();
//debug($arResult['ORDER']['ID'], false);
/**
 * @var array $arParams
 * @var array $arResult
 * @var $APPLICATION CMain
 * @var CBitrixComponentTemplate $this
 */
if ($arParams['SET_TITLE'] == 'Y')
	$APPLICATION->SetTitle(Loc::getMessage('SOA_ORDER_COMPLETE'));

$directory = $this->GetFolder();

?>



<div class="bx-soa-page bx-soa-page-confirm">
    <div class="row my-4 py-3">
	<?php if (!empty($arResult["ORDER"])) { ?>

		<div class="col-md-6 col-lg-4">
			<div class="d-flex align-items-center">
				<div class="align-self-start mr-3">
					<svg width="50" height="50" xmlns="http://www.w3.org/2000/svg"
					     class="fill-primary icon sprite-cart">
						<use href="<?=SITE_TEMPLATE_PATH?>/_nuxt/97ab6542f6842330a9d3d644fca97bea.svg#i-confirm"
						     xlink:href="<?=SITE_TEMPLATE_PATH?>/_nuxt/97ab6542f6842330a9d3d644fca97bea.svg#i-confirm"></use>
					</svg>
				</div>
				<div><p class="font-size-3 text-primary mb-1">
						Ваш заказ №<?=$arResult['ORDER']['ID']?> сформирован
					</p>
					<p class="font-size-6 font-weight-medium mb-0">
						Спасибо, <?=ucfirst($arOrder['USER_NAME'])?>!
					</p></div>
			</div>
		</div>
		<div class="d-none d-md-block col-md-6 col-lg-8 col-xl-7 offset-xl-1">
			<div class="d-flex align-items-center"><p class="font-size-3 text-gray-700 mb-0 mr-lg-5 mr-xl-60">
					Мы в социальных сетях:
				</p> <a href="<?=$GLOBALS['zloj_config']['links']['instagram'];?>" target="_blank" class="text-primary mr-2">
					<svg width="24" height="24" xmlns="http://www.w3.org/2000/svg" class="icon sprite-icons">
						<use href="<?=SITE_TEMPLATE_PATH?>/_nuxt/e9f276f8f2f8d76658b3ea83098ca231.svg#i-social-instagram"
						     xlink:href="<?=SITE_TEMPLATE_PATH?>/_nuxt/e9f276f8f2f8d76658b3ea83098ca231.svg#i-social-instagram"></use>
					</svg>
				</a> <a href="<?=$GLOBALS['zloj_config']['links']['vk'];?>" target="_blank" class="text-primary mr-2">
					<svg width="24" height="24" xmlns="http://www.w3.org/2000/svg" class="icon sprite-icons">
						<use href="<?=SITE_TEMPLATE_PATH?>/_nuxt/e9f276f8f2f8d76658b3ea83098ca231.svg#i-social-vk"
						     xlink:href="<?=SITE_TEMPLATE_PATH?>/_nuxt/e9f276f8f2f8d76658b3ea83098ca231.svg#i-social-vk"></use>
					</svg>
				</a> <a href="<?=$GLOBALS['zloj_config']['links']['facebook'];?>" target="_blank" class="text-primary mr-2">
					<svg width="24" height="24" xmlns="http://www.w3.org/2000/svg" class="icon sprite-icons">
						<use href="<?=SITE_TEMPLATE_PATH?>/_nuxt/e9f276f8f2f8d76658b3ea83098ca231.svg#i-social-facebook"
						     xlink:href="<?=SITE_TEMPLATE_PATH?>/_nuxt/e9f276f8f2f8d76658b3ea83098ca231.svg#i-social-facebook"></use>
					</svg>
				</a></div>
		</div>
	</div>

	<div class="row mb-4">
        <?php if ($arResult['ORDER']['IS_ALLOW_PAY'] === 'Y') { ?>
			<?php if (!empty($arResult['PAYMENT'])) { ?>
				<?php foreach ($arResult['PAYMENT'] as $arPayment) { ?>
					<?php $arPaySystem = $arResult['PAY_SYSTEM_LIST_BY_PAYMENT_ID'][$arPayment['ID']] ?>
					<?php if (!empty($arPaySystem) && $arPayment["PAID"] != 'Y') { ?>
						<div class="mb-4 col-md-6 col-lg-5 col-xl-4">
							<div class="card rounded-sm h-100">
								<div class="card-body">
									<p>
										Информация по&nbsp;заказу
									</p>
									<div class="text-gray-600 mb-4">
										<p>
											Заказ №<?=$arResult['ORDER']['ACCOUNT_NUMBER']?> от <?=$arResult['ORDER']['DATE_INSERT']->toUserTime()->format('d.m.Y H:i')?>
										</p>
										<p>
											Сумма:
											<span class="font-weight-medium text-body"><?=$arOrder['PRICE']?>&nbsp;р.</span>
										</p>
										<p>
											Адрес доставки:<br>
											<span class="text-gray-600 mb-4">
                                                <?=$arOrder['USER_NAME']?> <?=$arOrder['USER_LAST_NAME']?><br>
                                                <?=$arOrderProps['VALUE']?>
                                            </span>
										</p>

										<p>
											Доставка:<br>
											<span class="text-gray-600 mb-4">
                                                <?=$arDeliv['NAME']?>
                                            </span>
										</p>
										<p>
											Оплата: <br>
											<span class="text-gray-600 mb-4">
												<?php
												$arLogotype = CFile::ResizeImageGet($arPaySystem['LOGOTIP'], [
													'width' => 100,
													'height' => 100
												], BX_RESIZE_IMAGE_PROPORTIONAL);
												?>
                                                <?php if (empty($arPaySystem['ERROR'])) { ?>
                                                    <div class="bx-soa-page-payment-information">
                                                        <?php if (!empty($arLogotype)) { ?>
                                                            <div class="bx-soa-page-payment-logotype">
                                                                <img src="<?= $arLogotype['src'] ?>" alt="<?=$arPaySystem['NAME'] ?>" />
                                                            </div>
                                                        <?php } ?>
                                                        <div class="bx-soa-page-payment-name">
                                                            <?=$arPaySystem['NAME'] ?>

                                                        </div>
                                                    </div>
                                                    <?php if (strlen($arPaySystem['ACTION_FILE']) > 0 && $arPaySystem['NEW_WINDOW'] == 'Y' && $arPaySystem['IS_CASH'] != 'Y') { ?>
														<?php
														$orderAccountNumber = urlencode(urlencode($arResult['ORDER']['ACCOUNT_NUMBER']));
														$paymentAccountNumber = $arPayment['ACCOUNT_NUMBER'];
														?>
                                                            <script>
                                                                window.open('<?= $arParams['PATH_TO_PAYMENT'] ?>?ORDER_ID=<?=$orderAccountNumber?>&PAYMENT_ID=<?=$paymentAccountNumber?>');
                                                            </script>
<!--                                                            --><?//= Loc::getMessage('SOA_PAY_LINK', [
//                                                                '#LINK#' => $arParams['PATH_TO_PAYMENT'].'?ORDER_ID='.$orderAccountNumber.'&PAYMENT_ID='.$paymentAccountNumber
//                                                            ]) ?>
                                                            <p>
                                                                Если окно с платежной информацией не открылось автоматически, нажмите на ссылку
                                                                <a href="<?=$arParams['PATH_TO_PAYMENT'].'?ORDER_ID='.$orderAccountNumber.'&PAYMENT_ID='.$paymentAccountNumber?>" target="_blank">Оплатить заказ</a>.
                                                            </p>
                                                                        <?php if (CSalePdf::isPdfAvailable() && $arPaySystem['IS_AFFORD_PDF']) { ?>
                                                                            <br/>
                                                                            <?= Loc::getMessage('SOA_PAY_PDF', [
                                                                                '#LINK#' => $arParams['PATH_TO_PAYMENT'].'?ORDER_ID='.$orderAccountNumber.'&pdf=1&DOWNLOAD=Y'
                                                                            ]) ?>
                                                                        <?php } ?>
                                                        </div>
                                                        <?php } else if (!empty($arPaySystem['BUFFERED_OUTPUT'])) { ?>
                                                        <div class="confirm-card-payment__box">
                                                            <?if($arPaySystem["ID"] !== '15'):?>
                                                                <?=$arPaySystem['BUFFERED_OUTPUT']?>
                                                            <?endif;?>
                                                        </div>
													<?php } ?>
												<?php } else { ?>
                                                    <span style="color: red;">
                                                        <?=Loc::getMessage("SOA_ORDER_PS_ERROR")?>
                                                    </span>
												<?php } ?>
                                            </span>
										</p>
									</div>
									<div class="card-footer d-flex bg-transparent border-0 pt-0 pb-4">
										<!--                        <button type="button" class="btn flex-fill mr-3 btn-outline-gray-500">-->
										<!--                            Отменить-->
										<!--                        </button>-->
										<a href="/my/orders/detail/<?=$arResult['ORDER']['ID']?>/" class="btn flex-fill btn-primary">
											Отследить заказ
										</a>
									</div>
								</div>
							</div>
						</div>
					<?php } ?>
				<?php } ?>
			<?php } ?>
		<?php } else { ?>
    <div class="mb-4 col-md-6 col-lg-5 col-xl-4">
        <div class="card rounded-sm h-100">
            <div class="card-body">
                    <h3>Ваш заказ сформирован!</h3>

                    <?if ($arResult['ORDER']['IS_ALLOW_PAY'] === 'Y'):?>
                        <p>
                            Вы можете отследить Ваш заказ в <a href="/my/orders/detail/<?=$arResult['ORDER']['ID']?>/">Вашем личном кабинете</a>.
                        </p>
                        <p>или</p>
                        <form action="/order/payment/?ORDER_ID=<?=$arResult['ID']?>" method="post">
                            <input name="ready_to_pay" value="1" type="hidden">
                            <input name="BuyButton" value="Оплатить" type="hidden">
                            <button type="submit" class="btn d-flex flex-center px-1 line-height-120 btn-primary btn-block btn-order__payment btn-order">
                                Оплатить заказ
                            </button>
                        </form>
	                    <?else:?>
	                    <p>
                            Вы можете отследить Ваш заказ в <a href="/my/orders/detail/<?=$arResult['ORDER']['ID']?>/">Вашем личном кабинете</a>.
                        </p>
                    <?endif;?>
            </div>
        </div>
    </div>
		<?php } ?>
    <?php } else { ?>
        <div class="mb-4 col-md-6 col-lg-5 col-xl-4">
            <div class="card rounded-sm h-100">
                <div class="card-body">
                    <h3><?= Loc::getMessage('SOA_ERROR_ORDER') ?>!</h3>
                    <p>
	                    <?= Loc::getMessage('SOA_ERROR_ORDER_LOST', [
		                    '#ORDER_ID#' => Html::encode($arResult['ACCOUNT_NUMBER'])
	                    ]) ?> <br><br>
	                    <?= Loc::getMessage('SOA_ERROR_ORDER_LOST1') ?>
                    </p>
                </div>
            </div>
        </div>

    <?php } ?>
		<div class="mb-4 col-md-6 col-lg-7 offset-xl-1">
			<div class="d-flex flex-column h-100">
				<div class="d-flex align-items-center mb-4 d-md-none">
                    <p class="font-size-3 text-gray-700 mb-0 mr-4">
						Мы в социальных сетях:
					</p>
                    <a href="<?=$GLOBALS['zloj_config']['links']['instagram'];?>" target="_blank" class="text-primary mr-2">
						<svg width="24" height="24" xmlns="http://www.w3.org/2000/svg" class="icon sprite-icons">
							<use href="<?=SITE_TEMPLATE_PATH?>/_nuxt/e9f276f8f2f8d76658b3ea83098ca231.svg#i-social-instagram"
							     xlink:href="<?=SITE_TEMPLATE_PATH?>/_nuxt/e9f276f8f2f8d76658b3ea83098ca231.svg#i-social-instagram"></use>
						</svg>
					</a>
                    <a href="<?=$GLOBALS['zloj_config']['links']['vk'];?>" target="_blank" class="text-primary mr-2">
						<svg width="24" height="24" xmlns="http://www.w3.org/2000/svg" class="icon sprite-icons">
							<use href="<?=SITE_TEMPLATE_PATH?>/_nuxt/e9f276f8f2f8d76658b3ea83098ca231.svg#i-social-vk"
							     xlink:href="<?=SITE_TEMPLATE_PATH?>/_nuxt/e9f276f8f2f8d76658b3ea83098ca231.svg#i-social-vk"></use>
						</svg>
					</a>
                    <a href="<?=$GLOBALS['zloj_config']['links']['facebook'];?>" target="_blank" class="text-primary mr-2">
						<svg width="24" height="24" xmlns="http://www.w3.org/2000/svg" class="icon sprite-icons">
							<use href="<?=SITE_TEMPLATE_PATH?>/_nuxt/e9f276f8f2f8d76658b3ea83098ca231.svg#i-social-facebook"
							     xlink:href="<?=SITE_TEMPLATE_PATH?>/_nuxt/e9f276f8f2f8d76658b3ea83098ca231.svg#i-social-facebook"></use>
						</svg>
					</a>
                </div>
<!--				<div class="card flex-fill bg-gray-50 border-0 mb-4">-->
<!--					<div class="card-body">-->
<!--						<div class="row">-->
<!--							<div class="col-xl-9"><p-->
<!--									class="font-size-4 font-size-lg-6 font-weight-medium text-gray-700 mb-lg-4">-->
<!--									Делитесь с&nbsp;другими, экономьте и&nbsp;зарабатывайте еще-->
<!--									больше!-->
<!--								</p></div>-->
<!--						</div>-->
<!--						<p class="text-gray-600 mb-4 mb-xl-5">-->
<!--							Поделитесь Вашим кодом для&nbsp;вознаграждений-->
<!--							<strong class="font-weight-medium text-primary">КНГРП</strong>-->
<!--							с&nbsp;Вашими друзьями и&nbsp;семьей. Они получат-->
<!--							5%&nbsp;скидки, а&nbsp;Вы заработаете 5%&nbsp;вознаграждений!-->
<!--						</p>-->
<!--						<p class="text-gray-600">-->
<!--							Или поделитесь этой ссылкой-->
<!--						</p>-->
<!--						<div class="dropdown dropright dropdown-share-link mb-4"><span-->
<!--								class="dropdown-toggle dropdown-toggle-no-caret">-->
<!--                https://www.figma.com/file/K0A6guKr7SvSw0eiSNVcHD/bop?-->
<!--              </span>-->
<!--							<ul class="dropdown-menu" style="display: none;">-->
<!--								<li class="dropdown-item">-->
<!--									<svg width="17" height="19" xmlns="http://www.w3.org/2000/svg"-->
<!--									     class="icon sprite-icons">-->
<!--										<use href="/_nuxt/e9f276f8f2f8d76658b3ea83098ca231.svg#i-copy"-->
<!--										     xlink:href="/_nuxt/e9f276f8f2f8d76658b3ea83098ca231.svg#i-copy"></use>-->
<!--									</svg>-->
<!--									<span>Скопировать ссылку</span></li>-->
<!--							</ul>-->
<!--						</div>-->
<!--					</div>-->
<!--					<div class="card-footer d-flex bg-transparent border-0 pt-0 pb-4">-->
<!--						<div class="dropdown b-dropdown dropdown-share dropright btn-group" id="__BVID__707"-->
<!--							<button aria-haspopup="true" aria-expanded="false" type="button"-->
<!--							        class="btn dropdown-toggle btn-outline-dark btn-share dropdown-toggle-no-caret"-->
<!--							        id="__BVID__707__BV_toggle_"><span class="caption">-->
<!--      Поделиться-->
<!--    </span>-->
<!--								<svg width="17" height="9" xmlns="http://www.w3.org/2000/svg"-->
<!--								     class="icon sprite-icons">-->
<!--									<use href="/_nuxt/e9f276f8f2f8d76658b3ea83098ca231.svg#i-share"-->
<!--									     xlink:href="/_nuxt/e9f276f8f2f8d76658b3ea83098ca231.svg#i-share"></use>-->
<!--								</svg>-->
<!--							</button>-->
<!--							<ul role="menu" tabindex="-1" class="dropdown-menu dropdown-menu-share"-->
<!--							    aria-labelledby="__BVID__707__BV_toggle_">-->
<!--								<li role="presentation" class="fill-primary"><a role="menuitem" href="#"-->
<!--								                                                target="_self"-->
<!--								                                                class="dropdown-item">-->
<!--										<svg width="25" height="25" xmlns="http://www.w3.org/2000/svg"-->
<!--										     class="icon sprite-icons">-->
<!--											<use href="/_nuxt/e9f276f8f2f8d76658b3ea83098ca231.svg#i-social-instagram"-->
<!--											     xlink:href="/_nuxt/e9f276f8f2f8d76658b3ea83098ca231.svg#i-social-instagram"></use>-->
<!--										</svg>-->
<!--									</a></li>-->
<!--								<li role="presentation" class="fill-magenta"><a role="menuitem" href="#"-->
<!--								                                                target="_self"-->
<!--								                                                class="dropdown-item">-->
<!--										<svg width="25" height="25" xmlns="http://www.w3.org/2000/svg"-->
<!--										     class="icon sprite-icons">-->
<!--											<use href="/_nuxt/e9f276f8f2f8d76658b3ea83098ca231.svg#i-social-vk"-->
<!--											     xlink:href="/_nuxt/e9f276f8f2f8d76658b3ea83098ca231.svg#i-social-vk"></use>-->
<!--										</svg>-->
<!--									</a></li>-->
<!--								<li role="presentation" class="fill-secondary"><a role="menuitem" href="#"-->
<!--								                                                  target="_self"-->
<!--								                                                  class="dropdown-item">-->
<!--										<svg width="25" height="25" xmlns="http://www.w3.org/2000/svg"-->
<!--										     class="icon sprite-icons">-->
<!--											<use href="/_nuxt/e9f276f8f2f8d76658b3ea83098ca231.svg#i-social-facebook"-->
<!--											     xlink:href="/_nuxt/e9f276f8f2f8d76658b3ea83098ca231.svg#i-social-facebook"></use>-->
<!--										</svg>-->
<!--									</a></li>-->
<!--								<li role="presentation" class="fill-warning"><a role="menuitem" href="#"-->
<!--								                                                target="_self"-->
<!--								                                                class="dropdown-item">-->
<!--										<svg width="25" height="25" xmlns="http://www.w3.org/2000/svg"-->
<!--										     class="icon sprite-icons">-->
<!--											<use href="/_nuxt/e9f276f8f2f8d76658b3ea83098ca231.svg#i-social-whatsapp"-->
<!--											     xlink:href="/_nuxt/e9f276f8f2f8d76658b3ea83098ca231.svg#i-social-whatsapp"></use>-->
<!--										</svg>-->
<!--									</a></li>-->
<!--							</ul>-->
<!--						</div>-->
<!--						<button type="button" class="btn ml-auto btn-outline-primary">-->
<!--							Подробнее-->
<!--						</button>-->
<!--					</div>-->
<!--				</div>-->
				<div class="card border-0 rounded-0 mb-4 confirm__banners"
				     style="background: url(/images/confirm-page/bann1.png) no-repeat;">
					<div class="card-body">
                        <p class="">
                            <span class="font-size-3 font-weight-medium">Разнообразию быть!</span><br>
                            Актуальная подборка летних <br>
                            рецептов в нашем блоге
                        </p>
                    </div>
					<div class="card-footer bg-transparent border-0 pt-0 pb-4">
						<a href="/blog/" class="btn btn-outline-black">
							Подробнее
						</a>
					</div>
				</div>
				<div class="card border-0 rounded-0 confirm__banners"
                     style="background: url(/images/confirm-page/bann2.png) no-repeat;">
					<div class="card-body">
                            <p class="font-size-3 font-weight-medium mt-auto pt-5">
                                Заряжайтесь отличным <br>
                                настроением вместе <br>
                                с bop.ru
                            </p>
                    </div>
				</div>
			</div>
		</div>
	</div>

<?//$APPLICATION->IncludeComponent(
//	"bitrix:catalog.section",
//	"carousel",
//	array(
//		"ACTION_VARIABLE" => "action",
//		"ADD_PICT_PROP" => "-",
//		"ADD_PROPERTIES_TO_BASKET" => "Y",
//		"ADD_SECTIONS_CHAIN" => "N",
//		"ADD_TO_BASKET_ACTION" => "ADD",
//		"AJAX_MODE" => "N",
//		"AJAX_OPTION_ADDITIONAL" => "",
//		"AJAX_OPTION_HISTORY" => "N",
//		"AJAX_OPTION_JUMP" => "N",
//		"AJAX_OPTION_STYLE" => "Y",
//		"BACKGROUND_IMAGE" => "-",
//		"BASKET_URL" => "/personal/basket.php",
//		"BROWSER_TITLE" => "-",
//		"CACHE_FILTER" => "Y",
//		"CACHE_GROUPS" => "Y",
//		"CACHE_TIME" => "36000000",
//		"CACHE_TYPE" => "A",
//		"COMPATIBLE_MODE" => "Y",
//		"CONVERT_CURRENCY" => "N",
//		"CUSTOM_FILTER" => "{\"CLASS_ID\":\"CondGroup\",\"DATA\":{\"All\":\"AND\",\"True\":\"True\"},\"CHILDREN\":[]}",
//		"DETAIL_URL" => "",
//		"DISABLE_INIT_JS_IN_COMPONENT" => "N",
//		"DISPLAY_BOTTOM_PAGER" => "Y",
//		"DISPLAY_COMPARE" => "N",
//		"DISPLAY_TOP_PAGER" => "N",
//		"ELEMENT_SORT_FIELD" => "PROPERTY_SHOW_MAIN1",
//		"ELEMENT_SORT_FIELD2" => "id",
//		"ELEMENT_SORT_ORDER" => "desc",
//		"ELEMENT_SORT_ORDER2" => "desc",
//		"ENLARGE_PRODUCT" => "STRICT",
//		"FILTER_NAME" => "arrFilterCarousel",
//		"HIDE_NOT_AVAILABLE" => "N",
//		"HIDE_NOT_AVAILABLE_OFFERS" => "N",
//		"IBLOCK_ID" => "26",
//		"IBLOCK_TYPE" => "aspro_max_catalog",
//		"INCLUDE_SUBSECTIONS" => "Y",
//		"LABEL_PROP" => "",
//		"LAZY_LOAD" => "N",
//		"LINE_ELEMENT_COUNT" => "3",
//		"LOAD_ON_SCROLL" => "N",
//		"MESSAGE_404" => "",
//		"MESS_BTN_ADD_TO_BASKET" => "В корзину",
//		"MESS_BTN_BUY" => "Купить",
//		"MESS_BTN_DETAIL" => "Подробнее",
//		"MESS_BTN_SUBSCRIBE" => "Подписаться",
//		"MESS_NOT_AVAILABLE" => "Нет в наличии",
//		"META_DESCRIPTION" => "-",
//		"META_KEYWORDS" => "-",
//		"OFFERS_FIELD_CODE" => array(
//			0 => "",
//			1 => "",
//		),
//		"OFFERS_LIMIT" => "5",
//		"OFFERS_SORT_FIELD" => "sort",
//		"OFFERS_SORT_FIELD2" => "id",
//		"OFFERS_SORT_ORDER" => "asc",
//		"OFFERS_SORT_ORDER2" => "desc",
//		"PAGER_BASE_LINK_ENABLE" => "N",
//		"PAGER_DESC_NUMBERING" => "N",
//		"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
//		"PAGER_SHOW_ALL" => "N",
//		"PAGER_SHOW_ALWAYS" => "N",
//		"PAGER_TEMPLATE" => ".default",
//		"PAGER_TITLE" => "Товары",
//		"PAGE_ELEMENT_COUNT" => "15",
//		"PARTIAL_PRODUCT_PROPERTIES" => "N",
//		"PRICE_CODE" => array(
//			0 => "BASE",
//		),
//		"PRICE_VAT_INCLUDE" => "Y",
//		"PRODUCT_BLOCKS_ORDER" => "price,props,sku,quantityLimit,quantity,buttons",
//		"PRODUCT_DISPLAY_MODE" => "N",
//		"PRODUCT_ID_VARIABLE" => "id",
//		"PRODUCT_PROPS_VARIABLE" => "prop",
//		"PRODUCT_QUANTITY_VARIABLE" => "quantity",
//		"PRODUCT_ROW_VARIANTS" => "[{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false}]",
//		"PRODUCT_SUBSCRIPTION" => "Y",
//		"PROPERTY_CODE_MOBILE" => "",
//		"RCM_PROD_ID" => $_REQUEST["PRODUCT_ID"],
//		"RCM_TYPE" => "personal",
//		"SECTION_CODE" => "",
//		"SECTION_ID" => "",
//		"SECTION_ID_VARIABLE" => "SECTION_ID",
//		"SECTION_URL" => "",
//		"SECTION_USER_FIELDS" => array(
//			0 => "",
//			1 => "",
//		),
//		"SEF_MODE" => "N",
//		"SET_BROWSER_TITLE" => "Y",
//		"SET_LAST_MODIFIED" => "N",
//		"SET_META_DESCRIPTION" => "Y",
//		"SET_META_KEYWORDS" => "Y",
//		"SET_STATUS_404" => "N",
//		"SET_TITLE" => "Y",
//		"SHOW_404" => "N",
//		"SHOW_ALL_WO_SECTION" => "Y",
//		"SHOW_CLOSE_POPUP" => "N",
//		"SHOW_DISCOUNT_PERCENT" => "N",
//		"SHOW_FROM_SECTION" => "N",
//		"SHOW_MAX_QUANTITY" => "N",
//		"SHOW_OLD_PRICE" => "N",
//		"SHOW_PRICE_COUNT" => "1",
//		"SHOW_SLIDER" => "Y",
//		"SLIDER_INTERVAL" => "3000",
//		"SLIDER_PROGRESS" => "N",
//		"TEMPLATE_THEME" => "blue",
//		"USE_ENHANCED_ECOMMERCE" => "N",
//		"USE_MAIN_ELEMENT_SECTION" => "Y",
//		"USE_PRICE_COUNT" => "N",
//		"USE_PRODUCT_QUANTITY" => "N",
//		"COMPONENT_TEMPLATE" => "carousel",
//		"TITLE" => "РЕКОМЕНДУЕМЫЕ ТОВАРЫ",
//		"IDID" => "1"
//	),
//	false
//);?>

