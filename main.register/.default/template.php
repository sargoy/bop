<?
    $APPLICATION->SetPageProperty("full_width", "Y");
CJSCore::Init(array('ajax', 'jquery2'));
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)
	die();

if($arResult["SHOW_SMS_FIELD"] == true)
{
	CJSCore::Init('phone_auth');
}
?>
<div class="page-auth page-auth-register" style="background-color: transparent">
	<div class="bg-wrapper">
        <img src="/upload/static/register_bg.png" style="object-fit: fill;">
    </div>
	<div class="container-auth container">
		<div class="row h-100">
			<div class="d-flex flex-column justify-content-md-center col-md-6 offset-md-0 col-10 offset-1"><h3
				  class="mb-0">
					Регистрация
				</h3>
				<p class="font-size-4 text-primary mb-4 mb-lg-5">
					в&nbsp;личном кабинете bop.ru
				</p>
                <?
                    if (count($arResult["ERRORS"]) > 0):
                    foreach ($arResult["ERRORS"] as $key => $error)
                        if (intval($key) == 0 && $key !== 0)
                            $arResult["ERRORS"][$key] = str_replace("#FIELD_NAME#", "&quot;".GetMessage("REGISTER_FIELD_".$key)."&quot;", $error);

                    ShowError(implode("<br />", $arResult["ERRORS"]));

					elseif($arResult["USE_EMAIL_CONFIRMATION"] === "Y"):
                ?>
					<p><?echo GetMessage("REGISTER_EMAIL_WILL_BE_SENT")?></p>
                <?endif?>
                <?if($arResult["SHOW_SMS_FIELD"] == true):?>

					<form method="post" action="<?=POST_FORM_ACTION_URI?>" name="regform">
                        <?
                            if($arResult["BACKURL"] <> ''):
                                ?>
								<input type="hidden" name="backurl" value="<?=$arResult["BACKURL"]?>" />
                            <?
                            endif;
                        ?>
						<input type="hidden" name="SIGNED_DATA" value="<?=htmlspecialcharsbx($arResult["SIGNED_DATA"])?>" />
						<table>
							<tbody>
							<tr>
								<td><?echo GetMessage("main_register_sms")?><span class="starrequired">*</span></td>
								<td><input size="30" type="text" name="SMS_CODE" value="<?=htmlspecialcharsbx($arResult["SMS_CODE"])?>" autocomplete="off" /></td>
							</tr>
							</tbody>
							<tfoot>
							<tr>
								<td></td>
								<td><input type="submit" name="code_submit_button" value="<?echo GetMessage("main_register_sms_send")?>" /></td>
							</tr>
							</tfoot>
						</table>
					</form>

					<script>
											new BX.PhoneAuth({
												containerId: 'bx_register_resend',
												errorContainerId: 'bx_register_error',
												interval: <?=$arResult["PHONE_CODE_RESEND_INTERVAL"]?>,
												data:
                          <?=CUtil::PhpToJSObject([
                              'signedData' => $arResult["SIGNED_DATA"],
                          ])?>,
												onError:
													function(response)
													{
														var errorDiv = BX('bx_register_error');
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

					<div id="bx_register_error" style="display:none"><?ShowError("error")?></div>

					<div id="bx_register_resend"></div>

                <?else:?>
					<form id="form__register" class="form-auth" autocomplete="off" method="post" action="<?=POST_FORM_ACTION_URI?>" name="regform" enctype="multipart/form-data">
                        <?
                            if($arResult["BACKURL"] <> ''):
                                ?>
								<input type="hidden" name="backurl" value="<?=$arResult["BACKURL"]?>" />
                            <?
                            endif;
                        ?>
							<div class="row mb-md-4">


                                <?foreach ($arResult["SHOW_FIELDS"] as $FIELD):?>
                                    <?if($FIELD == "AUTO_TIME_ZONE" && $arResult["TIME_ZONE_ENABLED"] == true):?>
										<div class="col-lg-6">
											<fieldset class="form-group">
												<div tabindex="-1" role="group" class="bv-no-focus-ring">
														<select name="REGISTER[AUTO_TIME_ZONE]" onchange="this.form.elements['REGISTER[TIME_ZONE]'].disabled=(this.value != 'N')">
															<option value=""><?echo GetMessage("main_profile_time_zones_auto_def")?></option>
															<option value="Y"<?=$arResult["VALUES"][$FIELD] == "Y" ? " selected=\"selected\"" : ""?>><?echo GetMessage("main_profile_time_zones_auto_yes")?></option>
															<option value="N"<?=$arResult["VALUES"][$FIELD] == "N" ? " selected=\"selected\"" : ""?>><?echo GetMessage("main_profile_time_zones_auto_no")?></option>
														</select>
												</div>
											</fieldset>
										</div>
										<div class="col-lg-6">
											<fieldset class="form-group">
												<div tabindex="-1" role="group" class="bv-no-focus-ring">
														<select name="REGISTER[TIME_ZONE]"<?if(!isset($_REQUEST["REGISTER"]["TIME_ZONE"])) echo 'disabled="disabled"'?>>
		                                                    <?foreach($arResult["TIME_ZONE_LIST"] as $tz=>$tz_name):?>
																<option value="<?=htmlspecialcharsbx($tz)?>"<?=$arResult["VALUES"]["TIME_ZONE"] == $tz ? " selected=\"selected\"" : ""?>><?=htmlspecialcharsbx($tz_name)?></option>
		                                                    <?endforeach?>
														</select>
												</div>
											</fieldset>
										</div>
                                    <?else:?>

                                                    <? switch ($FIELD)
                                                    {
	                                                    case "LOGIN":?>
                                                        <div class="col-lg-6 d-none">
                                                            <fieldset class="form-group">
                                                                <div tabindex="-1" role="group" class="bv-no-focus-ring">
                                                                        <input id="login__field"
                                                                           class="bg-light border-light form-control"
                                                                           size="30"
                                                                           type="text"
                                                                           name="REGISTER[<?=$FIELD?>]"
                                                                           value="<?=$arResult["VALUES"][$FIELD]?>"
                                                                           placeholder='<?=GetMessage("REGISTER_FIELD_".$FIELD)?>'
                                                                        >
                                                                </div>
                                                            </fieldset>
                                                        </div>
		                                                    <?break;
                                                        case "EMAIL":?>
                                                            <div class="col-lg-6">
                                                                <fieldset class="form-group">
                                                                    <div tabindex="-1" role="group" class="bv-no-focus-ring">
                                                                        <input id="email__field"
                                                                           class="bg-light border-light form-control"
                                                                           size="30" type="text" name="REGISTER[<?=$FIELD?>]"
                                                                           value="<?=$arResult["VALUES"][$FIELD]?>"
                                                                           placeholder='<?=GetMessage("REGISTER_FIELD_".$FIELD)?><?if ($arResult["REQUIRED_FIELDS_FLAGS"][$FIELD] == "Y"):?>*<?endif?>'
                                                                           <?if ($arResult["REQUIRED_FIELDS_FLAGS"][$FIELD] == "Y"):?>required<?endif?>
                                                                        >
                                                                    </div>
                                                                </fieldset>
                                                            </div>
                                                            <?break;
                                                        case "PERSONAL_PHONE":?>
                                                            <div class="col-lg-6">
                                                                <fieldset class="form-group">
                                                                    <div tabindex="-1" role="group" class="bv-no-focus-ring">
                                                                        <input class="bg-light border-light form-control phone_mask"
                                                                           size="30"
                                                                           type="text"
                                                                           name="REGISTER[<?=$FIELD?>]"
                                                                           value="<?=$arResult["VALUES"][$FIELD]?>"
                                                                           placeholder='<?=GetMessage("REGISTER_FIELD_".$FIELD)?><?if ($arResult["REQUIRED_FIELDS_FLAGS"][$FIELD] == "Y"):?>*<?endif?>'
                                                                           <?if ($arResult["REQUIRED_FIELDS_FLAGS"][$FIELD] == "Y"):?>required<?endif?>
                                                                        >
                                                                    </div>
                                                                </fieldset>
                                                            </div>
                                                            <?break;
                                                        case "PASSWORD":
                                                            ?>
<!--                                                    <input class="bg-light border-light form-control" size="30" type="password" name="REGISTER[--><?//=$FIELD?><!--]" value="--><?//=$arResult["VALUES"][$FIELD]?><!--" autocomplete="off" placeholder='--><?//=GetMessage("REGISTER_FIELD_".$FIELD)?><!--:--><?//if ($arResult["REQUIRED_FIELDS_FLAGS"][$FIELD] == "Y"):?><!--*--><?//endif?><!--'>-->
                                                        <div class="col-lg-6">
                                                            <fieldset class="form-group">
                                                                <div tabindex="-1" role="group" class="bv-no-focus-ring">
                                                                    <input type="password"
                                                                       name="REGISTER[<?=$FIELD?>]"
                                                                       value=""
                                                                       placeholder="<?=GetMessage("REGISTER_FIELD_".$FIELD)?><?if ($arResult["REQUIRED_FIELDS_FLAGS"][$FIELD] == "Y"):?>*<?endif?>"
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
                                                                </div>
                                                            </fieldset>
                                                        </div>
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
                                                        <?endif?>
                                                            <?
                                                            break;
                                                        case "CONFIRM_PASSWORD":
                                                            ?>
<!--                                                        <input class="bg-light border-light form-control" size="30" type="password" name="REGISTER[--><?//=$FIELD?><!--]" value="--><?//=$arResult["VALUES"][$FIELD]?><!--" autocomplete="off" placeholder='--><?//=GetMessage("REGISTER_FIELD_".$FIELD)?><!--:--><?//if ($arResult["REQUIRED_FIELDS_FLAGS"][$FIELD] == "Y"):?><!--*--><?//endif?><!--'>-->
                                                        <div class="col-lg-6">
                                                            <fieldset class="form-group">
                                                                <div tabindex="-1" role="group" class="bv-no-focus-ring">
                                                                    <input type="password"
                                                                       class="bg-light border-light form-control"
                                                                       name="REGISTER[<?=$FIELD?>]"
                                                                       autocomplete="off"
                                                                       size="30"
                                                                       id="repass_id"
                                                                       onkeypress="CorrectPass('repass_id')"
                                                                       onfocus="CorrectPass('repass_id')"
                                                                       onkeyup="CorrectPass('repass_id')"
                                                                       value=""
                                                                       placeholder="<?=GetMessage("REGISTER_FIELD_".$FIELD)?><?if ($arResult["REQUIRED_FIELDS_FLAGS"][$FIELD] == "Y"):?>*<?endif?>"
                                                                       required
                                                                    >

                                                                    <small class="arrows_ook" id="repass_correct"></small>
                                                               </div>
                                                            </fieldset>
                                                        </div>
                                                    <? break;

                                                        case "PERSONAL_GENDER":
                                                            ?><select name="REGISTER[<?=$FIELD?>]">
																<option value=""><?=GetMessage("USER_DONT_KNOW")?></option>
																<option value="M"<?=$arResult["VALUES"][$FIELD] == "M" ? " selected=\"selected\"" : ""?>><?=GetMessage("USER_MALE")?></option>
																<option value="F"<?=$arResult["VALUES"][$FIELD] == "F" ? " selected=\"selected\"" : ""?>><?=GetMessage("USER_FEMALE")?></option>
															</select><?
                                                            break;

                                                        case "PERSONAL_COUNTRY":
                                                        case "WORK_COUNTRY":
                                                            ?><select name="REGISTER[<?=$FIELD?>]"><?
                                                            foreach ($arResult["COUNTRIES"]["reference_id"] as $key => $value)
                                                            {
                                                                ?>
                                                                <option value="<?=$value?>"<?if ($value == $arResult["VALUES"][$FIELD]):?>
                                                                    selected="selected"<?endif?>><?=$arResult["COUNTRIES"]["reference"][$key]?>
                                                                </option>
                                                                <?
                                                            }
                                                            ?></select><?
                                                            break;

                                                        case "PERSONAL_PHOTO":
                                                        case "WORK_LOGO":?>
                                                            <input class="bg-light border-light form-control"
                                                                 size="30"
                                                                 type="file"
                                                                 name="REGISTER_FILES_<?=$FIELD?>"
                                                                 placeholder='<?=GetMessage("REGISTER_FIELD_".$FIELD)?>:<?if ($arResult["REQUIRED_FIELDS_FLAGS"][$FIELD] == "Y"):?>*<?endif?>'
                                                            >
                                                        <? break;

                                                        case "PERSONAL_NOTES":
                                                        case "WORK_NOTES":
                                                            ?><textarea cols="30" rows="5" name="REGISTER[<?=$FIELD?>]"><?=$arResult["VALUES"][$FIELD]?></textarea><?
                                                            break;

                                                        default:
                                                            if ($FIELD == "PERSONAL_BIRTHDAY"):?>
                                                                <small><?=$arResult["DATE_FORMAT"]?></small><br />
                                                            <?endif;?>
                                                            <div class="col-lg-6">
                                                                <fieldset class="form-group">
                                                                    <div tabindex="-1" role="group" class="bv-no-focus-ring">
                                                                        <input class="bg-light border-light form-control"
                                                                           size="30"
                                                                           type="text"
                                                                           name="REGISTER[<?=$FIELD?>]"
                                                                           value="<?=$arResult["VALUES"][$FIELD]?>"
                                                                           placeholder='<?=GetMessage("REGISTER_FIELD_".$FIELD)?><?if ($arResult["REQUIRED_FIELDS_FLAGS"][$FIELD] == "Y"):?>*<?endif?>'
                                                                           <?if ($arResult["REQUIRED_FIELDS_FLAGS"][$FIELD] == "Y"):?>required<?endif?>
                                                                        >
                                                                    </div>
                                                                </fieldset>
                                                            </div>
                                                    <?
                                                            if ($FIELD == "PERSONAL_BIRTHDAY")
                                                                $APPLICATION->IncludeComponent(
                                                                    'bitrix:main.calendar',
                                                                    '',
                                                                    array(
                                                                        'SHOW_INPUT' => 'N',
                                                                        'FORM_NAME' => 'regform',
                                                                        'INPUT_NAME' => 'REGISTER[PERSONAL_BIRTHDAY]',
                                                                        'SHOW_TIME' => 'N'
                                                                    ),
                                                                    null,
                                                                    array("HIDE_ICONS"=>"Y")
                                                                );
                                                            ?><?
                                                    }?>

                                    <?endif?>
                                <?endforeach?>
                                <?// ********************* User properties ***************************************************?>
                                <?if($arResult["USER_PROPERTIES"]["SHOW"] == "Y"):?>

                                    <?foreach ($arResult["USER_PROPERTIES"]["DATA"] as $FIELD_NAME => $arUserField):?>
										<div class="col-lg-6">
											<fieldset class="form-group">
												<div tabindex="-1" role="group" class="bv-no-focus-ring">

		                                                <?$APPLICATION->IncludeComponent(
		                                                    "bitrix:system.field.edit",
		                                                    $arUserField["USER_TYPE"]["USER_TYPE_ID"],
		                                                    array("bVarsFromForm" => $arResult["bVarsFromForm"], "arUserField" => $arUserField, "form_name" => "regform"), null, array("HIDE_ICONS"=>"Y"));?>
												</div>
											</fieldset>
										</div>
                                    <?endforeach;?>
                                <?endif;?>
                                <?// ******************** /User properties ***************************************************?>
                                <?
                                    /* CAPTCHA */
                                    if ($arResult["USE_CAPTCHA"] == "Y")
                                    {
                                        ?>

										<div class="col-lg-6">
											<fieldset class="form-group">
												<div tabindex="-1" role="group" class="bv-no-focus-ring">
														<input type="hidden" name="captcha_sid" value="<?=$arResult["CAPTCHA_CODE"]?>" />
														<img src="/bitrix/tools/captcha.php?captcha_sid=<?=$arResult["CAPTCHA_CODE"]?>" width="180" height="40" alt="CAPTCHA" />
												</div>
											</fieldset>
										</div>
									<div class="col-lg-6">
										<fieldset class="form-group">
											<div tabindex="-1" role="group" class="bv-no-focus-ring">
												<input type="text" name="captcha_word" maxlength="50" value="" autocomplete="off" /></td>
											</div>
										</fieldset>
									</div>
                                        <?
                                    }
                                    /* !CAPTCHA */
                                ?>


                        </div>
                        <fieldset class="form-group mb-4">
                            <div tabindex="-1" role="group" class="bv-no-focus-ring">
                                <p class="font-size-1 font-weight-light line-height-120 mb-0">
                                    Нажимая кнопку «Зарегистрироваться», вы соглашаетесь с условиями <a href='/terms-of-use/'>пользовательского соглашения</a> и даете согласие <a href='/privacy/'>на обработку персональных данных.</a>
                                </p>
                            </div>
                        </fieldset>
						<input class="btn btn-primary mr-2" type="submit" name="register_submit_button" value="Зарегистрироваться">
                        <a class="btn btn-outline-gray-600" href="/my/login/">Авторизоваться</a>

					</form>

					<div class="text-center mt-auto d-md-none">
						<div class="mb-5"><a href="#" target="_blank"><img src="/images/app-apple-simple-light.svg"
						                                                   class="img-fluid" width="90"></a> <a href="#"
						                                                                                        target="_blank"><img
								  src="/images/app-google-simple-light.svg" class="img-fluid" width="90"></a></div>
						<div class="mb-4"><a href="#" target="_blank" class="text-gray-300 mx-1">
								<svg width="32" height="32" xmlns="http://www.w3.org/2000/svg" class="icon sprite-icons">
									<use href="/_nuxt/e9f276f8f2f8d76658b3ea83098ca231.svg#i-social-instagram"
									     xlink:href="/_nuxt/e9f276f8f2f8d76658b3ea83098ca231.svg#i-social-instagram"></use>
								</svg>
							</a> <a href="#" target="_blank" class="text-gray-300 mx-1">
								<svg width="32" height="32" xmlns="http://www.w3.org/2000/svg" class="icon sprite-icons">
									<use href="/_nuxt/e9f276f8f2f8d76658b3ea83098ca231.svg#i-social-vk"
									     xlink:href="/_nuxt/e9f276f8f2f8d76658b3ea83098ca231.svg#i-social-vk"></use>
								</svg>
							</a> <a href="#" target="_blank" class="text-gray-300 mx-1">
								<svg width="32" height="32" xmlns="http://www.w3.org/2000/svg" class="icon sprite-icons">
									<use href="/_nuxt/e9f276f8f2f8d76658b3ea83098ca231.svg#i-social-facebook"
									     xlink:href="/_nuxt/e9f276f8f2f8d76658b3ea83098ca231.svg#i-social-facebook"></use>
								</svg>
							</a></div>
					</div>
					<div class="d-none d-md-block"><a href="#" target="_blank" class="mr-1"><img
							  src="/images/app-apple-simple.svg" class="img-fluid" width="90"></a> <a href="#"
					                                                                                  target="_blank"><img
							  src="/images/app-google-simple.svg" class="img-fluid" width="90"></a></div>
				</div>
	            <?endif //$arResult["SHOW_SMS_FIELD"] == true ?>
		</div>
	</div>
</div>