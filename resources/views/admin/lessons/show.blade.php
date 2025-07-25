@extends('layouts.app')

@section('content')
<div class="container py-5">
    <h1 class="fw-bold mb-4" style="color: #7C3AED; font-family: 'Inter', sans-serif; letter-spacing: 1px;">Détail de la leçon</h1>
    <div class="card shadow rounded-4 border-0 p-4 mb-4">
        <h3 class="fw-bold mb-2" style="color:#4F46E5;">{{ $lesson->title }}</h3>
        <div class="mb-2"><strong>Cours :</strong> {{ $lesson->module->section->course->name ?? 'N/A' }}</div>
        <div class="mb-2"><strong>Status :</strong> 
            @if($lesson->status === 'pending')
                <span class="badge bg-warning text-dark">En attente</span>
            @elseif($lesson->status === 'validated')
                <span class="badge bg-success">Validée</span>
            @elseif($lesson->status === 'rejected')
                <span class="badge bg-danger">Rejetée</span>
            @else
                <span class="badge bg-secondary">{{ $lesson->status }}</span>
            @endif
        </div>
        <div class="mb-2"><strong>Date de création :</strong> {{ $lesson->created_at->format('d/m/Y H:i') }}</div>
        <div class="mb-2"><strong>Description :</strong> {{ $lesson->description }}</div>
    </div>
    <a href="{{ route('admin.lessons.index') }}" class="btn btn-outline-secondary rounded-pill">Retour à la liste</a>
</div>
@endsection
