<!-- resources/views/auth/register.blade.php -->

@extends('layouts.app')

@section('title', 'Register')

@section('content')
<div class="container d-flex align-items-center justify-content-center min-vh-100">
    <div class="card shadow-lg p-4" style="max-width: 430px; width: 100%; border-radius: 1.5rem;">
        <div class="text-center mb-4">
            <a href="/" class="navbar-brand fw-bold d-flex align-items-center justify-content-center text-primary" style="font-size: 2rem; color: #7C3AED !important;">
                <i class="fas fa-graduation-cap me-2" style="color: #FFD600; font-size: 1.5rem;"></i>MetaSchool
            </a>
            <h2 class="h4 mt-3 mb-2">Créer un compte</h2>
            <p class="text-muted mb-0">Inscrivez-vous pour commencer à apprendre</p>
        </div>

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
            <div class="mb-3">
                <label for="firstname" class="form-label">{{ __('messages.firstname') }}</label>
                <input id="firstname" type="text" class="form-control rounded-pill @error('firstname') is-invalid @enderror" name="firstname" value="{{ old('firstname') }}" required autofocus>
                @error('firstname')
                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                @enderror
            </div>
            <div class="mb-3">
                <label for="middlename" class="form-label">{{ __('messages.middlename') }}</label>
                <input id="middlename" type="text" class="form-control rounded-pill @error('middlename') is-invalid @enderror" name="middlename" value="{{ old('middlename') }}" placeholder="Optional">
                @error('middlename')
                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                @enderror
            </div>
            <div class="mb-3">
                <label for="lastname" class="form-label">{{ __('messages.lastname') }}</label>
                <input id="lastname" type="text" class="form-control rounded-pill @error('lastname') is-invalid @enderror" name="lastname" value="{{ old('lastname') }}" required>
                @error('lastname')
                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                @enderror
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">{{ __('messages.email') }}</label>
                <input id="email" type="email" class="form-control rounded-pill @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required>
                @error('email')
                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                @enderror
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">{{ __('messages.password') }}</label>
                <input id="password" type="password" class="form-control rounded-pill @error('password') is-invalid @enderror" name="password" required>
                @error('password')
                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                @enderror
            </div>
            <div class="mb-3">
                <label for="password_confirmation" class="form-label">{{ __('messages.confirm_password') }}</label>
                <input id="password_confirmation" type="password" class="form-control rounded-pill" name="password_confirmation" required>
            </div>
            <button type="submit" class="btn btn-primary w-100 rounded-pill fw-bold mb-2">{{ __('messages.register') }}</button>
        </form>
        <div class="text-center mt-4">
            <span class="text-muted">Déjà inscrit ?</span>
            <a href="{{ route('login') }}" class="fw-bold text-primary ms-1">Se connecter</a>
        </div>
    </div>
</div>
@endsection
