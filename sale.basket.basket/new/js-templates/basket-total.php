<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Localization\Loc;

/**
 * @var array $arParams
 */

?>
<script id="basket-total-template" type="text/html">
    <div class="mb-2 mb-md-3 px-md-3" style="padding: 0!important; margin-top: 39px">
	<? if ($arParams['HIDE_COUPON'] !== 'Y'):?>

            <div role="group" class="input-group">
                <input placeholder="Введите промокод" class="border-gray-600 bg-transparent form-control" type="text" id="__BVID__48" data-entity="basket-coupon-input">
                <span class=" basket-coupon-block-coupon-btn"></span>
                <div class="input-group-append">
                    <button type="button" class="btn btn-gray-600">
                        Применить
                    </button>
                </div>
            </div>
        </div>
        <div class="basket-coupon-alert-section mb-2 mb-md-3 px-md-3">
            <div class="basket-coupon-alert-inner">
                {{#COUPON_LIST}}
                <div class="basket-coupon-alert text-{{CLASS}} d-flex justify-content-between">
						<span class="basket-coupon-text">
							<strong>{{COUPON}}</strong> - <?=Loc::getMessage('SBB_COUPON')?> {{JS_CHECK_CODE}}
							{{#DISCOUNT_NAME}}({{DISCOUNT_NAME}}){{/DISCOUNT_NAME}}
						</span>
                    <a href="javascript:void(0)" class="close-link" data-entity="basket-coupon-delete" data-coupon="{{COUPON}}">
							<?=Loc::getMessage('SBB_DELETE')?>
						</a>
                </div>
                {{/COUPON_LIST}}
            </div>

		<?endif;?>
        </div>
        <div class="card card-white mb-30">
            <div class="card-body border-bottom border-light px-lg-3 py-4">
                <div class="px-lg-3">
                    <div class="d-flex align-items-end"><p class="font-weight-bold mb-md-4">
                            Корзина
                        </p>
                        <p class="font-size-1 ml-auto mb-4 d-none d-md-block">
                            <a href="?BasketDelete" class="text-gray-600 text-underline">
                                Очистить корзину
                            </a></p></div>
                    <table class="table table-borderless table-sm mb-4">
                        <tbody>
                        <tr>
                            <td class="px-0">
                                Всего товаров на&nbsp;сумму
                            </td>
                            <td class="text-right font-weight-medium pr-0">
                                {{{PRICE_WITHOUT_DISCOUNT_FORMATED}}}
                            </td>
                        </tr>
                        <tr>
                            <td class="px-0">
                                Скидка при оплате картой
                            </td>
                            <td class="text-right del-num pr-0">
                                - {{{DISCOUNT_SUM}}}
                            </td>
                        </tr>
                        {{^DELIV_SUMM_DELTA}}
                        <tr>
                            <td class="px-0">
                                Доставка
                            </td>
                            <td class="text-right font-weight-medium pr-0">
                                БЕСПЛАТНО
                            </td>
                        </tr>
                        {{/DELIV_SUMM_DELTA}}
                        {{#WEIGHT_FORMATED}}
                        <?=Loc::getMessage('SBB_WEIGHT')?>: {{{WEIGHT_FORMATED}}}
                        {{#SHOW_VAT}}<br>{{/SHOW_VAT}}
                        {{/WEIGHT_FORMATED}}
                        {{#SHOW_VAT}}
                        <?=Loc::getMessage('SBB_VAT')?>: {{{VAT_SUM_FORMATED}}}
                        {{/SHOW_VAT}}
                        {{#DISCOUNT_PRICE_FORMATED}}
                        <tr>
                            <td class="px-0">
                                Скидка по промокоду
                            </td>
                            <td class="text-right text-primary pr-0">
                                –{{{DISCOUNT_PRICE_FORMATED}}}
                            </td>
                        </tr>
                        {{/DISCOUNT_PRICE_FORMATED}}
                        <!--<tr>
                            <td class="px-0">
                                Доставка
                            </td>
                            <td class="text-right font-weight-medium pr-0">
                                0&nbsp;руб.
                            </td>
                        </tr>
                        <tr>
                            <td class="px-0">
                                Общий вес
                            </td>
                            <td class="text-right font-weight-medium pr-0">
                                {{{WEIGHT_FORMATED}}}кг.
                            </td>
                        </tr>-->
                        </tbody>
                        <tfoot>
                        <tr class="font-size-4 font-weight-bold">
                            <td class="px-0 pt-4">
                                Итого:
                            </td>
                            <td class="text-right pt-4 pr-0" data-entity="basket-total-price">
                                {{{PRICE_FORMATED}}}
                            </td>
                        </tr>
                        <tr>
                            <td class="px-0 pt-4"></td>
                            <td class="text-right pt-4 pr-0" style="font-size: small; padding-top: 0 !important;">
                                в т.ч. НДС
                            </td>
                        </tr>
                        </tfoot>
                    </table>
                </div>
                <!--<p class="delive_summ">
                    Скидка 5% при оплате картой онлайн
                </p>
                <p class="delive_summ">
                    Доставка в течение 48 часов
                </p>-->
                <!--{{^DELIV_SUMM_DELTA}}
                <div class="delive_summ">
                    Для вас доступна бесплатная доставка!
                </div>
                {{/DELIV_SUMM_DELTA}}-->
                {{#MIN_SUMM}}
                <div class="minimal_summ">
                    Минимальная сумма заказа {{{MIN_SUMM}}} руб.
                </div>
                {{/MIN_SUMM}}
                {{^MIN_SUMM}}
                {{#DELIV_SUMM_DELTA}}
                <div class="delive_summ">
                    До бесплатной доставки не хватает <br> всего <strong class="del-num">{{{DELIV_SUMM_DELTA}}} ₽</strong>
                </div>
                {{/DELIV_SUMM_DELTA}}
                <div class="delive_range">
                    <?php
                        $date1 = strtotime("+1 day");
                        $date2 = strtotime("+2 day");
                        $month = (int)date('m', $date2);
                    ?>
                    Доставим <span class="range_style"><?= (date('m', $date1) != date('m', $date2)) ? (int)(date('d', $date1)) . ' ' . month_verbose_rus(date('m', $date1)) . '-' . (int)(date('d', $date2)) . ' ' . month_verbose_rus($month) : (int)(date('d', $date1)) . '-' . (int)(date('d', $date2)) . ' ' . month_verbose_rus($month) ?></span>
                </div>
                <a href="#" target="_self" class="btn btn-primary btn-block" data-entity="basket-checkout-button">
                    <?=Loc::getMessage('SBB_ORDER')?>
                </a>
                {{/MIN_SUMM}}
            </div>
            <!--<div class="card-body px-lg-3 py-4">
                <div class="px-lg-3"><p class="font-weight-bold mb-md-4">
                        Бонусы к&nbsp;заказу
                    </p>
                    <ul class="list-unstyled text-gray-700 fill-gray-700">
                        <li class="d-flex align-items-center mb-3">
                            <div class="align-self-start mr-3">
                                <svg width="24" height="24" xmlns="http://www.w3.org/2000/svg" class="icon sprite-cart">
                                    <use href="<?/*= SITE_TEMPLATE_PATH */?>/_nuxt/97ab6542f6842330a9d3d644fca97bea.svg#i-delivery" xlink:href="<?/*= SITE_TEMPLATE_PATH */?>/_nuxt/97ab6542f6842330a9d3d644fca97bea.svg#i-delivery"></use>
                                </svg>
                            </div>
                            <span>
                      Бесплатная доставка
                    </span></li>
                        <li class="d-flex align-items-center mb-3">
                            <div class="align-self-start mr-3">
                                <svg width="24" height="24" xmlns="http://www.w3.org/2000/svg" class="icon sprite-cart">
                                    <use href="<?/*= SITE_TEMPLATE_PATH */?>/_nuxt/97ab6542f6842330a9d3d644fca97bea.svg#i-gift" xlink:href="<?/*= SITE_TEMPLATE_PATH */?>/_nuxt/97ab6542f6842330a9d3d644fca97bea.svg#i-gift"></use>
                                </svg>
                            </div>
                            <span>
                      Подарок
                    </span></li>
                        <li class="d-flex align-items-center mb-3">
                            <div class="align-self-start mr-3">
                                <svg width="24" height="24" xmlns="http://www.w3.org/2000/svg" class="icon sprite-cart">
                                    <use href="<?/*= SITE_TEMPLATE_PATH */?>/_nuxt/97ab6542f6842330a9d3d644fca97bea.svg#i-star" xlink:href="<?/*= SITE_TEMPLATE_PATH */?>/_nuxt/97ab6542f6842330a9d3d644fca97bea.svg#i-star"></use>
                                </svg>
                            </div>
                            <span>
                      +365&nbsp;бонусов
                    </span></li>
                        <li class="d-flex align-items-center mb-3">
                            <div class="align-self-start mr-3">
                                <svg width="24" height="24" xmlns="http://www.w3.org/2000/svg" class="icon sprite-cart">
                                    <use href="<?/*= SITE_TEMPLATE_PATH */?>/_nuxt/97ab6542f6842330a9d3d644fca97bea.svg#i-discount" xlink:href="<?/*= SITE_TEMPLATE_PATH */?>/_nuxt/97ab6542f6842330a9d3d644fca97bea.svg#i-discount"></use>
                                </svg>
                            </div>
                            <span>
                      –597&nbsp;р. скидка
                    </span></li>
                    </ul>
                    <div class="custom-control custom-checkbox b-custom-control-lg">
                        <input type="checkbox" autocomplete="off" value="true" class="custom-control-input" id="__BVID__51"><label class="custom-control-label" for="__BVID__51"><span class="font-size-1 text-gray-700 ml-2">
                    Зачислить на бонусный счёт
                  </span></label></div>
                </div>
            </div>-->
        </div>
		<?
		if ($arParams['HIDE_COUPON'] !== 'Y')
		{
			?>
			<!--<div class="basket-coupon-section">
				<div class="basket-coupon-block-field">
					<div class="basket-coupon-block-field-description">
						<?/*=Loc::getMessage('SBB_COUPON_ENTER')*/?>:
					</div>
					<div class="form">
						<div class="form-group" style="position: relative;">
							<input type="text" class="form-control" id="" placeholder="" data-entity="basket-coupon-input">
							<span class=" basket-coupon-block-coupon-btn"></span>
						</div>
					</div>

				</div>
			</div>-->
			<?
		}
		?>
		<!--<div class="basket-checkout-section">
			<div class="basket-checkout-section-inner<?/*=(($arParams['HIDE_COUPON'] == 'Y') ? ' justify-content-between' : '')*/?>">
				<div class="basket-checkout-block basket-checkout-block-total">
					<div class="basket-checkout-block-total-inner">
						<div class="basket-checkout-block-total-title"><?/*=Loc::getMessage('SBB_TOTAL')*/?>:</div>
						<div class="basket-checkout-block-total-description">
							{{#WEIGHT_FORMATED}}
								<?/*=Loc::getMessage('SBB_WEIGHT')*/?>: {{{WEIGHT_FORMATED}}}
								{{#SHOW_VAT}}<br>{{/SHOW_VAT}}
							{{/WEIGHT_FORMATED}}
							{{#SHOW_VAT}}
								<?/*=Loc::getMessage('SBB_VAT')*/?>: {{{VAT_SUM_FORMATED}}}
							{{/SHOW_VAT}}
						</div>
					</div>
				</div>

				<div class="basket-checkout-block basket-checkout-block-total-price">
					<div class="basket-checkout-block-total-price-inner">
						{{#DISCOUNT_PRICE_FORMATED}}
							<div class="basket-coupon-block-total-price-old">
								{{{PRICE_WITHOUT_DISCOUNT_FORMATED}}}
							</div>
						{{/DISCOUNT_PRICE_FORMATED}}

						<div class="basket-coupon-block-total-price-current" data-entity="basket-total-price">
							{{{PRICE_FORMATED}}}
						</div>

						{{#DISCOUNT_PRICE_FORMATED}}
							<div class="basket-coupon-block-total-price-difference">
								<?/*=Loc::getMessage('SBB_BASKET_ITEM_ECONOMY')*/?>
								<span style="white-space: nowrap;">{{{DISCOUNT_PRICE_FORMATED}}}</span>
							</div>
						{{/DISCOUNT_PRICE_FORMATED}}
					</div>
				</div>

				<div class="basket-checkout-block basket-checkout-block-btn">
					<button class="btn btn-lg btn-primary basket-btn-checkout{{#DISABLE_CHECKOUT}} disabled{{/DISABLE_CHECKOUT}}"
						data-entity="basket-checkout-button">
						<?/*=Loc::getMessage('SBB_ORDER')*/?>
					</button>
				</div>
			</div>
		</div>-->

        <div class="basket-banners">
            <div class="stock-banner stock-banner_delivery">
                <img src="/upload/static/stock-banner-delivery.svg" alt="Акция">
                <div class="stock-banner__text"><strong>БЕСПЛАТНАЯ ДОСТАВКА</strong>при заказе от 1000 р.</div>
            </div>
            <div class="stock-banner stock-banner_sale">
                <img src="/upload/static/stock-banner-sale.svg" alt="Акция">
                <div class="stock-banner__text"><strong>СКИДКА -5%</strong>при оплате картой на сайте</div>
            </div>
        </div>
</script>