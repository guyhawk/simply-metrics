@extends('layouts.empty')

@section('content')

    <form action="{{route("login.authenticate")}}" method="POST" class="login-form">

        @csrf

        <div class="app-name">
            {{ config('app.name') }}
        </div>
        <div class="form-item">
            <label for="email" class="form-item__label">{{__('Email:')}}</label>
            <input name="email" id="email" type="text" required class="form-item__input">
        </div>
        <div class="form-item">
            <label for="password" class="form-item__label">{{__('Password')}}</label>
            <input name="password" id="password" type="password" required class="form-item__input">
        </div>
        <div class="form-item">
            <button type="submit" class="btn w-full">{{ __('Login') }}
        </div>

    </form>
@endsection

