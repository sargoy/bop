<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();
/**
 * @global CMain $APPLICATION
 * @var array $arParams
 * @var array $arResult
 * @var CatalogSectionComponent $component
 * @var CBitrixComponentTemplate $this
 * @var string $templateName
 * @var string $componentPath
 * @var string $templateFolder
 */

?>
<div class="row">
	<div class="col-md-7 col-lg-8">
		<div class="row mb-3 mb-md-4 mb-lg-5 align-items-center">
			<div class="col-lg-8 col-xl-7 col-6">
				<div class="reviews-summary">
					<p class="reviews-count">
						<?=zlojPriceFrom($arResult['REVIEWS']['CNT']['ALL'], -1, '', false, ['<span class="text-primary">', '</span>']);?> о товаре
					</p>
					<div class="card-rating">
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
						<span class="rating-caption">
                            <?=zlojPriceFrom($rating, -4);?>
                        </span>
					</div>
				</div>
			</div>
			<div class="align-self-start col-lg-4 col-xl-3 col-6">
				<?if($USER->GetID()):?>
                    <button type="button" class="btn btn-outline-primary btn-block" data-toggle="modal" data-target="#modalReview">
                        Оставить отзыв
                    </button>
                <?endif;?>
			</div>
		</div>
		<div class="d-md-none mb-3">
			<div class="card card-review-filter">
				<div class="card-header">
					Показать отзывы с&nbsp;оценкой
				</div>
				<div class="card-body first-filter<?if($fullReviews):?> fast-rewiews-filter<?endif;?>">
					<?for($n = 5; $n >= 1; $n --):?>
						<div class="card-rating mb-2">
							<?
							for($i = 1; $i <= 5; $i++) {
								if($arResult['REVIEWS']['CNT'][$n] >= $i):?>
									<svg width="14" height="14" xmlns="http://www.w3.org/2000/svg" class="icon-rating icon-rating-full icon sprite-icons">
										<use href="/local/templates/new/_nuxt/08898a81d88ca4fa3db9dc44bfc54562.svg#i-rating" xlink:href="/local/templates/new/_nuxt/08898a81d88ca4fa3db9dc44bfc54562.svg#i-rating"></use>
									</svg>
								<?else:?>
									<svg width="14" height="14" xmlns="http://www.w3.org/2000/svg" class="icon-rating icon sprite-icons">
										<use href="/local/templates/new/_nuxt/08898a81d88ca4fa3db9dc44bfc54562.svg#i-rating" xlink:href="/local/templates/new/_nuxt/08898a81d88ca4fa3db9dc44bfc54562.svg#i-rating"></use>
									</svg>
								<?
								endif;
							}
							?>
							<?if($arResult['REVIEWS']['CNT'][$n]):
								$u = (!$fullReviews ? $arResult['DETAIL_PAGE_URL'].'reviews/' : '').'#'.$n.'star';
                                ?>
								<a data-href="#<?=$n?>star" href="<?=$u?>" class="rating-caption fast-filter-rating" data-rating="<?=$n?>">
									<?=zlojPriceFrom($arResult['REVIEWS']['CNT'][$n], -1);?>
								</a>
							<?else:?>
								<span class="rating-caption"></span>
							<?endif;?>
						</div>
					<?endfor;?>
				</div>
			</div>
		</div>
		<?
        $c = 0;
        foreach ($arResult['REVIEWS']['ITEMS'] as $arItem):
            $c ++;
            if(!$fullReviews and $c > 3):
                ?>
                <div class="row">
                    <div class="col-12">
                        <a type="button" class="btn btn-outline-primary btn-block" href="<?=$arResult['DETAIL_PAGE_URL'].'reviews/'?>">
                            Смотреть все отзывы
                        </a>
                    </div>
                </div>
                <?
                break;
            endif;
			$name = 'Гость';
			$photo = $photoAlt = '';
			if($arItem['UF_USER'] and $arResult['USERS'][$arItem['UF_USER']]){
				$name = trim(implode(' ', [
					$arResult['USERS'][$arItem['UF_USER']]['LAST_NAME'],
					$arResult['USERS'][$arItem['UF_USER']]['NAME'],
					$arResult['USERS'][$arItem['UF_USER']]['SECOND_NAME']
				]));
				if(!$name){
					$name = $arResult['USERS'][$arItem['UF_USER']]['LOGIN'];
				}
				if($arResult['USERS'][$arItem['UF_USER']]['PERSONAL_PHOTO']){
					$file = CFile::ResizeImageGet($arResult['USERS'][$arItem['UF_USER']]['PERSONAL_PHOTO'], array('width'=>200, 'height'=>200), BX_RESIZE_IMAGE_EXACT, true);
					$photo = $file['src'];
				}
				if(!$photo){
					$arName = preg_split('/[\s]+/', $name, -1, PREG_SPLIT_NO_EMPTY);
					if(count($arName) == 1){
						$photoAlt = substr($arName, 0, 2);
					}else{
						$i = 0;
						foreach ($arName as $item){
							$i ++;
							if($i > 2){
								break;
							}
							$photoAlt .= substr($item, 0, 1);
						}
					}
					$photoAlt = ToUpper($photoAlt);
				}
			}
			$rating = ceil($arItem['UF_RATING']);
			$comments = count($arItem['COMMENTS']);
			?>
			<div class="product-review class<?=$rating?>star">
				<div class="userpic d-none d-lg-flex">
					<?if($photo):?>
						<img src="<?=$photo;?>" alt="" class="card-img">
					<?else:?>
						<div class="card-img">
                            <?=$photoAlt?>
						</div>
					<?endif;?>
				</div>
				<div class="review-content" itemprop="review" itemscope itemtype="https://schema.org/Review">
					<div class="d-flex align-items-center mb-3 mb-lg-4">
						<div class="userpic d-lg-none">
							<?if($photo):?>
								<img itemprop="image" src="<?=$photo;?>" alt="" class="card-img">
							<?else:?>
								<div class="card-img">
                                    <span itemprop="name"><?=$photoAlt?></span>
								</div>
							<?endif;?>
						</div>
						<div class="mr-30">
							<p class="font-weight-medium mb-2">
                                <span itemprop="author"><?=$name?></span>
							</p>
							<p class="font-size-1 text-dark mb-0">
                                <meta itemprop="datePublished" content="<?=$arItem['UF_DATE']?>"><?=$arItem['UF_DATE']->format('d.m.Y');?>
							</p>
						</div>
						<div class="card-rating" itemprop="reviewRating" itemscope itemtype="https://schema.org/Rating">

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
							<span class="rating-caption">
                                <?=zlojPriceFrom($rating, -4);?>
                            </span>
						</div>
					</div>
					<?if($arItem['UF_PLUS']):?>
						<p class="font-weight-medium mb-2">
							Достоинства
						</p>
						<div class="mb-4">
							<span itemprop="reviewBody"><?=zlojFormatP($arItem['UF_PLUS']);?></span>
						</div>
					<?endif;?>
					<?if($arItem['UF_MINUS']):?>
						<p class="font-weight-medium mb-2">
							Недостатки
						</p>
						<div class="mb-4">
                            <span itemprop="reviewBody"><?=zlojFormatP($arItem['UF_MINUS']);?></span>
						</div>
					<?endif;?>
					<p class="font-weight-medium mb-2">
						Комментарий
					</p>
					<div class="mb-4">
                        <span itemprop="reviewBody"><?=zlojFormatP($arItem['UF_TEXT']);?></span>
					</div>
					<div class="row align-items-center">
						<div class="col-md-6">
							<?if($comments):?>
								<a href="#" target="_self" class="font-weight-medium review-comments-open" data-review-id="<?=$arItem['ID']?>">
									<?=zlojPriceFrom($comments, -3)?>
								</a>
							<?endif;?>
						</div>
						<div class="text-md-right col-md-6">
                            <?if(false and $USER->GetID()):?>
                                <button type="button" class="btn btn-outline-primary review-comments-form-open" data-review-id="<?=$arItem['ID']?>" data-toggle="1">
                                    <?if($fullReviews):?>Оставить комментарий<?else:?>Комментировать<?endif;?>
                                </button>
                            <?endif;?>
						</div>
					</div>
					<?if(false and $USER->GetID()):?>
                        <form class="review-comments-form" style="display: none" data-review-id="<?=$arItem['ID']?>">
                            <fieldset class="form-group my-4">
                                <div tabindex="-1" role="group" class="bv-no-focus-ring">
                                    <textarea placeholder="Ваш комментарий" rows="3" class="form-control" wrap="soft"></textarea>
                                </div>
                            </fieldset>
                            <div class="text-right">
                                <button type="submit" class="btn btn-outline-primary">
                                    Отправить
                                </button>
                            </div>
                        </form>
					<?endif;?>
					<div class="mt-4">
						<?foreach ($arItem['COMMENTS'] as $arComment):
							$name = 'Гость';
							$photo = $photoAlt = '';
							if($arComment['UF_USER'] and $arResult['USERS'][$arComment['UF_USER']]){
								$name = trim(implode(' ', [
									$arResult['USERS'][$arComment['UF_USER']]['LAST_NAME'],
									$arResult['USERS'][$arComment['UF_USER']]['NAME'],
									$arResult['USERS'][$arComment['UF_USER']]['SECOND_NAME']
								]));
								if(!$name){
									$name = $arResult['USERS'][$arComment['UF_USER']]['LOGIN'];
								}
								if($arResult['USERS'][$arComment['UF_USER']]['PERSONAL_PHOTO']){
									$file = CFile::ResizeImageGet($arResult['USERS'][$arComment['UF_USER']]['PERSONAL_PHOTO'], array('width'=>200, 'height'=>200), BX_RESIZE_IMAGE_EXACT, true);
									$photo = $file['src'];
								}
								if(!$photo){
									$arName = preg_split('/[\s]+/', $name, -1, PREG_SPLIT_NO_EMPTY);
									if(count($arName) == 1){
										$photoAlt = substr($arName, 0, 2);
									}else{
										$i = 0;
										foreach ($arName as $item){
											$i ++;
											if($i > 2){
												break;
											}
											$photoAlt .= substr($item, 0, 1);
										}
									}
									$photoAlt = ToUpper($photoAlt);
								}
							}
							?>
							<div class="product-review mb-3" style="display: none" data-review-id="<?=$arItem['ID']?>">
								<div class="userpic d-none d-lg-flex">
									<?if($photo):?>
                                        <img src="<?=$photo;?>" alt="" class="card-img">
									<?else:?>
                                        <div class="card-img">
											<?=$photoAlt?>
                                        </div>
									<?endif;?>
                                </div>
								<div class="review-content" itemprop="review" itemscope itemtype="https://schema.org/Review">
									<div class="d-flex align-items-center mb-3 mb-lg-4">
										<div class="userpic d-lg-none">
											<?if($photo):?>
                                                <img itemprop="image" src="<?=$photo;?>" alt="" class="card-img">
											<?else:?>
                                                <div class="card-img">
                                                    <span itemprop="name"><?=$photoAlt?></span>
                                                </div>
											<?endif;?>
										</div>
										<div class="mr-30">
											<p class="font-weight-medium mb-2">
                                                <span itemprop="author"><?=$name?></span>
											</p>
											<p class="font-size-1 text-dark mb-0"></p>
										</div>
									</div>
									<div class="mb-3">
										<?=zlojFormatP($arComment['UF_COMMENT']);?>
                                        <?if($USER->GetID()):?>
                                            <a href="#" target="_self" class="font-weight-medium review-comments-form-open" data-review-id="<?=$arItem['ID']?>">
                                                Ответить
                                            </a>
                                        <?endif;?>
									</div>
								</div>
							</div>
						<?endforeach;?>
					</div>
				</div>
			</div>
		<?endforeach;?>
	</div>
	<div class="d-none d-md-block col-md-5 col-lg-4">
        <?if($arResult['REVIEWS']['CNT']['ALL']):?>
            <div class="card card-review-filter">
                <div class="card-header">
                    Показать отзывы с&nbsp;оценкой
                </div>
                <div class="card-body<?if($fullReviews):?> fast-rewiews-filter<?endif;?>">
                    <?for($n = 5; $n >= 1; $n --):?>
                        <div class="card-rating mb-2">
                            <?
                            for($i = 1; $i <= 5; $i++) {
                                if($n >= $i):?>
                                    <svg width="14" height="14" xmlns="http://www.w3.org/2000/svg" class="icon-rating icon-rating-full icon sprite-icons">
                                        <use href="/local/templates/new/_nuxt/08898a81d88ca4fa3db9dc44bfc54562.svg#i-rating" xlink:href="/local/templates/new/_nuxt/08898a81d88ca4fa3db9dc44bfc54562.svg#i-rating"></use>
                                    </svg>
                                <?else:?>
                                    <svg width="14" height="14" xmlns="http://www.w3.org/2000/svg" class="icon-rating icon sprite-icons">
                                        <use href="/local/templates/new/_nuxt/08898a81d88ca4fa3db9dc44bfc54562.svg#i-rating" xlink:href="/local/templates/new/_nuxt/08898a81d88ca4fa3db9dc44bfc54562.svg#i-rating"></use>
                                    </svg>
                                <?
                                endif;
                            }
                            ?>
                            <?if($arResult['REVIEWS']['CNT'][$n]):
	                            $u = (!$fullReviews ? $arResult['DETAIL_PAGE_URL'].'reviews/' : '').'#'.$n.'star';
	                            ?>
                                <a href="<?=$u?>" class="rating-caption fast-filter-rating" data-rating="<?=$n?>">
                                    <?=zlojPriceFrom($arResult['REVIEWS']['CNT'][$n], -1);?>
                                </a>
                            <?else:?>
                                <span class="rating-caption"></span>
                            <?endif;?>
                        </div>
                    <?endfor;?>
                </div>
            </div>
        <?endif;?>
	</div>
