@extends('layouts.app')

@section('title', 'Courses - MetaSchool')

@section('content')
<div class="container mt-5 courses-view">
    <h1>{{ __('messages.courses') }}</h1>

    <!-- Button to create a new course -->
    <a href="{{ route('teacher.courses.create') }}" class="btn btn-primary mb-3">{{ __('messages.create_new_course') }}</a>

    @if ($courses->isEmpty())
    <p>{{ __('messages.no_courses_available') }}</p>
    @else
    <table class="table table-striped">
        <thead>
            <tr>
                <th>#</th>
                <th>{{ __('messages.course_name(2)') }}</th>
                <th>{{ __('messages.description') }}</th>
                <th>{{ __('messages.actions') }}</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($courses as $course)
            <tr>
                <td>{{ $course->id }}</td>
                <td>{{ $course->name }}</td>
                <td>{{ $course->description }}</td>
                <td>
                    <div class="btn-container">
                        <!-- View Button -->
                        <a href="{{ route('teacher.courses.show', $course->id) }}" class="btn btn-info btn-sm btn-view">
                            <span class="text-view">{{ __('messages.view') }}</span>
                            <i class="fas fa-eye"></i> <!-- Eye icon -->
                        </a>

                        <!-- Edit Button -->
                        <a href="{{ route('teacher.courses.edit', $course->id) }}" class="btn btn-warning btn-sm btn-edit">
                            <span class="text-edit">{{ __('messages.edit') }}</span>
                            <i class="fas fa-edit"></i> <!-- Pencil icon -->
                        </a>

                        <!-- Delete Button -->
                        <form action="{{ route('teacher.courses.destroy', $course->id) }}" method="POST" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm btn-delete" onclick="return confirm('{{ __('messages.are_you_sure_you_want_to_delete_this_course') }}')">
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
