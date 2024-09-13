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
