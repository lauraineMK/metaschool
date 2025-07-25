@extends('layouts.app')

@section('content')
<div class="container py-5">
    <h1 class="mb-4 fw-bold" style="color: #7C3AED;">Tous les cours</h1>
    <div class="row">
        @forelse($courses as $course)
            <div class="col-md-4 mb-4">
                <div class="card shadow rounded-4 h-100">
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title">{{ $course->name }}</h5>
                        <p class="card-text text-muted">{{ $course->author->firstname ?? '' }} {{ $course->author->lastname ?? '' }}</p>
                        <form method="POST" action="{{ route('student.courses.start', $course->id) }}" class="mt-auto mb-2">
                            @csrf
                            <button type="submit" class="btn btn-outline-primary rounded-pill w-100 mb-2">Commencer ce cours</button>
                        </form>
                        <a href="{{ url('/students/courses/'.$course->id) }}" class="btn btn-link w-100 p-0 text-decoration-underline">Voir le cours</a>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="alert alert-info">Aucun cours disponible pour le moment.</div>
            </div>
        @endforelse
    </div>
</div>
@endsection
