@extends('layouts.app')

@section('title', 'Lesson Details - MetaSchool')

@section('content')
<style>
    body {
        background: linear-gradient(120deg,#f7f7fa 60%,#e9e6fc 100%);
        font-family: 'Inter', Arial, sans-serif;
    }
    .main-card {
        background: #fff;
        border-radius: 2rem;
        box-shadow: 0 8px 32px rgba(124,58,237,0.10);
        padding: 2.5rem 2rem;
        margin-bottom: 2.5rem;
        max-width: 900px;
        margin-left: auto;
        margin-right: auto;
    }
    .block-card {
        background: #f7f7fa;
        border-radius: 1.5rem;
        box-shadow: 0 2px 8px #e9e6fc;
        padding: 2rem 1.5rem;
        margin-bottom: 2rem;
    }
    .block-title {
        color: #7C3AED;
        font-size: 2rem;
        font-weight: 900;
        text-align: center;
        margin-bottom: 1.2rem;
        letter-spacing: 1px;
    }
    .lesson-label {
        color: #7C3AED;
        font-weight: 700;
        font-size: 1.1rem;
        margin-bottom: 0.5rem;
    }
    .lesson-btn, .btn-harmonized {
        background: #7C3AED;
        color: #fff;
        border-radius: 2rem;
        font-weight: 700;
        box-shadow: 0 2px 8px rgba(124,58,237,0.08);
        padding: 0.9rem 2.7rem;
        font-size: 1.18rem;
        transition: background 0.2s;
        margin: 0.5rem 0.7rem 0.5rem 0;
        border: none;
        display: inline-block;
        text-align: center;
    }
    .lesson-btn:hover, .btn-harmonized:hover {
        background: #5b21b6;
        color: #fff;
    }
    .btn-danger {
        background: #ef4444;
        color: #fff;
        border-radius: 2rem;
        font-weight: 700;
        box-shadow: 0 2px 8px rgba(239,68,68,0.08);
        padding: 0.9rem 2.7rem;
        font-size: 1.18rem;
        border: none;
        margin: 0.5rem 0.7rem 0.5rem 0;
    }
    .btn-danger:hover {
        background: #b91c1c;
    }
    .video-container iframe {
        width: 100%;
        height: 350px;
        border-radius: 1rem;
        box-shadow: 0 2px 8px #e9e6fc;
    }
    .lesson-actions {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        gap: 1.5rem;
        margin-bottom: 0;
        background: #f7f7fa;
        border-radius: 2rem;
        box-shadow: 0 8px 32px rgba(124,58,237,0.10);
        padding: 2rem 0.5rem;
        max-width: 900px;
        margin-left: auto;
        margin-right: auto;
        margin-top: 3rem;
        border: 1px solid #ede9fe;
    }
    @media (max-width: 600px) {
        .main-card, .block-card, .lesson-actions {
            padding: 1rem 0.5rem;
        }
        .block-title {
            font-size: 1.3rem;
        }
    }
</style>
<div class="container py-5">
    <div class="main-card">
        <div class="block-card">
            <div class="block-title">{{ $lesson->course->name }}</div>
            <div class="d-flex flex-wrap gap-3 justify-content-center mb-2">
                <span class="lesson-label">Section :</span> <span>{{ $lesson->section ? $lesson->section->name : __('messages.no_section') }}</span>
                <span class="lesson-label">Module :</span> <span>{{ $lesson->module ? $lesson->module->name : __('messages.no_module') }}</span>
                <span class="lesson-label">Niveau :</span> <span>{{ $lesson->level ?? 1 }}</span>
            </div>
        </div>
        <div class="block-card">
            <div class="block-title">{{ $lesson->title }}</div>
            <span class="lesson-label">{{ __('messages.lesson_content') }}</span>
            <div style="background:#fff;border-radius:1rem;padding:1rem 1.5rem;margin-top:0.5rem;box-shadow:0 2px 8px #ede9fe;">{{ $lesson->content }}</div>
        </div>
        <div class="block-card">
            <div class="block-title">{{ __('messages.course_content') }}</div>
            @forelse($lesson->course->sections as $section)
                <div class="block-card" style="background:#fff;box-shadow:0 2px 8px #ede9fe;">
                    <div class="lesson-label mb-2">Section : {{ $section->name }}</div>
                    @if($section->modules->count() > 0)
                        @foreach($section->modules as $module)
                            <div class="block-card" style="background:#f7f7fa;box-shadow:none;padding:1rem 1rem;">
                                <span class="lesson-label">Module : {{ $module->name }}</span>
                                @if($module->lessons->count() > 0)
                                    <ul class="lesson-list" style="margin-top:0.5rem;">
                                        @foreach($module->lessons as $l)
                                            <li style="padding:0.3rem 0;">{{ $l->title }}</li>
                                        @endforeach
                                    </ul>
                                @else
                                    <div class="no-lessons" style="color:#b91c1c;">{{ __('messages.no_lessons_available_for_this_module') }}</div>
                                @endif
                            </div>
                        @endforeach
                    @else
                        <div class="no-modules" style="color:#b91c1c;">{{ __('messages.no_modules_available_in_this_section') }}</div>
                    @endif
                </div>
            @empty
                <div class="no-sections" style="color:#b91c1c;">{{ __('messages.no_sections_available_for_this_course') }}</div>
            @endforelse
        </div>
        <div class="block-card">
            <div class="block-title">{{ __('messages.videos') }}</div>
            @if($videos->count() > 0)
                <div class="row">
                @foreach($videos as $video)
                    <div class="col-md-6 mb-4">
                        <div style="background:#fff;border-radius:1rem;padding:1rem 1.5rem;box-shadow:0 2px 8px #ede9fe;">
                            <h5>{{ $video->title }}</h5>
                            <p>{{ $video->description }}</p>
                            @php
                            $url = $video->url;
                            $videoId = null;
                            if (str_contains($url, 'youtube.com/watch?v=')) {
                                parse_str(parse_url($url, PHP_URL_QUERY), $query);
                                $videoId = $query['v'] ?? null;
                            } elseif (str_contains($url, 'youtu.be/')) {
                                $videoId = basename($url);
                            }
                            @endphp
                            @if($videoId)
                            <div class="video-container mt-2">
                                <iframe src="https://www.youtube.com/embed/{{ $videoId }}" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                            </div>
                            @else
                            <p>{{ __('messages.unsupported_video_format_or_URL') }}.</p>
                            @endif
                        </div>
                    </div>
                @endforeach
                </div>
            @else
                <div class="mt-2"><em>{{ __('messages.no_videos_available_for_this_lesson') }}</em></div>
            @endif
        </div>
        <div class="block-card">
            <div class="block-title">{{ __('messages.documents') }}</div>
            @if($documents->count() > 0)
                <div class="row">
                @foreach($documents as $document)
                    <div class="col-md-6 mb-4">
                        <div style="background:#fff;border-radius:1rem;padding:1rem 1.5rem;box-shadow:0 2px 8px #ede9fe;">
                            <h5>{{ $document->title }}</h5>
                            <p>{{ $document->description }}</p>
                            @if($document->file)
                                @php
                                $fileExtension = strtolower(pathinfo($document->file, PATHINFO_EXTENSION));
                                @endphp
                                @if($fileExtension === 'pdf')
                                    <iframe src="{{ url('storage/' . $document->file) }}" width="100%" height="300px" frameborder="0" style="border-radius:1rem;"></iframe>
                                @elseif(in_array($fileExtension, ['jpg', 'jpeg', 'png', 'gif']))
                                    <img src="{{ url('storage/' . $document->file) }}" alt="{{ $document->title }}" style="max-width: 100%; height: auto; border-radius:1rem;">
                                @else
                                    <a href="{{ url('storage/' . $document->file) }}" class="lesson-btn" target="_blank">{{ __('messages.view') }} {{ $document->title }}</a>
                                    <a href="{{ url('storage/' . $document->file) }}" class="lesson-btn" download>{{ __('messages.download') }} {{ $document->title }}</a>
                                @endif
                            @else
                                <p>{{ __('messages.no_file_available_for_this_document') }}</p>
                            @endif
                        </div>
                    </div>
                @endforeach
                </div>
            @else
                <div class="mt-2"><em>{{ __('messages.no_documents_available_for_this_lesson') }}</em></div>
            @endif
        </div>
        <div class="block-card">
            <div class="block-title">Quiz</div>
            @if($lesson->quiz)
                <a href="{{ route('teacher.quizzes.show', $lesson->quiz->id) }}" class="lesson-btn">
                    {{ $lesson->quiz->title }}
                </a>
            @else
                <div class="mt-2"><em>{{ __('messages.no_quiz_available_for_this_lesson') }}</em></div>
            @endif
        </div>
    </div>
    <!-- Barre d'action moderne tout en bas -->
    <div class="lesson-actions">
        @if ($previousLesson)
        <a href="{{ route('teacher.lessons.show', $previousLesson->id) }}" class="lesson-btn"><strong>{{ __('messages.previous_lesson') }}</strong></a>
        @endif
        <a href="{{ route('teacher.lessons.edit', $lesson->id) }}" class="lesson-btn"><strong>{{ __('messages.edit_lesson') }}</strong></a>
        <form action="{{ route('teacher.lessons.destroy', $lesson->id) }}" method="POST" style="display:inline;">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn-danger"><strong>{{ __('messages.delete_lesson') }}</strong></button>
        </form>
        <a href="{{ route('teacher.lessons.index') }}" class="lesson-btn"><strong>{{ __('messages.back_to_lessons') }}</strong></a>
        <a href="{{ route('teacher.courses.show', $lesson->course->id) }}" class="lesson-btn"><strong>{{ __('messages.back_to_course') }}</strong></a>
    </div>
</div>
@endsection
