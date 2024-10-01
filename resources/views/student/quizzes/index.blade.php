@extends('layouts.app')

@section('title', 'Quizzes - MetaSchool')

@section('content')
<div class="container mt-5 quizzes-view">
    <h1>Quizzes</h1>

    @if ($quizzes->isEmpty())
    <p>No quizzes available.</p>
    @else
    <table class="table table-striped">
        <thead>
            <tr>
                <th>#</th>
                <th>Quiz Title</th>
                <th class="hide-on-small-mobile">Description</th>
                <th>Lesson</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($quizzes as $quiz)
            <tr>
                <td>{{ $quiz->id }}</td>
                <td>{{ $quiz->title }}</td>
                <td class="hide-on-small-mobile">{{ $quiz->description }}</td>
                <td>
                    <a href="{{ route('student.lessons.show', $quiz->lesson->id) }}">
                        {{ $quiz->lesson ? $quiz->lesson->title : 'N/A' }}
                    </a>
                </td>
                <td>
                    <div class="btn-container">
                        <!-- View Button (Student can only view the quiz) -->
                        <a href="{{ route('student.quizzes.show', $quiz->id) }}" class="btn btn-info btn-sm btn-view">
                            <span class="text-view">View</span>
                            <i class="fas fa-eye"></i> <!-- Eye icon -->
                        </a>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @endif
</div>
@endsection
