<div class="mdl-layer login-modal">
    <div class="mdl-wr">
        <span class="fa fa-times mdl-close"></span>
        <div class="mdl-content">
            <form class="row-line">
                <h4>
                    {{ trans('strings.login') }}
                </h4>
                <div class="row-liner">
                    <a href="{{ url('fbauth') }}" class="bt bt-facebook bt-facebook-login">
                        <div class="bt-inline-wr">
                            <span class="ic"><i class="fab fa-facebook"></i></span>
                            <span class="tx">
                                {{ trans('strings.Login With Facebook') }}
                            </span>
                        </div>
                    </a>

                    <a href="{{ url('googleauth') }}" class="bt bt-google bt-google-login">
                        <div class="bt-inline-wr">
                            <span class="ic"><i class="fab fa-google"></i></span>
                            <span class="tx">
                                {{ trans('strings.Login With Google') }}
                            </span>
                        </div>
                    </a>
                </div>
                <div class="row-liner text-center">
                    {{ trans('strings.or') }}
                </div>
                <div class="row-liner text-center">
                    {{ trans('strings.Email') }}
                </div>

                <div class="row-liner">
                    <input id="email" name="email" class="validate[required,custom[email]] inp inp-flat"
                           type="text" tabindex="1" autocomplete="username"
                           placeholder="{{ trans('strings.Email') }}">
                    <div class="input-wr password">
                        <input id="password" name="password" class="validate[required] inp inp-flat" type="password"
                               tabindex="2" autocomplete="password"
                               placeholder="{{ trans('strings.Password') }}">
                        <i class="fa fa-eye show-password"></i>
                    </div>
                </div>

                <div class="row-liner">
                    <h6 class="open-custom-modal"
                        data-rel="reset-password">{{ trans('strings.Forgot Password?') }}</h6>
                    <button id="btn_modal_login" class="bt bt-red bt-block"
                          tabindex="3">{{ trans('strings.login') }}<i class="fas fa-circle-notch fa-spin"></i></button>
                </div>


            </form>
            <div class="row-line">
                <div class="spacer25"></div>
            </div>
            <div class="row-line">
                <h4 class="open-custom-modal" data-rel="signup">
                    {{ trans('strings.register') }}
                </h4>
                <div class="row-liner">
                    {{ trans('strings.Dont have an account?') }}
                </div>
                <div class="row-liner">
                    <span class="bt bt-red bt-block open-custom-modal"
                          data-rel="signup">{{ trans('strings.register') }}</span>

                </div>
            </div>
        </div>
    </div>
</div>
