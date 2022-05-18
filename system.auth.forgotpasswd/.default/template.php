<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?><?
$APPLICATION->SetPageProperty("full_width", "Y");
ShowMessage($arParams["~AUTH_RESULT"]);
CJSCore::Init(array('ajax', 'jquery2'));
?>
<main class="page-auth page-auth-login">
    <div class="bg-wrapper"><img src="/images/account/bg-auth-md.jpg" class="d-lg-none"> <img
                src="/images/account/bg-auth.jpg" class="d-none d-lg-block d-xl-none"> <img
                src="/images/account/bg-auth-2k.jpg" class="d-none d-xl-block"></div>
    <div class="container-auth container">
        <div class="row h-100">
            <div class="d-flex flex-column justify-content-md-center col-md-6 col-xl-5 offset-md-6 offset-xl-7 col-10 offset-1">
                <h3 class="mb-4">
                   Восстановление пароля
                </h3>
                <div id="forgot_pass_box">
                 <form name="bform" method="post" class="form-auth" target="_top" action="<?=$arResult["AUTH_URL"]?>">
		            <?
		            if (strlen($arResult["BACKURL"]) > 0)
		            {
			            ?>
                        <input type="hidden" name="backurl" value="<?=$arResult["BACKURL"]?>" />
			            <?
		            }
		            ?>
                    <input type="hidden" name="AUTH_FORM" value="Y">
                    <input type="hidden" name="TYPE" value="SEND_PWD">
                    <div class="row mb-3 pb-3">
                        <div class="col-lg-8">

                            <input placeholder="<?=GetMessage("sys_forgot_pass_login1")?>" type="text" name="USER_LOGIN" value="<?=$arResult["USER_LOGIN"]?>" class="bg-light border-light form-control">
                            <input type="hidden" name="USER_EMAIL" />

	                        <?if($arResult["PHONE_REGISTRATION"]):?>

                                <input placeholder="<?=GetMessage("sys_forgot_pass_phone")?>" type="text" name="USER_PHONE_NUMBER" value="<?=$arResult["USER_PHONE_NUMBER"]?>" class="bg-light border-light form-control">

	                        <?endif;?>

	                        <?if($arResult["USE_CAPTCHA"]):?>
                                <div style="margin-top: 16px">
                                    <div>
                                        <input type="hidden" name="captcha_sid" value="<?=$arResult["CAPTCHA_CODE"]?>" />
                                        <img src="/bitrix/tools/captcha.php?captcha_sid=<?=$arResult["CAPTCHA_CODE"]?>" width="180" height="40" alt="CAPTCHA" />
                                    </div>
                                    <div><?echo GetMessage("system_auth_captcha")?></div>
                                    <div>
                                        <input type="text" name="captcha_word" maxlength="50" value="" />
                                    </div>
                                </div>
	                        <?endif?>

                        </div>
                    </div>
                    <input class="btn btn-primary" type="submit" name="send_account_info" value="<?=GetMessage("AUTH_SEND")?>" />

                </form>

                <div style="margin-top: 16px">

                    <div><?echo GetMessage("sys_forgot_pass_note_email")?></div>

	                <?if($arResult["PHONE_REGISTRATION"]):?>

                        <div><?echo GetMessage("sys_forgot_pass_note_phone")?></div>

	                <?endif;?>
<!--                    <p><a href="--><?//=$arResult["AUTH_AUTH_URL"]?><!--"><b>--><?//=GetMessage("AUTH_AUTH")?><!--</b></a></p>-->
                </div>

                <script type="text/javascript">
                    document.bform.onsubmit = function(e){
                        e.preventDefault();
                        document.bform.USER_EMAIL.value = document.bform.USER_LOGIN.value;
                        let url = $(e.target).attr('action'),
                            data = $(e.target).serialize();
                        $.ajax({
                            url: url,
                            data: data,
                            method: 'post',
                            success: function(msg){
                                $('#forgot_pass_box').html('<p>На указанный email <span style="font-size: 18px;">' + document.bform.USER_LOGIN.value + '</span> выслана ссылка на восстановление пароля!</p>')
                            }
                        });
                    };
                    document.bform.USER_LOGIN.focus();
                </script>

                </div>
            </div>
            <div class="d-none d-md-block">
                <a href="#" target="_blank" class="mr-1">
                    <img src="/images/app-apple-simple.svg" class="img-fluid" width="90">
                </a>
                <a href="#" target="_blank">
                    <img src="/images/app-google-simple.svg" class="img-fluid" width="90">
                </a>
            </div>
        </div>
    </div>
</main>
