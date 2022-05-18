<?
/**
 * @global CMain $APPLICATION
 * @var array $arParams
 * @var array $arResult
 */
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

if(!$arResult["arUser"]["ID"]){
    LocalRedirect('/my/login/', true);
}
//if (CUser::IsAuthorized()) {
//	debug($arResult);
//}
ShowError($arResult["strProfileError"]);

if ($arResult['DATA_SAVED'] == 'Y') {
	ShowNote('Настройки обновлены, спасибо что пользуетесь нашим сайтом!');
}
?>
<a href="/account" class="btn account-backlink d-md-none nuxt-link-active btn-link" target="_self">
    <svg width="19" height="7" xmlns="http://www.w3.org/2000/svg" class="icon sprite-icons">
        <use href="/_nuxt/e9f276f8f2f8d76658b3ea83098ca231.svg#i-arrow-backlink" xlink:href="/_nuxt/e9f276f8f2f8d76658b3ea83098ca231.svg#i-arrow-backlink"></use>
    </svg>
    <span class="caption">
        Информация об&nbsp;аккаунте
    </span>
</a>
<?
$file = [
	'src' => '/images/nophoto.svg'
];
if($arResult["arUser"]["PERSONAL_PHOTO"]) {
	$file = CFile::ResizeImageGet($arResult["arUser"]["PERSONAL_PHOTO"], ['width' => 400, 'height' => 400], BX_RESIZE_IMAGE_EXACT, true);
}
?>
<form method="post" name="form1" action="<?=$arResult["FORM_TARGET"]?>" enctype="multipart/form-data" class="mb-4">
    <?=$arResult["BX_SESSION_CHECK"]?>
    <input type="hidden" name="lang" value="<?=LANG?>" />
    <input type="hidden" name="ID" value=<?=$arResult["ID"]?> />
    <div class="row">
        <div class="col-lg-6 col-xl-4">
            <fieldset class="form-group">
                <div class="account-photo">
	                <?if($file):?>
                        <img src="<?=$file['src']?>" data-default-src="<?=$file['src']?>" class="ajax-upload-img">
	                <?endif;?>
                </div>
                <div data-toggle="modal" data-target="#photo-modal" class="account-photo-btn">Загрузить фото</div>
            </fieldset>
            <fieldset class="form-group">
                <div tabindex="-1" role="group" class="bv-no-focus-ring">
                    <input type="text" placeholder="ФИО*" required="required" aria-required="true" class="form-control"
                           name="NAME" maxlength="50" value="<?=$arResult["arUser"]["NAME"]?>">
                </div>
            </fieldset>
            <fieldset class="form-group">
                <div tabindex="-1" role="group" class="bv-no-focus-ring">
                    <input type="tel" placeholder="Телефон*" required="required" aria-required="true" class="phone_mask form-control"
                           name="PERSONAL_PHONE" maxlength="50" value="<?=$arResult["arUser"]["PERSONAL_PHONE"]?>">
                </div>
            </fieldset>
            <fieldset class="form-group">
                <div tabindex="-1" role="group" class="bv-no-focus-ring">
                    <input type="email" placeholder="E-mail*" required="required" aria-required="true" class="form-control"
                           name="EMAIL" maxlength="50" value="<?=$arResult["arUser"]["EMAIL"]?>">
                </div>
            </fieldset>
            <h5>
                Изменение пароля
            </h5>
            <fieldset class="form-group">
                <div tabindex="-1" role="group" class="bv-no-focus-ring mb-3">
                    <input type="password" placeholder="Новый пароль" class="form-control"
                           name="NEW_PASSWORD" maxlength="50" value="" autocomplete="off">
                </div>
                <div tabindex="-1" role="group" class="bv-no-focus-ring">
                    <input type="password" placeholder="Подтверждение нового пароля" class="form-control"
                           name="NEW_PASSWORD_CONFIRM" maxlength="50" value="" autocomplete="off">
                </div>
            </fieldset>
            <input type="hidden" name="save" value="Ok">
            <button type="submit" class="btn btn-primary btn-block">
                Сохранить изменения
            </button>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="photo-modal" tabindex="-1" role="dialog" aria-labelledby="photo-modal-label"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="photo-modal-label">Фотография профиля</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true"><img src="/images/modal-photo-close.png"></span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-sm-6 col-12 account-photo-modal">
                            <div>
	                            <?if($file):?>
                                    <img src="<?=$file['src']?>" data-default-src="<?=$file['src']?>" class="ajax-upload-img">
	                            <?endif;?>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6 col-12">
                            <div class="photo-modal-text">Загрузите изображение</div>
                            <input accept="image/jpeg,image/png" for="form1" id="photo-file-modal" type="file" name="PERSONAL_PHOTO">
                            <label for="photo-file-modal">Загрузить</label>
                            <div class="photo-modal-text">Вы можете загрузить фотографию в jpg или png. Обьемом не больше 5 МБ.
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="photo-modal-btn photo-modal-btn_cancel">Передумал</button>
                    <button type="button" class="photo-modal-btn photo-modal-btn_save" data-dismiss="modal" style="display: none">Использовать</button>
                </div>
            </div>
        </div>
    </div>
</form>
