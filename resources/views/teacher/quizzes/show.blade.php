@extends('layouts.app')

@section('title', 'Quiz - MetaSchool')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-lg border-0 rounded-4 mb-4">
                <div class="card-body p-5">
                    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start mb-4 gap-3">
                        <div>
                            <h1 class="fw-bold mb-2" style="color: #7C3AED;"><i class="fas fa-question-circle me-2"></i>{{ $quiz->title }}</h1>
                            <p class="text-secondary mb-0">{{ $quiz->description }}</p>
                        </div>
                        <div class="d-flex flex-column gap-2 align-items-end">
                            <a href="{{ route('teacher.quizzes.edit', $quiz->id) }}" class="btn btn-warning btn-sm rounded-pill px-4 mb-1"><i class="fa fa-pencil-alt me-1"></i> Modifier</a>
                            <form action="{{ route('teacher.quizzes.destroy', $quiz->id) }}" method="POST" onsubmit="return confirm('Supprimer ce quiz ?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm rounded-pill px-4"><i class="fa fa-trash-alt me-1"></i> Supprimer</button>
                            </form>
                            <a href="{{ route('teacher.quizzes.index') }}" class="btn btn-outline-secondary btn-sm rounded-pill px-4"><i class="fa fa-list me-1"></i> Tous les quiz</a>
                            <a href="{{ route('teacher.lessons.show', $quiz->lesson->id) }}" class="btn btn-outline-primary btn-sm rounded-pill px-4"><i class="fa fa-book me-1"></i> Retour à la leçon</a>
                        </div>
                    </div>
                    <hr>
                    @if($quiz->questions->count() > 0)
                        <h4 class="mb-4" style="color: #4F46E5;"><i class="fas fa-list-ol me-2"></i>Questions du quiz</h4>
                        @foreach($quiz->questions as $question)
                            <div class="mb-4 p-3 rounded-3" style="background: #F8F9FB;">
                                <h5 class="fw-bold mb-2"><i class="fa fa-question text-primary me-2"></i>{{ $question->question_text }}</h5>
                                <ul class="list-unstyled ms-3">
                                    @foreach($question->answers as $answer)
                                        <li class="mb-1">
                                            <span class="me-2">{{ $answer->answer_text }}</span>
                                            @if($answer->is_correct)
                                                <span class="badge bg-success">Bonne réponse</span>
                                            @else
                                                <span class="badge bg-light text-secondary border">Faux</span>
                                            @endif
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        @endforeach
                    @else
                        <div class="alert alert-info">Aucune question pour ce quiz.</div>
                    @endif
                    <div class="d-flex justify-content-between mt-4">
                        @if ($previousQuiz)
                            <a href="{{ route('teacher.quizzes.show', $previousQuiz->id) }}" class="btn btn-outline-primary rounded-pill px-4"><i class="fa fa-arrow-left me-2"></i>Quiz précédent</a>
                        @else
                            <span></span>
                        @endif
                        @if ($nextQuiz)
                            <a href="{{ route('teacher.quizzes.show', $nextQuiz->id) }}" class="btn btn-outline-primary rounded-pill px-4">Quiz suivant<i class="fa fa-arrow-right ms-2"></i></a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
