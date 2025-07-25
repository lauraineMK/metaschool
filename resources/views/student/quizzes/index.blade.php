@extends('layouts.app')

@section('title', 'Quizzes - MetaSchool')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card shadow-lg border-0 rounded-4 mb-4">
                <div class="card-body p-5">
                    <h1 class="fw-bold mb-4" style="color: #7C3AED;"><i class="fas fa-question-circle me-2"></i>Mes Quiz</h1>
                    @if ($quizzes->isEmpty())
                        <div class="alert alert-info">Aucun quiz disponible pour le moment.</div>
                    @else
                        <div class="table-responsive">
                            <table class="table table-hover align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th>#</th>
                                        <th>Titre</th>
                                        <th class="d-none d-md-table-cell">Description</th>
                                        <th>Leçon</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($quizzes as $quiz)
                                    <tr>
                                        <td><span class="badge bg-primary">{{ $quiz->id }}</span></td>
                                        <td class="fw-bold">{{ $quiz->title }}</td>
                                        <td class="d-none d-md-table-cell">{{ $quiz->description }}</td>
                                        <td>
                                            <a href="{{ route('student.lessons.show', $quiz->lesson->id) }}" class="text-decoration-underline">
                                                {{ $quiz->lesson ? $quiz->lesson->title : 'N/A' }}
                                            </a>
                                        </td>
                                        <td>
                                            <a href="{{ route('student.quizzes.show', $quiz->id) }}" class="btn btn-outline-primary btn-sm rounded-pill px-3">
                                                <i class="fas fa-eye me-1"></i> Voir
                                            </a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
