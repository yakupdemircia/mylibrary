@extends("panel.layouts.master")

@section('body')

    <div class="container-fluid">
    <!-- Icon Cards-->

    <div class="row">
        <div class="col-xl-3 col-sm-6 mb-3">
            <div class="card text-white bg-primary o-hidden h-100">
                <div class="card-body">
                    <div class="card-body-icon">
                        <i class="fas fa-fw fa-book"></i>
                    </div>
                    <div class="mr-5">{{$books}} Books</div>
                </div>
                <a class="card-footer text-white clearfix small z-1" href="{{route('panel.book.list')}}">
                    <span class="float-left">Details</span>
                    <span class="float-right">
                  <i class="fas fa-angle-right"></i>
                </span>
                </a>
            </div>
        </div>
        <div class="col-xl-3 col-sm-6 mb-3">
            <div class="card text-white bg-warning o-hidden h-100">
                <div class="card-body">
                    <div class="card-body-icon">
                        <i class="fas fa-fw fa-book-reader"></i>
                    </div>
                    <div class="mr-5">{{$users}} Users</div>
                </div>
                <a class="card-footer text-white clearfix small z-1" href="{{route('panel.user.list')}}">
                    <span class="float-left">Details</span>
                    <span class="float-right">
                  <i class="fas fa-angle-right"></i>
                </span>
                </a>
            </div>
        </div>
        <div class="col-xl-3 col-sm-6 mb-3">
            <div class="card text-white bg-success o-hidden h-100">
                <div class="card-body">
                    <div class="card-body-icon">
                        <i class="fas fa-fw fa-book-open"></i>
                    </div>
                    <div class="mr-5">{{$issues}} Book Issues</div>
                </div>
                <a class="card-footer text-white clearfix small z-1" href="{{route('panel.issue.list')}}">
                    <span class="float-left">Details</span>
                    <span class="float-right">
                  <i class="fas fa-angle-right"></i>
                </span>
                </a>
            </div>
        </div>
        <div class="col-xl-3 col-sm-6 mb-3">
            <div class="card text-white bg-danger o-hidden h-100">
                <div class="card-body">
                    <div class="card-body-icon">
                        <i class="fas fa-fw fa-clock"></i>
                    </div>
                    <div class="mr-5">{{$delayed}} Delayed</div>
                </div>
                <!--@todo delayed issues list-->
                <a class="card-footer text-white clearfix small z-1" href="#">
                    <span class="float-left">Details</span>
                    <span class="float-right">
                  <i class="fas fa-angle-right"></i>
                </span>
                </a>
            </div>
        </div>
    </div>


@endsection



