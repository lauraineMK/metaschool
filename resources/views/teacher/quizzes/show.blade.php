@extends('layouts.app')

@section('title', 'Quiz Details - MetaSchool')

@section('content')
<div class="container mt-5">
    <div class="wrapper">
        <!-- Left sidebar for buttons -->
        <div class="sidebar">
            <!-- Button to edit the quiz -->
            <a href="{{ route('teacher.quizzes.edit', $quiz->id) }}" class="btn btn-warning mb-3 btn-block d-none d-md-block">Edit Quiz</a>
            <a href="{{ route('teacher.quizzes.edit', $quiz->id) }}" class="btn btn-warning mb-3 btn-block d-block d-md-none">
                <i class="fa fa-pencil-alt"></i>
            </a>

            <!-- Button to delete the quiz -->
            <form action="{{ route('teacher.quizzes.destroy', $quiz->id) }}" method="POST" style="display: inline;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger mb-3 btn-block d-none d-md-block" onclick="return confirm('Are you sure you want to delete this quiz?')">Delete Quiz</button>
                <button type="submit" class="btn btn-danger mb-3 btn-block d-block d-md-none" onclick="return confirm('Are you sure you want to delete this quiz?')">
                    <i class="fa fa-trash-alt"></i>
                </button>
            </form>

            <!-- Button to go back to quizzes list -->
            <a href="{{ route('teacher.quizzes.index') }}" class="btn btn-secondary mb-3 btn-block d-none d-md-block">Back to Quizzes</a>
            <a href="{{ route('teacher.quizzes.index') }}" class="btn btn-secondary mt-4 btn-block d-block d-md-none">
                <i class="fa fa-list"></i>&nbsp;<i class="fa fa-arrow-left"></i>
            </a>

            <!-- Button to go back to lesson -->
            <a href="{{ route('teacher.lessons.show', $quiz->lesson->id) }}" class="btn btn-secondary mb-3 btn-block d-none d-md-block">Back to Lesson</a>
            <a href="{{ route('teacher.lessons.show', $quiz->lesson->id) }}" class="btn btn-secondary mt-4 btn-block d-block d-md-none">
                <i class="fa fa-book"></i>&nbsp;<i class="fa fa-arrow-left"></i>
            </a>
        </div>

        <!-- Right section for quiz details -->
        <div class="content">
            <h1>{{ $quiz->title }}</h1>

            <!-- Quiz Content -->
            <p>{{ $quiz->description }}</p>

            <!-- Quiz Questions -->
            @if($quiz->questions->count() > 0)
            <div class="mt-4">
                <h3>Questions</h3>
                @foreach($quiz->questions as $question)
                <div class="mb-3">
                    <h5>{{ $question->question_text }}</h5>
                    <ul>
                        @foreach($question->answers as $answer)
                        <li>{{ $answer->answer_text }} ({{ $answer->is_correct ? 'Correct' : 'Incorrect' }})</li>
                        @endforeach
                    </ul>
                </div>
                @endforeach
            </div>
            @else
            <div class="mt-4">
                <p>No questions available for this quiz.</p>
            </div>
            @endif

            <!-- Navigation Buttons -->
            <div class="mt-4">
                @if ($previousQuiz)
                <a href="{{ route('teacher.quizzes.show', $previousQuiz->id) }}" class="btn btn-primary btn-desktop-only">Previous Quiz</a>
                <a href="{{ route('teacher.quizzes.show', $previousQuiz->id) }}" class="btn btn-primary btn-mobile-only btn-icon-space">
                    <i class="fa fa-arrow-left"></i>
                </a>
                @endif

                @if ($nextQuiz)
                <a href="{{ route('teacher.quizzes.show', $nextQuiz->id) }}" class="btn btn-primary btn-desktop-only">Next Quiz</a>
                <a href="{{ route('teacher.quizzes.show', $nextQuiz->id) }}" class="btn btn-primary btn-mobile-only btn-icon-space">
                    <i class="fa fa-arrow-right"></i>
                </a>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
