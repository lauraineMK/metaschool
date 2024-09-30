<!-- resources/views/auth/register.blade.php -->

@extends('layouts.app')

@section('title', 'Register')

@section('content')
<div class="container">
    <h1 class="page-title">Register</h1>

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
            <label for="firstname">Firstname</label>
            <input type="text" class="form-control" id="firstname" name="firstname" required>
        </div>
        <div class="form-group mt-3">
            <label for="middlename">Middle Name</label>
            <input type="text" class="form-control" id="middlename" name="middlename" placeholder="Optional">
        </div>
        <div class="form-group mt-3">
            <label for="lastname">Last Name</label>
            <input type="text" class="form-control" id="lastname" name="lastname" required>
        </div>
        <div class="form-group">
            <label for="email">Email address</label>
            <input type="email" class="form-control" id="email" name="email" required>
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" class="form-control" id="password" name="password" required>
        </div>
        <div class="form-group mb-3">
            <label for="password_confirmation">Confirm Password</label>
            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
        </div>
        <div class="mb-3">
            <button type="submit" class="btn btn-primary">Register</button>
            <a class="btn btn-secondary" href="{{ url('/') }}" id="backButton">Back</a>
            <!-- <a class="btn btn-secondary" href="{{ $isMobile ? url('/account') : url('/') }}" id="backButton">Back</a> -->
        </div>
    </form>
</div>
@endsection
