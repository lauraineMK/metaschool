@extends('layouts.app')

@section('title', 'Create Lesson - MetaSchool')

@section('content')
<div class="container mt-5">
    <div class="header">
        <h1>{{ __('messages.create_a_new_lesson') }}</h1>
        <a href="{{ route('teacher.lessons.index') }}" class="btn btn-secondary">{{ __('messages.cancel') }}</a>
    </div>

    <!-- Form to create a new lesson -->
    <form action="{{ route('teacher.lessons.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <!-- Title input -->
        <div class="form-group">
            <label for="title">{{ __('messages.lesson_title') }}</label>
            <input type="text" class="form-control" id="title" name="title" value="{{ old('title') }}" required>
        </div>

        <!-- Content input -->
        <div class="form-group mt-3">
            <label for="content">{{ __('messages.lesson_content') }}</label>
            <textarea class="form-control" id="content" name="content" rows="5" required>{{ old('content') }}</textarea>
        </div>

        <!-- Video input -->
        <div id="video-section" class="mt-5">
            <h3>{{ __('messages.videos') }}</h3>
            <div id="video-groups">
                <!-- Initial video group -->
                <div class="video-group mt-3">
                    <div class="form-group mt-3">
                        <label for="video_title_0">{{ __('messages.video_title') }}</label>
                        <input type="text" name="videos[0][title]" id="video_title_0" class="form-control" placeholder="Enter video title">
                    </div>
                    <div class="form-group mt-3">
                        <label for="video_url_0" class="mt-2">{{ __('messages.video_URL') }}</label>
                        <input type="text" name="videos[0][url]" id="video_url_0" class="form-control" placeholder="Enter video URL">
                    </div>
                    <div class="form-group mt-3">
                        <label for="video_description_0" class="mt-2">{{ __('messages.video_description') }}</label>
                        <textarea name="videos[0][description]" id="video_description_0" class="form-control" rows="3" placeholder="Enter video description"></textarea>
                    </div>
                </div>
            </div>
        </div>

        <!-- Add Video Button -->
        <button type="button" id="add-video-button" class="btn btn-secondary mt-3">{{ __('messages.add_video') }}</button>

        <!-- Document input -->
        <div id="document-section" class="mt-5">
            <h3>{{ __('messages.documents') }}</h3>
            <div id="document-groups">
                <!-- Initial document group -->
                <div class="document-group mt-3">
                    <div class="form-group mt-3">
                        <label for="document_title_0">{{ __('messages.document_title') }}</label>
                        <input type="text" name="documents[0][title]" id="document_title_0" class="form-control" placeholder="Enter document title">
                    </div>
                    <div class="form-group mt-3">
                        <label for="document_file_0" class="mt-2">{{ __('messages.document_file') }}</label>
                        <input type="file" name="documents[0][file]" accept=".pdf,.doc,.docx,.xls,.xlsx, .txt" id="document_file_0" class="form-control">
                    </div>
                    <div class="form-group mt-3">
                        <label for="document_description_0" class="mt-2">{{ __('messages.document_description') }}</label>
                        <textarea name="documents[0][description]" id="document_description_0" class="form-control" rows="3" placeholder="Enter document description"></textarea>
                    </div>
                </div>
            </div>
        </div>

        <!-- Add Document Button -->
        <button type="button" id="add-document-button" class="btn btn-secondary mt-3">{{ __('messages.add_document') }}</button>

        <!-- Course selection -->
        <div class="form-group mt-3">
            <label for="course_id">{{ __('messages.course') }}</label>
            <select class="form-control" id="course_id" name="course_id" required>
                <option value="" disabled selected>{{ __('messages.select_a_course') }}</option>
                @foreach($courses as $course)
                <option value="{{ $course->id }}" {{ old('course_id') == $course->id ? 'selected' : '' }}>
                    {{ $course->name }}
                </option>
                @endforeach
            </select>
        </div>

        <!-- Section selection (optional) -->
        <div class="form-group mt-3" id="section-container" style="display: none;">
            <label for="section_id">{{ __('messages.section(2)') }}</label>
            <select class="form-control" id="section_id" name="section_id">
                <option value="" selected>{{ __('messages.select_a_section') }}</option>
            </select>
        </div>

        <!-- Module selection (optional) -->
        <div class="form-group mt-3" id="module-container" style="display: none;">
            <label for="module_id">{{ __('messages.module(2)') }}</label>
            <select class="form-control" id="module_id" name="module_id">
                <option value="" selected>{{ __('messages.select_a_module') }}</option>
            </select>
        </div>

        <!-- Level input -->
        <div class="form-group mt-3">
            <label for="level">{{ __('messages.lesson_level') }}</label>
            <input type="number" class="form-control" id="level" name="level" value="{{ old('level') }}" required>
        </div>

        <!-- Submit button -->
        <button type="submit" class="btn btn-primary mt-3">{{ __('messages.create_lesson') }}</button>
    </form>
</div>

<!-- Data attributes for JavaScript -->
<div id="data-sections" data-sections='@json($sections)' style="display: none;"></div>
<div id="data-modules" data-modules='@json($modules)' style="display: none;"></div>

@endsection

<script>
    const translations = {
        documentTitle: '{{ __('messages.document_title') }}',
        documentFile: '{{ __('messages.document_file') }}',
        documentDescription: '{{ __('messages.document_description') }}',
        videoTitle: '{{ __('messages.video_title') }}',
        videoURL: '{{ __('messages.video_url') }}',
        videoDescription: '{{ __('messages.video_description') }}',
        cancel: '{{ __('messages.cancel') }}',
    };
</script>
