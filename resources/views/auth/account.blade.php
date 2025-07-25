<!-- resources/views/auth/account.blade.php -->

@extends('layouts.app')

@section('title', 'Account')

@section('content')
<div class="container py-5" style="background:linear-gradient(120deg,#f7f7fa 60%,#e9e6fc 100%);min-height:100vh;">
    <div class="row justify-content-center">
        <div class="col-lg-6 col-md-8 col-12">
            <div class="card shadow-lg rounded-4 border-0 mb-4">
                <div class="card-body p-4">
                    @auth
                    <div class="d-flex align-items-center mb-4">
                        <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-3" style="width:56px;height:56px;font-size:2rem;">
                            <i class="fas fa-user"></i>
                        </div>
                        <div>
                            <h2 class="fw-bold mb-0" style="color:#7C3AED;">{{ Auth::user()->firstname }} {{ Auth::user()->middlename }} {{ Auth::user()->lastname }}</h2>
                            <span class="badge bg-secondary">{{ Auth::user()->role == 'teacher' ? 'Professeur' : 'Étudiant' }}</span>
                        </div>
                    </div>
                    <hr>
                    <form action="{{ route('account.update') }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="firstname" class="fw-semibold">Prénom</label>
                                <input type="text" class="form-control" id="firstname" name="firstname" value="{{ old('firstname', Auth::user()->firstname) }}">
                            </div>
                            <div class="col-md-6">
                                <label for="middlename" class="fw-semibold">Deuxième prénom</label>
                                <input type="text" class="form-control" id="middlename" name="middlename" value="{{ old('middlename', Auth::user()->middlename) }}" placeholder="Optionnel">
                            </div>
                            <div class="col-md-12">
                                <label for="lastname" class="fw-semibold">Nom</label>
                                <input type="text" class="form-control" id="lastname" name="lastname" value="{{ old('lastname', Auth::user()->lastname) }}">
                            </div>
                            <div class="col-md-12">
                                <label for="email" class="fw-semibold">Email</label>
                                <input type="email" class="form-control" id="email" name="email" value="{{ old('email', Auth::user()->email) }}">
                            </div>
                            <div class="col-md-12">
                                <label for="password" class="fw-semibold">Nouveau mot de passe</label>
                                <input type="password" class="form-control" id="password" name="password" placeholder="Changer le mot de passe (optionnel)">
                            </div>
                        </div>
                        <div class="d-flex justify-content-between align-items-center mt-4">
                            <button type="submit" class="btn btn-primary rounded-pill px-4 fw-bold shadow-sm">Enregistrer</button>
                            <a class="btn btn-outline-danger rounded-pill px-4 fw-bold" href="{{ route('logout') }}"
                                onclick="event.preventDefault();document.getElementById('logout-form').submit();">Déconnexion</a>
                        </div>
                    </form>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                    @else
                    <div class="text-center py-5">
                        <h2 class="fw-bold mb-3" style="color:#7C3AED;">{{ __('messages.account') }}</h2>
                        <p>Pour accéder à votre compte, veuillez vous connecter ou vous inscrire.</p>
                        <a class="btn btn-primary rounded-pill px-4 fw-bold me-2" href="{{ route('login') }}">Connexion</a>
                        <a class="btn btn-outline-secondary rounded-pill px-4 fw-bold" href="{{ route('register') }}">Inscription</a>
                    </div>
                    @endauth
                    <div class="mt-4 text-center">
                        <a class="btn btn-secondary rounded-pill px-4 fw-bold" href="{{ url('/') }}" id="backButton">Retour</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
