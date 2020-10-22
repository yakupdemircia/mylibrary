<div class="mdl-layer send-verification-modal">
    <div class="mdl-wr">
        <span class="fa fa-times mdl-close"></span>
        <div class="mdl-content">
            <form class="row-line">
                <h4>
                    {{ trans('strings.Send Verification Code') }}
                </h4>
                <div class="row-liner">
                    {!! trans("strings.Send Verification Code Description")  !!}
                </div>
                <div class="row-liner">
                    <input type="text" placeholder="{{ trans("strings.Email") }}" name="customer_mail"
                           class="validate[required,custom[email]] inp inp-flat"
                           value="{{ \Auth::user()->email ?? '' }}" disabled>
                </div>
                <div class="row-liner">
                    <button id="btn_modal_send_verification" class="bt bt-red bt-block">{{ trans('strings.Send') }}<i
                                class="fas fa-circle-notch fa-spin"></i></button>
                </div>
            </form>
        </div>
    </div>
</div>
