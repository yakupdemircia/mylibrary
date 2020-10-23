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
                                                <th>Start Date</th>
                                                <th>End Date</th>
                                                <th>Return Date</th>
                                                <th>Status</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @if($issues)
                                            @foreach($issues as $issue)
                                                @php
                                                    $status = calc_issue_status($issue);
                                                @endphp

                                                <tr>
                                                    <td>{{$issue->book()->title}}</td>
                                                    <td>{{date_locale($issue->start_date)}}</td>
                                                    <td>{{date_locale($issue->end_date)}}</td>
                                                    <td>{{date_locale($issue->return_date)}}</td>
                                                    <td>{{ucwords($status)}}</td>
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
