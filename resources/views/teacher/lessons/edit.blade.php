@extends('layouts.app')

@section('title', 'Edit Lesson - MetaSchool')

@section('content')
<style>
select option {
    color: #222 !important;
    background: #fff !important;
}
</style>
<style>
    .edit-lesson-form {
        border: 2px solid #7C3AED;
        background: linear-gradient(120deg,#fff 70%,#e9e6fc 100%);
        box-shadow: 0 8px 32px rgba(124,58,237,0.12);
        padding: 2.5rem 2rem;
        border-radius: 2rem;
        margin-bottom: 2rem;
    }
    .edit-lesson-title {
        color: #7C3AED;
        font-size: 2.6rem;
        font-weight: 900;
        letter-spacing: 2px;
        margin-bottom: 1.5rem;
        text-shadow: 0 2px 8px #e9e6fc;
    }
    .edit-lesson-label {
        color: #7C3AED;
        font-weight: 700;
        font-size: 1.1rem;
        margin-bottom: 0.5rem;
    }
    .edit-lesson-btn {
        background: #7C3AED;
        color: #fff;
        border-radius: 2rem;
        font-weight: 700;
        box-shadow: 0 2px 8px rgba(124,58,237,0.08);
        padding: 0.7rem 2.5rem;
        font-size: 1.15rem;
        transition: background 0.2s;
    }
    .edit-lesson-btn:hover {
        background: #5b21b6;
        color: #fff;
    }
</style>
</style>
<div class="container py-5" style="background:linear-gradient(120deg,#f7f7fa 60%,#e9e6fc 100%);min-height:100vh;">
    <div class="row justify-content-center">
        <div class="col-xl-7 col-lg-8 col-md-10 col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="edit-lesson-title">{{ __('messages.edit_lesson') }}</h1>
                <a href="{{ route('teacher.lessons.index') }}" class="btn btn-outline-secondary rounded-pill px-4 fw-bold shadow-sm">{{ __('messages.cancel') }}</a>
            </div>
            <form action="{{ route('teacher.lessons.update', $lesson->id) }}" method="POST" enctype="multipart/form-data" class="edit-lesson-form position-relative" style="min-height:600px;">
                @csrf
                @method('PUT')
                <!-- Course selection -->
                <div class="form-group mb-4">
                    <label for="course_id" class="edit-lesson-label">{{ __('messages.course') }}</label>
                    <select class="form-select border-2 rounded-3" id="course_id" name="course_id" required>
                        <option value="" disabled>{{ __('messages.select_a_course') }}</option>
                        @foreach($courses as $course)
                        <option value="{{ $course->id }}" {{ old('course_id', $lesson->course_id) == $course->id ? 'selected' : '' }}>
                            {{ $course->name }}
                        </option>
                        @endforeach
                    </select>
                </div>
                <!-- Section selection -->
                <div class="form-group mb-4">
                    <label for="section_id" class="edit-lesson-label">Section du cours</label>
                    <select class="form-select border-2 rounded-3" id="section_id" name="section_id" required>
                        <option value="" disabled>Sélectionner une section</option>
                        @if(count($sections) > 0)
                        @foreach($sections as $section)
                        <option value="{{ $section->id }}" data-course="{{ $section->course_id }}" {{ (old('section_id') ? old('section_id') : $lesson->section_id) == $section->id ? 'selected' : '' }}>
                            {{ $section->title }}
                        </option>
                        @endforeach
                        @else
                        <option value="" disabled style="color:#888;">Aucune section disponible pour ce cours</option>
                        @endif
                    </select>
                </div>
                <!-- Module selection -->
                <div class="form-group mb-4">
                    <label for="module_id" class="edit-lesson-label">Module</label>
                    <select class="form-select border-2 rounded-3" id="module_id" name="module_id" required>
                        <option value="" disabled>Sélectionner un module</option>
                        @if(count($modules) > 0)
                        @foreach($modules as $module)
                        <option value="{{ $module->id }}" data-section="{{ $module->section_id }}" {{ (old('module_id') ? old('module_id') : $lesson->module_id) == $module->id ? 'selected' : '' }}>
                            {{ $module->title }}
                        </option>
                        @endforeach
                        @else
                        <option value="" disabled style="color:#888;">Aucun module disponible pour cette section</option>
                        @endif
                    </select>
                </div>
                <!-- Title input -->
                <div class="form-group mb-4">
                    <label for="title" class="edit-lesson-label">{{ __('messages.lesson_title') }}</label>
                    <input type="text" class="form-control border-2 rounded-3" id="title" name="title" value="{{ old('title', $lesson->title) }}" required>
                </div>
                <!-- Content input -->
                <div class="form-group mb-4">
                    <label for="content" class="edit-lesson-label">{{ __('messages.lesson_content') }}</label>
                    <textarea class="form-control border-2 rounded-3" id="content" name="content" rows="5" required>{{ old('content', $lesson->content) }}</textarea>
                </div>
                <!-- Video input -->
                <div id="video-section" class="mb-4">
                    <h3 class="edit-lesson-label mb-3">{{ __('messages.videos') }}</h3>
                    <div id="video-groups">
                        @if(old('videos', $lesson->videos ?? []))
                            @foreach(old('videos', $lesson->videos ?? []) as $i => $video)
                            <div class="video-group mt-3">
                                <div class="form-group mb-3">
                                    <label for="video_title_{{ $i }}" class="fw-semibold">{{ __('messages.video_title') }}</label>
                                    <input type="text" name="videos[{{ $i }}][title]" id="video_title_{{ $i }}" class="form-control rounded-3 border-2" value="{{ $video['title'] ?? '' }}" placeholder="Enter video title">
                                </div>
                                <div class="form-group mb-3">
                                    <label for="video_url_{{ $i }}" class="mt-2 fw-semibold">{{ __('messages.video_URL') }}</label>
                                    <input type="text" name="videos[{{ $i }}][url]" id="video_url_{{ $i }}" class="form-control rounded-3 border-2" value="{{ $video['url'] ?? '' }}" placeholder="Enter video URL">
                                </div>
                                <div class="form-group mb-3">
                                    <label for="video_description_{{ $i }}" class="mt-2 fw-semibold">{{ __('messages.video_description') }}</label>
                                    <textarea name="videos[{{ $i }}][description]" id="video_description_{{ $i }}" class="form-control rounded-3 border-2" rows="3" placeholder="Enter video description">{{ $video['description'] ?? '' }}</textarea>
                                </div>
                                <button type="button" class="btn btn-danger btn-sm mt-2 remove-video">Supprimer</button>
                            </div>
                            @endforeach
                        @else
                        <div class="video-group mt-3">
                            <div class="form-group mb-3">
                                <label for="video_title_0" class="fw-semibold">{{ __('messages.video_title') }}</label>
                                <input type="text" name="videos[0][title]" id="video_title_0" class="form-control rounded-3 border-2" placeholder="Enter video title">
                            </div>
                            <div class="form-group mb-3">
                                <label for="video_url_0" class="mt-2 fw-semibold">{{ __('messages.video_URL') }}</label>
                                <input type="text" name="videos[0][url]" id="video_url_0" class="form-control rounded-3 border-2" placeholder="Enter video URL">
                            </div>
                            <div class="form-group mb-3">
                                <label for="video_description_0" class="mt-2 fw-semibold">{{ __('messages.video_description') }}</label>
                                <textarea name="videos[0][description]" id="video_description_0" class="form-control rounded-3 border-2" rows="3" placeholder="Enter video description"></textarea>
                            </div>
                            <button type="button" class="btn btn-danger btn-sm mt-2 remove-video">Supprimer</button>
                        </div>
                        @endif
                    </div>
                </div>
                <button type="button" id="add-video-button" class="edit-lesson-btn mb-4">{{ __('messages.add_video') }}</button>
                <!-- Document input -->
                <div id="document-section" class="mb-4">
                    <h3 class="edit-lesson-label mb-3">{{ __('messages.documents') }}</h3>
                    <div id="document-groups">
                        @if(old('documents', $lesson->documents ?? []))
                            @foreach(old('documents', $lesson->documents ?? []) as $i => $document)
                            <div class="document-group mt-3">
                                <div class="form-group mb-3">
                                    <label for="document_title_{{ $i }}" class="fw-semibold">{{ __('messages.document_title') }}</label>
                                    <input type="text" name="documents[{{ $i }}][title]" id="document_title_{{ $i }}" class="form-control rounded-3 border-2" value="{{ $document['title'] ?? '' }}" placeholder="Enter document title">
                                </div>
                                <div class="form-group mb-3">
                                    <label for="document_file_{{ $i }}" class="mt-2 fw-semibold">{{ __('messages.document_file') }}</label>
                                    <input type="file" name="documents[{{ $i }}][file]" accept=".pdf,.doc,.docx,.xls,.xlsx,.txt" id="document_file_{{ $i }}" class="form-control rounded-3 border-2">
                                </div>
                                <div class="form-group mb-3">
                                    <label for="document_description_{{ $i }}" class="mt-2 fw-semibold">{{ __('messages.document_description') }}</label>
                                    <textarea name="documents[{{ $i }}][description]" id="document_description_{{ $i }}" class="form-control rounded-3 border-2" rows="3" placeholder="Enter document description">{{ $document['description'] ?? '' }}</textarea>
                                </div>
                                <button type="button" class="btn btn-danger btn-sm mt-2 remove-document">Supprimer</button>
                            </div>
                            @endforeach
                        @else
                        <div class="document-group mt-3">
                            <div class="form-group mb-3">
                                <label for="document_title_0" class="fw-semibold">{{ __('messages.document_title') }}</label>
                                <input type="text" name="documents[0][title]" id="document_title_0" class="form-control rounded-3 border-2" placeholder="Enter document title">
                            </div>
                            <div class="form-group mb-3">
                                <label for="document_file_0" class="mt-2 fw-semibold">{{ __('messages.document_file') }}</label>
                                <input type="file" name="documents[0][file]" accept=".pdf,.doc,.docx,.xls,.xlsx,.txt" id="document_file_0" class="form-control rounded-3 border-2">
                            </div>
                            <div class="form-group mb-3">
                                <label for="document_description_0" class="mt-2 fw-semibold">{{ __('messages.document_description') }}</label>
                                <textarea name="documents[0][description]" id="document_description_0" class="form-control rounded-3 border-2" rows="3" placeholder="Enter document description"></textarea>
                            </div>
                            <button type="button" class="btn btn-danger btn-sm mt-2 remove-document">Supprimer</button>
                        </div>
                        @endif
                    </div>
                </div>
                <button type="button" id="add-document-button" class="edit-lesson-btn mb-4">{{ __('messages.add_document') }}</button>
                <!-- Course selection -->
                <div class="form-group mb-4">
                    <label for="course_id" class="fw-semibold">{{ __('messages.course') }}</label>
                    <select class="form-select" id="course_id" name="course_id" required>
                        <option value="" disabled>{{ __('messages.select_a_course') }}</option>
                        @foreach($courses as $course)
                        <option value="{{ $course->id }}" {{ old('course_id', $lesson->course_id) == $course->id ? 'selected' : '' }}>
                            {{ $course->name }}
                        </option>
                        @endforeach
                    </select>
                </div>
                <!-- Level input -->
                <div class="form-group mb-4">
                    <label for="level" class="edit-lesson-label">{{ __('messages.lesson_level') }}</label>
                    <input type="number" class="form-control border-2 rounded-3" id="level" name="level" value="{{ old('level', $lesson->level) }}" required>
                </div>
                <div style="position:sticky;bottom:0;z-index:100;background:linear-gradient(90deg,#f7f7fa 60%,#e9e6fc 100%);padding:1rem 0 0.5rem 0;box-shadow:0 -2px 8px rgba(0,0,0,0.08);">
                    <button type="submit" class="edit-lesson-btn w-100" style="font-size:1.2rem;">{{ __('messages.update_lesson') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Data attributes for JavaScript -->
<div id="data-sections" data-sections='@json($sections)' style="display: none;"></div>
<div id="data-modules" data-modules='@json($modules)' style="display: none;"></div>

@endsection


@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Filtrage dynamique sections/modules
    const courseSelect = document.getElementById('course_id');
    const sectionSelect = document.getElementById('section_id');
    const moduleSelect = document.getElementById('module_id');
    // Affiche toutes les options au départ
    Array.from(sectionSelect.options).forEach(option => {
        if (!option.value) return;
        option.style.display = '';
    });
    Array.from(moduleSelect.options).forEach(option => {
        if (!option.value) return;
        option.style.display = '';
    });
    // Filtrage lors du changement de cours
    courseSelect.addEventListener('change', function() {
        const courseId = this.value;
        Array.from(sectionSelect.options).forEach(option => {
            if (!option.value) return;
            option.style.display = option.getAttribute('data-course') === courseId ? '' : 'none';
        });
        sectionSelect.value = '';
        Array.from(moduleSelect.options).forEach(option => {
            if (!option.value) return;
            option.style.display = 'none';
        });
        moduleSelect.value = '';
    });
    // Filtrage lors du changement de section
    sectionSelect.addEventListener('change', function() {
        const sectionId = this.value;
        Array.from(moduleSelect.options).forEach(option => {
            if (!option.value) return;
            option.style.display = option.getAttribute('data-section') === sectionId ? '' : 'none';
        });
        moduleSelect.value = '';
    });

    // Ajout dynamique de vidéos
    const addVideoBtn = document.getElementById('add-video-button');
    const videoGroups = document.getElementById('video-groups');
    addVideoBtn.addEventListener('click', function() {
        const index = videoGroups.querySelectorAll('.video-group').length;
        const group = document.createElement('div');
        group.className = 'video-group mt-3';
        group.innerHTML = `
            <div class="form-group mb-3">
                <label for="video_title_${index}" class="fw-semibold">Titre de la vidéo</label>
                <input type="text" name="videos[${index}][title]" id="video_title_${index}" class="form-control rounded-3 border-2" placeholder="Enter video title">
            </div>
            <div class="form-group mb-3">
                <label for="video_url_${index}" class="mt-2 fw-semibold">URL de la vidéo</label>
                <input type="text" name="videos[${index}][url]" id="video_url_${index}" class="form-control rounded-3 border-2" placeholder="Enter video URL">
            </div>
            <div class="form-group mb-3">
                <label for="video_description_${index}" class="mt-2 fw-semibold">Description de la vidéo</label>
                <textarea name="videos[${index}][description]" id="video_description_${index}" class="form-control rounded-3 border-2" rows="3" placeholder="Enter video description"></textarea>
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

    // Ajout dynamique de documents
    const addDocumentBtn = document.getElementById('add-document-button');
    const documentGroups = document.getElementById('document-groups');
    addDocumentBtn.addEventListener('click', function() {
        const index = documentGroups.querySelectorAll('.document-group').length;
        const group = document.createElement('div');
        group.className = 'document-group mt-3';
        group.innerHTML = `
            <div class="form-group mb-3">
                <label for="document_title_${index}" class="fw-semibold">Titre du document</label>
                <input type="text" name="documents[${index}][title]" id="document_title_${index}" class="form-control rounded-3 border-2" placeholder="Enter document title">
            </div>
            <div class="form-group mb-3">
                <label for="document_file_${index}" class="mt-2 fw-semibold">Fichier du document</label>
                <input type="file" name="documents[${index}][file]" accept=".pdf,.doc,.docx,.xls,.xlsx,.txt" id="document_file_${index}" class="form-control rounded-3 border-2">
            </div>
            <div class="form-group mb-3">
                <label for="document_description_${index}" class="mt-2 fw-semibold">Description du document</label>
                <textarea name="documents[${index}][description]" id="document_description_${index}" class="form-control rounded-3 border-2" rows="3" placeholder="Enter document description"></textarea>
            </div>
            <button type="button" class="btn btn-danger btn-sm mt-2 remove-document">Supprimer</button>
        `;
        documentGroups.appendChild(group);
    });
    documentGroups.addEventListener('click', function(e) {
        if (e.target.classList.contains('remove-document')) {
            e.target.closest('.document-group').remove();
        }
    });
});
</script>
@endpush
