@extends('layouts.app')

@section('title', 'Course Details - MetaSchool')

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-md-8">
            <div class="card mb-4 shadow-sm border-0">
                <div class="card-body">
                    <h1 class="card-title mb-3" style="color: #1c1d1f;">{{ $course->name }}</h1>
                    <p class="card-text text-muted">{{ $course->description }}</p>
                </div>
            </div>
            <h2 class="fw-bold mb-3" style="color: #1c1d1f;">{{ __('messages.course_content') }}</h2>
            @if (!$course->sections->isEmpty())
                @foreach ($course->sections as $section)
                <div class="mb-4">
                    <h4 class="fw-bold" style="color: #6C63FF;">{{ __('messages.section') }} {{ $section->name }}</h4>
                    @if (!$section->modules->isEmpty())
                        @foreach ($section->modules as $module)
                        <div class="mb-3 ms-3">
                            <h5 class="fw-bold" style="color: #fbb034;">{{ __('messages.module') }} {{ $module->name }}</h5>
                            @if (!$module->lessons->isEmpty())
                                <ul class="list-group ms-3">
                                    @foreach ($module->lessons as $lesson)
                                    @php
                                        $isCompleted = in_array($lesson->id, $completedLessons ?? []);
                                    @endphp
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        <div class="d-flex align-items-center gap-2">
                                            <i class="fas fa-play-circle text-primary"></i>
                                            <span class="fw-bold">{{ $lesson->title }}</span>
                                            @if($isCompleted)
                                                <span class="badge bg-success ms-2">Terminé</span>
                                            @endif
                                        </div>
                                        <a href="{{ route('student.lessons.show', $lesson->id) }}" class="btn btn-outline-primary btn-sm rounded-pill">
                                            <i class="fas fa-play me-1"></i> {{ $isCompleted ? 'Revoir' : 'Commencer' }}
                                        </a>
                                    </li>
                                    @endforeach
                                </ul>
                            @else
                                <p class="text-muted ms-3">{{ __('messages.no_lessons_available_in_this_module') }}</p>
                            @endif
                        </div>
                        @endforeach
                    @else
                        <p class="text-muted ms-3">{{ __('messages.no_modules_available_in_this_section') }}</p>
                    @endif
                </div>
                @endforeach
            @else
                <p class="text-muted">{{ __('messages.no_sections_available_in_this_course') }}</p>
            @endif

            @if($literature->count() > 0)
                <div class="mt-4">
                    <h3 class="fw-bold" style="color: #7C3AED;">Littérature / Documents du cours</h3>
                    <ul class="list-group">
                        @foreach($literature as $doc)
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <span>{{ $doc->title }}</span>
                                <a href="{{ url('storage/' . $doc->file) }}" class="btn btn-outline-info btn-sm rounded-pill" download>
                                    <i class="fa fa-download me-1"></i> Télécharger
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>
        <div class="col-md-4">
            <a href="{{ route('student.courses.index') }}" class="btn btn-secondary w-100 mb-3" style="border-radius: 30px;">{{ __('messages.back_to_courses') }}</a>
        </div>
    </div>
</div>
@endsection
