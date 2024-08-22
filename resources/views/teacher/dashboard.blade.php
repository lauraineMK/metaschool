@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Dashboard Enseignant</h1>
        <p>Bienvenue, {{ Auth::user()->firstname }} !</p>
        <!-- Contenu spécifique aux enseignants -->
    </div>
@endsection
