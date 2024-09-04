@extends('layouts.app')

@section('title', 'Create Lesson - MetaSchool')

@section('content')
<div class="container mt-5">
    <h1>Create a New Lesson</h1>

    <!-- Form to create a new lesson -->
    <form action="{{ route('teacher.lessons.store') }}" method="POST">
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
