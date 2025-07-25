<!-- resources/views/auth/login.blade.php -->

@extends('layouts.app')

@section('title', 'Login')

@section('content')
<div class="container d-flex align-items-center justify-content-center min-vh-100">
    <div class="card shadow-lg p-4" style="max-width: 400px; width: 100%; border-radius: 1.5rem;">
        <div class="text-center mb-4">
            <a href="/" class="navbar-brand fw-bold d-flex align-items-center justify-content-center text-primary" style="font-size: 2rem; color: #7C3AED !important;">
                <i class="fas fa-graduation-cap me-2" style="color: #FFD600; font-size: 1.5rem;"></i>MetaSchool
            </a>
            <h2 class="h4 mt-3 mb-2">Connexion</h2>
            <p class="text-muted mb-0">Connectez-vous à votre compte</p>
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

        <form method="POST" action="{{ route('login') }}">
            @csrf
            <div class="mb-3">
                <label for="email" class="form-label">Adresse e-mail</label>
                <input id="email" type="email" class="form-control rounded-pill @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autofocus>
                @error('email')
                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                @enderror
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Mot de passe</label>
                <input id="password" type="password" class="form-control rounded-pill @error('password') is-invalid @enderror" name="password" required>
                @error('password')
                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                @enderror
            </div>
            <div class="mb-3 form-check">
                <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                <label class="form-check-label" for="remember">Se souvenir de moi</label>
            </div>
            <button type="submit" class="btn btn-primary w-100 rounded-pill fw-bold mb-2">Se connecter</button>
        </form>
        <div class="text-center mt-4">
            <span class="text-muted">Pas encore de compte ?</span>
            <a href="{{ route('register') }}" class="fw-bold text-primary ms-1">Créer un compte</a>
        </div>
    </div>
</div>
@endsection
