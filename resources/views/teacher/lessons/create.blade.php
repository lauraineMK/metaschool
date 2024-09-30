@extends('layouts.app')

@section('title', 'Create Lesson - MetaSchool')

@section('content')
<div class="container mt-5">
    <div class="header">
        <h1>Create a New Lesson</h1>
        <a href="{{ route('teacher.lessons.index') }}" class="btn btn-secondary">Cancel</a>
    </div>

    <!-- Form to create a new lesson -->
    <form action="{{ route('teacher.lessons.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <!-- Title input -->
        <div class="form-group">
            <label for="title">Lesson Title</label>
            <input type="text" class="form-control" id="title" name="title" value="{{ old('title') }}" required>
        </div>

        <!-- Content input -->
        <div class="form-group mt-3">
            <label for="content">Content</label>
            <textarea class="form-control" id="content" name="content" rows="5" required>{{ old('content') }}</textarea>
        </div>

        <!-- Video input -->
        <div id="video-section" class="mt-5">
            <h3>Videos</h3>
            <div id="video-groups">
                <!-- Initial video group -->
                <div class="video-group mt-3">
                    <div class="form-group mt-3">
                        <label for="video_title_0">Video Title</label>
                        <input type="text" name="videos[0][title]" id="video_title_0" class="form-control" placeholder="Enter video title">
                    </div>
                    <div class="form-group mt-3">
                        <label for="video_url_0" class="mt-2">Video URL</label>
                        <input type="text" name="videos[0][url]" id="video_url_0" class="form-control" placeholder="Enter video URL">
                    </div>
                    <div class="form-group mt-3">
                        <label for="video_description_0" class="mt-2">Video Description</label>
                        <textarea name="videos[0][description]" id="video_description_0" class="form-control" rows="3" placeholder="Enter video description"></textarea>
                    </div>
                </div>
            </div>
        </div>

        <!-- Add Video Button -->
        <button type="button" id="add-video-button" class="btn btn-secondary mt-3">Add Video</button>

        <!-- Document input -->
        <div id="document-section" class="mt-5">
            <h3>Documents</h3>
            <div id="document-groups">
                <!-- Initial document group -->
                <div class="document-group mt-3">
                    <div class="form-group mt-3">
                        <label for="document_title_0">Document Title</label>
                        <input type="text" name="documents[0][title]" id="document_title_0" class="form-control" placeholder="Enter document title">
                    </div>
                    <div class="form-group mt-3">
                        <label for="document_file_0" class="mt-2">Document File</label>
                        <input type="file" name="documents[0][file]" accept=".pdf,.doc,.docx,.xls,.xlsx, .txt" id="document_file_0" class="form-control">
                    </div>
                    <div class="form-group mt-3">
                        <label for="document_description_0" class="mt-2">Document Description</label>
                        <textarea name="documents[0][description]" id="document_description_0" class="form-control" rows="3" placeholder="Enter document description"></textarea>
                    </div>
                </div>
            </div>
        </div>

        <!-- Add Document Button -->
        <button type="button" id="add-document-button" class="btn btn-secondary mt-3">Add Document</button>

        <!-- Course selection -->
        <div class="form-group mt-3">
            <label for="course_id">Course</label>
            <select class="form-control" id="course_id" name="course_id" required>
                <option value="" disabled selected>Select a course</option>
                @foreach($courses as $course)
                <option value="{{ $course->id }}" {{ old('course_id') == $course->id ? 'selected' : '' }}>
                    {{ $course->name }}
                </option>
                @endforeach
            </select>
        </div>

        <!-- Section selection (optional) -->
        <div class="form-group mt-3" id="section-container" style="display: none;">
            <label for="section_id">Section (Optional)</label>
            <select class="form-control" id="section_id" name="section_id">
                <option value="" selected>No section</option>
            </select>
        </div>

        <!-- Module selection (optional) -->
        <div class="form-group mt-3" id="module-container" style="display: none;">
            <label for="module_id">Module (Optional)</label>
            <select class="form-control" id="module_id" name="module_id">
                <option value="" selected>No module</option>
            </select>
        </div>

        <!-- Level input -->
        <div class="form-group mt-3">
            <label for="level">Level</label>
            <input type="number" class="form-control" id="level" name="level" value="{{ old('level') }}" required>
        </div>

        <!-- Submit button -->
        <button type="submit" class="btn btn-primary mt-3">Create Lesson</button>
    </form>
</div>

<!-- Data attributes for JavaScript -->
<div id="data-sections" data-sections='@json($sections)' style="display: none;"></div>
<div id="data-modules" data-modules='@json($modules)' style="display: none;"></div>

@endsection
