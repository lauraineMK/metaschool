@extends('layouts.app')

@section('content')
<div class="container py-5">
    <h1 class="fw-bold mb-4" style="color: #7C3AED; font-family: 'Inter', sans-serif; letter-spacing: 1px;">Gestion des quiz</h1>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <div class="table-responsive">
        <table class="table table-hover align-middle bg-white rounded-4 shadow-sm">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Titre</th>
                    <th>Cours</th>
                    <th>Status</th>
                    <th>Date création</th>
                    <th>Enseignant</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($quizzes as $quiz)
                <tr>
                    <td>{{ $quiz->id }}</td>
                    <td>{{ $quiz->title }}</td>
                    <td>{{ $quiz->lesson->module->section->course->name ?? 'N/A' }}</td>
                    <td>
                        <span class="badge-status {{ $quiz->status }}">
                            @if($quiz->status === 'pending') En attente
                            @elseif($quiz->status === 'validated') Validé
                            @elseif($quiz->status === 'rejected') Rejeté
                            @else {{ $quiz->status }} @endif
                        </span>
                    </td>
                    <td>{{ $quiz->created_at->format('d/m/Y') }}</td>
                    <td>
                        <span class="fw-bold text-primary">{{ $quiz->lesson->module->section->course->author->firstname ?? 'Inconnu' }} {{ $quiz->lesson->module->section->course->author->lastname ?? '' }}</span>
                    </td>
                    <td>
                        <a href="{{ route('admin.quizzes.show', $quiz->id) }}" class="btn btn-sm btn-outline-primary rounded-pill">Voir</a>
                        @if($quiz->status === 'pending')
                            <form action="{{ route('admin.quizzes.validate', $quiz->id) }}" method="POST" class="d-inline ms-1">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-success rounded-circle" title="Valider" style="width:2.2em;height:2.2em;display:inline-flex;align-items:center;justify-content:center;"><span style="font-size:1.2em;">✔️</span></button>
                            </form>
                            <form action="{{ route('admin.quizzes.reject', $quiz->id) }}" method="POST" class="d-inline ms-1">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-danger rounded-circle" title="Rejeter" style="width:2.2em;height:2.2em;display:inline-flex;align-items:center;justify-content:center;"><span style="font-size:1.2em;">✖️</span></button>
                            </form>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="mt-4">
        {{ $quizzes->links() }}
    </div>
</div>
<style>
/* Suppression des flèches de tri Bootstrap/DataTables */
.table th.sorting:after,
.table th.sorting:before,
.table th.sorting_asc:after,
.table th.sorting_asc:before,
.table th.sorting_desc:after,
.table th.sorting_desc:before {
    display: none !important;
}

/* Pagination MetaSchool : masquer tout sauf Previous et Next */
.pagination .page-item:not(.previous):not(.next) {
    display: none !important;
}
.pagination .page-item .page-link[aria-label="Next"],
.pagination .page-item .page-link[aria-label="Previous"],
.pagination .page-item .page-link svg,
.pagination .page-item .page-link i {
    display: none !important;
}
</style>
@endsection
