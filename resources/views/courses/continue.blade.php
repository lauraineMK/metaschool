@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow rounded-4">
                <div class="card-body text-center">
                    <h2 class="fw-bold mb-3">{{ $course->title ?? 'Titre du cours' }}</h2>
                    <div class="mb-4">
                        <iframe width="100%" height="320" src="{{ $course->video_url ?? 'https://www.youtube.com/embed/dQw4w9WgXcQ' }}" frameborder="0" allowfullscreen class="rounded-4"></iframe>
                    </div>
                    <div class="mb-4">
                        @foreach($course->documents ?? [] as $doc)
                            <a href="{{ $doc->url }}" class="btn btn-outline-primary me-2 mb-2" target="_blank">
                                <i class="fas fa-file-pdf me-1"></i> {{ $doc->title }}
                            </a>
                        @endforeach
                    </div>
                    <div class="mb-3">
                        <span class="text-muted small">Votre progression</span>
                        <div class="progress" style="height: 8px;">
                            <div class="progress-bar bg-success" role="progressbar" style="width: {{ isset($progress) ? $progress : 0 }}%;" aria-valuenow="{{ isset($progress) ? $progress : 0 }}" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                        <span class="small">{{ isset($progress) ? $progress : 0 }}%</span>
                    </div>
                    <a href="#" class="btn btn-success btn-lg px-5 fw-bold mt-3">Continuer le cours</a>
                    @if($nextLesson)
                        <a href="{{ route('student.lessons.show', $nextLesson->id) }}" class="btn btn-success btn-lg px-5 fw-bold mt-3">
                            Accéder à la prochaine leçon : {{ $nextLesson->title }}
                        </a>
                    @else
                        <span class="btn btn-secondary btn-lg px-5 fw-bold mt-3 disabled">Aucune leçon disponible</span>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
