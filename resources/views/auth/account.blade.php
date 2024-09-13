<!-- resources/views/auth/account.blade.php -->

@extends('layouts.app')

@section('title', 'Account')

@section('content')
<div class="container">
<h1 class="page-title">Account</h1>
    <p>To access your account, please login or register.</p>

    <div class="mt-4">
        <a class="btn btn-primary" href="{{ route('login') }}">Login</a>
        <a class="btn btn-secondary" href="{{ route('register') }}">Register</a>
        <a class="btn btn-secondary" href="{{ url('/') }}" id="backButton">Back</a>
    </div>
</div>
@endsection
