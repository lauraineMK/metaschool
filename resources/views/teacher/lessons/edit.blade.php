@extends('layouts.app')

@section('title', 'Edit Lesson - MetaSchool')

@section('content')
<div class="container py-5" style="background:linear-gradient(120deg,#f7f7fa 60%,#e9e6fc 100%);min-height:100vh;">
    <div class="row justify-content-center">
        <div class="col-lg-8 col-md-10 col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="fw-bold" style="color:#7C3AED; font-size:2.2rem;letter-spacing:1px;">{{ __('messages.edit_lesson') }}</h1>
                <a href="{{ route('teacher.lessons.index') }}" class="btn btn-outline-secondary rounded-pill px-4 fw-bold shadow-sm">{{ __('messages.cancel') }}</a>
            </div>
            <form action="{{ route('teacher.lessons.update', $lesson->id) }}" method="POST" enctype="multipart/form-data" class="bg-white p-4 rounded-4 shadow-lg position-relative" style="min-height:600px;">
                @csrf
                @method('PUT')
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
                <!-- Section selection -->
                <div class="form-group mb-4">
                    <label for="section_id" class="fw-semibold">Section du cours</label>
                    <select class="form-select" id="section_id" name="section_id" required>
                        <option value="" disabled>Sélectionner une section</option>
                        @foreach($sections as $section)
                        <option value="{{ $section->id }}" data-course="{{ $section->course_id }}" {{ (old('section_id') ? old('section_id') : $lesson->section_id) == $section->id ? 'selected' : '' }} style="display:none;">
                            {{ $section->title }} ({{ $courses->where('id', $section->course_id)->first()->name ?? '' }})
                        </option>
                        @endforeach
                    </select>
                </div>
                <!-- Module selection -->
                <div class="form-group mb-4">
                    <label for="module_id" class="fw-semibold">Module</label>
                    <select class="form-select" id="module_id" name="module_id" required>
                        <option value="" disabled>Sélectionner un module</option>
                        @foreach($modules as $module)
                        <option value="{{ $module->id }}" data-section="{{ $module->section_id }}" {{ (old('module_id') ? old('module_id') : $lesson->module_id) == $module->id ? 'selected' : '' }} style="display:none;">
                            {{ $module->title }} (Section: {{ $sections->where('id', $module->section_id)->first()->title ?? '' }})
                        </option>
                        @endforeach
                    </select>
                </div>
                <!-- Title input -->
                <div class="form-group mb-4">
                    <label for="title" class="fw-semibold">{{ __('messages.lesson_title') }}</label>
                    <input type="text" class="form-control rounded-3 border-2" id="title" name="title" value="{{ old('title', $lesson->title) }}" required>
                </div>
                <!-- Content input -->
                <div class="form-group mb-4">
                    <label for="content" class="fw-semibold">{{ __('messages.lesson_content') }}</label>
                    <textarea class="form-control rounded-3 border-2" id="content" name="content" rows="5" required>{{ old('content', $lesson->content) }}</textarea>
                </div>
                <!-- Video input -->
                <div id="video-section" class="mb-4">
                    <h3 class="fw-bold">{{ __('messages.videos') }}</h3>
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
                <button type="button" id="add-video-button" class="btn btn-secondary mb-4">{{ __('messages.add_video') }}</button>
                <!-- Document input -->
                <div id="document-section" class="mb-4">
                    <h3 class="fw-bold">{{ __('messages.documents') }}</h3>
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
                <button type="button" id="add-document-button" class="btn btn-secondary mb-4">{{ __('messages.add_document') }}</button>
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
                    <label for="level" class="fw-semibold">{{ __('messages.lesson_level') }}</label>
                    <input type="number" class="form-control rounded-3 border-2" id="level" name="level" value="{{ old('level', $lesson->level) }}" required>
                </div>
                <div style="position:sticky;bottom:0;z-index:100;background:linear-gradient(90deg,#f7f7fa 60%,#e9e6fc 100%);padding:1rem 0 0.5rem 0;box-shadow:0 -2px 8px rgba(0,0,0,0.08);">
                    <button type="submit" class="btn btn-primary rounded-pill px-4 fw-bold shadow-sm w-100" style="font-size:1.2rem;">{{ __('messages.update_lesson') }}</button>
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
    // Initialisation : affiche les options sélectionnées à l'édition
    function showInitialOptions() {
        const selectedCourse = courseSelect.value;
        Array.from(sectionSelect.options).forEach(option => {
            if (!option.value) return;
            option.style.display = (option.getAttribute('data-course') === selectedCourse) ? '' : 'none';
        });
        const selectedSection = sectionSelect.value;
        Array.from(moduleSelect.options).forEach(option => {
            if (!option.value) return;
            option.style.display = (option.getAttribute('data-section') === selectedSection) ? '' : 'none';
        });
    }
    showInitialOptions();
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
    sectionSelect.addEventListener('change', function() {
        const sectionId = this.value;
        Array.from(moduleSelect.options).forEach(option => {
            if (!option.value) return;
            option.style.display = option.getAttribute('data-section') === sectionId ? '' : 'none';
        });
        moduleSelect.value = '';
    });
    // ...existing JS code pour vidéos/documents...
});
</script>
@endpush
