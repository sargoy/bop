<?php if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die() ?>
<?php
$APPLICATION->SetPageProperty("full_width", "Y");

use Bitrix\Main;
use Bitrix\Main\Loader;
use Bitrix\Main\Localization\Loc;
use Bitrix\Sale\PropertyValueCollection;
use intec\core\bitrix\Component;
use intec\core\helpers\Html;
use intec\core\helpers\JavaScript;

/**
 * @var array $arParams
 * @var array $arResult
 * @var CMain $APPLICATION
 * @var CUser $USER
 * @var SaleOrderAjax $component
 * @var string $templateFolder
 */
/*
if (!Loader::includeModule('intec.core'))
    return;

if (!Loader::includeModule('intec.basket'))
    return;

IntecBasket::Initialize();
*/
$sTemplateId = Html::getUniqueId(null, Component::getUniqueId($this));

$context = Main\Application::getInstance()->getContext();
$request = $context->getRequest();
$scheme = $request->isHttps() ? 'https' : 'http';

switch (LANGUAGE_ID) {
	case 'ru':
		$locale = 'ru-RU'; break;
	case 'ua':
		$locale = 'ru-UA'; break;
	case 'tk':
		$locale = 'tr-TR'; break;
	default:
		$locale = 'en-US'; break;
}

$APPLICATION->SetAdditionalCSS($templateFolder.'/style.css', true);
$APPLICATION->SetAdditionalCSS($templateFolder.'/css/suggestions.min.css', true);
$this->addExternalJs($templateFolder.'/order_ajax.js');
$this->addExternalJs($templateFolder.'/scripts/jquery.suggestions.min.js');

PropertyValueCollection::initJs();
$this->addExternalJs($templateFolder.'/script.js');
//$this->addExternalJs($templateFolder.'/script_dadata.js');
?>
<noscript>
    <div style="color:red"><?=Loc::getMessage('SOA_NO_JS')?></div>
</noscript>
<?

$hideDelivery = empty($arResult['DELIVERY']);

