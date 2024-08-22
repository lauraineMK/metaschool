@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Dashboard Étudiant</h1>
        <p>Bienvenue, {{ Auth::user()->firstname }} !</p>
        <!-- Contenu spécifique aux étudiants -->
    </div>
@endsection
