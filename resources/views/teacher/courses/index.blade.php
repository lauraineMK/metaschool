@extends('layouts.app')

@section('title', 'Courses - MetaSchool')

@section('content')
<div class="container py-5">
    <h1 class="fw-bold mb-4" style="color: #23272f; font-family: 'Inter', sans-serif; letter-spacing: 1px;">Mes cours créés</h1>
    <a href="{{ route('teacher.courses.create') }}" class="btn btn-primary mb-4 px-4 py-2 fw-bold shadow-sm rounded-pill" style="font-size:1.1rem; background: #2563eb; border: none;">
        <i class="fas fa-plus me-2"></i>{{ __('messages.create_new_course') }}
    </a>
    @if ($courses->isEmpty())
        <div class="alert alert-info shadow-sm rounded-4 p-4 text-center">{{ __('messages.no_courses_available') }}</div>
    @else
    <div class="row g-4">
        @foreach ($courses as $course)
        <div class="col-12 col-md-6 col-lg-4">
            <div class="card shadow rounded-4 border-0 h-100 p-4 d-flex flex-column justify-content-between" style="background: #fff;">
                <div>
                    <div class="d-flex align-items-center mb-3">
                        <div class="course-thumbnail bg-secondary rounded-circle d-flex align-items-center justify-content-center me-3 shadow-sm" style="width: 56px; height: 56px;">
                            <i class="fas fa-book text-white fa-lg"></i>
                        </div>
                        <div>
                            <h5 class="fw-bold mb-1" style="color:#23272f; font-family: 'Inter', sans-serif;">{{ $course->name }}</h5>
                        </div>
                    </div>
                    <p class="text-muted mb-3" style="min-height:48px;">{{ $course->description }}</p>
                </div>
                <div class="d-flex gap-2 mt-2">
                    <a href="{{ route('teacher.courses.show', $course->id) }}" class="btn btn-outline-primary rounded-pill flex-fill fw-semibold shadow-sm" style="border-width:2px;"><i class="fas fa-eye me-1"></i> Voir</a>
                    <a href="{{ route('teacher.courses.edit', $course->id) }}" class="btn btn-outline-secondary rounded-pill flex-fill fw-semibold shadow-sm" style="border-width:2px;"><i class="fas fa-edit me-1"></i> Éditer</a>
                    <form action="{{ route('teacher.courses.destroy', $course->id) }}" method="POST" style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-outline-danger rounded-pill flex-fill fw-semibold shadow-sm" style="border-width:2px;" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce cours ?');">
                            <i class="fas fa-trash-alt me-1"></i> Supprimer
                        </button>
                    </form>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    @endif
</div>
@endsection
