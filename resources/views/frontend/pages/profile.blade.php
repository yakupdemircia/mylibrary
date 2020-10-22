@extends('frontend.layouts.master')

@section('body-class','page-the-tribe')

@section('meta_keywords',trans('strings.meta_keywords'))

@section('content')

    <section class="profile-edit">
        <div class="content">

            @if(!Auth::user()->hasVerifiedEmail())

                <div class="container">
                    <div class="card">
                        <div class="card-body">
                            {!! trans('strings.alert_verification') !!}
                        </div>
                    </div>
                    <div class="spacer25"></div>
                </div>
            @endif

            <div class="container">
                <div class="row">
                    @include('frontend.components.profile_left_menu')
                    <div class="col-md-9">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12">

                                        <form method="post" action="{{route_locale('frontend.profile.index')}}">
                                            @csrf
                                            <div class="form-group row">
                                                <div class="col-4 col-form-label text-right">
                                                    <div class="im-wr circle md profile me">
                                                        <img src="{{$user->image}}">
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="spacer10"></div>
                                                    <div class="spacer25"></div>
                                                    <b>{{ $user->username ?? $user->name ?? "" }}</b><br>
                                                    <a onclick="$('.profile-photo-uploader-wr').toggleClass('opened');">Update Photo</a>

                                                </div>
                                            </div>
                                            <div class="form-group row text-right">
                                                <label for="select" class="col-4 col-form-label"><b></b>E-posta</label>
                                                <div class="col-6">
                                                    <input type="text" class="form-control" value="{{ $user->email }}" disabled>
                                                </div>
                                            </div>
                                            <div class="form-group row text-right">
                                                <label for="username" class="col-4 col-form-label">Adın</label>
                                                <div class="col-6">
                                                    <input type="text" name="name" class="form-control" value="{{ old('name') ?? $user->name }}">
                                                    @include('panel.partial.form-error',['errname'=>'name'])
                                                </div>
                                            </div>

                                            <div class="form-group row text-right">
                                                <label for="birthday" class="col-4 col-form-label">Doğum Tarihin</label>
                                                <div class="col-6">
                                                    <input type="text" id="birthday_user" class="form-control dpicker" autocomplete="Off" value="{{ date_locale($user->birthday) }}">
                                                    <input type="hidden" id="birthday_user_alt" name="birthday" value="{{ $user->birthday }}">
                                                    @include('panel.partial.form-error',['errname'=>'birthday'])
                                                </div>
                                            </div>
                                            <div class="form-group row text-right">
                                                <label for="website" class="col-4 col-form-label">Cinsiyet</label>
                                                <div class="col-6">
                                                    <select id="select" name="gender" class="custom-select">
                                                        <option value="0">Belirtilmemiş</option>
                                                        <option value="1" {{$user->gender == 1 ? 'selected="selected"':''}}>
                                                            Kadın
                                                        </option>
                                                        <option value="2" {{$user->gender == 2 ? 'selected="selected"':''}}>
                                                            Erkek
                                                        </option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <div class="offset-4 col-6">
                                                    <button class="bt">Güncelle</button>
                                                </div>
                                            </div>
                                        </form>
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
    <script type="text/javascript">
        $(document).ready(function () {

            $("#birthday_user").datepicker({
                dateFormat: '{{ trans('globals.date_format_js') }}',
                altField: '#birthday_user_alt',
                altFormat: '{{ trans('globals.date_format_js_alt') }}',
                firstDay: 1,
                changeMonth: true,
                changeYear: true,
            });

        });
    </script>
@endpush
