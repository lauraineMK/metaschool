<!-- resources/views/auth/account.blade.php -->

@extends('layouts.app')

@section('title', 'Account')

@section('content')
<div class="container">
<h1 class="page-title">
        @auth
            {{ Auth::user()->firstname }} {{ Auth::user()->surname }}
        @else
            Account
        @endauth
    </h1>

    <div class="mt-4">
        @auth
            <!-- When the user is authenticated -->
            <p>Welcome back, {{ Auth::user()->firstname }}!</p>

            <!-- User account update form -->
            <form action="{{ route('account.update') }}" method="POST">
                @csrf
                @method('PUT')

                <!-- First Name field -->
                <div class="form-group">
                    <label for="firstname">First Name</label>
                    <input type="text" class="form-control" id="firstname" name="firstname" value="{{ old('firstname', Auth::user()->firstname) }}">
                </div>

                <!-- Surname field -->
                <div class="form-group mt-3">
                    <label for="surname">Surname</label>
                    <input type="text" class="form-control" id="surname" name="surname" value="{{ old('surname', Auth::user()->surname) }}">
                </div>

                <!-- Email field -->
                <div class="form-group mt-3">
                    <label for="email">Email</label>
                    <input type="email" class="form-control" id="email" name="email" value="{{ old('email', Auth::user()->email) }}">
                </div>

                <!-- Password field (optional) -->
                <div class="form-group mt-3">
                    <label for="password">New Password</label>
                    <input type="password" class="form-control" id="password" name="password" placeholder="Enter new password (optional)">
                </div>

                <!-- Save Changes button -->
                <div class="form-group mt-4">
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </div>
            </form>

            <a class="btn btn-secondary" href="{{ route('logout') }}"
               onclick="event.preventDefault();
               document.getElementById('logout-form').submit();">Logout</a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
        @else
            <!-- When the user is not authenticated -->
            <p>To access your account, please login or register.</p>
            <a class="btn btn-primary" href="{{ route('login') }}">Login</a>
            <a class="btn btn-secondary" href="{{ route('register') }}">Register</a>
        @endauth

        <a class="btn btn-secondary" href="{{ url('/') }}" id="backButton">Back</a>
    </div>
</div>
@endsection
