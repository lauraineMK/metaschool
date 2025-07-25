@extends('layouts.app')

@section('content')
<div class="container py-5">
    <h1 class="fw-bold mb-4" style="color: #7C3AED; font-family: 'Inter', sans-serif; letter-spacing: 1px;">Détail du cours</h1>
    <div class="card shadow rounded-4 border-0 p-4 mb-4">
        <h3 class="fw-bold mb-2" style="color:#4F46E5;">{{ $course->name }}</h3>
        <div class="mb-2"><strong>Auteur :</strong> {{ $course->author->firstname ?? 'Inconnu' }} {{ $course->author->lastname ?? '' }}</div>
        <div class="mb-2"><strong>Status :</strong> 
            @if($course->status === 'pending')
                <span class="badge bg-warning text-dark">En attente</span>
            @elseif($course->status === 'validated')
                <span class="badge bg-success">Validé</span>
            @elseif($course->status === 'rejected')
                <span class="badge bg-danger">Rejeté</span>
            @else
                <span class="badge bg-secondary">{{ $course->status }}</span>
            @endif
        </div>
        <div class="mb-2"><strong>Date de création :</strong> {{ $course->created_at->format('d/m/Y H:i') }}</div>
        <div class="mb-2"><strong>Description :</strong> {{ $course->description }}</div>
    </div>
    <a href="{{ route('admin.courses.index') }}" class="btn btn-outline-secondary rounded-pill">Retour à la liste</a>
</div>
@endsection
