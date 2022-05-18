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
	                <?=GetMessage("AUTH_CHANGE_PASSWORD")?>
                </h3>
				<?
				if($arResult["PHONE_REGISTRATION"])
				{
					CJSCore::Init('phone_auth');
				}
				?>
                <div id="forgot_pass_box">
					<?if($arResult["SHOW_FORM"]):?>
<!--                    --><?//debug($arResult)?>
                        <form method="post" action="<?=$arResult["AUTH_FORM"]?>" name="bform" class="form-auth">
							<?if (strlen($arResult["BACKURL"]) > 0): ?>
                                <input type="hidden" name="backurl" value="<?=$arResult["BACKURL"]?>" />
							<? endif ?>
                            <input type="hidden" name="AUTH_FORM" value="Y">
                            <input type="hidden" name="TYPE" value="CHANGE_PWD">

                            <div class="row mb-3 pb-3">
                                <div class="col-lg-8">

								<?if($arResult["PHONE_REGISTRATION"]):?>
                                        <div style="margin-top: 16px">
                                            <input type="text" value="<?=htmlspecialcharsbx($arResult["USER_PHONE_NUMBER"])?>" class="bg-light border-light form-control" disabled="disabled" />
                                            <input type="hidden" name="USER_PHONE_NUMBER" value="<?=htmlspecialcharsbx($arResult["USER_PHONE_NUMBER"])?>" />
                                        </div>
                                        <div style="margin-top: 16px">
    <!--                                        <span class="starrequired">*</span>--><?//echo GetMessage("sys_auth_chpass_code")?>
                                            <input type="text" placeholder="<?echo GetMessage("sys_auth_chpass_code")?>*" name="USER_CHECKWORD" maxlength="50" value="<?=$arResult["USER_CHECKWORD"]?>" class="bg-light border-light form-control" autocomplete="off" />
                                        </div>
                                    <?else:?>
                                        <div style="margin-top: 16px">
    <!--                                       <span class="starrequired">*</span>--><?//=GetMessage("AUTH_LOGIN")?>
                                          <input placeholder="<?=GetMessage("AUTH_LOGIN")?>*" type="text" name="USER_LOGIN" maxlength="50" value="<?=$arResult["LAST_LOGIN"]?>" class="bg-light border-light form-control" />
                                        </div>
                                        <div style="margin-top: 16px" class="d-none">
    <!--                                    <span class="starrequired">*</span>--><?//=GetMessage("AUTH_CHECKWORD")?>
                                          <input type="text" placeholder="<?=GetMessage("AUTH_CHECKWORD")?>*" name="USER_CHECKWORD" maxlength="50" value="<?=$arResult["USER_CHECKWORD"]?>" class="bg-light border-light form-control" autocomplete="off" />
                                        </div>
								<?endif?>
                                    <div style="margin-top: 16px">
<!--                                        <span class="starrequired">*</span>--><?//=GetMessage("AUTH_NEW_PASSWORD_REQ")?>
<!--                                      <input placeholder="--><?//=GetMessage("AUTH_NEW_PASSWORD_REQ")?><!--*" type="password" name="USER_PASSWORD" maxlength="255" value="--><?//=$arResult["USER_PASSWORD"]?><!--" class="bg-light border-light form-control" autocomplete="off" />-->
                                        <input type="password"
                                               name="USER_PASSWORD"
                                               value=""
                                               placeholder="<?=GetMessage("AUTH_NEW_PASSWORD_REQ")?>*"
                                               autocomplete="off"
                                               class="bg-light border-light form-control"
                                               id="pass_id"
                                               maxlength="20"
                                               size="40"
                                               onkeypress="CountPass('pass_id')"
                                               onfocus="CountPass('pass_id')"
                                               onkeyup="CountPass('pass_id')"
                                               required
                                        >
                                        <small>Минимальное количество 6 символов</small><br>
                                        <small id="pass_correct">Вы ввели <span id="pass_view">0</span> символов</small>
<!--                                        <small>--><?//echo $arResult["GROUP_POLICY"]["PASSWORD_REQUIREMENTS"];?><!--</small>-->
                                            <?if($arResult["SECURE_AUTH"]):?>
                                                <span class="bx-auth-secure" id="bx_auth_secure" title="<?echo GetMessage("AUTH_SECURE_NOTE")?>" style="display:none">
                                                    <div class="bx-auth-secure-icon"></div>
                                                </span>
                                                <noscript>
                                                    <span class="bx-auth-secure" title="<?echo GetMessage("AUTH_NONSECURE_NOTE")?>">
                                                        <div class="bx-auth-secure-icon bx-auth-secure-unlock"></div>
                                                    </span>
                                                </noscript>
                                                <script type="text/javascript">
                                                    document.getElementById('bx_auth_secure').style.display = 'inline-block';
                                                </script>
                                    </div>
                    <?endif?>
                            <div style="margin-top: 16px">
