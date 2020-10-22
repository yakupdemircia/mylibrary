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

                                        <div class="form-group row">
                                            <div class="col-12 text-center">
                                                <h4>{{ $page->title }}</h4>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-12">
                                                {!! $page->desc !!}
                                            </div>
                                        </div>

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

