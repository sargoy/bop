<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Localization\Loc;

/**
 * @var array $mobileColumns
 * @var array $arParams
 * @var string $templateFolder
 */

$usePriceInAdditionalColumn = in_array('PRICE', $arParams['COLUMNS_LIST']) && $arParams['PRICE_DISPLAY_MODE'] === 'Y';
$useSumColumn = in_array('SUM', $arParams['COLUMNS_LIST']);
$useActionColumn = in_array('DELETE', $arParams['COLUMNS_LIST']);

$restoreColSpan = 2 + $usePriceInAdditionalColumn + $useSumColumn + $useActionColumn;

$positionClassMap = array(
	'left' => 'basket-item-label-left',
	'center' => 'basket-item-label-center',
	'right' => 'basket-item-label-right',
	'bottom' => 'basket-item-label-bottom',
	'middle' => 'basket-item-label-middle',
	'top' => 'basket-item-label-top'
);

$discountPositionClass = '';
if ($arParams['SHOW_DISCOUNT_PERCENT'] === 'Y' && !empty($arParams['DISCOUNT_PERCENT_POSITION']))
{
	foreach (explode('-', $arParams['DISCOUNT_PERCENT_POSITION']) as $pos)
	{
		$discountPositionClass .= isset($positionClassMap[$pos]) ? ' '.$positionClassMap[$pos] : '';
	}
}

