<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<div>
	<?if(empty($arResult['ORDERS'])):?>
        <div class="container empty-basket">
            <div class="empty-basket__icon">
                <img alt="Пустая корзина" src="emptyorders.svg">
            </div>
            <h1 class="empty-basket__heading">Ваш список заказов пуст</h1>
            <p class="empty-basket__text">
                Начните покупки на bop.ru.
                <br>
                После оформления заказ отобразится тут.</p>
            <a class="empty-basket__btn" href="/catalog/">Начать покупки</a>
        </div>
	<?else:?>
        <div id="ajax-load-orders-wrap">
			<?
			foreach ($arResult['ORDERS'] as $arOrder):
				//pr($arOrder);
				?>
                <div class="card card-rounded p-2 py-lg-1 mb-2">
                    <div class="card-body p-0 p-lg-3">
                        <div class="row row-cols-9 align-items-center">
                            <div class="col-xl-5">
                                <div class="row mx-n2 mb-3 mb-xl-0">
                                    <div class="px-2 col-md-5 col-lg-6 col-6">
                                        <p class="mb-1">
                                            Заказ
                                            <a href="/my/orders/detail/<?=$arOrder['ORDER']['ID']?>/" target="_self" class="font-weight-medium">
                                                № <?=$arOrder['ORDER']['ID']?>
                                            </a>
                                        </p>
                                        <p class="font-weight-light text-gray-500 mb-0">
                                            от <?=date('d.m.Y', strtotime($arOrder['ORDER']['DATE_INSERT']));?>
                                        </p>
                                    </div>
                                    <div class="text-right text-xl-left px-2 col-md-7 col-lg-6 col-6">
                                        <p class="mb-1">
                                            Сумма:
                                            <span class="font-weight-medium"><?=zlojPriceFormat($arOrder['ORDER']['PRICE'], false);?></span>
                                        </p>
                                        <p class="mb-0">
	                                        <?=zlojStatusFormat($arOrder['ORDER']['STATUS_ID']);?>
                                            <?/*
                                            Баллов за покупку:
                                            <span class="font-weight-medium text-primary">0</span>
                                            */?>
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-4">
                                <div class="row mx-n2">
                                    <div class="px-2 col-6">
                                        <a href="/my/orders/?ID=<?=$arOrder['ORDER']['ID']?>&amp;COPY_ORDER=Y" class="btn d-flex flex-center px-1 line-height-120 btn-outline-primary btn-block">
                                            <svg width="20" height="20" xmlns="http://www.w3.org/2000/svg" class="mr-2 my-n1 d-md-none d-lg-inline-block icon sprite-icons">
                                                <use href="/local/templates/new/_nuxt/e9f276f8f2f8d76658b3ea83098ca231.svg#i-refresh" xlink:href="/local/templates/new/_nuxt/e9f276f8f2f8d76658b3ea83098ca231.svg#i-refresh"></use>
                                            </svg>
                                            Повторить заказ
                                        </a>
                                    </div>
                                    <div class="px-2 col-6">
                                        <a href="/my/orders/detail/<?=$arOrder['ORDER']['ID']?>/" target="_self" class="btn line-height-120 btn-primary btn-block">
                                            Детали заказа
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
			<?endforeach;?>
        </div>
		<?=$arResult['NAV_STRING'];?>
	<?endif;?>
</div>