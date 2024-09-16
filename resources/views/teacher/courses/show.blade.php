@extends('layouts.app')

@section('title', 'Course Details - MetaSchool')

@section('content')
<div class="container mt-5">
    <h1>{{ $course->name }}</h1>

    <!-- Course Description -->
    <p>{{ $course->description }}</p>

    <!-- Button to edit the course -->
    <a href="{{ route('teacher.courses.edit', $course->id) }}" class="btn btn-warning mb-3">Edit Course</a>

    <!-- Button to delete the course -->
    <form action="{{ route('teacher.courses.destroy', $course->id) }}" method="POST" style="display: inline;">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-danger mb-3" onclick="return confirm('Are you sure you want to delete this course?')">Delete Course</button>
    </form>

    <!-- Course Content -->
    <h2 class="mt-5">Course Content</h2>

    <!-- First case: Sections -> Modules -> Lessons -->
    @if (!$course->sections->isEmpty())
        @foreach ($course->sections as $section)
            <div class="section mb-4">
                <h3>Section: {{ $section->name }}</h3>

                @if (!$section->modules->isEmpty())
                    @foreach ($section->modules as $module)
                        <div class="module ml-4 mb-3">
                            <h4>Module: {{ $module->name }}</h4>

                            @if (!$module->lessons->isEmpty())
                                <ul class="list-group ml-4">
                                    @foreach ($module->lessons as $lesson)
                                        <li class="list-group-item">
                                            <a href="{{ route('teacher.lessons.show', $lesson->id) }}">{{ $lesson->title }}</a>
                                        </li>
                                    @endforeach
                                </ul>
                            @else
                                <p>No lessons available in this module.</p>
                            @endif
                        </div>
                    @endforeach
                @else
                    <p>No modules available in this section.</p>
                @endif
            </div>
        @endforeach
    <!-- Second case: Modules -> Lessons -->
    @elseif (!$course->modules->isEmpty())
        @foreach ($course->modules as $module)
            <div class="module mb-4">
                <h4>Module: {{ $module->name }}</h4>

                @if (!$module->lessons->isEmpty())
                    <ul class="list-group ml-4">
                        @foreach ($module->lessons as $lesson)
                            <li class="list-group-item">
                                <a href="{{ route('teacher.lessons.show', $lesson->id) }}">{{ $lesson->title }}</a>
                            </li>
                        @endforeach
                    </ul>
                @else
                    <p>No lessons available in this module.</p>
                @endif
            </div>
        @endforeach
    <!-- Third case: Direct lessons from the course -->
    @elseif (!$course->lessons->isEmpty())
        <ul class="list-group">
            @foreach ($course->lessons as $lesson)
                <li class="list-group-item">
                    <a href="{{ route('teacher.lessons.show', $lesson->id) }}">{{ $lesson->title }}</a>
                </li>
            @endforeach
        </ul>
    @else
        <p>No lessons available for this course.</p>
    @endif

    <!-- Button to go back to the courses list -->
    <a href="{{ route('teacher.courses.index') }}" class="btn btn-secondary mt-4 ">Back to Courses</a>
</div>
@endsection
