
@extends('layouts.app')

@section('content')
<section class="py-5 fade-in" style="background: #fff;">
    <div class="container">
        <div class="row mb-4">
            <div class="col-12 text-center">
                <h2 class="fw-bold mb-3" style="color: #7C3AED;">Votre cours en cours</h2>
                <p class="lead text-secondary">Continuez votre parcours d'apprentissage</p>
            </div>
        </div>
        <div class="row g-4">
            <div class="col-md-4">
                <div class="card border-0 shadow-sm rounded-4 mb-4">
                    <div class="card-body">
                        <h3 class="fw-bold mb-3" style="color:#7C3AED;">{{ $course->name ?? $course->title ?? 'Titre du cours' }}</h3>
                        <div class="mb-2">
                            <span class="fw-semibold">Section :</span>
                            @if(isset($nextLesson) && $nextLesson && $nextLesson->section)
                                {{ $nextLesson->section->name ?? $nextLesson->section->title ?? 'Section non définie' }}
                            @else
                                Section non définie
                            @endif
                        </div>
                        <div class="mb-2">
                            <span class="fw-semibold">Module :</span>
                            @if(isset($nextLesson) && $nextLesson && $nextLesson->module)
                                {{ $nextLesson->module->name ?? $nextLesson->module->title ?? 'Module non défini' }}
                            @else
                                Module non défini
                            @endif
                        </div>
                        <div class="mb-2">
                            <span class="fw-semibold">Leçon :</span>
                            @if(isset($nextLesson) && $nextLesson)
                                {{ $nextLesson->title ?? 'Leçon non définie' }}
                            @else
                                Leçon non définie
                            @endif
                        </div>
                        <div class="mb-3">
                            <span class="text-muted small">Votre progression</span>
                            @php
                                $progress = $progress ?? 0;
                                $progressColor = $progress < 30 ? 'bg-danger' : ($progress < 70 ? 'bg-warning' : 'bg-success');
                            @endphp
                            <div class="progress" style="height: 8px;">
                                <div class="progress-bar {{ $progressColor }}" role="progressbar" style="width: {{ $progress }}%;" aria-valuenow="{{ $progress }}" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                            <span class="small">{{ $progress }}%</span>
                        </div>
                        <div class="mt-3">
                            <span class="fw-bold">Professeur : {{ $course->author->firstname ?? '' }} {{ $course->author->lastname ?? '' }}</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <div class="card border-0 shadow-sm rounded-4 mb-4">
                    <div class="card-body text-center">
                        <div class="mb-4">
                            @if(!empty($course->video_url))
                                <iframe width="100%" height="320" src="{{ $course->video_url }}" frameborder="0" allowfullscreen class="rounded-4"></iframe>
                            @else
                                <div class="alert alert-info">Aucune vidéo disponible pour ce cours.</div>
                            @endif
                        </div>
                        <div class="mb-4">
                            @forelse($course->documents ?? [] as $doc)
                                <a href="{{ $doc->url }}" class="btn btn-outline-primary me-2 mb-2" target="_blank">
                                    <i class="fas fa-file-pdf me-1"></i> {{ $doc->title }}
                                </a>
                            @empty
                                <span class="text-muted">Aucun document disponible</span>
                            @endforelse
                        </div>
                        @if($nextLesson && $nextLesson instanceof \App\Models\Lesson)
                            <a href="{{ route('student.lessons.show', $nextLesson->id) }}" class="btn btn-success btn-lg px-5 fw-bold">
                                Continuer : {{ $nextLesson->title }}
                            </a>
                        @elseif($nextLesson)
                            <span class="btn btn-danger btn-lg px-5 fw-bold disabled">Erreur : la prochaine leçon n'est pas valide</span>
                        @else
                            <span class="btn btn-secondary btn-lg px-5 fw-bold disabled">Toutes les leçons sont terminées</span>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
