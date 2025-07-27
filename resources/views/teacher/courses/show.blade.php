@extends('layouts.app')

@section('title', 'Course Details - MetaSchool')

@section('content')
<style>
    body {
        background: linear-gradient(120deg,#f7f7fa 60%,#e9e6fc 100%);
        font-family: 'Inter', Arial, sans-serif;
        margin: 0;
        padding: 0;
    }
    .container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 1rem;
    }
    .main-card {
        background: #fff;
        border-radius: 2rem;
        box-shadow: 0 8px 32px rgba(124,58,237,0.10);
        padding: 2rem 1.5rem;
        margin-bottom: 2rem;
        max-width: 900px;
        margin-left: auto;
        margin-right: auto;
    }
    .block-card {
        background: #f7f7fa;
        border-radius: 1.5rem;
        box-shadow: 0 2px 8px #ede9fe;
        padding: 1rem 1rem;
        margin-bottom: 1rem;
    }
    .block-title {
        font-size: 1.1rem;
        font-weight: bold;
        color: #7c3aed;
        margin-bottom: 0.5rem;
    }
    .lesson-label {
        font-size: 1rem;
        font-weight: 600;
        color: #6366f1;
        margin-bottom: 0.5rem;
        display: block;
    }
    .btn-danger {
        background: #ef4444;
        color: #fff;
        border: none;
        border-radius: 1rem;
        padding: 0.3rem 0.8rem;
        font-size: 0.95rem;
        font-weight: 500;
        cursor: pointer;
        transition: background 0.2s;
        margin-left: 0.5rem;
    }
    .btn-danger:hover {
        background: #dc2626;
    }
    .no-modules, .no-lessons, .no-sections {
        color: #ef4444;
        background: #fef2f2;
        border-radius: 1rem;
        padding: 0.7rem;
        text-align: center;
        margin: 0.7rem 0;
        font-weight: 500;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.98rem;
    }
    .no-modules::before, .no-lessons::before, .no-sections::before {
        content: "⚠️ ";
        margin-right: 0.5rem;
    }
    .footer {
        background: #7c3aed;
        color: #fff;
        padding: 1rem 0 0.7rem 0;
        text-align: center;
        margin-top: 2rem;
        border-top-left-radius: 2rem;
        border-top-right-radius: 2rem;
        max-width: 1200px;
        margin-left: auto;
        margin-right: auto;
    }
    .footer-links a {
        color: #fff;
        margin: 0 0.7rem;
        text-decoration: none;
        font-weight: 500;
        transition: color 0.2s;
        font-size: 1rem;
    }
    .footer-links a:hover {
        color: #ede9fe;
    }
</style>
<div class="container">

@if($course->sections && $course->sections->count() > 0)
    @foreach ($course->sections as $section)
        <div class="main-card">
            <span class="lesson-label">Section : {{ $section->name }}</span>
            <p style="color:#444;font-size:1rem;">{{ $section->description }}</p>
            <form method="POST" action="{{ route('teacher.section.destroy', $section->id) }}" onsubmit="return confirm('Supprimer cette section ?');" style="display:inline-block;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn-danger"><i class="fa fa-trash"></i> Supprimer</button>
            </form>
            @if (!$section->modules->isEmpty())
                @foreach ($section->modules as $module)
                    <div class="block-card">
                        <div style="display:flex;justify-content:space-between;align-items:center;">
                            <span class="lesson-label">Module : {{ $module->name }}</span>
                            <form method="POST" action="{{ route('teacher.module.destroy', $module->id) }}" onsubmit="return confirm('Supprimer ce module ?');" style="display:inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-danger"><i class="fa fa-trash"></i> Supprimer</button>
                            </form>
                        </div>
                        @if (!$module->lessons->isEmpty())
                            @foreach ($module->lessons as $lesson)
                                <div class="block-card" style="background:#fff;box-shadow:0 2px 8px #ede9fe;">
                                    <div class="block-title">{{ $lesson->title }}</div>
                                    <span class="lesson-label">{{ __('messages.lesson_content') }}</span>
                                    <div style="background:#f7f7fa;border-radius:1rem;padding:1rem 1.5rem;margin-top:0.5rem;box-shadow:0 2px 8px #ede9fe;">{{ $lesson->content }}</div>
                                    <div class="mt-3">
                                        @if($lesson->videos && $lesson->videos->count() > 0)
                                            <div class="lesson-label mb-2">{{ __('messages.videos') }}</div>
                                            <div class="row">
                                            @foreach($lesson->videos as $video)
                                                <div class="col-md-6 mb-4">
                                                    <div style="background:#f7f7fa;border-radius:1rem;padding:1rem 1.5rem;">
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
                                        @endif
                                        @if($lesson->documents && $lesson->documents->count() > 0)
                                            <div class="lesson-label mb-2">{{ __('messages.documents') }}</div>
                                            <div class="row">
                                            @foreach($lesson->documents as $document)
                                                <div class="col-md-6 mb-4">
                                                    <div style="background:#f7f7fa;border-radius:1rem;padding:1rem 1.5rem;">
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
                                                                <a href="{{ url('storage/' . $document->file) }}" class="course-btn" target="_blank">{{ __('messages.view') }} {{ $document->title }}</a>
                                                                <a href="{{ url('storage/' . $document->file) }}" class="course-btn" download>{{ __('messages.download') }} {{ $document->title }}</a>
                                                            @endif
                                                        @else
                                                            <p>{{ __('messages.no_file_available_for_this_document') }}</p>
                                                        @endif
                                                    </div>
                                                </div>
                                            @endforeach
                                            </div>
                                        @endif
                                        <div class="mt-2">
                                            <div class="lesson-label mb-2">Quiz</div>
                                            @if($lesson->quiz)
                                                <a href="{{ route('teacher.quizzes.show', $lesson->quiz->id) }}" class="course-btn">
                                                    {{ $lesson->quiz->title }}
                                                </a>
                                            @else
                                                <div class="mt-2"><em>{{ __('messages.no_quiz_available_for_this_lesson') }}</em></div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div class="no-lessons">{{ __('messages.no_lessons_available_in_this_module') }}</div>
                        @endif
                    </div>
                @endforeach
            @else
                <div class="no-modules">{{ __('messages.no_modules_available_in_this_section') }}</div>
            @endif
        </div>
    @endforeach
