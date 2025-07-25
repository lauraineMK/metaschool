@extends('layouts.app')

@section('title', 'Lessons - MetaSchool')

@section('content')
<div class="container py-5">
    <h1 class="mb-4 fw-bold" style="color: #1c1d1f;">{{ __('messages.lessons') }}</h1>
    @if ($lessons->isEmpty())
        <p>{{ __('messages.no_lessons_available') }}</p>
    @else
    <div class="row g-4">
        @foreach ($lessons as $lesson)
        <div class="col-md-4">
            <div class="card h-100 shadow-sm border-0">
                <div class="card-body">
                    <h5 class="card-title">{{ $lesson->title }}</h5>
                    <p class="card-text text-muted">{{ Str::limit($lesson->content, 50) }}</p>
                    <p class="mb-1"><span class="fw-bold">Cours :</span> {{ $lesson->course->name }}</p>
                    <a href="{{ route('student.lessons.show', $lesson->id) }}" class="btn btn-primary w-100" style="border-radius: 30px; background: #6C63FF;">Voir la leçon</a>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    @endif
</div>
@endsection
