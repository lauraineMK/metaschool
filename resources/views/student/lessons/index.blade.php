@extends('layouts.app')

@section('title', 'Lessons - MetaSchool')

@section('content')
<div class="container mt-5 lessons-view">
    <h1>{{ __('messages.lessons') }}</h1>

    @if ($lessons->isEmpty())
    <p>{{ __('messages.no_lessons_available') }}</p>
    @else
    <table class="table table-striped">
        <thead>
            <tr>
                <th>#</th>
                <th>{{ __('messages.lesson_title(2)') }}</th>
                <th class="hide-on-small-mobile">{{ __('messages.lesson_content(2)') }}</th>
                <th>{{ __('messages.courses') }}</th>
                <th class="hide-on-mobile">{{ __('messages.section(2)') }}</th>
                <th class="hide-on-mobile">{{ __('messages.module(2)') }}</th>
                <th>{{ __('messages.actions') }}</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($lessons as $lesson)
            <tr>
                <td>{{ $lesson->id }}</td>
                <td>
                    <div class="d-flex justify-content-between align-items-center">{{ $lesson->title }}
                        <button id="lesson-viewed-btn-index" data-lesson-id="{{ $lesson->id }}" class="btn btn-outline-secondary">
                            <span class="fa fa-check-circle"></span>
                        </button>
                    </div>
                </td>
                <td class="hide-on-small-mobile">{{ Str::limit($lesson->content, 50) }}</td>
                <td>{{ $lesson->course->name }}</td>
                <td class="hide-on-mobile">{{ $lesson->section ? $lesson->section->name : 'N/A' }}</td>
                <td class="hide-on-mobile">{{ $lesson->module ? $lesson->module->name : 'N/A' }}</td>
                <td>
                    <!-- View Button -->
                    <a href="{{ route('student.lessons.show', $lesson->id) }}" class="btn btn-info btn-sm btn-view">
                        <span class="text-view">{{ __('messages.view') }}</span>
                        <i class="fas fa-eye"></i> <!-- Eye icon -->
                    </a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @endif
</div>
@endsection
