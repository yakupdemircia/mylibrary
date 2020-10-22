<div class="mdl-layer reset-password-modal">
    <div class="mdl-wr">
        <span class="fa fa-times mdl-close"></span>
        <div class="mdl-content">
            <form class="row-line">
                <h4>
                    {{ trans('strings.Reset Password') }}
                </h4>

                @if(isset($page_type) && $page_type == "reset_password_form")
                    <div class="row-liner">
                        {!! trans("strings.Enter New Password")  !!}
                    </div>
                    <input id="reset_password_token" type="hidden" value="{{ $reset_password_token }}">
                    <input id="reset_password_email" type="hidden" value="{{ $reset_password_email }}">
                    <div class="row-liner">
                        <div class="input-wr password">
                            <input id="reset_password" name="reset_password"
                                   class="validate[required,minSize[8]] inp inp-flat" type="password"
                                   tabindex="1" autocomplete="Off"
                                   placeholder="{{ trans('strings.Password') }}">
                            <i class="fa fa-eye show-password"></i>
                        </div>
                        <div class="input-wr password">
                            <input id="reset_password_confirm" name="reset_password_confirm"
                                   class="validate[required,minSize[8],equals[reset_password]] inp inp-flat"
                                   type="password"
                                   tabindex="2" autocomplete="Off"
                                   placeholder="{{ trans('strings.Password Again') }}">
                            <i class="fa fa-eye show-password"></i>
                        </div>
                    </div>
                @else
                    <div class="row-liner">
                        {!! trans("strings.Reset Password Description")  !!}
                    </div>
                    <div class="row-liner">
                        <input id="email" type="text" placeholder="{{ trans("strings.Email") }}" name="customer_mail"
                               class="validate[required,custom[email]] inp inp-flat">
                    </div>
                @endif
                <div class="row-liner">
                    <button id="btn_reset_password" class="bt bt-red bt-block">{{ trans('strings.Send') }}<i
                                class="fas fa-circle-notch fa-spin"></i></button>
                </div>
            </form>
        </div>
    </div>
</div>
