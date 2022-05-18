<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */
$this->setFrameMode(true);
?>
<?if(count($arResult["ITEMS"])):?>
    <div class="swiper swiper-products swiper-vacancy mb-5" id="swiper-vacancy">
        <div class="row swiper-header">
            <div class="col-md-9 col-xl-10">
                <h2 class="page-career__vacancy-title">Актуальные вакансии</h2>
            </div>
            <div class="col-md-3 col-xl-2">
                <div class="d-none d-md-flex justify-content-end">
                    <div class="swiper-nav swiper-button-prev">
                    </div>
                    <div class="swiper-nav swiper-button-next">
                    </div>
                </div>
            </div>
        </div>
        <div class="swiper-container">
            <div class="swiper-wrapper">
                <?
                foreach($arResult["ITEMS"] as $arItem):
                $this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
                $this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
                ?>
                    <div class="swiper-slide" id="<?=$this->GetEditAreaId($arItem['ID']);?>">
                        <div class="card card-career">
                            <div class="card-body">
                                <p class="font-size-3 font-weight-bold card-body__title">
	                                <?=$arItem['NAME']?>
                                </p>
	                            <?if($arItem['PROPERTIES']['CITY']['VALUE']):?>
                                    <p>
                                        г. <?=$arItem['PROPERTIES']['CITY']['VALUE']?>
                                    </p>
	                            <?endif;?>
	                            <?if($arItem['PROPERTIES']['TIME']['VALUE']):?>
                                    <p>
                                        График <?=$arItem['PROPERTIES']['TIME']['VALUE']?>
                                    </p>
	                            <?endif;?>
	                            <?if($arItem['PROPERTIES']['WORK_TYPE']['VALUE']):?>
                                    <p class="font-weight-medium">
                                        Обязанности:
                                    </p>
                                    <ul class="list-unstyled">
                                        <li><?=implode('</li><li>', $arItem['PROPERTIES']['WORK_TYPE']['VALUE']);?></li>
                                    </ul>
	                            <?endif;?>
                            </div>
                            <div class="card-footer">
                                <a href="#vacancy-form__box" class="btn font-weight-medium btn-primary">
                                    Откликнуться </a>
                            </div>
                        </div>
                    </div>
                <?endforeach;?>
            </div>
        </div>
    </div>
    <div id="vacancy-form__box" class="row mb-4">
        <div class="d-none d-md-block col-md-6 col-lg-5 offset-xl-1">
            <p class="font-size-3 font-weight-bold mt-xl-60">
                Мы ищем профессионалов и талантливых людей, которые станут частью дружной команды!
            </p>
            <p class="font-weight-light mb-4 page-career__desc">
                Отправьте нам свое резюме, короткий рассказ о себе или позвоните нашему менеджеру, чтобы узнать подробнее о вакансиях, графике и условиях работы в bop.ru.
            </p>
            <h3 class="font-size-2 font-weight-bold mb-3">Контакты</h3>
            <h4 class="font-size-1 font-weight-bold">Менеджер по персоналу</h4>
            <p class="font-weight-light">
                <a href="+74956516161" class=" page-career__contact-link">тел. 8 (495) 651-61-61, доб. 1721</a>
            </p>
            <p>
                <a href="mailto:hr@bop24.ru">hr@bop24.ru</a><br>
            </p>
            <p class="font-weight-light">
                г. Москва, м. Шелепиха, Шелепихинская наб., 8А, пом. 12,
            </p>
            <!--<p class="font-weight-light">
                м. Сокол (склад)
            </p>-->
            <p>
                <br>
            </p>
        </div>
        <div class="col-md-6 col-lg-5 col-xl-4 offset-xl-1">
            <p class="font-size-3 font-weight-bold">
                Отправьте нам свое резюме
            </p>
            <form id="form-vacancy" class="form-transparent mb-4" enctype="multipart/form-data">
                <input type="hidden" name="form_id" value="11">
                <fieldset class="form-group">
                    <div tabindex="-1" role="group" class="bv-no-focus-ring">
                        <select name="form_text_65" class="form-control" required>
                            <option value="">Выберите вакансию</option>
                            <?foreach($arResult["ITEMS"] as $arItem):?>
                                <option value="<?=$arItem['PROPERTIES']['NAME']['VALUE']?>"><?=$arItem['PROPERTIES']['NAME']['VALUE']?></option>
                            <?endforeach;?>
                        </select>
                    </div>
                </fieldset>
                <fieldset class="form-group" id="__BVID__48">
                    <div tabindex="-1" role="group" class="bv-no-focus-ring">
                        <input placeholder="Имя*" required="required" aria-required="true" class="form-control" type="text" name="form_text_53" div="">
                    </div>
                </fieldset>
                <fieldset class="form-group" id="__BVID__50">
                    <div tabindex="-1" role="group" class="bv-no-focus-ring">
                        <input type="email" placeholder="E-mail*" required="required" aria-required="true" class="form-control" id="__BVID__51" name="form_email_54">
                    </div>
                </fieldset>
                <fieldset class="form-group mb-2" id="__BVID__52">
                    <div tabindex="-1" role="group" class="bv-no-focus-ring">
                        <input type="tel" placeholder="Телефон*" required="required" aria-required="true" class="form-control phone_mask" id="__BVID__53" name="form_text_55">
                    </div>
                </fieldset>
                <div class="row align-items-center">
                    <div class="col-9">
                        <p class="ml-3 mb-2">
                            Напишите нам
                        </p>
                    </div>
                    <div class="d-flex mb-2 col-3">
                        <div class="custom-file b-form-file ml-auto custom-file-icon" id="__BVID__54__BV_file_outer_">
                            <input type="file" class="custom-file-input" id="__BVID__54" name="form_file_56"> <label class="custom-file-label" for="__BVID__54">No file chosen</label>
                        </div>
                    </div>
                </div>
                <fieldset class="form-group" id="__BVID__55">
                    <div tabindex="-1" role="group" class="bv-no-focus-ring">
                        <textarea rows="4" wrap="soft" class="form-control" id="__BVID__56" name="form_textarea_57"></textarea>
                    </div>
                </fieldset>
                <fieldset class="form-group mb-4" id="__BVID__57">
                    <div tabindex="-1" role="group" class="bv-no-focus-ring">
                        <div class="custom-control custom-checkbox b-custom-control-lg">
                            <input type="checkbox" autocomplete="off" value="true" class="custom-control-input" id="__BVID__58" required=""> <label class="custom-control-label" for="__BVID__58"><span class="font-size-1 line-height-120">
                                    Я даю согласие на&nbsp;обработку и&nbsp;хранение своих персональных данных. </span></label>
                        </div>
                    </div>
                </fieldset>
                <div class="row">
                    <div class="col-6">
                        <button type="submit" class="btn btn-primary">
                            Отправить </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
<?endif;?>
