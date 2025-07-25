@extends('layouts.app')

@section('title', 'Lesson Details - MetaSchool')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card rounded-4 shadow-lg border-0 mb-4">
                <div class="card-body p-4">
                    @php $isCompleted = auth()->user()->hasCompletedLesson($lesson->id); @endphp
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h2 class="fw-bold mb-0" style="color: #7C3AED;">{{ $lesson->title }}</h2>
                        @if($isCompleted)
                            <span class="badge bg-success fs-6"><i class="fa fa-check-circle me-1"></i> Leçon terminée</span>
                            <a href="{{ route('student.lessons.show', $lesson->id) }}" class="btn btn-outline-primary ms-2 rounded-pill">
                                <i class="fa fa-redo me-1"></i> Revoir
                            </a>
                        @else
                            <form method="POST" action="{{ route('student.lessons.complete', $lesson->id) }}" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-success rounded-pill">
                                    <span class="fa fa-check-circle"></span> Marquer comme terminée
                                </button>
                            </form>
                        @endif
                    </div>
                    <p class="lead text-secondary mb-4">{{ $lesson->content }}</p>
                    <div class="row mb-3">
                        <div class="col-md-4 mb-2">
                            <span class="fw-bold text-muted">Cours :</span> <span>{{ $lesson->course->name ?? '' }}</span>
                        </div>
                        <div class="col-md-4 mb-2">
                            <span class="fw-bold text-muted">Section :</span> <span>{{ $lesson->section->name ?? '-' }}</span>
                        </div>
                        <div class="col-md-4 mb-2">
                            <span class="fw-bold text-muted">Module :</span> <span>{{ $lesson->module->name ?? '-' }}</span>
                        </div>
                    </div>

                    <!-- Vidéo -->
                    <div class="mb-4">
                        @if($lesson->video_path)
                            <link rel="stylesheet" href="https://cdn.plyr.io/3.7.8/plyr.css" />
                            <div class="video-container mb-3 rounded-4 overflow-hidden">
                                <video id="player" playsinline controls style="width:100%;max-height:400px;">
                                    <source src="{{ route('lessons.video.stream', $lesson->id) }}" type="video/mp4" />
                                    Votre navigateur ne supporte pas la vidéo HTML5.
                                </video>
                            </div>
                            <script src="https://cdn.plyr.io/3.7.8/plyr.polyfilled.js"></script>
                            <script>document.addEventListener('DOMContentLoaded', () => { new Plyr('#player'); });</script>
                        @elseif(isset($videos) && $videos->count() > 0)
                            @foreach($videos as $video)
                                <div class="mb-3">
                                    <h5 class="fw-bold">{{ $video->title }}</h5>
                                    <p class="text-secondary">{{ $video->description }}</p>
                                    @php
                                    $url = $video->url;
                                    $videoId = null;
                                    if (str_contains($url, 'youtube.com/watch?v=')) {
                                        parse_str(parse_url($url, PHP_URL_QUERY), $query);
                                        $videoId = $query['v'] ?? null;
                                    } elseif (str_contains($url, 'youtu.be/')) {
                                        $videoId = basename($url);
                                    }
                                    @endphp
                                    @if($videoId)
                                    <div class="video-container rounded-4 overflow-hidden">
                                        <iframe src="https://www.youtube.com/embed/{{ $videoId }}" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen style="width:100%;min-height:320px;"></iframe>
                                    </div>
                                    @else
                                    <p class="text-danger">Format ou URL vidéo non supporté.</p>
                                    @endif
                                </div>
                            @endforeach
                        @else
                            <div class="alert alert-warning mb-3">
                                <i class="fas fa-exclamation-triangle me-2"></i>Cette leçon ne contient pas de vidéo. Merci de contacter l'administrateur ou votre enseignant.
                            </div>
                        @endif
                    </div>

                    <!-- Documents PDF -->
                    <div class="mb-4">
                        <h4 class="fw-bold mb-3"><i class="fas fa-file-pdf me-2 text-danger"></i>Documents PDF</h4>
                        @if($documents->count() > 0)
                            <div class="row">
                                @foreach($documents as $document)
                                    <div class="col-md-6 mb-3">
                                        <div class="card border-0 shadow-sm rounded-4">
                                            <div class="card-body">
                                                <h5 class="fw-bold">{{ $document->title }}</h5>
                                                <p class="text-secondary">{{ $document->description }}</p>
                                                @if($document->file)
                                                    @php $fileExtension = strtolower(pathinfo($document->file, PATHINFO_EXTENSION)); @endphp
                                                    @if($fileExtension === 'pdf')
                                                        <iframe src="{{ url('storage/' . $document->file) }}" width="100%" height="320px" frameborder="0" class="rounded-4"></iframe>
                                                    @else
                                                        <a href="{{ url('storage/' . $document->file) }}" class="btn btn-outline-primary" target="_blank">Voir le document</a>
                                                        <a href="{{ url('storage/' . $document->file) }}" class="btn btn-outline-success ms-2" download>Télécharger</a>
                                                    @endif
                                                @else
                                                    <p class="text-danger">Aucun fichier disponible pour ce document.</p>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="alert alert-warning">
                                <i class="fas fa-exclamation-triangle me-2"></i>Aucun document disponible pour cette leçon.
                            </div>
                        @endif
                    </div>

                    <!-- Quiz -->
                    <div class="mb-4">
                        <h4 class="fw-bold mb-3"><i class="fas fa-question-circle me-2 text-info"></i>Quiz</h4>
                        @if($lesson->quiz)
                            <a href="{{ route('student.quizzes.show', $lesson->quiz->id) }}" class="btn btn-info rounded-pill px-4">
                                {{ $lesson->quiz->title }}
                            </a>
                        @else
                            <div class="alert alert-warning">
                                Aucun quiz disponible pour cette leçon.
                            </div>
                        @endif
                    </div>

                    <!-- Navigation -->
                    <div class="d-flex justify-content-between mt-4">
                        @if ($previousLesson)
                            <a href="{{ route('student.lessons.show', $previousLesson->id) }}" class="btn btn-outline-primary rounded-pill px-4">
                                <i class="fa fa-arrow-left me-2"></i> Leçon précédente
                            </a>
                        @else
                            <span></span>
                        @endif
                        @if ($nextLesson)
                            <a href="{{ route('student.lessons.show', $nextLesson->id) }}" class="btn btn-primary rounded-pill px-4">
                                Leçon suivante <i class="fa fa-arrow-right ms-2"></i>
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4 mt-4">
            <a href="{{ route('student.lessons.index') }}" class="btn btn-outline-secondary w-100 mb-3 rounded-pill">Retour aux leçons</a>
            <a href="{{ route('student.courses.show', $lesson->course->id) }}" class="btn btn-outline-secondary w-100 mb-3 rounded-pill">Retour au cours</a>
        </div>
    </div>
</div>
@endsection
