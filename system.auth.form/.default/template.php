<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
    $APPLICATION->SetPageProperty("full_width", "Y");

CJSCore::Init();

?>

<main class="page-auth page-auth-login">
		<div class="bg-wrapper"><img src="/images/account/bg-auth-md.jpg" class="d-lg-none"> <img
			  src="/images/account/bg-auth.jpg" class="d-none d-lg-block d-xl-none"> <img
			  src="/images/account/bg-auth-2k.jpg" class="d-none d-xl-block"></div>
		<div class="container-auth container">
			<div class="row h-100">
				<div
				  class="d-flex flex-column justify-content-md-center col-md-6 col-xl-5 offset-md-6 offset-xl-7 col-10 offset-1">
					<h3 class="mb-0">
						Добро пожаловать
					</h3>
					<p class="font-size-4 text-primary mb-4 mb-lg-5">
						в&nbsp;личный кабинет bop.ru
					</p>
                    <?
                        if ($arResult['SHOW_ERRORS'] == 'Y' && $arResult['ERROR'])
                            ShowMessage($arResult['ERROR_MESSAGE']);
                    ?>

                    <?if($arResult["FORM_TYPE"] == "login"):?>

						<form class="form-auth" name="system_auth_form<?=$arResult["RND"]?>" method="post" target="_top" action="<?=$arResult["AUTH_URL"]?>">
                        <?if($arResult["BACKURL"] <> ''):?>
							<input type="hidden" name="backurl" value="<?=$arResult["BACKURL"]?>" />
                        <?endif?>
                        <?foreach ($arResult["POST"] as $key => $value):?>
							<input type="hidden" name="<?=$key?>" value="<?=$value?>" />
                        <?endforeach?>
						<input type="hidden" name="AUTH_FORM" value="Y" />
						<input type="hidden" name="TYPE" value="AUTH" />
						<div class="form-row mb-4">
							<div class="col-lg-8">
								<input class="bg-light border-light form-control" type="text" name="USER_LOGIN" maxlength="50" value="" size="17" placeholder="<?=GetMessage("AUTH_LOGIN")?>">
								<script>
									BX.ready(function() {
										var loginCookie = BX.getCookie("<?=CUtil::JSEscape($arResult["~LOGIN_COOKIE_NAME"])?>");
										if (loginCookie)
										{
											var form = document.forms["system_auth_form<?=$arResult["RND"]?>"];
											var loginInput = form.elements["USER_LOGIN"];
											loginInput.value = loginCookie;
										}
									});
								</script>
							</div>
						</div>
						<div class="form-row mb-3 mb-lg-4 pb-2 align-items-center">
							<div class="col-lg-8">
								<input type="password" name="USER_PASSWORD" maxlength="255" size="17" autocomplete="off" placeholder="<?=GetMessage("AUTH_PASSWORD")?>" class="bg-light border-light form-control">
                                <?if($arResult["SECURE_AUTH"]):?>
									<span class="bx-auth-secure" id="bx_auth_secure<?=$arResult["RND"]?>" title="<?echo GetMessage("AUTH_SECURE_NOTE")?>" style="display:none">
                                            <div class="bx-auth-secure-icon"></div>
                                        </span>
									<noscript>
                                            <span class="bx-auth-secure" title="<?echo GetMessage("AUTH_NONSECURE_NOTE")?>">
                                                <div class="bx-auth-secure-icon bx-auth-secure-unlock"></div>
                                            </span>
									</noscript>
									<script type="text/javascript"> 
                                        document.getElementById('bx_auth_secure<?=$arResult["RND"]?>').style.display = 'inline-block';
									</script>
                                <?endif?>
							</div>
							<div class="text-right text-lg-left pt-3 pt-lg-0 col-lg-4">
								<a href="<?=$arResult["AUTH_FORGOT_PASSWORD_URL"]?>"
								   target="_self"
								   class="font-size-1 font-weight-light text-dark">
                                    <?=GetMessage("AUTH_FORGOT_PASSWORD_2")?>
								</a>
							</div>
						</div>
						<div class="form-row">
							<div class="col-lg-4 col-sm-6 col-12 mb-3 mb-sm-0">
                                <?if($arResult["NEW_USER_REGISTRATION"] == "Y"):?>
									<a href="<?=$arResult["AUTH_REGISTER_URL"]?>" rel="nofollow" target="_self"
									   class="btn btn-outline-gray-600 btn-block"><?=GetMessage("AUTH_REGISTER")?></a>
                                <?endif?>
							</div>
							<div class="col-lg-4 col-sm-6 col-12">
								<input class="btn nuxt-link-active btn-primary btn-block" type="submit" name="Login" value="<?=GetMessage("AUTH_LOGIN_BUTTON")?>">
							</div>
						</div>
					</form>
					<?php
                        if($arResult["AUTH_SERVICES"]) {
                            $APPLICATION->IncludeComponent("bitrix:socserv.auth.form", "",
                                array(
                                    "AUTH_SERVICES"=>$arResult["AUTH_SERVICES"],
                                    "CURRENT_SERVICE"=>$arResult["CURRENT_SERVICE"],
                                    "AUTH_URL"=>$arResult["AUTH_URL"],
                                    "POST"=>$arResult["POST"],
                                ),
                                $component,
                                array("HIDE_ICONS"=>"Y")
                            );
                        }
                    ?>
