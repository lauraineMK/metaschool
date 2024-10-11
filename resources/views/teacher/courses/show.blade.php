@extends('layouts.app')

@section('title', 'Course Details - MetaSchool')

@section('content')
<div class="container mt-5">
    <div class="wrapper">
        <!-- Left sidebar for buttons -->
        <div class="sidebar">
            <!-- Button to edit the course -->
            <a href="{{ route('teacher.courses.edit', $course->id) }}" class="btn btn-warning mb-3 btn-block d-none d-md-block">{{ __('messages.edit_course') }}</a>
            <a href="{{ route('teacher.courses.edit', $course->id) }}" class="btn btn-warning mb-3 btn-block d-block d-md-none">
                <i class="fa fa-pencil-alt"></i>
            </a>

            <!-- Button to delete the course -->
            <form action="{{ route('teacher.courses.destroy', $course->id) }}" method="POST" style="display: inline;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger mb-3 btn-block d-none d-md-block" onclick="return confirm('{{ __('messages.are_you_sure_you_want_to_delete_this_course') }}')">{{ __('messages.delete_course') }}</button>
                <button type="submit" class="btn btn-danger mb-3 btn-block d-block d-md-none" onclick="return confirm('{{ __('messages.are_you_sure_you_want_to_delete_this_course') }}')">
                    <i class="fa fa-trash-alt"></i>
                </button>
            </form>

            <!-- Button to go back to the courses list -->
            <a href="{{ route('teacher.courses.index') }}" class="btn btn-secondary mt-4 btn-block d-none d-md-block">{{ __('messages.back_to_courses') }}</a>
            <a href="{{ route('teacher.courses.index') }}" class="btn btn-secondary mt-4 btn-block d-block d-md-none">
                <i class="fa fa-arrow-left"></i>
            </a>
        </div>

        <!-- Right section for course details -->
        <div class="content">
            <h1>{{ $course->name }}</h1>

            <!-- Course Description -->
            <p>{{ $course->description }}</p>

            <!-- Course Content -->
            <h2 class="mt-5">{{ __('messages.course_content') }}</h2>

            <!-- First case: Sections -> Modules -> Lessons -->
            @if (!$course->sections->isEmpty())
            @foreach ($course->sections as $section)
            <div class="section mb-4">
                <h3>{{ __('messages.section') }} {{ $section->name }}</h3>

                @if (!$section->modules->isEmpty())
                @foreach ($section->modules as $module)
                <div class="module ml-4 mb-3">
                    <h4>{{ __('messages.module') }} {{ $module->name }}</h4>

                    @if (!$module->lessons->isEmpty())
                    <ul class="list-group ml-4">
                        @foreach ($module->lessons as $lesson)
                        <li class="list-group-item">
                            <a href="{{ route('teacher.lessons.show', $lesson->id) }}">{{ $lesson->title }}</a>
                        </li>
                        @endforeach
                    </ul>
                    @else
                    <p>{{ __('messages.no_lessons_available_in_this_module') }}</p>
                    @endif
                </div>
                @endforeach
                @else
                <p>{{ __('messages.no_modules_available_in_this_section') }}</p>
                @endif
            </div>
            @endforeach
            <!-- Second case: Modules -> Lessons -->
            @elseif (!$course->modules->isEmpty())
            @foreach ($course->modules as $module)
            <div class="module mb-4">
                <h4>{{ __('messages.module') }} {{ $module->name }}</h4>

                @if (!$module->lessons->isEmpty())
                <ul class="list-group ml-4">
                    @foreach ($module->lessons as $lesson)
                    <li class="list-group-item">
                        <a href="{{ route('teacher.lessons.show', $lesson->id) }}">{{ $lesson->title }}</a>
                    </li>
                    @endforeach
                </ul>
                @else
                <p>{{ __('messages.no_lessons_available_in_this_module') }}</p>
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
            <p>{{ __('messages.no_lessons_available_for_this_course') }}</p>
            @endif
        </div>
    </div>
</div>
@endsection
