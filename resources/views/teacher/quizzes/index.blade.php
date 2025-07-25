@extends('layouts.app')

@section('title', 'Quizzes - MetaSchool')

@section('content')
<div class="container py-5">
    <h1 class="fw-bold mb-4" style="color: #23272f; font-family: 'Inter', sans-serif; letter-spacing: 1px;">Mes quiz créés</h1>
    <a href="{{ route('teacher.quizzes.create') }}" class="btn btn-primary mb-4 px-4 py-2 fw-bold shadow-sm rounded-pill" style="font-size:1.1rem; background: #2563eb; border: none;">
        <i class="fas fa-plus me-2"></i>Créer un quiz
    </a>
    @if ($quizzes->isEmpty())
        <div class="alert alert-info shadow-sm rounded-4 p-4 text-center">Aucun quiz disponible.</div>
    @else
    <div class="table-responsive rounded-4 shadow-sm">
        <table class="table align-middle mb-0" style="font-family: 'Inter', sans-serif;">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>Titre du quiz</th>
                    <th class="d-none d-md-table-cell">Description</th>
                    <th>Leçon</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($quizzes as $quiz)
                <tr>
                    <td>{{ $quiz->id }}</td>
                    <td class="fw-semibold" style="color:#2563eb;">{{ $quiz->title }}</td>
                    <td class="d-none d-md-table-cell text-muted">{{ $quiz->description }}</td>
                    <td>
                        <a href="{{ route('teacher.lessons.show', $quiz->lesson->id) }}" class="text-decoration-none text-dark fw-semibold">
                            {{ $quiz->lesson ? $quiz->lesson->title : 'N/A' }}
                        </a>
                    </td>
                    <td>
                        <div class="d-flex gap-2">
                            <a href="{{ route('teacher.quizzes.show', $quiz->id) }}" class="btn btn-outline-primary btn-sm rounded-pill fw-semibold shadow-sm"><i class="fas fa-eye me-1"></i> Voir</a>
                            <a href="{{ route('teacher.quizzes.edit', $quiz->id) }}" class="btn btn-outline-secondary btn-sm rounded-pill fw-semibold shadow-sm"><i class="fas fa-edit me-1"></i> Éditer</a>
                            <form action="{{ route('teacher.quizzes.destroy', $quiz->id) }}" method="POST" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-outline-danger btn-sm rounded-pill fw-semibold shadow-sm" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce quiz ?')">
                                    <i class="fas fa-trash me-1"></i> Supprimer
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endif
</div>
@endsection
