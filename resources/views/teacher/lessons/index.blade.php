@extends('layouts.app')

@section('title', 'Lessons - MetaSchool')

@section('content')
<div class="container py-5">
    <h1 class="fw-bold mb-4" style="color: #23272f; font-family: 'Inter', sans-serif; letter-spacing: 1px;">Mes leçons créées</h1>
    <a href="{{ route('teacher.lessons.create') }}" class="btn btn-primary mb-4 px-4 py-2 fw-bold shadow-sm rounded-pill" style="font-size:1.1rem; background: #2563eb; border: none;">
        <i class="fas fa-plus me-2"></i>{{ __('messages.create_new_lesson') }}
    </a>
    @if ($lessons->isEmpty())
        <div class="alert alert-info shadow-sm rounded-4 p-4 text-center">{{ __('messages.no_lessons_available') }}</div>
    @else
    <div class="table-responsive rounded-4 shadow-sm">
        <table class="table align-middle mb-0" style="font-family: 'Inter', sans-serif;">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>{{ __('messages.lesson_title(2)') }}</th>
                    <th class="d-none d-md-table-cell">{{ __('messages.lesson_content(2)') }}</th>
                    <th>{{ __('messages.course(2)') }}</th>
                    <th class="d-none d-lg-table-cell">{{ __('messages.section(2)') }}</th>
                    <th class="d-none d-lg-table-cell">{{ __('messages.module(2)') }}</th>
                    <th>{{ __('messages.actions') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($lessons as $lesson)
                <tr>
                    <td>{{ $lesson->id }}</td>
                    <td class="fw-semibold" style="color:#2563eb;">{{ $lesson->title }}</td>
                    <td class="d-none d-md-table-cell text-muted">{{ Str::limit($lesson->content, 50) }}</td>
                    <td>
                        <a href="{{ route('teacher.courses.show', $lesson->course->id) }}" class="text-decoration-none text-dark fw-semibold">
                            {{ $lesson->course->name }}
                        </a>
                    </td>
                    <td class="d-none d-lg-table-cell">{{ $lesson->section ? $lesson->section->name : 'N/A' }}</td>
                    <td class="d-none d-lg-table-cell">{{ $lesson->module ? $lesson->module->name : 'N/A' }}</td>
                    <td>
                        <div class="d-flex gap-2">
                            <a href="{{ route('teacher.lessons.show', $lesson->id) }}" class="btn btn-outline-primary btn-sm rounded-pill fw-semibold shadow-sm"><i class="fas fa-eye me-1"></i> Voir</a>
                            <a href="{{ route('teacher.lessons.edit', $lesson->id) }}" class="btn btn-outline-secondary btn-sm rounded-pill fw-semibold shadow-sm"><i class="fas fa-edit me-1"></i> Éditer</a>
                            <form action="{{ route('teacher.lessons.destroy', $lesson->id) }}" method="POST" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-outline-danger btn-sm rounded-pill fw-semibold shadow-sm" onclick="return confirm('{{ __('messages.are_you_sure_you_want_to_delete_this_lesson') }}')">
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
