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

                                        <form method="POST" action="">
                                            @csrf
                                            @if(!is_null($user->password))
                                            <div class="form-group row text-right">
                                                <label for="username" class="col-4 col-form-label">Current Pass</label>
                                                <div class="col-6">
                                                    <input type="password" name="current_password" class="form-control">
                                                </div>
                                            </div>
                                            @endif
                                            <div class="form-group row text-right">
                                                <label for="username" class="col-4 col-form-label">New Pass</label>
                                                <div class="col-6">
                                                    <input type="password" name="new_password" class="form-control">
                                                </div>
                                            </div>
                                            <div class="form-group row text-right">
                                                <label for="username" class="col-4 col-form-label">Retype New Pass</label>
                                                <div class="col-6">
                                                    <input type="password" name="new_password_verify" class="form-control">
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <div class="offset-4 col-6">
                                                    <button class="bt">Update</button>
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
@endpush
