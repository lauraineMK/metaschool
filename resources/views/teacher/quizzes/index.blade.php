@extends('layouts.app')

@section('title', 'Quizzes - MetaSchool')

@section('content')
<div class="container mt-5 quizzes-view">
    <h1>Quizzes</h1>

    <!-- Button to create a new quiz -->
    <a href="{{ route('teacher.quizzes.create') }}" class="btn btn-primary mb-3">Create New Quiz</a>

    @if ($quizzes->isEmpty())
        <p>No quizzes available.</p>
    @else
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Quiz Title</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($quizzes as $quiz)
                    <tr>
                        <td>{{ $quiz->id }}</td>
                        <td>{{ $quiz->title }}</td>
                        <td>
                            <div class="btn-container">
                                <!-- View Button -->
                                <a href="{{ route('teacher.quizzes.show', $quiz->id) }}" class="btn btn-info btn-sm btn-view">
                                    <span class="text-view">View</span>
                                    <i class="fas fa-eye"></i> <!-- Eye icon -->
                                </a>

                                <!-- Edit Button -->
                                <a href="{{ route('teacher.quizzes.edit', $quiz->id) }}" class="btn btn-warning btn-sm btn-edit">
                                    <span class="text-edit">Edit</span>
                                    <i class="fas fa-edit"></i> <!-- Pencil icon -->
                                </a>

                                <!-- Delete Button -->
                                <form action="{{ route('teacher.quizzes.destroy', $quiz->id) }}" method="POST" style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm btn-delete" onclick="return confirm('Are you sure you want to delete this quiz?')">
                                        <span class="text-delete">Delete</span>
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
