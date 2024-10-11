@extends('layouts.app')

@section('title', 'Create Course')

@section('content')
<div class="container mt-5">
    <div class="header">
        <h1>{{ __('messages.create_a_new_course') }}</h1>
        <a href="{{ route('teacher.courses.index') }}" class="btn btn-secondary">{{ __('messages.cancel') }}</a>
    </div>

    <!-- Form to create a new course -->
    <form action="{{ route('teacher.courses.store') }}" method="POST">
        @csrf

        <!-- Course Details -->
        <div class="form-section">
            <h2>{{ __('messages.course_details') }}</h2>

            <div class="form-group">
                <label for="course_name">{{ __('messages.course_name') }}</label>
                <input type="text" id="course_name" name="name" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="course_description">{{ __('messages.course_description') }}</label>
                <textarea id="course_description" name="description" class="form-control"></textarea>
            </div>

            <div class="form-group">
                <label for="course_creation_date">{{ __('messages.creation_date') }}</label>
                <input type="date" id="course_creation_date" name="creation_date" class="form-control">
            </div>

            <input type="hidden" name="author_id" value="{{ auth()->user()->id }}">
        </div>

        <!-- Toggle to show/hide sections and modules -->
        <div class="form-group">
            <label for="include_sections">
                <input type="checkbox" id="include_sections" name="include_sections"> {{ __('messages.include_sections_and_modules') }}
            </label>
        </div>

        <!-- Section Details -->
        <div id="section-container" style="display: none;">
            <!-- Sections will be added here -->
        </div>

        <!-- Module Details -->
        <div id="module-container">
            <!-- Standalone Modules will be added here -->
        </div>

        <div class="d-flex justify-content-between mt-3">
            <button type="button" class="btn btn-secondary" id="add-section-btn" style="display: none;">{{ __('messages.add_section') }}</button>
            <button type="button" class="btn btn-secondary" id="add-module-btn">{{ __('messages.add_module') }}</button>
            <button type="submit" class="btn btn-primary">{{ __('messages.create_course') }}</button>
        </div>
    </form>
</div>
@endsection