$labelPositionClass = '';
if (!empty($arParams['LABEL_PROP_POSITION']))
{
	foreach (explode('-', $arParams['LABEL_PROP_POSITION']) as $pos)
	{
		$labelPositionClass .= isset($positionClassMap[$pos]) ? ' '.$positionClassMap[$pos] : '';
	}
}
?>
<script id="basket-item-template" type="text/html">
	<div class="basket-items-list-item-container{{#SHOW_RESTORE}} basket-items-list-item-container-expend{{/SHOW_RESTORE}}"
		id="basket-item-{{ID}}" data-entity="basket-item" data-id="{{ID}}">
		{{#SHOW_RESTORE}}
        <div class="cart-item cart-item-removed" id="cart-item-removed_{{ID}}">
            <div class="cart-item-img"><img src="/images/catalog/groceries-milk.jpg"></div>

            <div class="cart-item-remove">
                <button type="button" class="btn btn-link">
                    <svg width="14" height="14" xmlns="http://www.w3.org/2000/svg" class="icon sprite-icons">
                        <use href="<?= SITE_TEMPLATE_PATH ?>/_nuxt/e9f276f8f2f8d76658b3ea83098ca231.svg#i-close" xlink:href="<?= SITE_TEMPLATE_PATH ?>/_nuxt/e9f276f8f2f8d76658b3ea83098ca231.svg#i-close"></use>
                    </svg>
                </button>
            </div>
            <div class="cart-item-overlay">
                <div class="cart-item-body">
                    <div class="cart-item-content">
                        <p class="font-size-base font-weight-bold mb-lg-0">
                            Вы удалили товар:
                        </p>
                        <span style="width: 200px">{{NAME}}</span>
                        <p class="font-weight-medium mb-lg-0">
                                <a href="javascript:void(0)" class="restore_basket" data-entity="basket-item-restore-button"><?=Loc::getMessage('SBB_BASKET_ITEM_RESTORE')?></a>
                        </p>
                        <p class="font-weight-medium mb-lg-0">
                            <a href="#" onclick="toFav({{PRODUCT_ID}})" class="text-primary element-fav {{ACT}}" data-element-id="{{PRODUCT_ID}}">{{FAV}}</a>
                        </p>
                    </div>
                </div>
                <div class="cart-item-remove">
                    <button type="button" class="btn btn-link" onclick="showHide({{ID}})">
                        <svg width="14" height="14" xmlns="http://www.w3.org/2000/svg" class="icon sprite-icons">
                            <use href="<?= SITE_TEMPLATE_PATH ?>/_nuxt/e9f276f8f2f8d76658b3ea83098ca231.svg#i-close" xlink:href="<?= SITE_TEMPLATE_PATH ?>/_nuxt/e9f276f8f2f8d76658b3ea83098ca231.svg#i-close"></use>
                        </svg>
                    </button>
                </div>
            </div>
        </div>
<!--			<div class="basket-items-list-item-notification" colspan="--><?//=$restoreColSpan?><!--">-->
<!--				<div class="basket-items-list-item-notification-inner basket-items-list-item-notification-removed" id="basket-item-height-aligner-{{ID}}">-->
<!--					{{#SHOW_LOADING}}-->
<!--						<div class="basket-items-list-item-overlay"></div>-->
<!--					{{/SHOW_LOADING}}-->
<!--					<div class="basket-items-list-item-removed-container">-->
<!--                        <div class="cart-item-body">-->
<!--                            <div class="cart-item-content">-->
<!--                                <p class="font-size-base font-weight-bold mb-lg-0">-->
<!--                                    Вы удалили товар-->
<!--                                </p>-->
<!--                                <p class="font-weight-medium mb-lg-0">-->
<!--                                    <a href="javascript:void(0)" data-entity="basket-item-restore-button">--><?//=Loc::getMessage('SBB_BASKET_ITEM_RESTORE')?><!--</a>-->
<!--                                </p>-->
<!--                                <p class="mb-0">-->
<!--                                    <a href="#" target="_self" class="text-primary">Переместить в&nbsp;избранное</a>-->
<!--                                </p>-->
<!--                            </div>-->
<!--                        </div>-->
<!--						<div>-->
<!--							--><?//=Loc::getMessage('SBB_GOOD_CAP')?><!-- <strong>{{NAME}}</strong> --><?//=Loc::getMessage('SBB_BASKET_ITEM_DELETED')?><!--.-->
<!--						</div>-->
<!--						<div class="basket-items-list-item-removed-block">-->
<!--							<a href="javascript:void(0)" data-entity="basket-item-restore-button">-->
<!--								--><?//=Loc::getMessage('SBB_BASKET_ITEM_RESTORE')?>
<!--							</a>-->
<!--							<span class="basket-items-list-item-clear-btn" data-entity="basket-item-close-restore-button"></span>-->
<!--						</div>-->
<!--					</div>-->
<!--				</div>-->
<!--			</div>-->
		{{/SHOW_RESTORE}}
		{{^SHOW_RESTORE}}
        <div class="cart-item">
            	<?
					if (in_array('PREVIEW_PICTURE', $arParams['COLUMNS_LIST']))
					{
						?>
						<div class="cart-item-img" style="margin: 10px 0 10px 10px; height: 4.4rem;">
							<img src="{{{IMAGE_URL}}}{{^IMAGE_URL}}/images/nophoto.svg{{/IMAGE_URL}}">

							<!--{{#SHOW_LABEL}}
								<div class="basket-item-label-text basket-item-label-big <?/*=$labelPositionClass*/?>">
									{{#LABEL_VALUES}}
										<div{{#HIDE_MOBILE}} class="d-none d-sm-block"{{/HIDE_MOBILE}}>
											<span title="{{NAME}}">{{NAME}}</span>
										</div>
									{{/LABEL_VALUES}}-->
								</div>
							{{/SHOW_LABEL}}

							<?
							if ($arParams['SHOW_DISCOUNT_PERCENT'] === 'Y')
							{
								?>
								{{#DISCOUNT_PRICE_PERCENT}}
									<div class="basket-item-label-ring basket-item-label-small <?=$discountPositionClass?>">
										-{{DISCOUNT_PRICE_PERCENT_FORMATED}}
									</div>
								{{/DISCOUNT_PRICE_PERCENT}}
								<?
							}
							?>

							{{#DETAIL_PAGE_URL}}
								</a>
							{{/DETAIL_PAGE_URL}}

						<?
					}
					?>
						<?
						if (isset($mobileColumns['DELETE']))
						{
							?>
							<span class="basket-item-actions-remove d-block d-md-none" data-entity="basket-item-delete"></span>
							<?
						}
						?>

						{{#NOT_AVAILABLE}}
							<div class="basket-items-list-item-warning-container">
								<div class="alert alert-warning text-center">
									<?=Loc::getMessage('SBB_BASKET_ITEM_NOT_AVAILABLE')?>.
								</div>
							</div>
						{{/NOT_AVAILABLE}}
						<!--{{#DELAYED}}
							<div class="basket-items-list-item-warning-container">
								<div class="alert alert-warning text-center">
									<?/*=Loc::getMessage('SBB_BASKET_ITEM_DELAYED')*/?>.
									<a href="javascript:void(0)" data-entity="basket-item-remove-delayed">
										<?/*=Loc::getMessage('SBB_BASKET_ITEM_REMOVE_DELAYED')*/?>
									</a>
								</div>
							</div>
						{{/DELAYED}}
						{{#WARNINGS.length}}
							<div class="basket-items-list-item-warning-container">
								<div class="alert alert-warning alert-dismissable" data-entity="basket-item-warning-node">
									<span class="close" data-entity="basket-item-warning-close">&times;</span>
										{{#WARNINGS}}
											<div data-entity="basket-item-warning-text">{{{.}}}</div>
										{{/WARNINGS}}
								</div>
							</div>
						{{/WARNINGS.length}}
						<div class="basket-item-block-properties">
							<?
							if (!empty($arParams['PRODUCT_BLOCKS_ORDER']))
							{
								foreach ($arParams['PRODUCT_BLOCKS_ORDER'] as $blockName)
								{
									switch (trim((string)$blockName))
									{
										case 'props':
											if (in_array('PROPS', $arParams['COLUMNS_LIST']))
											{
												?>
												{{#PROPS}}
													<div class="basket-item-property<?=(!isset($mobileColumns['PROPS']) ? ' d-none d-sm-block' : '')?>">
														<div class="basket-item-property-name">
															{{{NAME}}}
														</div>
														<div class="basket-item-property-value"
															data-entity="basket-item-property-value" data-property-code="{{CODE}}">
															{{{VALUE}}}
														</div>
													</div>
												{{/PROPS}}
												<?
											}

											break;
										case 'sku':
											?>
											{{#SKU_BLOCK_LIST}}
												{{#IS_IMAGE}}
													<div class="basket-item-property basket-item-property-scu-image"
														data-entity="basket-item-sku-block">
														<div class="basket-item-property-name">{{NAME}}</div>
														<div class="basket-item-property-value">
															<ul class="basket-item-scu-list">
																{{#SKU_VALUES_LIST}}
																	<li class="basket-item-scu-item{{#SELECTED}} selected{{/SELECTED}}
																		{{#NOT_AVAILABLE_OFFER}} not-available{{/NOT_AVAILABLE_OFFER}}"
																		title="{{NAME}}"
																		data-entity="basket-item-sku-field"
																		data-initial="{{#SELECTED}}true{{/SELECTED}}{{^SELECTED}}false{{/SELECTED}}"
																		data-value-id="{{VALUE_ID}}"
																		data-sku-name="{{NAME}}"
																		data-property="{{PROP_CODE}}">
																				<span class="basket-item-scu-item-inner"
																					style="background-image: url({{PICT}});"></span>
																	</li>
																{{/SKU_VALUES_LIST}}
															</ul>
														</div>
													</div>
												{{/IS_IMAGE}}

												{{^IS_IMAGE}}
													<div class="basket-item-property basket-item-property-scu-text"
														data-entity="basket-item-sku-block">
														<div class="basket-item-property-name">{{NAME}}</div>
														<div class="basket-item-property-value">
															<ul class="basket-item-scu-list">
																{{#SKU_VALUES_LIST}}
																	<li class="basket-item-scu-item{{#SELECTED}} selected{{/SELECTED}}
																		{{#NOT_AVAILABLE_OFFER}} not-available{{/NOT_AVAILABLE_OFFER}}"
																		title="{{NAME}}"
																		data-entity="basket-item-sku-field"
																		data-initial="{{#SELECTED}}true{{/SELECTED}}{{^SELECTED}}false{{/SELECTED}}"
																		data-value-id="{{VALUE_ID}}"
																		data-sku-name="{{NAME}}"
																		data-property="{{PROP_CODE}}">
																		<span class="basket-item-scu-item-inner">{{NAME}}</span>
																	</li>
																{{/SKU_VALUES_LIST}}
															</ul>
														</div>
													</div>
												{{/IS_IMAGE}}
											{{/SKU_BLOCK_LIST}}

											{{#HAS_SIMILAR_ITEMS}}
												<div class="basket-items-list-item-double" data-entity="basket-item-sku-notification">
													<div class="alert alert-info alert-dismissable text-center">
														{{#USE_FILTER}}
															<a href="javascript:void(0)"
																class="basket-items-list-item-double-anchor"
																data-entity="basket-item-show-similar-link">
														{{/USE_FILTER}}
														<?=Loc::getMessage('SBB_BASKET_ITEM_SIMILAR_P1')?>{{#USE_FILTER}}</a>{{/USE_FILTER}}
														<?=Loc::getMessage('SBB_BASKET_ITEM_SIMILAR_P2')?>
														{{SIMILAR_ITEMS_QUANTITY}} {{MEASURE_TEXT}}
														<br>
														<a href="javascript:void(0)" class="basket-items-list-item-double-anchor"
															data-entity="basket-item-merge-sku-link">
															<?=Loc::getMessage('SBB_BASKET_ITEM_SIMILAR_P3')?>
															{{TOTAL_SIMILAR_ITEMS_QUANTITY}} {{MEASURE_TEXT}}?
														</a>
													</div>
												</div>
											{{/HAS_SIMILAR_ITEMS}}
											<?
											break;
										case 'columns':
											?>
											{{#COLUMN_LIST}}
												{{#IS_IMAGE}}
													<div class="basket-item-property-custom basket-item-property-custom-photo
														{{#HIDE_MOBILE}}d-none d-sm-block{{/HIDE_MOBILE}}"
														data-entity="basket-item-property">
														<div class="basket-item-property-custom-name">{{NAME}}</div>
														<div class="basket-item-property-custom-value">
															{{#VALUE}}
																<span>
																	<img class="basket-item-custom-block-photo-item"
																		src="{{{IMAGE_SRC}}}" data-image-index="{{INDEX}}"
																		data-column-property-code="{{CODE}}">
																</span>
															{{/VALUE}}
														</div>
													</div>
												{{/IS_IMAGE}}

												{{#IS_TEXT}}
													<div class="basket-item-property-custom basket-item-property-custom-text
														{{#HIDE_MOBILE}}d-none d-sm-block{{/HIDE_MOBILE}}"
														data-entity="basket-item-property">
														<div class="basket-item-property-custom-name">{{NAME}}</div>
														<div class="basket-item-property-custom-value"
															data-column-property-code="{{CODE}}"
															data-entity="basket-item-property-column-value">
															{{VALUE}}
														</div>
													</div>
												{{/IS_TEXT}}

												{{#IS_LINK}}
													<div class="basket-item-property-custom basket-item-property-custom-text
														{{#HIDE_MOBILE}}d-none d-sm-block{{/HIDE_MOBILE}}"
														data-entity="basket-item-property">
														<div class="basket-item-property-custom-name">{{NAME}}</div>
														<div class="basket-item-property-custom-value"
															data-column-property-code="{{CODE}}"
															data-entity="basket-item-property-column-value">
															{{#VALUE}}
															{{{LINK}}}{{^IS_LAST}}<br>{{/IS_LAST}}
															{{/VALUE}}
														</div>
													</div>
												{{/IS_LINK}}
											{{/COLUMN_LIST}}
											<?
											break;
									}
								}
							}
							?>
						</div>-->
					{{#SHOW_LOADING}}
						<div class="basket-items-list-item-overlay"></div>
					{{/SHOW_LOADING}}
				</div>
			<?
			if ($usePriceInAdditionalColumn)
			{
				?>
                <div class="cart-item-body">
                    <div class="cart-item-content">
                        <p class="font-weight-medium mb-2">
                            {{#DETAIL_PAGE_URL}}
                                <a href="{{DETAIL_PAGE_URL}}" class="text-reset text-decoration-none basket-item-info-name-link">
                            {{/DETAIL_PAGE_URL}}
                                {{NAME}}
                            {{#DETAIL_PAGE_URL}}
                                </a>
                            {{/DETAIL_PAGE_URL}}
                        </p>

                    </div>

				<?
			}
			?>

                <div class="cart-item-controls">
                        <div role="group" class="b-form-spinbutton form-control d-inline-flex align-items-stretch">
                        <output style="margin: 0 auto; display: flex; align-items: center" class="basket-item-block-amount{{#NOT_AVAILABLE}} disabled{{/NOT_AVAILABLE}}" data-entity="basket-item-quantity-block">
                            <span class="basket-item-amount-btn-minus btn btn-sm border-0 rounded-0 py-0" data-entity="basket-item-quantity-minus">
                                 <svg viewBox="0 0 16 16" width="1em" height="1em" focusable="false" role="img" alt="icon" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="bi-dash b-icon bi">
                                    <g transform="translate(8 8) scale(1.25 1.25) translate(-8 -8)">
                                        <path fill-rule="evenodd" d="M3.5 8a.5.5 0 0 1 .5-.5h8a.5.5 0 0 1 0 1H4a.5.5 0 0 1-.5-.5z"></path>
                                    </g>
                                </svg>
                            </span>
                            <input style="border: none; text-align: center; outline: none; border-radius: 0;" maxlength="3" size="1px" type="tel" class="basket-item-amount-filed" data-value="{{QUANTITY}}" data-entity="basket-item-quantity-field" id="basket-item-quantity-{{ID}}" value="{{QUANTITY}}" onkeypress="return (event.charCode >= 48 && event.charCode <= 57 && /^\d{0,3}$/.test(this.value));">
                            <span class="basket-item-amount-btn-plus btn btn-sm border-0 rounded-0 py-0" data-entity="basket-item-quantity-plus">
                                <svg viewBox="0 0 16 16" width="1em" height="1em" focusable="false" role="img" alt="icon" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="bi-plus b-icon bi">
                                    <g transform="translate(8 8) scale(1.25 1.25) translate(-8 -8)">
                                        <path fill-rule="evenodd" d="M8 3.5a.5.5 0 0 1 .5.5v4a.5.5 0 0 1-.5.5H4a.5.5 0 0 1 0-1h3.5V4a.5.5 0 0 1 .5-.5z"></path>
                                        <path fill-rule="evenodd" d="M7.5 8a.5.5 0 0 1 .5-.5h4a.5.5 0 0 1 0 1H8.5V12a.5.5 0 0 1-1 0V8z"></path>
                                    </g>
                                </svg>
                            </span>

                            {{#SHOW_LOADING}}
                                <div class="basket-items-list-item-overlay"></div>
                            {{/SHOW_LOADING}}
                            </div>
                        <?
                        if ($useSumColumn)
                        {
                            ?>
                            <div class="basket-items-list-item-price<?=(!isset($mobileColumns['SUM']) ? ' d-none d-sm-block' : '')?>">
                                <div class="basket-item-block-price" style="min-width: 100px">
                                    <!--{{#SHOW_DISCOUNT_PRICE}}
                                        <div class="basket-item-price-old">
                                            <span class="basket-item-price-old-text" id="basket-item-sum-price-old-{{ID}}">
                                                {{{SUM_FULL_PRICE_FORMATED}}}
                                            </span>
                                        </div>
                                    {{/SHOW_DISCOUNT_PRICE}}-->

                                    <p class="price">
                                        <span class="basket-item-price-current-text" id="basket-item-sum-price-{{ID}}">
                                            {{{SUM_FULL_PRICE_FORMATED}}}
                                        </span>
                                    </p>


                                    <!--{{#SHOW_DISCOUNT_PRICE}}
                                        <div class="basket-item-price-difference">
                                            <?/*=Loc::getMessage('SBB_BASKET_ITEM_ECONOMY')*/?>
                                            <span id="basket-item-sum-price-difference-{{ID}}" style="white-space: nowrap;">
                                                {{{SUM_DISCOUNT_PRICE_FORMATED}}}
                                            </span>
                                        </div>
                                    {{/SHOW_DISCOUNT_PRICE}}-->
                                    {{#SHOW_LOADING}}
                                        <div class="basket-items-list-item-overlay"></div>
                                    {{/SHOW_LOADING}}
                                </div>
                            </div>
                            <?
                        }
                        ?>
                    </div>


                </div>
        <div class="cart-item-remove">
            <button type="button" class="btn btn-link" data-entity="basket-item-delete">
                <svg width="14" height="14" xmlns="http://www.w3.org/2000/svg" class="icon sprite-icons">
                    <use href="<?= SITE_TEMPLATE_PATH ?>/_nuxt/e9f276f8f2f8d76658b3ea83098ca231.svg#i-close" xlink:href="<?= SITE_TEMPLATE_PATH ?>/_nuxt/e9f276f8f2f8d76658b3ea83098ca231.svg#i-close"></use>
                </svg>
            </button>
        </div>
		{{/SHOW_RESTORE}}
    </div>
</script>