@else
    <div class="no-sections">{{ __('messages.no_sections_available_in_this_course') }}</div>
@endif
</div>
@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Dynamique pour modules/sections si besoin
    // (à adapter si tu ajoutes des filtres par cours)

    // Add Video
    const addVideoBtn = document.getElementById('add-video-button');
    const videoGroups = document.getElementById('video-groups');
    if (addVideoBtn && videoGroups) {
        addVideoBtn.addEventListener('click', function() {
            const idx = videoGroups.querySelectorAll('.video-group').length;
            const group = document.createElement('div');
            group.className = 'video-group mt-3';
            group.innerHTML = `
                <div class="form-group mb-3">
                    <label class="fw-semibold">Titre vidéo</label>
                    <input type="text" name="videos[${idx}][title]" class="form-control rounded-3 border-2" placeholder="Titre">
                </div>
                <div class="form-group mb-3">
                    <label class="fw-semibold">URL vidéo</label>
                    <input type="text" name="videos[${idx}][url]" class="form-control rounded-3 border-2" placeholder="URL">
                </div>
                <div class="form-group mb-3">
                    <label class="fw-semibold">Description vidéo</label>
                    <textarea name="videos[${idx}][description]" class="form-control rounded-3 border-2" rows="3" placeholder="Description"></textarea>
                </div>
                <button type="button" class="btn btn-danger btn-sm mt-2 remove-video">Supprimer</button>
            `;
            videoGroups.appendChild(group);
        });
        videoGroups.addEventListener('click', function(e) {
            if (e.target.classList.contains('remove-video')) {
                e.target.closest('.video-group').remove();
            }
        });
    }

    // Add Document
    const addDocBtn = document.getElementById('add-document-button');
    const docGroups = document.getElementById('document-groups');
    if (addDocBtn && docGroups) {
        addDocBtn.addEventListener('click', function() {
            const idx = docGroups.querySelectorAll('.document-group').length;
            const group = document.createElement('div');
            group.className = 'document-group mt-3';
            group.innerHTML = `
                <div class="form-group mb-3">
                    <label class="fw-semibold">Titre document</label>
                    <input type="text" name="documents[${idx}][title]" class="form-control rounded-3 border-2" placeholder="Titre">
                </div>
                <div class="form-group mb-3">
                    <label class="fw-semibold">Fichier</label>
                    <input type="file" name="documents[${idx}][file]" accept=".pdf,.doc,.docx,.xls,.xlsx,.txt" class="form-control rounded-3 border-2">
                </div>
                <div class="form-group mb-3">
                    <label class="fw-semibold">Description document</label>
                    <textarea name="documents[${idx}][description]" class="form-control rounded-3 border-2" rows="3" placeholder="Description"></textarea>
                </div>
                <button type="button" class="btn btn-danger btn-sm mt-2 remove-document">Supprimer</button>
            `;
            docGroups.appendChild(group);
        });
        docGroups.addEventListener('click', function(e) {
            if (e.target.classList.contains('remove-document')) {
                e.target.closest('.document-group').remove();
            }
        });
    }
});
</script>
@endpush
@endsection
