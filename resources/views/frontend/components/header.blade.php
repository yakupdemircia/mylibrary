@section('header')

    <header id="header">

        <div class="header">
            <a class="logo" href="/">
                <h1>My Library</h1>
            </a>

            <ul class="menu">

                @if(\Auth::check())
                    <li><a href="{{route_locale('frontend.profile.favorites')}}">{{trans('favorites')}}</a></li>

                    <li>
                        <a href="/profile">
                            <div class="im-wr circle xxs profile me"><img src=""></div>
                            {{ \Auth::user()->name }}</a>
                    </li>
                @else
                    <li><a class="open-custom-modal" data-rel="login">{{trans('favorites')}}</a></li>
                    <li><a class="open-custom-modal" data-rel="login">{{trans('login')}}</a></li>
                @endif
            </ul>

            <div class="hamburger hamburger--squeeze">
                <div class="hamburger-box">
                    <div class="hamburger-inner"></div>
                </div>
            </div>
        </div>
    </header>
@show
