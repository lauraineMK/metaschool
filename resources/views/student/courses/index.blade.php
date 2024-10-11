@extends('layouts.app')

@section('title', 'Courses - MetaSchool')

@section('content')
<div class="container mt-5 courses-view">
    <h1>{{ __('messages.courses') }}</h1>

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
                    <!-- View Button -->
                    <a href="{{ route('student.courses.show', $course->id) }}" class="btn btn-info btn-sm btn-view">
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
