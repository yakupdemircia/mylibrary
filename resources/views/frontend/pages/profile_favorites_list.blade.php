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
                                        <table class="table table-bordered table-striped">
                                            <thead>
                                            <tr>
                                                <th>Book</th>
                                                <th>Author</th>
                                                <th>Actions</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @if($favorites)
                                            @foreach($favorites as $fav)

                                                <tr>
                                                    <td>{{$fav->book()->title}}</td>
                                                    <td>{{$fav->book()->author()->name}}</td>
                                                    <td>
                                                        <a class="btn btn-info btn-sm" href="{{route_locale('frontend.book-detail',['isbn' => $fav->book()->isbn])}}" title="Details"><span class="fa fa-list"></span></a>
                                                        <button class="btn btn-danger btn-sm" title="Remove from favorites"><span class="fa fa-trash"></span></button>
                                                    </td>
                                                </tr>

                                            @endforeach
                                            @else
                                                <tr>
                                                    <td colspan="5">You have no books rented</td>
                                                </tr>
                                            @endif
                                            </tbody>
                                        </table>
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
