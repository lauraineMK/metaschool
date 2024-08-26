@extends('layouts.app')

@section('title', 'Edit Course')

@section('content')
    <div class="container mt-5">
        <h1>Edit Course</h1>
        <form action="{{ route('teacher.courses.update', $course->id) }}" method="POST">
            @csrf
            @method('PUT')

            <!-- Course Details -->
            <div class="form-group">
                <label for="course_title">Course Title:</label>
                <input type="text" id="course_title" name="title" class="form-control" value="{{ old('title', $course->title) }}" required>
                @error('title')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <div class="form-group">
                <label for="course_description">Course Description:</label>
                <textarea id="course_description" name="description" class="form-control">{{ old('description', $course->description) }}</textarea>
                @error('description')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <div class="form-group">
                <label for="course_price">Course Price:</label>
                <input type="number" id="course_price" name="price" class="form-control" value="{{ old('price', $course->price) }}">
                @error('price')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <div class="form-group">
                <label for="course_creation_date">Creation Date:</label>
                <input type="date" id="course_creation_date" name="creation_date" class="form-control" value="{{ old('creation_date', $course->creation_date) }}">
                @error('creation_date')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <!-- Section Details -->
            @if(isset($section))
                <input type="hidden" name="section_id" value="{{ $section->id }}">
            @endif
            <div class="form-group">
                <label for="section_title">Section Title:</label>
                <input type="text" id="section_title" name="section_title" class="form-control" value="{{ old('section_title', $section->title ?? '') }}">
                @error('section_title')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <div class="form-group">
                <label for="section_level">Section Level:</label>
                <input type="number" id="section_level" name="section_level" class="form-control" value="{{ old('section_level', $section->level ?? '') }}">
                @error('section_level')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <!-- Module Details -->
            @if(isset($module))
                <input type="hidden" name="module_id" value="{{ $module->id }}">
            @endif
            <div class="form-group">
                <label for="module_title">Module Title:</label>
                <input type="text" id="module_title" name="module_title" class="form-control" value="{{ old('module_title', $module->title ?? '') }}">
                @error('module_title')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <div class="form-group">
                <label for="module_description">Module Description:</label>
                <textarea id="module_description" name="module_description" class="form-control">{{ old('module_description', $module->description ?? '') }}</textarea>
                @error('module_description')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <div class="form-group">
                <label for="module_level">Module Level:</label>
                <input type="number" id="module_level" name="module_level" class="form-control" value="{{ old('module_level', $module->level ?? '') }}">
                @error('module_level')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary">Update Course</button>
        </form>
    </div>
@endsection
