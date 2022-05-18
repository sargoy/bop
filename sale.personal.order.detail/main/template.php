<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

//pr($arResult);

use Bitrix\Main\Page\Asset;

if (!empty($arResult['ERRORS']['FATAL'])){
	$component = $this->__component;
	foreach($arResult['ERRORS']['FATAL'] as $code => $error)
	{
		ShowError($error);
	}
}else{
	if (!empty($arResult['ERRORS']['NONFATAL'])){
		foreach ($arResult['ERRORS']['NONFATAL'] as $error){
			ShowError($error);
		}
	}
    ?>
    <div class="row mb-3 mt-lg-4 align-items-center">
        <div class="col-lg-4 col-12">
            <div class="row align-items-center">
                <div class="col-lg-12 col-7">
                    <a href="/my/orders/" class="btn account-backlink mb-2 d-md-none nuxt-link-active btn-link" target="_self">
                        <svg width="19" height="7" xmlns="http://www.w3.org/2000/svg" class="icon sprite-icons">
                            <use href="/local/templates/new/_nuxt/e9f276f8f2f8d76658b3ea83098ca231.svg#i-arrow-backlink" xlink:href="/local/templates/new/_nuxt/e9f276f8f2f8d76658b3ea83098ca231.svg#i-arrow-backlink"></use>
                        </svg>
                        <span class="caption">
                            Заказ
                            <span class="font-weight-medium text-primary">
                                №&nbsp;<?=$arResult['ID']?>
                            </span>
                        </span>
                    </a>
                    <p class="mb-2 d-none d-md-block">
                        Заказ №&nbsp;<?=$arResult['ID']?>
                    </p>
                </div>
                <div class="text-right text-lg-left col-lg-12 col-5">
                    <p class="font-weight-light text-gray-500 mb-2">
                        от&nbsp;<?=date('d.m.Y', strtotime($arResult['DATE_INSERT']));?>
                    </p>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-xl-5 col-12">
            <div class="row align-items-center">
                <div class="col-lg-12 col-5">
                    <p class="mb-lg-2">
                        Сумма:
                        <span class="font-weight-medium">
                            <?=zlojPriceFormat($arResult['PRICE'], false);?>
                        </span>
                    </p>
                </div>
                <div class="text-right text-lg-left col-lg-12 col-7">
                    <p class="mb-lg-2">
	                    <?=zlojStatusFormat($arResult['STATUS_ID']);?>
                    </p>
                </div>
            </div>
        </div>
        <div class="col-md-7 col-lg-4 col-xl-3 col-6">
            <div class="mb-2">
                <a href="/my/orders/?ID=<?=$arResult['ID']?>&amp;COPY_ORDER=Y" class="btn d-flex flex-center px-1 line-height-120 btn-outline-primary btn-block">
                    <svg width="20" height="20" xmlns="http://www.w3.org/2000/svg" class="mr-2 my-n1 icon sprite-icons">
                        <use href="/local/templates/new/_nuxt/e9f276f8f2f8d76658b3ea83098ca231.svg#i-refresh" xlink:href="/local/templates/new/_nuxt/e9f276f8f2f8d76658b3ea83098ca231.svg#i-refresh"></use>
                    </svg>
                    Повторить заказ
                </a>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-6 col-md-12 mb-2">
	        <?if ($arResult["CAN_CANCEL"] === "Y" and $arResult['STATUS_ID'] != 'C'):?>
                <a data-toggle="modal" data-target="#cancelModal"
                   class="btn d-flex flex-center px-1 line-height-120 btn-outline-primary btn-block btn-order__cancel btn-order">
                    Отменить
                </a>
		    <?endif;?>
        </div>
        <div class="col-lg-6 col-md-12 mb-2">

	        <?if ($arResult['IS_ALLOW_PAY'] == 'Y' && $arResult['PAY_SYSTEM']['IS_CASH'] != 'Y' && $arResult['PAYED'] != 'Y' && $arResult['STATUS_ID'] != 'R' && $arResult['STATUS_ID'] != 'RO' && $arResult['STATUS_ID'] != 'F'):?>
                <form action="/order/payment/?ORDER_ID=<?=$arResult['ID']?>" method="post">
                    <input name="ready_to_pay" value="1" type="hidden">
                    <input name="BuyButton" value="Оплатить" type="hidden">
                    <button type="submit" class="btn d-flex flex-center px-1 line-height-120 btn-primary btn-block btn-order__payment btn-order">
                        Оплатить заказ
                    </button>
                </form>
            <?elseif($arResult['PAYED'] == 'Y' && $arResult['STATUS_ID'] != 'C'):?>
                <div class="row align-items-center justify-content-center h-100">
                    <span class="font-weight-medium text-success">
                        Заказ оплачен
                    </span>
                </div>
            <?endif;?>
        </div>
    </div>
    <div class="mb-3 mb-lg-5">
        <?
        foreach($arResult['BASKET'] as $arItem):
	        if($arResult['IBLOCK_ELEMENTS'][$arItem['PRODUCT_ID']]["PREVIEW_PICTURE"]) {
		        $file = CFile::ResizeImageGet($arResult['IBLOCK_ELEMENTS'][$arItem['PRODUCT_ID']]["PREVIEW_PICTURE"], ['width' => 400, 'height' => 400], BX_RESIZE_IMAGE_PROPORTIONAL, true);
	        }else{
		        $file = [
			        'src' => '/images/nophoto.svg'
		        ];
	        }
	        if(!empty($arResult['IBLOCK_ELEMENTS'][$arItem['PRODUCT_ID']])){
	            $name = $arResult['IBLOCK_ELEMENTS'][$arItem['PRODUCT_ID']]['NAME'];
		        $rating = intval($arItem['PROPERTY_rating_VALUE']);
		        $url = $arResult['IBLOCK_ELEMENTS'][$arItem['PRODUCT_ID']]['DETAIL_PAGE_URL'];
		        $cart = $arResult['IBLOCK_ELEMENTS'][$arItem['PRODUCT_ID']]['ID'];
	        }else{
	            $name = $arItem['NAME'];
		        $rating = false;
		        $url = '';
		        $cart = false;
	        }
	        ?>
            <div class="card card-order-item mb-3 mb-lg-2">
                <div class="row mx-n2">
                    <div class="px-2 pr-lg-4 col-lg-2 col-3">
                        <div class="card-img-wrapper embed-responsive embed-responsive-1by1">
                            <div class="embed-responsive-item d-flex">
                                <img src="<?=$file['src']?>" class="card-img">
                            </div>
                        </div>
                        <div class="text-center mt-1 d-lg-none">
	                        <?if($rating !== false):?>
                                <div class="card-rating d-inline-flex">
			                        <?
			                        for($i = 1; $i <= 5; $i++) {
				                        if($rating >= $i):?>
                                            <svg width="11" height="11" xmlns="http://www.w3.org/2000/svg" class="icon-rating icon-rating-full icon sprite-icons">
                                                <use href="/local/templates/new/_nuxt/08898a81d88ca4fa3db9dc44bfc54562.svg#i-rating" xlink:href="/local/templates/new/_nuxt/08898a81d88ca4fa3db9dc44bfc54562.svg#i-rating"></use>
                                            </svg>
				                        <?else:?>
                                            <svg width="11" height="11" xmlns="http://www.w3.org/2000/svg" class="icon-rating icon sprite-icons">
                                                <use href="/local/templates/new/_nuxt/08898a81d88ca4fa3db9dc44bfc54562.svg#i-rating" xlink:href="/local/templates/new/_nuxt/08898a81d88ca4fa3db9dc44bfc54562.svg#i-rating"></use>
                                            </svg>
				                        <?
				                        endif;
			                        }
			                        ?>
                                </div>
	                        <?endif;?>
                        </div>
                    </div>
                    <div class="px-2 pl-lg-0 col-lg-10 col-9">
                        <div class="card-body">
                            <div class="row h-100 align-items-center">
                                <div class="mb-2 mb-lg-auto col-lg-5 col-12">
	                                <?if($rating !== false):?>
                                        <div class="card-rating d-none d-lg-flex">
			                                <?
			                                for($i = 1; $i <= 5; $i++) {
				                                if($rating >= $i):?>
                                                    <svg width="11" height="11" xmlns="http://www.w3.org/2000/svg" class="icon-rating icon-rating-full icon sprite-icons">
                                                        <use href="/local/templates/new/_nuxt/08898a81d88ca4fa3db9dc44bfc54562.svg#i-rating" xlink:href="/local/templates/new/_nuxt/08898a81d88ca4fa3db9dc44bfc54562.svg#i-rating"></use>
                                                    </svg>
				                                <?else:?>
                                                    <svg width="11" height="11" xmlns="http://www.w3.org/2000/svg" class="icon-rating icon sprite-icons">
                                                        <use href="/local/templates/new/_nuxt/08898a81d88ca4fa3db9dc44bfc54562.svg#i-rating" xlink:href="/local/templates/new/_nuxt/08898a81d88ca4fa3db9dc44bfc54562.svg#i-rating"></use>
                                                    </svg>
				                                <?
				                                endif;
			                                }
			                                ?>
                                        </div>
	                                <?endif;?>
                                    <p class="font-size-lg-2 font-weight-medium mb-0">
	                                    <?if($url):?>
                                            <a href="<?=$url?>" class="text-reset text-decoration-none" target="_self">
	                                            <?=$name?>
                                            </a>
                                        <?else:?>
		                                    <?=$name?>
	                                    <?endif;?>

                                    </p>
                                </div>
                                <div class="col-lg-4 col-12">
                                    <div class="d-flex flex-column flex-lg-column-reverse text-gray-700">
                                        <p class="mb-2 mb-lg-0">
                                            Количество:
                                            <span class="font-size-2 font-weight-medium text-secondary">
                                                <?=$arItem['QUANTITY']?>
                                            </span>
                                        </p>
                                        <p class="mb-2">
                                            Цена:
                                            <span class="font-size-2 font-weight-medium text-secondary">
                                                <?=zlojPriceFormat($arItem['PRICE'], false);?>
                                            </span>
                                        </p>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-12">
                                    <div class="row no-gutters align-items-center">
                                        <div class="text-gray-700 text-lg-center col-lg-12 order-lg-2 col-6">
                                            <?if($url):?>
                                                <a href="<?=$url?>" class="text-reset text-decoration-none" target="_self">
                                                    Оставить отзыв
                                                </a>
                                            <?endif;?>
                                        </div>
                                        <div class="mb-lg-2 col-lg-12 order-lg-1 col-6">
                                            <?if($cart):?>
                                                <div class="btn-cart element-in-basket" style="display: none" data-element-id="<?=$cart?>">
                                                    <div role="group" tabindex="-1" class="b-form-spinbutton form-control d-flex align-items-stretch" lang="ru">
                                                        <button tabindex="-1" type="button" aria-label="Decrement" aria-keyshortcuts="ArrowDown" class="btn btn-sm btn-cart-action border-0 rounded-0 py-0" data-element-id="<?=$cart?>" data-increment="-1">
                                                            <div>
                                                                <svg viewBox="0 0 16 16" width="1em" height="1em" focusable="false" role="img" alt="icon" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="bi-dash b-icon bi">
                                                                    <g transform="translate(8 8) scale(1.25 1.25) translate(-8 -8)">
                                                                        <path fill-rule="evenodd" d="M3.5 8a.5.5 0 0 1 .5-.5h8a.5.5 0 0 1 0 1H4a.5.5 0 0 1-.5-.5z"></path>
                                                                    </g>
                                                                </svg>
                                                            </div>
                                                        </button>
                                                        <output dir="ltr" role="spinbutton" tabindex="0" aria-live="off" class="flex-grow-1 align-self-center border-left border-right" data-element-id="<?=$cart?>">
                                                            <bdi>0</bdi>
                                                        </output>
                                                        <button tabindex="-1" type="button" aria-label="Increment" aria-keyshortcuts="ArrowUp" class="btn btn-sm btn-cart-action border-0 rounded-0 py-0" data-element-id="<?=$cart?>" data-increment="1">
                                                            <div>
                                                                <svg viewBox="0 0 16 16" width="1em" height="1em" focusable="false" role="img" alt="icon" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="bi-plus b-icon bi">
                                                                    <g transform="translate(8 8) scale(1.25 1.25) translate(-8 -8)">
                                                                        <path fill-rule="evenodd" d="M8 3.5a.5.5 0 0 1 .5.5v4a.5.5 0 0 1-.5.5H4a.5.5 0 0 1 0-1h3.5V4a.5.5 0 0 1 .5-.5z"></path>
                                                                        <path fill-rule="evenodd" d="M7.5 8a.5.5 0 0 1 .5-.5h4a.5.5 0 0 1 0 1H8.5V12a.5.5 0 0 1-1 0V8z"></path>
                                                                    </g>
                                                                </svg>
                                                            </div>
                                                        </button>
                                                    </div>
                                                </div>
                                                <div class="flex-fill element-basket" data-element-id="<?=$cart?>">
                                                    <button type="button" class="btn btn-cart btn-primary btn-block btn-cart-action" data-element-id="<?=$cart?>" data-increment="1">
                                                        <svg width="22" height="20" xmlns="http://www.w3.org/2000/svg" class="mr-3 my-n1 d-none d-xl-inline-block icon sprite-icons">
                                                            <use href="/local/templates/new/_nuxt/08898a81d88ca4fa3db9dc44bfc54562.svg#i-cart" xlink:href="/local/templates/new/_nuxt/08898a81d88ca4fa3db9dc44bfc54562.svg#i-cart"></use>
                                                        </svg>
                                                        <span class="caption">В корзину</span>
                                                    </button>
                                                </div>
                                            <?endif;?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-img-wrapper"></div>
            </div>
        <?endforeach;?>
    </div>
    <?
}
//pr($arResult);
?>

<?if ($arResult["CAN_CANCEL"] === "Y" and $arResult['STATUS_ID'] != 'C'):?>
    <div class="modal fade" id="cancelModal" tabindex="-1" role="dialog" aria-labelledby="cancelModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="cancelModalLabel">
                        <img src="/images/icon-order-cancellation.svg">
                    </h5>
                </div>
                <div class="modal-body">
                    Вы действительно хотите<br> отменить заказ?
                </div>
                <div class="modal-footer modal-footer-cancel">
                    <form method="post" action="/my/orders/detail/<?=$arResult["ID"]?>/?action=del">
                        <input type="hidden" name="CANCEL" value="Y">
                        <?=bitrix_sessid_post()?>
                        <input type="hidden" name="ID" value="<?=$arResult["ID"]?>">
                        <button type="button" class="btn btn-outline-primary" data-dismiss="modal">Не отменять</button>
                        <button type="submit" class="btn btn-outline-primary">Отменить</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
<?endif;?>