@extends('frontend.layouts.master')

@section('body-class','page-contact')

@section('content')
    <section class="profile-edit">
        <div class="content">

            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12">

                                        @if(Session::has('message'))
                                            <div class="form-message">
                                                {{ Session::get('message') }}
                                            </div>
                                        @else

                                            <form id="contact-form" method="post"
                                                  action="{{route_locale('frontend.contact')}}">
                                                @csrf

                                                <div class="form-group row">
                                                    <div class="col-12 text-center">
                                                        <h4>İletişim Formu</h4>
                                                    </div>
                                                </div>

                                                <div class="form-group row text-right">
                                                    <label for="name" class="col-4 col-form-label">Name *</label>
                                                    <div class="col-6">
                                                        <input type="text" name="cf_name"
                                                               value="{{ old('cf_name') ?? '' }}"
                                                               class="form-control validate[required]">
                                                        @if (isset($errors) && $errors->contact->first('cf_name'))
                                                            <p class="text-danger">{{$errors->contact->first('cf_name')}}</p>
                                                        @endif
                                                    </div>
                                                </div>

                                                <div class="form-group row text-right">
                                                    <label for="email" class="col-4 col-form-label">E-mail *</label>
                                                    <div class="col-6">
                                                        <input type="text" name="cf_email"
                                                               value="{{ old('cf_email') ?? '' }}"
                                                               class="form-control validate[required,custom[email]]">
                                                        @if (isset($errors) && $errors->contact->first('cf_email'))
                                                            <p class="text-danger">{{$errors->contact->first('cf_email')}}</p>
                                                        @endif
                                                    </div>
                                                </div>

                                                <div class="form-group row text-right">
                                                    <label for="subject" class="col-4 col-form-label">Konu *</label>
                                                    <div class="col-6">
                                                        <input type="text" name="cf_subject"
                                                               value="{{ request()->input('subject') ?? old('cf_subject') ?? '' }}"
                                                               class="form-control validate[required]">
                                                        @if (isset($errors) && $errors->contact->first('cf_subject'))
                                                            <p class="text-danger">{{$errors->contact->first('cf_subject')}}</p>
                                                        @endif
                                                    </div>
                                                </div>

                                                <div class="form-group row text-right">
                                                    <label for="message" class="col-4 col-form-label">Mesaj *</label>
                                                    <div class="col-6">
                                                        <textarea id="cf_message" name="cf_message"
                                                                  class="">{{ old('cf_message') ?? '' }}</textarea>
                                                        @if (isset($errors) && $errors->contact->first('cf_message'))
                                                            <p class="text-danger">{{$errors->contact->first('cf_message')}}</p>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="form-group row text-right">
                                                    <label for="message" class="col-4 col-form-label"></label>
                                                    <div class="col-6">
                                                        <div class="row">
                                                            <div class="col-6">
                                                                @if(env('GOOGLE_RECAPTCHA_KEY'))
                                                                    <div class="g-recaptcha"
                                                                         data-sitekey="{{env('GOOGLE_RECAPTCHA_KEY')}}">
                                                                    </div>
                                                                    @if (isset($errors) && $errors->contact->first('g-recaptcha-response'))
                                                                        <p class="text-danger">{{$errors->contact->first('g-recaptcha-response')}}</p>
                                                                    @endif
                                                                @endif
                                                            </div>
                                                            <div class="col-4 text-right">
                                                                <span id="submit-contact-form"
                                                                      class="bt">
                                                                    Send
                                                                </span>
                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>

                                            </form>

                                        @endif
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>


        </div>
    </section>

@endsection

@push('js')
    <script src="https://www.google.com/recaptcha/api.js"></script>

    <script type="text/javascript">

        $(document).ready(function () {

            var editorElem;

            ClassicEditor
                .create(document.querySelector('#cf_message'), {
                    toolbar: ['heading', '|', 'bold', 'italic', 'link', 'bulletedList', 'numberedList', 'blockQuote'],
                    heading: {
                        options: [
                            {model: 'paragraph', title: 'Paragraph', class: 'ck-heading_paragraph'},
                            {model: 'heading1', view: 'h1', title: 'Heading 1', class: 'ck-heading_heading1'},
                            {model: 'heading2', view: 'h2', title: 'Heading 2', class: 'ck-heading_heading2'}
                        ]
                    }
                })
                .then(editor => {
                    editorElem = editor;

                })
                .catch(error => {
                    // console.error(error);
                });

            $("#contact-form").validationEngine();

            $("#submit-contact-form").click(function (e) {
                $("#contact-form").submit();
            });

            @if ($errors->contact->all())
            Swal.fire({
                icon: 'error',
                html: "@foreach ($errors->contact->all() as $error)<div>{{ $error }}</div>@endforeach",
            });
            @endif


        });
    </script>
@endpush
