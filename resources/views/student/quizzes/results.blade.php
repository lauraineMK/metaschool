@extends('layouts.app')

@section('title', 'Quiz Results - MetaSchool')

@section('content')
<div class="container mt-5">
    <div class="wrapper">
        <!-- Quiz results -->
        <div class="content">
            <h1>{{ $quiz->title }} - Results</h1>

            <!-- Student's score -->
            <p><strong>Your score:</strong> {{ $score }}/{{ $quiz->questions->count() }}</p>

            <!-- Display questions with correct answers -->
            <div class="mt-4">
                <h3>Questions and Your Answers</h3>
                @foreach($quiz->questions as $question)
                <div class="mb-3">
                    <h5>{{ $question->question_text }}</h5>
                    <ul>
                        @foreach($question->answers as $answer)
                        <li>
                            {{ $answer->answer_text }}
                            @if($answer->is_correct)
                                <strong>(Correct)</strong>
                            @endif
                            @if(isset($userAnswers[$question->id]) && $userAnswers[$question->id] == $answer->id)
                                <strong>(Your Answer)</strong>
                            @endif
                        </li>
                        @endforeach
                    </ul>
                    @if(!isset($userAnswers[$question->id]))
                        <p><em>Your Answer: No answer provided</em></p>
                    @endif
                </div>
                @endforeach
            </div>

            <!-- Button to go back to quizzes list -->
            <div class="mt-4">
                <a href="{{ route('student.quizzes.index') }}" class="btn btn-secondary">Back to Quizzes</a>
            </div>
        </div>
    </div>
</div>
@endsection
