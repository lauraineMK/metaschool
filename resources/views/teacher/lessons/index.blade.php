@extends('layouts.app')

@section('title', 'Lessons - MetaSchool')

@section('content')
<div class="container mt-5 lessons-view">
    <h1>{{ __('messages.lessons') }}</h1>

    <!-- Button to create a new lesson -->
    <a href="{{ route('teacher.lessons.create') }}" class="btn btn-primary mb-3">{{ __('messages.create_new_lesson') }}</a>

    @if ($lessons->isEmpty())
    <p>{{ __('messages.no_lessons_available') }}</p>
    @else
    <table class="table table-striped">
        <thead>
            <tr>
                <th>#</th>
                <th>{{ __('messages.lesson_title(2)') }}</th>
                <th class="hide-on-small-mobile">{{ __('messages.lesson_content(2)') }}</th>
                <th>{{ __('messages.course(2)') }}</th>
                <th class="hide-on-mobile">{{ __('messages.section(2)') }}</th>
                <th class="hide-on-mobile">{{ __('messages.module(2)') }}</th>
                <th>{{ __('messages.actions') }}</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($lessons as $lesson)
            <tr>
                <td>{{ $lesson->id }}</td>
                <td>{{ $lesson->title }}</td>
                <td class="hide-on-small-mobile">{{ Str::limit($lesson->content, 50) }}</td>
                <td>
                    <a href="{{ route('teacher.courses.show', $lesson->course->id) }}">
                        {{ $lesson->course->name }}
                    </a>
                </td>
                <td class="hide-on-mobile">{{ $lesson->section ? $lesson->section->name : 'N/A' }}</td>
                <td class="hide-on-mobile">{{ $lesson->module ? $lesson->module->name : 'N/A' }}</td>
                <td>
                    <div class="btn-container">
                        <!-- View Button -->
                        <a href="{{ route('teacher.lessons.show', $lesson->id) }}" class="btn btn-info btn-sm btn-view">
                            <span class="text-view">{{ __('messages.view') }}</span>
                            <i class="fas fa-eye"></i> <!-- Eye icon -->
                        </a>

                        <!-- Edit Button -->
                        <a href="{{ route('teacher.lessons.edit', $lesson->id) }}" class="btn btn-warning btn-sm btn-edit">
                            <span class="text-edit">{{ __('messages.edit') }}</span>
                            <i class="fas fa-edit"></i> <!-- Pencil icon -->
                        </a>

                        <!-- Delete Button -->
                        <form action="{{ route('teacher.lessons.destroy', $lesson->id) }}" method="POST" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm btn-delete" onclick="return confirm('{{ __('messages.are_you_sure_you_want_to_delete_this_lesson') }}')">
                                <span class="text-delete">{{ __('messages.delete') }}</span>
                                <i class="fas fa-trash"></i> <!-- Trash icon -->
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @endif
</div>
@endsection
