<!-- resources/views/auth/account.blade.php -->

@extends('layouts.app')

@section('title', 'Account')

@section('content')
<div class="container">
    <h1 class="page-title">
        @auth
        {{ Auth::user()->firstname }} {{ Auth::user()->middlename }} {{ Auth::user()->lastname }}
        @else
        {{ __('messages.account') }}
        @endauth
    </h1>

    <div class="mt-4">
        @auth
        <!-- When the user is authenticated -->
        <p>{{ __('messages.welcome_back') }}, {{ Auth::user()->firstname }}!</p>

        <!-- User account update form -->
        <form action="{{ route('account.update') }}" method="POST">
            @csrf
            @method('PUT')

            <!-- First Name field -->
            <div class="form-group">
                <label for="firstname">{{ __('messages.firstname') }}</label>
                <input type="text" class="form-control" id="firstname" name="firstname" value="{{ old('firstname', Auth::user()->firstname) }}">
            </div>

            <!-- Middle Name field -->
            <div class="form-group mt-3">
                <label for="middlename">{{ __('messages.middlename') }}</label>
                <input type="text" class="form-control" id="middlename" name="middlename" value="{{ old('middlename', Auth::user()->middlename) }}" placeholder="Optional">
            </div>

            <!-- Last Name field -->
            <div class="form-group mt-3">
                <label for="lastname">{{ __('messages.lastname') }}</label>
                <input type="text" class="form-control" id="lastname" name="lastname" value="{{ old('lastname', Auth::user()->lastname) }}">
            </div>

            <!-- Email field -->
            <div class="form-group mt-3">
                <label for="email">{{ __('messages.email') }}</label>
                <input type="email" class="form-control" id="email" name="email" value="{{ old('email', Auth::user()->email) }}">
            </div>

            <!-- Password field (optional) -->
            <div class="form-group mt-3">
                <label for="password">{{ __('messages.new_password') }}</label>
                <input type="password" class="form-control" id="password" name="password" placeholder="Enter new password (optional)">
            </div>

            <!-- Save Changes button -->
            <div class="form-group mt-4 mb-4">
                <button type="submit" class="btn btn-primary">{{ __('messages.save') }}</button>
            </div>
        </form>

        <a class="btn btn-secondary" href="{{ route('logout') }}"
            onclick="event.preventDefault();
               document.getElementById('logout-form').submit();">{{ __('messages.logout') }}</a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
        </form>
        @else
        <!-- When the user is not authenticated -->
        <p>To access your account, please login or register.</p>
        <a class="btn btn-primary" href="{{ route('login') }}">{{ __('messages.login') }}</a>
        <a class="btn btn-secondary" href="{{ route('register') }}">{{ __('messages.register') }}</a>
        @endauth

        <a class="btn btn-secondary" href="{{ url('/') }}" id="backButton">{{ __('messages.back') }}</a>
    </div>
</div>
@endsection