<!--					<form class="form-auth">-->
<!--						<div class="form-row mb-4">-->
<!--							<div class="col-lg-8"><input type="text" placeholder="Логин" required="required"-->
<!--							                             aria-required="true"-->
<!--							                             class="bg-light border-light form-control"-->
<!--							                             id="__BVID__348"></div>-->
<!--						</div>-->
<!--						<div class="form-row mb-3 mb-lg-4 pb-2 align-items-center">-->
<!--							<div class="col-lg-8"><input type="password" placeholder="Пароль"-->
<!--							                             required="required" aria-required="true"-->
<!--							                             class="bg-light border-light form-control"-->
<!--							                             id="__BVID__349"></div>-->
<!--							<div class="text-right text-lg-left pt-3 py-lg-0 col-lg-4"><a-->
<!--								  href="/account/restore" class="font-size-1 font-weight-light text-dark"-->
<!--								  target="_self">-->
<!--									Забыли пароль?-->
<!--								</a></div>-->
<!--						</div>-->
<!--						<div class="form-row">-->
<!--							<div class="col-lg-4 col-6"><a href="/account/register"-->
<!--							                               class="btn btn-outline-gray-600 btn-block"-->
<!--							                               target="_self">-->
<!--									Регистрация-->
<!--								</a></div>-->
<!--							<div class="col-lg-4 col-6"><a href="/account"-->
<!--							                               class="btn nuxt-link-active btn-primary btn-block"-->
<!--							                               target="_self">-->
<!--									Войти-->
<!--								</a></div>-->
<!--						</div>-->
<!--					</form>-->
					<?endif;?>
					<div class="text-center mt-auto d-md-none">
						<div class="mb-5"><a href="#" target="_blank"><img
								  src="/images/app-apple-simple-light.svg" class="img-fluid" width="90"></a>
							<a href="#" target="_blank"><img src="/images/app-google-simple-light.svg"
							                                 class="img-fluid" width="90"></a></div>
						<div class="mb-4"><a href="#" target="_blank" class="text-gray-300 mx-1">
								<svg width="32" height="32" xmlns="http://www.w3.org/2000/svg"
								     class="icon sprite-icons">
									<use
									  href="/local/templates/new/_nuxt/e9f276f8f2f8d76658b3ea83098ca231.svg#i-social-instagram"
									  xlink:href="/local/templates/new/_nuxt/e9f276f8f2f8d76658b3ea83098ca231.svg#i-social-instagram"></use>
								</svg>
							</a> <a href="#" target="_blank" class="text-gray-300 mx-1">
								<svg width="32" height="32" xmlns="http://www.w3.org/2000/svg"
								     class="icon sprite-icons">
									<use href="/local/templates/new/_nuxt/e9f276f8f2f8d76658b3ea83098ca231.svg#i-social-vk"
									     xlink:href="/local/templates/new/_nuxt/e9f276f8f2f8d76658b3ea83098ca231.svg#i-social-vk"></use>
								</svg>
							</a> <a href="#" target="_blank" class="text-gray-300 mx-1">
								<svg width="32" height="32" xmlns="http://www.w3.org/2000/svg"
								     class="icon sprite-icons">
									<use
									  href="/local/templates/new/_nuxt/e9f276f8f2f8d76658b3ea83098ca231.svg#i-social-facebook"
									  xlink:href="/local/templates/new/_nuxt/e9f276f8f2f8d76658b3ea83098ca231.svg#i-social-facebook"></use>
								</svg>
							</a></div>
					</div>
					
					<div class="d-none d-md-block"><a href="#" target="_blank" class="mr-1"><img
							  src="/images/app-apple-simple.svg" class="img-fluid" width="90"></a> <a
						  href="#" target="_blank"><img src="/images/app-google-simple.svg"
					                                    class="img-fluid" width="90"></a></div>
				</div>
			</div>
		</div>
	</main>