?>
<div class="container-fluid">
    <div id="<?= $sTemplateId ?>" class="ns-bitrix c-sale-order-ajax c-sale-order-ajax-simple-1">
        <div class="sale-order-ajax-wrapper">
            <div class="sale-order-ajax-wrapper-2">

                <? if (strlen($request->get('ORDER_ID')) > 0) { ?>
                    <div class="container">

                        <!-- Custom -->
	                    <?
	                        $payIDChoose = null;
                            if ($_SERVER['SERVER_NAME'] !== 'bop.ru') {
                                $payIDChoose = '16';
                            } else {
                                $payIDChoose = '9';
                            }
                        ?>
						<?if (current($arResult['PAYMENT'])['PAY_SYSTEM_ID'] === $payIDChoose):
							$orderAccountNumber = urlencode(urlencode($arResult['ORDER']['ACCOUNT_NUMBER']));
							header("Location: {$arParams['PATH_TO_PAYMENT']}?ORDER_ID={$orderAccountNumber}", true);
						else:
							include(__DIR__.'/pages/confirm_new.php');
						endif;?>

                    </div>
				<?php } elseif ($arParams['DISABLE_BASKET_REDIRECT'] === 'Y' && $arResult['SHOW_EMPTY_BASKET']) { ?>
                    <div class="container">
						<?php include(__DIR__.'/pages/empty.php') ?>
                    </div>
				<?php } else { ?>
                    <form action="<?= POST_FORM_ACTION_URI ?>" method="POST" name="ORDER_FORM" id="bx-soa-order-form" enctype="multipart/form-data">
						<?= bitrix_sessid_post() ?>
						<?= strlen($arResult['PREPAY_ADIT_FIELDS']) > 0 ? $arResult['PREPAY_ADIT_FIELDS'] : null ?>
                        <input type="hidden" name="<?=$arParams['ACTION_VARIABLE']?>" value="saveOrderAjax">
                        <input type="hidden" name="location_type" value="code">
                        <input type="hidden" name="BUYER_STORE" id="BUYER_STORE" value="<?=$arResult['BUYER_STORE']?>">
                        <div id="bx-soa-order" class="row bx-<?=$arParams['TEMPLATE_THEME']?>" style="opacity: 0">
                            <!--    MAIN BLOCK  -->
                            <div class="bx-soa col-12 p-0">
                                <div id="bx-soa-main-notifications">
                                    <div class="container">
                                        <div class="alert alert-danger" style="display:none"></div>
                                        <div data-type="informer" style="display:none"></div>
                                    </div>
                                </div>
                                <!--    AUTH BLOCK  -->
                                <div id="bx-soa-auth" class="bx-soa-section bx-soa-auth" style="display:none">
                                    <div class="bx-soa-section-title-container">
                                        <h2 class="bx-soa-section-title font-size-base font-size-lg-4 mb-3">
											<?=$arParams['MESS_AUTH_BLOCK_NAME']?>
                                        </h2>
                                    </div>
                                    <div class="bx-soa-section-content container-fluid"></div>
                                </div>


								<? if ($arParams['BASKET_POSITION'] === 'before'): ?>
                                    <!--    BASKET ITEMS BLOCK  -->
                                    <div id="bx-soa-basket" data-visited="false" class="bx-soa-section bx-active d-none
    ">
                                        <div class="bx-soa-section-title-container">
                                            <h2 class="bx-soa-section-title font-size-base font-size-lg-4 mb-3">
												<?=$arParams['MESS_BASKET_BLOCK_NAME']?>
                                            </h2>
                                            <a href="javascript:void(0)" class="bx-soa-editstep"><?=$arParams['MESS_EXTEND']?></a>
                                        </div>
                                        <div class="bx-soa-section-content container-fluid"></div>
                                    </div>
								<? endif ?>

								<? if ($arParams['DELIVERY_TO_PAYSYSTEM'] === 'p2d'): ?>
                                    <div id="bx-soa-paysystem-and-delivery" class="bx-soa-delivery-and-paysystem">
										<?= Html::beginTag('div', [
											'class' => Html::cssClassFromArray([
												'bx-soa-delivery-and-paysystem-item' => true,
												'bx-soa-delivery-and-paysystem-item-full' => $hideDelivery
											], true)
										]) ?>
                                        <div class="container">
                                            <!--    PAY SYSTEMS BLOCK   -->
                                            <div id="bx-soa-paysystem" data-visited="false" class="bx-soa-section bx-active">
                                                <div class="bx-soa-section-title-container">
                                                    <h2 class="bx-soa-section-title font-size-base font-size-lg-4 mb-3">
														<?=$arParams['MESS_PAYMENT_BLOCK_NAME']?>
                                                    </h2>
                                                    <div class="col-xs-12 col-sm-3 text-right" style="display: none;"><a href="" class="bx-soa-editstep"><?=$arParams['MESS_EDIT']?></a></div>
                                                </div>
                                                <div class="bx-soa-section-content container-fluid"></div>
                                            </div>
											<?= Html::endTag('div') ?>
											<?= Html::beginTag('div', [
												'class' => 'bx-soa-delivery-and-paysystem-item',
												'style' => [
													'display' => $hideDelivery ? 'none' : null
												]
											]) ?>

                                            <!--    REGION BLOCK    -->
                                            <div id="bx-soa-region" data-visited="false" class="bx-soa-section bx-active">
                                                <div class="bx-soa-section-title-container">
                                                    <h2 class="bx-soa-section-title font-size-base font-size-lg-4 mb-3">
														<?=$arParams['MESS_REGION_BLOCK_NAME']?>
                                                    </h2>
                                                    <div class="col-xs-12 col-sm-3 text-right" style="display: none;"><a href="" class="bx-soa-editstep"><?=$arParams['MESS_EDIT']?></a></div>
                                                </div>
                                                <div class="bx-soa-section-content container-fluid"></div>
                                            </div>

                                            <!--    DELIVERY BLOCK  -->
                                            <div id="bx-soa-delivery" data-visited="false" class="bx-soa-section bx-active">
                                                <div class="bx-soa-section-title-container">
                                                    <h2 class="bx-soa-section-title font-size-base font-size-lg-4 mb-3">
														<?=$arParams['MESS_DELIVERY_BLOCK_NAME']?>
                                                    </h2>
                                                    <div class="col-xs-12 col-sm-3 text-right" style="display: none;"><a href="" class="bx-soa-editstep"><?=$arParams['MESS_EDIT']?></a></div>
                                                </div>
                                                <div class="bx-soa-section-content container-fluid"></div>
                                            </div>
											<?= Html::endTag('div') ?>
                                        </div>
                                        <!--    PICKUP BLOCK    -->
                                        <div id="bx-soa-pickup" data-visited="false" class="bx-soa-section" style="display:none">
                                            <div class="bx-soa-section-title-container">
                                                <h2 class="bx-soa-section-title font-size-base font-size-lg-4 mb-3">
                                                </h2>
                                                <div class="col-xs-12 col-sm-3 text-right" style="display: none;"><a href="" class="bx-soa-editstep"><?=$arParams['MESS_EDIT']?></a></div>
                                            </div>
                                            <div class="bx-soa-section-content container-fluid"></div>
                                        </div>
                                    </div>
								<? else: ?>

                                <div id="bx-soa-paysystem-and-delivery" class="bx-soa-delivery-and-paysystem">
									<?= Html::beginTag('div', [
										'class' => 'bx-soa-delivery-and-paysystem-item',
										'style' => [
											'display' => $hideDelivery ? 'none' : null
										]
									]) ?>


                                    <div class="sale-order-ajax-wrapper__bg">
                                        <div class="container">
                                            <div class="row justify-content-between">
                                                <div class="col">
                                                    <!--    REGION BLOCK    -->
                                                    <div id="bx-soa-region" data-visited="false" class="bx-soa-section bx-active">
                                                        <div class="bx-soa-section-title-container">
                                                            <h2 class="bx-soa-section-title font-size-base font-size-lg-4 mb-3">
																<?=$arParams['MESS_REGION_BLOCK_NAME']?>
                                                            </h2>
                                                            <div class="col-xs-12 col-sm-3 text-right" style="display: none;"><a href="" class="bx-soa-editstep"><?=$arParams['MESS_EDIT']?></a></div>
                                                        </div>
                                                        <div class="bx-soa-section-content container-fluid"></div>
                                                    </div>

                                                    <!--    DELIVERY BLOCK  -->
                                                    <div id="bx-soa-delivery" data-visited="false" class="bx-soa-section bx-active">
                                                        <div class="bx-soa-section-title-container">
                                                            <h2 class="bx-soa-section-title font-size-base font-size-lg-4 mb-3">
																<?=$arParams['MESS_DELIVERY_BLOCK_NAME']?>
                                                            </h2>
                                                            <div class="col-xs-12 col-sm-3 text-right" style="display: none;"><a href="" class="bx-soa-editstep"><?=$arParams['MESS_EDIT']?></a></div>
                                                        </div>
                                                        <div class="bx-soa-section-content container-fluid"></div>
                                                    </div>
                                                </div>
                                                <!--    SIDEBAR BLOCK   -->
                                                <div id="bx-soa-total" class="bx-soa-sidebar">
                                                    <div class="d-flex align-items-center mb-2">
                                                        <p class="font-weight-bold mb-0">Ваш заказ</p>
                                                        <a href="/basket/" class="btn ml-auto line-height-120 nuxt-link-active btn-outline-primary" target="_self">Изменить</a>
                                                    </div>
                                                    <div class="bx-soa-cart-total-ghost"></div>
                                                    <div class="bx-soa-cart-total"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="container">
                                        <!--    PICKUP BLOCK    -->
                                        <!--                                                <div id="delivery_custom_map" class="bx-soa-section col-lg-10" style="display:none">-->
                                        <!--                                                    <div class="bx-soa-section-title-container">-->
                                        <!--                                                        <h2 class="bx-soa-section-title font-size-base font-size-lg-4 mb-3"></h2>-->
                                        <!--                                                    </div>-->
                                        <!--                                                    <div class="bx-soa-section-content container-fluid"></div>-->
                                        <!--                                                </div>-->
                                        <div id="bx-soa-pickup" data-visited="false" class="bx-soa-section col-lg-11" style="display:none">
                                            <div class="bx-soa-section-title-container">
                                                <h2 class="bx-soa-section-title font-size-base font-size-lg-4 mb-3"></h2>
                                                <div class="col-xs-12 col-sm-3 text-right" style="display: none;"><a href="" class="bx-soa-editstep"><?=$arParams['MESS_EDIT']?></a></div>
                                            </div>
                                            <div class="bx-soa-section-content container-fluid pb-0"></div>
                                        </div>
                                    </div>
                                </div>
								<?= Html::endTag('div') ?>
								<?= Html::beginTag('div', [
									'class' => Html::cssClassFromArray([
										'bx-soa-buyer-and-paysystem-item' => true,
										'bx-soa-buyer-and-paysystem-item-full' => $hideDelivery
									], true)
								]) ?>

                                <div class="container">

                                        <div class="row no-gutters">

                                            <!--    BUYER PROPS BLOCK   -->
                                            <div id="bx-soa-properties" data-visited="false" class="bx-soa-section bx-active">
                                                <div class="bx-soa-section-title-container">
                                                    <h2 class="bx-soa-section-title font-size-base font-size-lg-4 mb-3">
														<?=$arParams['MESS_BUYER_BLOCK_NAME']?>
                                                    </h2>
                                                    <div class="col-xs-12 col-sm-3 text-right" style="display: none;"><a href="" class="bx-soa-editstep"><?=$arParams['MESS_EDIT']?></a></div>
                                                </div>
<!--                                                <div id="custom_bx_soa_properties_profiles"></div>-->
                                                <div class="bx-soa-section-content container-fluid"></div>
                                            </div>
                                            <!--    PICKUP BLOCK    -->
                                            <div id="delivery_custom_map_box" class="bx-soa-section pr-0">
                                                <div class="bx-soa-section-title-container">
                                                    <h2 class="bx-soa-section-title font-size-base font-size-lg-4">Зоны доставки</h2>
                                                </div>
                                                <div id="delivery_custom_map"style="height: 400px; width: 100%;"></div>
                                            </div>
                                            <!--                                            <div id="bx-soa-pickup" data-visited="false" class="bx-soa-section col-lg-12 pr-0" style="display:none">-->
                                            <!--                                                <div class="bx-soa-section-title-container">-->
                                            <!--                                                    <h2 class="bx-soa-section-title font-size-base font-size-lg-4 mb-3"></h2>-->
                                            <!--                                                    <div class="col-xs-12 col-sm-3 text-right" style="display: none;"><a href="" class="bx-soa-editstep">--><?//=$arParams['MESS_EDIT']?><!--</a></div>-->
                                            <!--                                                </div>-->
                                            <!--                                                <div class="bx-soa-section-content container-fluid pb-0 pr-0"></div>-->
                                            <!--                                            </div>-->
                                            <!--    DUPLICATE MOBILE ORDER SAVE BLOCK   -->
                                            <div id="bx-soa-total-mobile" class="bx-soa-sidebar-mobile"></div>
                                            <!--    PAY SYSTEMS BLOCK   -->
                                            <div id="bx-soa-paysystem" data-visited="false" class="bx-soa-section bx-active">
                                                <div class="bx-soa-section-title-container">
                                                    <h2 class="bx-soa-section-title font-size-base font-size-lg-4 mb-3">
														<?=$arParams['MESS_PAYMENT_BLOCK_NAME']?>
                                                    </h2>

                                                    <div class="col-xs-12 col-sm-3 text-right" style="display: none;"><a href="" class="bx-soa-editstep"><?=$arParams['MESS_EDIT']?></a></div>
                                                </div>
                                                <div class="covid-info">
                                                    <div class="covid-info__img">
                                                        <svg width="30" height="30" viewBox="0 0 30 30" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                            <circle cx="15" cy="15" r="15" fill="#D41894"/>
                                                            <path d="M16.7461 18.7617H13.9336L13.5352 6.9375H17.1445L16.7461 18.7617ZM15.3398 20.6133C15.9102 20.6133 16.3672 20.7812 16.7109 21.1172C17.0625 21.4531 17.2383 21.8828 17.2383 22.4062C17.2383 22.9219 17.0625 23.3477 16.7109 23.6836C16.3672 24.0195 15.9102 24.1875 15.3398 24.1875C14.7773 24.1875 14.3203 24.0195 13.9688 23.6836C13.625 23.3477 13.4531 22.9219 13.4531 22.4062C13.4531 21.8906 13.625 21.4648 13.9688 21.1289C14.3203 20.7852 14.7773 20.6133 15.3398 20.6133Z" fill="white"/>
                                                        </svg>
                                                    </div>
                                                    <span class="covid-info__text">
                                                            В связи с распространением вирусной инфекции COVID 19 и других простудных заболеваний действует только онлайн-оплата, при которой на каждый заказ вы получаете скидку 5%. Во избежание лишних контактов также предусмотрена услуга бесконтактной доставки.
                                                        </span>
                                                </div>
                                                <div class="bx-soa-section-content container-fluid"></div>

                                                <!--    ORDER SAVE BLOCK    -->
                                                <div id="bx-soa-orderSave">
                                                    <div class="bx-soa-orderSave-wrapper">
														<?php if ($arParams['USER_CONSENT'] === 'Y') { ?>
                                                            <div class="bx-soa-orderSave-consent">
																<?php $APPLICATION->IncludeComponent(
																	'bitrix:main.userconsent.request',
																	'',
																	array(
																		'ID' => $arParams['USER_CONSENT_ID'],
																		'IS_CHECKED' => $arParams['USER_CONSENT_IS_CHECKED'],
																		'IS_LOADED' => $arParams['USER_CONSENT_IS_LOADED'],
																		'AUTO_SAVE' => 'N',
																		'SUBMIT_EVENT_NAME' => 'bx-soa-order-save',
																		'REPLACE' => array(
																			'button_caption' => isset($arParams['~MESS_ORDER']) ? $arParams['~MESS_ORDER'] : $arParams['MESS_ORDER'],
																			'fields' => $arResult['USER_CONSENT_PROPERTY_DATA']
																		)
																	)
																) ?>
                                                            </div>
														<?php } ?>
                                                        <div class="bx-soa-orderSave-button">
                                                            <a href="javascript:void(0)" style="margin: 10px 0" class="bx-soa-button bx-soa-button-colored bx-soa-button-lg" data-save-button="true">
																<?=$arParams['MESS_ORDER']?>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="access" style="font-size: 13px">
                                                    <?php
                                                    global $USER;
                                                    if (!$USER->IsAuthorized()) echo "Нажимая кнопку «Оплатить», вы соглашаетесь с условиями <a href='/terms-of-use/'>пользовательского соглашения</a> и даете согласие <a href='/privacy/'>на обработку персональных данных.</a>";
                                                    ?>
                                                </div>
                                            </div>
                                            </div>

                                        </div>

                                </div>

								<?= Html::endTag('div') ?>
                            </div>

							<? endif ?>

							<? if ($arParams['BASKET_POSITION'] === 'after'): ?>
                                <!--    BASKET ITEMS BLOCK  -->
                                <div id="bx-soa-basket" data-visited="false" class="bx-soa-section bx-active d-none">
                                    <div class="bx-soa-section-title-container">
                                        <h2 class="bx-soa-section-title font-size-base font-size-lg-4 mb-3">
											<?=$arParams['MESS_BASKET_BLOCK_NAME']?>
                                        </h2>
                                        <a href="javascript:void(0)" class="bx-soa-editstep"><?=$arParams['MESS_EXTEND']?></a>
                                    </div>
                                    <div class="bx-soa-section-content container-fluid"></div>
                                </div>
							<? endif ?>

                            <div style="display: none;">
                                <div id='bx-soa-basket-hidden' class="bx-soa-section"></div>
                                <div id='bx-soa-region-hidden' class="bx-soa-section"></div>
                                <div id='bx-soa-paysystem-hidden' class="bx-soa-section"></div>
                                <div id='bx-soa-delivery-hidden' class="bx-soa-section"></div>
                                <div id='bx-soa-pickup-hidden' class="bx-soa-section"></div>
                                <div id="bx-soa-properties-hidden" class="bx-soa-section"></div>
                                <div id="bx-soa-auth-hidden" class="bx-soa-section">
                                    <div class="bx-soa-section-content container-fluid reg"></div>
                                </div>
                            </div>
                        </div>

                    </form>

                    <div id="bx-soa-saved-files" style="display: none"></div>
                    <div id="bx-soa-soc-auth-services" style="display:none">
						<?
						$arServices = false;
						$arResult['ALLOW_SOCSERV_AUTHORIZATION'] = Main\Config\Option::get('main', 'allow_socserv_authorization', 'Y') != 'N' ? 'Y' : 'N';
						$arResult['FOR_INTRANET'] = false;

						if (Main\ModuleManager::isModuleInstalled('intranet') || Main\ModuleManager::isModuleInstalled('rest'))
							$arResult['FOR_INTRANET'] = true;

						if (Main\Loader::includeModule('socialservices') && $arResult['ALLOW_SOCSERV_AUTHORIZATION'] === 'Y')
						{
							$oAuthManager = new CSocServAuthManager();
							$arServices = $oAuthManager->GetActiveAuthServices(array(
								'BACKURL' => $this->arParams['~CURRENT_PAGE'],
								'FOR_INTRANET' => $arResult['FOR_INTRANET'],
							));

							if (!empty($arServices))
							{
								$APPLICATION->IncludeComponent(
									'bitrix:socserv.auth.form',
									'flat',
									array(
										'AUTH_SERVICES' => $arServices,
										'AUTH_URL' => $arParams['~CURRENT_PAGE'],
										'POST' => $arResult['POST'],
									),
									$component,
									array('HIDE_ICONS' => 'Y')
								);
							}
						}
						?>
                    </div>
                    <div style="display: none">
						<?php $APPLICATION->IncludeComponent(
							'bitrix:sale.location.selector.steps',
							'.default',
							array(),
							false
						) ?>
						<?php $APPLICATION->IncludeComponent(
							'bitrix:sale.location.selector.search',
							'.default',
							array(),
							false
						) ?>
                    </div>
				<?php
				$signer = new Main\Security\Sign\Signer;
				$signedParams = $signer->sign(base64_encode(serialize($arParams)), 'sale.order.ajax');
				$messages = Loc::loadLanguageFile(__FILE__);
				?>
                    <script>
                        BX.message(<?= JavaScript::toObject($messages) ?>);
                        BX.Sale.OrderAjaxComponent.init({
                            result: <?=CUtil::PhpToJSObject($arResult['JS_DATA'])?>,
                            locations: <?=CUtil::PhpToJSObject($arResult['LOCATIONS'])?>,
                            params: <?=CUtil::PhpToJSObject($arParams)?>,
                            signedParamsString: '<?=CUtil::JSEscape($signedParams)?>',
                            siteID: '<?=CUtil::JSEscape($component->getSiteId())?>',
                            ajaxUrl: '<?=CUtil::JSEscape($component->getPath().'/ajax.php')?>',
                            templateFolder: '<?=CUtil::JSEscape($templateFolder)?>',
                            propertyValidation: true,
                            showWarnings: true,
                            pickUpMap: {
                                defaultMapPosition: {
                                    lat: 55.76,
                                    lon: 37.64,
                                    zoom: 13
                                },
                                secureGeoLocation: false,
                                geoLocationMaxTime: 5000,
                                minToShowNearestBlock: 3,
                                nearestPickUpsToShow: 3
                            },
                            propertyMap: {
                                defaultMapPosition: {
                                    lat: 55.76,
                                    lon: 37.64,
                                    zoom: 13
                                }
                            },
                            orderBlockId: 'bx-soa-order',
                            authBlockId: 'bx-soa-auth',
                            basketBlockId: 'bx-soa-basket',
                            regionBlockId: 'bx-soa-region',
                            paySystemBlockId: 'bx-soa-paysystem',
                            deliveryBlockId: 'bx-soa-delivery',
                            pickUpBlockId: 'bx-soa-pickup',
                            propsBlockId: 'bx-soa-properties',
                            totalBlockId: 'bx-soa-total'
                        });
                    </script>
                    <script>
						<?
						// spike: for children of cities we place this prompt
						$city = \Bitrix\Sale\Location\TypeTable::getList(array('filter' => array('=CODE' => 'CITY'), 'select' => array('ID')))->fetch();
						?>
                        BX.saleOrderAjax.init(<?=CUtil::PhpToJSObject(array(
							'source' => $component->getPath().'/get.php',
							'cityTypeId' => intval($city['ID']),
							'messages' => array(
								'otherLocation' => '--- '.Loc::getMessage('SOA_OTHER_LOCATION'),
								'moreInfoLocation' => '--- '.Loc::getMessage('SOA_NOT_SELECTED_ALT'), // spike: for children of cities we place this prompt
								'notFoundPrompt' => '<div class="-bx-popup-special-prompt">'.Loc::getMessage('SOA_LOCATION_NOT_FOUND').'.<br />'.Loc::getMessage('SOA_LOCATION_NOT_FOUND_PROMPT', array(
										'#ANCHOR#' => '<a href="javascript:void(0)" class="-bx-popup-set-mode-add-loc">',
										'#ANCHOR_END#' => '</a>'
									)).'</div>'
							)
						))?>);
                    </script>
				<?php if ($arParams['SHOW_PICKUP_MAP'] === 'Y' || $arParams['SHOW_MAP_IN_PROPS'] === 'Y') { ?>
				<?php if ($arParams['PICKUP_MAP_TYPE'] === 'yandex') { ?>
				<?php $this->addExternalJs($templateFolder.'/scripts/yandex_maps.js') ?>
				<?php $yandexAPIkey = \Bitrix\Main\Config\Option::get('fileman', 'yandex_map_api_key', '');?>
                    <script src="<?=$scheme?>://api-maps.yandex.ru/2.1.50/?load=package.full&lang=<?=$locale?>&apikey=<?=$yandexAPIkey?>"></script>
                    <script>
                        (function bx_ymaps_waiter(){
                            if (typeof ymaps !== 'undefined' && BX.Sale && BX.Sale.OrderAjaxComponent)
                                ymaps.ready(BX.proxy(BX.Sale.OrderAjaxComponent.initMaps, BX.Sale.OrderAjaxComponent));
                            else
                                setTimeout(bx_ymaps_waiter, 100);
                        })();
                    </script>
				<?php } else if ($arParams['PICKUP_MAP_TYPE'] === 'google') { ?>
				<?php $this->addExternalJs($templateFolder.'/scripts/google_maps.js') ?>
                    <script async defer src="<?=$scheme?>://maps.googleapis.com/maps/api/js?key=<?= htmlspecialcharsbx(Main\Config\Option::get('fileman', 'google_map_api_key', '')) ?>&callback=bx_gmaps_waiter">
                    </script>
                    <script>
                        function bx_gmaps_waiter() {
                            if (BX.Sale && BX.Sale.OrderAjaxComponent) {
                                BX.Sale.OrderAjaxComponent.initMaps();
                            } else {
                                setTimeout(bx_gmaps_waiter, 100);
                            }
                        }
                    </script>
				<?php } ?>
				<?php } ?>
				<?php if ($arParams['USE_YM_GOALS'] === 'Y') { ?>
                    <script>
                        (function bx_counter_waiter(i){
                            i = i || 0;
                            if (i > 50)
                                return;

                            if (typeof window['yaCounter<?=$arParams['YM_GOALS_COUNTER']?>'] !== 'undefined')
                                BX.Sale.OrderAjaxComponent.reachGoal('initialization');
                            else
                                setTimeout(function(){bx_counter_waiter(++i)}, 100);
                        })();
                    </script>
				<?php } ?>
				<?php } ?>
            </div>
        </div>
    </div>
