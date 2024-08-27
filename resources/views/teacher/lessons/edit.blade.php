@extends('layouts.app')

@section('title', 'Edit Lesson - MetaSchool')

@section('content')
<div class="container mt-5">
    <h1>Edit Lesson</h1>

    <!-- Form to edit the lesson -->
    <form action="{{ route('teacher.lessons.update', $lesson->id) }}" method="POST">
        @csrf
        @method('PUT')

        <!-- Title input -->
        <div class="form-group">
            <label for="title">Lesson Title</label>
            <input type="text" class="form-control" id="title" name="title" value="{{ old('title', $lesson->title) }}" required>
        </div>

        <!-- Content input -->
        <div class="form-group mt-3">
            <label for="content">Content</label>
            <textarea class="form-control" id="content" name="content" rows="5" required>{{ old('content', $lesson->content) }}</textarea>
        </div>

        <!-- Course selection -->
        <div class="form-group mt-3">
            <label for="course_id">Course</label>
            <select class="form-control" id="course_id" name="course_id" required>
                <option value="" disabled>Select a course</option>
                @foreach($courses as $course)
                    <option value="{{ $course->id }}" {{ old('course_id', $lesson->course_id) == $course->id ? 'selected' : '' }}>
                        {{ $course->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Module selection (optional) -->
        <div class="form-group mt-3">
            <label for="module_id">Module (Optional)</label>
            <select class="form-control" id="module_id" name="module_id">
                <option value="" {{ !$lesson->module_id ? 'selected' : '' }}>No module</option>
                @foreach($modules as $module)
                    <option value="{{ $module->id }}" {{ old('module_id', $lesson->module_id) == $module->id ? 'selected' : '' }}>
                        {{ $module->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Section selection (optional) -->
        <div class="form-group mt-3">
            <label for="section_id">Section (Optional)</label>
            <select class="form-control" id="section_id" name="section_id">
                <option value="" {{ !$lesson->section_id ? 'selected' : '' }}>No section</option>
                @foreach($sections as $section)
                    <option value="{{ $section->id }}" {{ old('section_id', $lesson->section_id) == $section->id ? 'selected' : '' }}>
                        {{ $section->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Level input -->
        <div class="form-group mt-3">
            <label for="level">Level</label>
            <input type="number" class="form-control" id="level" name="level" value="{{ old('level', $lesson->level) }}" required>
        </div>

        <!-- Submit button -->
        <button type="submit" class="btn btn-primary mt-3">Update Lesson</button>
    </form>
</div>
@endsection