</div>
<?if($USER->GetID()):?>
    <div id="modalReview" role="dialog" class="modal fade" aria-hidden="true">
        <div class="modal-dialog modal-md">
            <span tabindex="0"></span>
            <div tabindex="-1" class="modal-content">
                <header class="modal-header">
                    <p class="flex-fill text-left mb-0">
                        Мой отзыв о&nbsp;товаре
                    </p>
                    <button type="button" aria-label="Close" class="close">
                        <svg width="14" height="14" xmlns="http://www.w3.org/2000/svg" class="icon sprite-icons">
                            <use href="/local/templates/new/_nuxt/e9f276f8f2f8d76658b3ea83098ca231.svg#i-close" xlink:href="/local/templates/new/_nuxt/e9f276f8f2f8d76658b3ea83098ca231.svg#i-close"></use>
                        </svg>
                    </button>
                </header>
                <div class="modal-body">
                    <form class="" id="form-rewiew-new">
                        <input type="hidden" name="element" value="<?=$arResult['ID']?>">
                        <fieldset class="form-group mb-4">
                            <legend tabindex="-1" class="bv-no-focus-ring col-form-label pt-0 font-weight-medium">
                                Общая оценка
                            </legend>
                            <div tabindex="-1" role="group" class="bv-no-focus-ring">
                                <div role="radiogroup" tabindex="-1" class="card-rating btn-group-toggle btn-group bv-no-focus-ring custom-styled-radio">
                                    <?for($i = 1; $i <= 5; $i ++):?>
                                        <label class="btn btn-link" data-value="<?=$i?>">
                                            <input type="radio" autocomplete="off" class="" value="<?=$i?>" name="rating">
                                            <svg width="24" height="24" xmlns="http://www.w3.org/2000/svg" class="icon-rating icon sprite-icons">
                                                <use href="/local/templates/new/_nuxt/e9f276f8f2f8d76658b3ea83098ca231.svg#i-rating" xlink:href="/local/templates/new/_nuxt/e9f276f8f2f8d76658b3ea83098ca231.svg#i-rating"></use>
                                            </svg>
                                        </label>
                                    <?endfor;?>
                                </div>
                            </div>
                        </fieldset>
                        <fieldset class="form-group">
                            <div tabindex="-1" role="group" class="bv-no-focus-ring">
                                <textarea name="plus" placeholder="Достоинства" rows="3" class="form-control" wrap="soft"></textarea>
                            </div>
                        </fieldset>
                        <fieldset class="form-group">
                            <div tabindex="-1" role="group" class="bv-no-focus-ring">
                                <textarea name="minus" placeholder="Недостатки" rows="3" class="form-control" wrap="soft"></textarea>
                            </div>
                        </fieldset>
                        <fieldset class="form-group mb-4">
                            <div tabindex="-1" role="group" class="bv-no-focus-ring">
                                <textarea name="text" placeholder="Комментарий (заполните обязательно)" rows="3" class="form-control" wrap="soft" required></textarea>
                            </div>
                        </fieldset>
                        <button type="submit" class="btn btn-primary">
                            Отправить отзыв
                        </button>
                    </form>
                </div>
            </div>
            <span tabindex="0"></span>
        </div>
    </div>
<?endif;?>
<?
//pr($arResult);
?>

