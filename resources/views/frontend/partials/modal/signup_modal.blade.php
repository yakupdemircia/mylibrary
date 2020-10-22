<div class="mdl-layer signup-modal">
    <div class="mdl-wr">
        <span class="fa fa-times mdl-close"></span>
        <div class="mdl-content">
            <form class="row-line" id="user_register">
                <h4>
                    {{ trans('strings.register') }}
                </h4>

                <div class="row-liner">

                </div>
                <div class="row-liner">
                    <div class="bt bt-facebook bt-facebook-login">
                        <a href="/fbauth" class="bt-inline-wr">
                            <span class="ic"><i class="fab fa-facebook"></i></span>
                            <span class="tx">{{ trans('strings.Register With Facebook') }}</span>
                        </a>
                    </div>

                    <div class="bt bt-google bt-google-login">
                        <a href="googleauth" class="bt-inline-wr">
                            <span class="ic"><i class="fab fa-google"></i></span>
                            <span class="tx">{{ trans('strings.Register With Google') }}</span>
                        </a>
                    </div>
                </div>
                <div class="row-liner text-center">
                    {{ trans('strings.or') }}
                </div>
                <div class="row-liner">
                    <input id="name" class="validate[required] inp inp-flat"
                           type="text" tabindex="1" autocomplete="name"
                           placeholder="{{ trans('strings.Name Surname') }}">

                    <input id="email" class="validate[required,custom[email]] inp inp-flat"
                           type="text" tabindex="1" autocomplete="username"
                           placeholder="{{ trans('strings.Email') }}">

                    <div class="input-wr password">
                        <input id="password" class="validate[required,minSize[8]] inp inp-flat" type="password"
                               tabindex="2" autocomplete="password"
                               placeholder="{{ trans('strings.Password') }}">
                        <i class="fa fa-eye show-password"></i>
                    </div>
                </div>

                <div class="row-liner kvkk_gdpr">
                    <input name="agreementIds" type="hidden" value="1,2">
                    By loggin in I accept
                    <a href="" target="_blank">Terms of use</a>
                </div>

                <div class="row-liner">
                    <button id="btn_modal_signup" type="submit"
                            class="bt"> {{ trans('strings.register') }}<i class="fas fa-circle-notch fa-spin"></i>
                    </button>
                </div>
            </form>
            <div class="row-liner">
                <h6>Already have an account?
                    <small class="open-custom-modal" data-rel="login">{{trans('strings.login')}}</small>
                </h6>
            </div>
        </div>
    </div>
</div>
