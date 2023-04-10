@extends('layouts.base')

@section('content')


    <h2 class="page-title">
        {{ __('Add new counter') }}
    </h2 >

    <form action="{{route("dashboard.counter.store")}}" method="POST" class="create-form">

        @csrf
        <div class="form-item">
            <label for="site_name" class="form-item__label">{{__('Site name:')}}</label>
            <input name="site_name" id="site_name" type="text" required class="form-item__input">
        </div>

        <div class="form-item">
            <label for="site_url" class="form-item__label">{{__('Site url:')}}</label>
            <input name="site_url" id="site_url" type="text" required class="form-item__input">
        </div>

        <div class="form-item">
            <button type="submit" class="btn">{{ __('Create') }}
        </div>

    </form>
@endsection
