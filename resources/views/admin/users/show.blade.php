@extends('layouts.app')

@section('content')
<div class="container py-5">
    <h1 class="fw-bold mb-4" style="color: #7C3AED; font-family: 'Inter', sans-serif; letter-spacing: 1px;">Détail utilisateur</h1>
    <div class="card shadow rounded-4 border-0 p-4 mb-4">
        <h3 class="fw-bold mb-2" style="color:#4F46E5;">{{ $user->firstname }} {{ $user->lastname }}</h3>
        <div class="mb-2"><strong>Email :</strong> {{ $user->email }}</div>
        <div class="mb-2"><strong>Rôle :</strong> <span class="badge bg-primary">{{ ucfirst($user->role) }}</span></div>
        <div class="mb-2"><strong>Date de création :</strong> {{ $user->created_at->format('d/m/Y H:i') }}</div>
    </div>
    <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary rounded-pill">Retour à la liste</a>
</div>
@endsection
