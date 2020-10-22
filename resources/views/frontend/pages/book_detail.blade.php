@extends('frontend.layouts.master')

@section('body-class','page-book-detail')

@section('meta_keywords',trans('strings.meta_keywords'))

@section('content')

    <section class="book-detail-top">
        <div class="content">
            <div class="c-wr">
                <div class="im-wr">
                    <img src="{{$book->image_url}}">
                </div>

                <div class="name">{{$book->title}}</div>
                <div class="city">Author: {{$book->author()->name}}</div>

                <ul class="tab-menu">
                    <li><a class="bt bt-white">Category: {{$book->category()->title}}</a></li>
                    <li><a class="bt bt-white">ISBN: {{$book->isbn}}</a></li>
                    <li><a class="bt bt-white">Stock: {{$book->stock - $book->in_rent}}</a></li>
                </ul>

            </div>
        </div>
    </section>

    <section class="book-detail-mid">
        <div class="content">
            <h3>Book Description:</h3>
            <p>{{nl2br($book->description)}}</p>
        </div>
    </section>

@endsection

@push('js')
    <script type="text/javascript">
        $(document).ready(function () {

        });
    </script>
@endpush