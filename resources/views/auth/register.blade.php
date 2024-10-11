<!-- resources/views/auth/register.blade.php -->

@extends('layouts.app')

@section('title', 'Register')

@section('content')
<div class="container">
    <h1 class="page-title">{{ __('messages.register') }}</h1>

    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form method="POST" action="{{ url('register') }}">
        @csrf
        <div class="form-group">
            <label for="firstname">{{ __('messages.firstname') }}</label>
            <input type="text" class="form-control" id="firstname" name="firstname" required>
        </div>
        <div class="form-group mt-3">
            <label for="middlename">{{ __('messages.middlename') }}</label>
            <input type="text" class="form-control" id="middlename" name="middlename" placeholder="Optional">
        </div>
        <div class="form-group mt-3">
            <label for="lastname">{{ __('messages.lastname') }}</label>
            <input type="text" class="form-control" id="lastname" name="lastname" required>
        </div>
        <div class="form-group">
            <label for="email">{{ __('messages.email') }}</label>
            <input type="email" class="form-control" id="email" name="email" required>
        </div>
        <div class="form-group">
            <label for="password">{{ __('messages.password') }}</label>
            <input type="password" class="form-control" id="password" name="password" required>
        </div>
        <div class="form-group mb-3">
            <label for="password_confirmation">{{ __('messages.confirm_password') }}</label>
            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
        </div>
        <div class="mb-3">
            <button type="submit" class="btn btn-primary">{{ __('messages.register') }}</button>
            <a class="btn btn-secondary" href="{{ url('/') }}" id="backButton">{{ __('messages.back') }}</a>
            <!-- <a class="btn btn-secondary" href="{{ $isMobile ? url('/account') : url('/') }}" id="backButton">{{ __('messages.back') }}</a> -->
        </div>
    </form>
</div>
@endsection
