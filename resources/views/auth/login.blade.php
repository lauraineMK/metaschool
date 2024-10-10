<!-- resources/views/auth/login.blade.php -->

@extends('layouts.app')

@section('title', 'Login')

@section('content')
<div class="container">
    <h1 class="page-title">{{ __('messages.login') }}</h1>

    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form method="POST" action="{{ url('login') }}">
        @csrf
        <div class="form-group">
            <label for="email">{{ __('messages.email') }}</label>
            <input type="email" class="form-control" id="email" name="email" required>
        </div>
        <div class="form-group mb-3">
            <label for="password">{{ __('messages.password') }}</label>
            <input type="password" class="form-control" id="password" name="password" required>
        </div>
        <div class="mb-3">
            <button type="submit" class="btn btn-primary">{{ __('messages.login') }}</button>
            <a class="btn btn-secondary" href="{{ url('/') }}" id="backButton">{{ __('messages.back') }}</a>
            <!-- <a class="btn btn-secondary" href="{{ $isMobile ? url('/account') : url('/') }}" id="backButton">{{ __('messages.back') }}</a> -->
        </div>
    </form>
</div>
@endsection