<!--                                          <span class="starrequired">*</span>--><?//=GetMessage("AUTH_NEW_PASSWORD_CONFIRM")?>
<!--                                <input type="password" placeholder="--><?//=GetMessage("AUTH_NEW_PASSWORD_CONFIRM")?><!--*" name="USER_CONFIRM_PASSWORD" maxlength="255" value="--><?//=$arResult["USER_CONFIRM_PASSWORD"]?><!--" class="bg-light border-light form-control" autocomplete="off" />-->
                                <input type="password"
                                       class="bg-light border-light form-control"
                                       name="USER_CONFIRM_PASSWORD"
                                       autocomplete="off"
                                       size="30"
                                       id="repass_id"
                                       onkeypress="CorrectPass('repass_id')"
                                       onfocus="CorrectPass('repass_id')"
                                       onkeyup="CorrectPass('repass_id')"
                                       value=""
                                       placeholder="<?=GetMessage("AUTH_NEW_PASSWORD_CONFIRM")?>*"
                                       required
                                >

                                <small class="arrows_ook" id="repass_correct"></small>
                                <input id="check_repass" type="hidden" name="check_repass" value="0">
                            </div>
                            <?if($arResult["USE_CAPTCHA"]):?>
                                <div style="margin-top: 16px">
                                        <input type="hidden" name="captcha_sid" value="<?=$arResult["CAPTCHA_CODE"]?>" />
                                        <img src="/bitrix/tools/captcha.php?captcha_sid=<?=$arResult["CAPTCHA_CODE"]?>" width="180" height="40" alt="CAPTCHA" />

                                         <span class="starrequired">*</span><?echo GetMessage("system_auth_captcha")?>
                                      <input type="text" name="captcha_word" maxlength="50" value="" />
                                </div>
                            <?endif?>

                            <div style="margin-top: 16px">
                                <input class="btn btn-primary" type="submit" name="change_pwd" value="<?=GetMessage("AUTH_CHANGE")?>" />
                            </div>
                        </form>
                </div>
                    <script type="text/javascript">

                        function CountPass(item) {
                            let item_view = 'pass_view',
                                item_correct = 'pass_correct';

                            document.getElementById(item_view).innerHTML = document.getElementById(item).value.length++;

                            if (document.getElementById(item).value.length >= 6) {
                                document.getElementById(item_correct).style.color = 'green';
                            }

                            else {
                                document.getElementById(item_correct).style.color = 'red';
                            }
                        }

                        function CorrectPass(item) {
                            let item_pass_value = document.getElementById('pass_id').value,
                                item_pass_length = document.getElementById('pass_id').value.length,
                                item_correct = 'repass_correct';
                            if (item_pass_length >= 6) {

                                if (document.getElementById(item).value == item_pass_value) {
                                    document.getElementById(item_correct).style.color = 'green';
                                    document.getElementById(item_correct).innerHTML = 'Пароли совпадают';
                                    document.getElementById('check_repass').value = 1;
                                }

                                else if (document.getElementById(item).value.length >= 6) {
                                    document.getElementById(item_correct).style.color = 'red';
                                    document.getElementById(item_correct).innerHTML = 'Пароли не совпадают!';
                                    document.getElementById('check_repass').value = 0;
                                } else {
                                    document.getElementById(item_correct).style.color = 'red';
                                    document.getElementById(item_correct).innerHTML = 'Минимальное количество 6 символов';
                                }
                            }
                        }
                        document.bform.onsubmit = function(e){
                            e.preventDefault();
                            if (document.getElementById('check_repass').value !== '0') {
                                let url = $(e.target).attr('action'),
                                    data = $(e.target).serialize();

                                $.ajax({
                                    url: url,
                                    data: data,
                                    method: 'POST',
                                    success: function(msg){
                                        $('#forgot_pass_box').html('<p><span>Ваш пароль успешно изменен!</span><br><br><a class="btn btn-primary" href="/my/">Вход в личный кабинет</a></p>')
                                    }
                                });
                            } else {
                                return false;
                            }
                        };
                    </script>

					    <?if($arResult["PHONE_REGISTRATION"]):?>

                        <script type="text/javascript">
                            new BX.PhoneAuth({
                                containerId: 'bx_chpass_resend',
                                errorContainerId: 'bx_chpass_error',
                                interval: <?=$arResult["PHONE_CODE_RESEND_INTERVAL"]?>,
                                data:
								<?=CUtil::PhpToJSObject([
									'signedData' => $arResult["SIGNED_DATA"]
								])?>,
                                onError:
                                    function(response)
                                    {
                                        var errorDiv = BX('bx_chpass_error');
                                        var errorNode = BX.findChildByClassName(errorDiv, 'errortext');
                                        errorNode.innerHTML = '';
                                        for(var i = 0; i < response.errors.length; i++)
                                        {
                                            errorNode.innerHTML = errorNode.innerHTML + BX.util.htmlspecialchars(response.errors[i].message) + '<br>';
                                        }
                                        errorDiv.style.display = '';
                                    }
                            });
                        </script>

                        <div id="bx_chpass_error" style="display:none"><?ShowError("error")?></div>

                        <div id="bx_chpass_resend"></div>

					<?endif?>

					<?endif?>

<!--                    <p><a href="--><?//=$arResult["AUTH_AUTH_URL"]?><!--"><b>--><?//=GetMessage("AUTH_AUTH")?><!--</b></a></p>-->


            </div>
            <div class="d-none d-md-block mt-4">
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

