@extends('panel.layouts.login')

@section('body')

    <form url="{{ route('panel.do-login') }}" method="post">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <div class="inputGroup inputGroup1">
            <label for="loginEmail" id="loginEmailLabel">Email</label>
            <input name="email" type="email" id="loginEmail" maxlength="254" value="admin@mylibrary.com"/>
        </div>
        <div class="inputGroup inputGroup2">
            <label for="loginPassword" id="loginPasswordLabel">Password</label>
            <input name="password" type="password" id="loginPassword" value="132435"/>
        </div>
        <div class="inputGroup inputGroup3">
            <button id="login">Log in</button>
        </div>
    </form>

@endsection