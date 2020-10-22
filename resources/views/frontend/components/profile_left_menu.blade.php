<div class="col-md-3">
    <div class="list-group nav tabs ">
        <a href="{{route_locale('frontend.profile.index')}}"
               class="list-group-item list-group-item-action {{ route_locale('frontend.profile.index') == url()->current() ? 'active':''}}">Edit Profile</a>
        <a href="{{route_locale('frontend.profile.change-password')}}"
           class="list-group-item list-group-item-action {{ route_locale('frontend.profile.change-password') == url()->current() ? 'active':''}}">Update Password</a>
        <a href="{{route_locale('frontend.profile.favorites')}}"
           class="list-group-item list-group-item-action {{ route_locale('frontend.profile.favorites') == url()->current() ? 'active':''}}">My Favorites</a>
        <a href="{{route_locale('frontend.profile.issues')}}"
           class="list-group-item list-group-item-action {{ route_locale('frontend.profile.issues') == url()->current() ? 'active':''}}">My Rents</a>
    </div>
    <div class="spacer25"></div>
    <div class="list-group nav tabs ">
        <a href="/logout" class="list-group-item list-group-item-action">Logout</a>
    </div>
</div>
