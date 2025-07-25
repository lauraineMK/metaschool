@extends('layouts.app')

@section('content')
<div class="container py-5">
    <h1 class="fw-bold mb-4" style="color: #7C3AED; font-family: 'Inter', sans-serif; letter-spacing: 1px;">Créer un cours</h1>
    <form method="POST" action="{{ route('admin.courses.store') }}">
        @csrf
        <div class="mb-3">
            <label for="name" class="form-label fw-semibold">Titre du cours</label>
            <input type="text" class="form-control rounded-3" id="name" name="name" required>
        </div>
        <div class="mb-3">
            <label for="description" class="form-label fw-semibold">Description</label>
            <textarea class="form-control rounded-3" id="description" name="description" rows="3"></textarea>
        </div>
        <div class="mb-3">
            <label for="author_id" class="form-label fw-semibold">Auteur</label>
            <select class="form-select rounded-3" id="author_id" name="author_id" required>
                @foreach(\App\Models\User::whereIn('role', ['teacher', 'admin'])->get() as $user)
                    <option value="{{ $user->id }}">{{ $user->firstname }} {{ $user->lastname }} ({{ $user->role }})</option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="btn btn-primary rounded-pill px-4 fw-bold">Créer le cours</button>
        <a href="{{ route('admin.courses.index') }}" class="btn btn-outline-secondary rounded-pill ms-2">Annuler</a>
    </form>
</div>
@endsection
