@extends('layouts.app')

@section('title', 'Edit Course')

@section('content')
    <div class="container">
        <h1>Edit Course</h1>
        <form action="{{ route('teachers.courses.update', $course->id) }}" method="POST">
            @csrf
            @method('PUT')

            <!-- Course Details -->
            <label for="course_title">Course Title:</label>
            <input type="text" id="course_title" name="title" value="{{ old('title', $course->title) }}" required>

            <label for="course_description">Course Description:</label>
            <textarea id="course_description" name="description">{{ old('description', $course->description) }}</textarea>

            <label for="course_price">Course Price:</label>
            <input type="number" id="course_price" name="price" value="{{ old('price', $course->price) }}">

            <label for="course_creation_date">Creation Date:</label>
            <input type="date" id="course_creation_date" name="creation_date" value="{{ old('creation_date', $course->creation_date) }}">

            <!-- Section Details -->
            @if(isset($section))
                <input type="hidden" name="section_id" value="{{ $section->id }}">
            @endif
            <label for="section_title">Section Title:</label>
            <input type="text" id="section_title" name="section_title" value="{{ old('section_title', $section->title ?? '') }}">

            <label for="section_level">Section Level:</label>
            <input type="number" id="section_level" name="section_level" value="{{ old('section_level', $section->level ?? '') }}">

            <!-- Module Details -->
            @if(isset($module))
                <input type="hidden" name="module_id" value="{{ $module->id }}">
            @endif
            <label for="module_title">Module Title:</label>
            <input type="text" id="module_title" name="module_title" value="{{ old('module_title', $module->title ?? '') }}">

            <label for="module_description">Module Description:</label>
            <textarea id="module_description" name="module_description">{{ old('module_description', $module->description ?? '') }}</textarea>

            <label for="module_level">Module Level:</label>
            <input type="number" id="module_level" name="module_level" value="{{ old('module_level', $module->level ?? '') }}">

            <button type="submit">Update Course</button>
        </form>
    </div>
@endsection
