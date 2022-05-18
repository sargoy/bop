<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
//pr($arResult);
if(count($arResult['rows'])):
	?>
	<div class="container">
		<div class="swiper swiper-reviews mb-5">
			<p class="section-title">Отзывы</p>
			<div class="row">
				<div class="col-md-12 offset-md-0 col-10 offset-1">
					<div class="swiper-container">
						<div class="swiper-wrapper">
							<?foreach ($arResult['rows'] as $arItem):
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
								?>
								<div class="swiper-slide">
									<div class="card card-review">
                                        <?if($photo):?>
										    <img src="<?=$photo;?>" class="card-img">
                                        <?else:?>
                                            <div class="card-img">
                                                <?=$photoAlt?>
                                            </div>
                                        <?endif;?>
										<div class="card-body">
											<div class="card-rating">
												<?for($i = 1; $i <= 5; $i ++):
													if($rating >= $i):?>
														<svg width="11" height="11" xmlns="http://www.w3.org/2000/svg" class="icon-rating icon-rating-full icon sprite-icons">
															<use href="/local/templates/new/_nuxt/08898a81d88ca4fa3db9dc44bfc54562.svg#i-rating" xlink:href="/local/templates/new/_nuxt/08898a81d88ca4fa3db9dc44bfc54562.svg#i-rating"></use>
														</svg>
													<?else:?>
														<svg width="11" height="11" xmlns="http://www.w3.org/2000/svg" class="icon-rating icon sprite-icons">
															<use href="/local/templates/new/_nuxt/08898a81d88ca4fa3db9dc44bfc54562.svg#i-rating" xlink:href="/local/templates/new/_nuxt/08898a81d88ca4fa3db9dc44bfc54562.svg#i-rating"></use>
														</svg>
													<?endif;?>
												<?endfor;?>
											</div>
											<p class="font-size-3 font-weight-medium mb-1">
												<?=$name?>
											</p>
											<p class="mb-0">
												<?=$arItem['UF_TEXT'];?>
											</p>
										</div>
									</div>
								</div>
							<?endforeach;?>
						</div>
						<div class="swiper-pagination swiper-reviews-pagination"></div>
					</div>
					<div class="swiper-nav swiper-button-prev d-md-none"></div>
					<div class="swiper-nav swiper-button-next d-md-none"></div>
				</div>
			</div>
		</div>
	</div>
<?endif;?>

