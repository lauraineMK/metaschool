@extends('layouts.app')

@section('title', 'Edit Lesson - MetaSchool')

@section('content')
<div class="container mt-5">
    <div class="header">
        <h1>{{ __('messages.edit_lesson') }}</h1>
        <a href="{{ route('teacher.lessons.index') }}" class="btn btn-secondary">{{ __('messages.cancel') }}</a>
    </div>

    <!-- Form to edit an existing lesson -->
    <form action="{{ route('teacher.lessons.update', $lesson->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <!-- Title input -->
        <div class="form-group">
            <label for="title">{{ __('messages.lesson_title') }}</label>
            <input type="text" class="form-control" id="title" name="title" value="{{ old('title', $lesson->title) }}" required>
        </div>

        <!-- Content input -->
        <div class="form-group mt-3">
            <label for="content">{{ __('messages.lesson_content') }}</label>
            <textarea class="form-control" id="content" name="content" rows="5" required>{{ old('content', $lesson->content) }}</textarea>
        </div>

        <!-- Video inputs -->
        <div id="video-section" data-edit-mode="{{ isset($lesson->id) ? 'true' : 'false' }}">
            <h3>{{ __('messages.videos') }}</h3>
            @foreach($lesson->videos as $index => $video)
            <div class="video-group" id="video-group-{{ $index }}">
                <div class="form-group mt-3">
                    <label for="video_title_{{ $index }}">{{ __('messages.video_title') }}</label>
                    <input type="text" class="form-control" id="video_title_{{ $index }}" name="videos[{{ $index }}][title]"
                        value="{{ old('videos.' . $index . '.title', $video->title) }}">
                </div>

                <div class="form-group mt-3">
                    <label for="video_url_{{ $index }}">{{ __('messages.video_URL') }}</label>
                    <input type="url" class="form-control" id="video_url_{{ $index }}" name="videos[{{ $index }}][url]"
                        value="{{ old('videos.' . $index . '.url', $video->url) }}">
                </div>

                <div class="form-group mt-3">
                    <label for="video_description_{{ $index }}">{{ __('messages.video_description') }}</label>
                    <textarea class="form-control" id="video_description_{{ $index }}" name="videos[{{ $index }}][description]" rows="3">{{ old('videos.' . $index . '.description', $video->description) }}</textarea>
                </div>

                <!-- Button to clear fields for this video group -->
                <button type="button" class="btn btn-warning clear-video-button mt-3 desktop-only" data-index="{{ $index }}">{{ __('messages.clear') }}</button>
                <button type="button" class="btn btn-warning clear-video-button mt-3 mobile-only" data-index="{{ $index }}">
                    <i class="fas fa-eraser"></i>
                </button>

                <!-- Button to remove video -->
                <button type="button" class="btn btn-danger remove-video-button mt-3 desktop-only" data-index="{{ $index }}">{{ __('messages.remove_video') }}</button>
                <button type="button" class="btn btn-danger remove-video-button mt-3 mobile-only" data-index="{{ $index }}">
                    <i class="fas fa-trash"></i>
                </button>

                <!-- Hidden input to mark videos for deletion -->
                <input type="hidden" name="videos[{{ $index }}][_delete]" value="0">
            </div>
            @endforeach
        </div>

        <!-- Add Video Button -->
        <button type="button" id="add-video-button" class="btn btn-secondary mt-3">{{ __('messages.add_video') }}</button>

        <!-- Document input -->
        <div id="document-section" data-edit-mode="{{ isset($lesson->id) ? 'true' : 'false' }}" class="mt-5">
            <h3>{{ __('messages.documents') }}</h3>
            @foreach($lesson->documents as $index => $document)
            <div class="document-group" id="document-group-{{ $index }}">
                <!-- Hidden input for document ID -->
                <input type="hidden" name="documents[{{ $index }}][id]" value="{{ $document->id ?? '' }}">

                <div class="form-group mt-3">
                    <label for="document_title_{{ $index }}">{{ __('messages.document_title') }}</label>
                    <input type="text" class="form-control" id="document_title_{{ $index }}" name="documents[{{ $index }}][title]"
                        value="{{ old('documents.' . $index . '.title', $document->title) }}">
                </div>

                <div class="form-group mt-3">
                    <label for="document_file_{{ $index }}">{{ __('messages.document_file') }}</label>
                    <input type="file" class="form-control" id="document_file_{{ $index }}" name="documents[{{ $index }}][file]">
                    <!-- Display the existing file name if any -->
                    @if($document->file)
                    <small class="form-text text-muted">Current file: {{ basename($document->file) }}</small>
                    @endif
                </div>

                <div class="form-group mt-3">
                    <label for="document_description_{{ $index }}">{{ __('messages.document_description') }}</label>
                    <textarea class="form-control" id="document_description_{{ $index }}" name="documents[{{ $index }}][description]" rows="3">{{ old('documents.' . $index . '.description', $document->description) }}</textarea>
                </div>

                <!-- Button to clear fields for this document group -->
                <button type="button" class="btn btn-warning clear-document-button mt-3" data-index="{{ $index }}">{{ __('messages.clear') }}</button>

                <!-- Button to remove document -->
                <button type="button" class="btn btn-danger remove-document-button mt-3" data-index="{{ $index }}">{{ __('messages.remove_document') }}</button>

                <!-- Hidden input to mark documents for deletion -->
                <input type="hidden" name="documents[{{ $index }}][_delete]" value="0">
            </div>
            @endforeach
        </div>

        <!-- Add Document Button -->
        <button type="button" id="add-document-button" class="btn btn-secondary mt-3">{{ __('messages.add_document') }}</button>

        <!-- Course selection -->
        <div class="form-group mt-3">
            <label for="course_id">{{ __('messages.course') }}</label>
            <select class="form-control" id="course_id" name="course_id" required>
                <option value="" disabled>{{ __('messages.select_a_course') }}</option>
                @foreach($courses as $course)
                <option value="{{ $course->id }}" {{ old('course_id', $lesson->course_id) == $course->id ? 'selected' : '' }}>
                    {{ $course->name }}
                </option>
                @endforeach
            </select>
        </div>

        <!-- Section selection (optional) -->
        <div class="form-group mt-3" id="section-container" style="display: none;">
            <label for="section_id">{{ __('messages.section(2)') }}</label>
            <select class="form-control" id="section_id" name="section_id">
                <option value="">{{ __('messages.select_a_section') }}</option>
                @foreach($sections as $section)
                <option value="{{ $section->id }}" {{ old('section_id', $lesson->section_id) == $section->id ? 'selected' : '' }}>
                    {{ $section->name }}
                </option>
                @endforeach
            </select>
        </div>

        <!-- Module selection (optional) -->
        <div class="form-group mt-3" id="module-container" style="display: none;">
            <label for="module_id">{{ __('messages.module(2)') }}</label>
            <select class="form-control" id="module_id" name="module_id">
                <option value="">{{ __('messages.select_a_module') }}</option>
                @foreach($modules as $module)
                <option value="{{ $module->id }}" {{ old('module_id', $lesson->module_id) == $module->id ? 'selected' : '' }}>
                    {{ $module->name }}
                </option>
                @endforeach
            </select>
        </div>

        <!-- Level input -->
        <div class="form-group mt-3">
            <label for="level">{{ __('messages.lesson_level') }}</label>
            <input type="number" class="form-control" id="level" name="level" value="{{ old('level', $lesson->level) }}" required>
        </div>

        <!-- Submit button -->
        <button type="submit" class="btn btn-primary mt-3">{{ __('messages.update_lesson') }}</button>
    </form>
</div>

<!-- Data as JSON in hidden elements -->
<div id="data-sections" data-sections='@json($sections)' style="display: none;"></div>
<div id="data-modules" data-modules='@json($modules)' style="display: none;"></div>

@endsection
