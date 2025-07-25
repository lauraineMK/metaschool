@extends('layouts.app')
@section('title', 'Mes cours - MetaSchool')
@section('content')

<div class="container-fluid py-5" style="background:linear-gradient(120deg,#f7f7fa 60%,#e9e6fc 100%);min-height:100vh;">
  <div class="row justify-content-center">
    <div class="col-xl-7 col-lg-8 col-md-10 col-12 mx-auto">
      <div class="text-center mb-5">
        <h1 class="fw-bold" style="color:#7C3AED; font-size:2.5rem;letter-spacing:1px;">Mes cours</h1>
      </div>
      <form method="GET" action="" class="mb-4">
        <div class="d-flex flex-wrap align-items-center justify-content-center gap-3">
          <label for="status" class="fw-semibold mb-0">Filtrer par statut :</label>
          <select name="status" id="status" class="form-select w-auto">
            <option value="in_progress" {{ request('status') == 'in_progress' ? 'selected' : '' }}>Cours en cours</option>
            <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Cours terminés</option>
          </select>
          <button type="submit" class="btn btn-outline-primary">Filtrer</button>
        </div>
      </form>

      @if(isset($filteredCourses) && $filteredCourses->count())
        @foreach($filteredCourses as $course)
          <div class="card mb-4 shadow-lg rounded-4">
            <div class="card-body">
              <h2 class="fw-bold mb-3" style="color:#7C3AED;">{{ $course->name ?? 'Non défini' }}</h2>
              @php
                // Trouver la leçon en cours (non terminée) pour ce cours
                $currentLesson = null;
                $allLessons = collect();
                foreach ($course->sections as $section) {
                  foreach ($section->modules as $module) {
                    foreach ($module->lessons as $lesson) {
                      $allLessons->push($lesson);
                      $isCompleted = auth()->user()->lessons->contains(function($l) use ($lesson) {
                        return $l->id === $lesson->id && $l->pivot->completed;
                      });
                      if (!$isCompleted && !$currentLesson) {
                        $currentLesson = $lesson;
                        $currentSection = $section;
                        $currentModule = $module;
                      }
                    }
                  }
                }
                if (!$currentLesson && $allLessons->count()) {
                  $currentLesson = $allLessons->first();
                  $currentSection = $currentLesson->section;
                  $currentModule = $currentLesson->module;
                }
                $progress = $course->progress ?? 0;
              @endphp
              <div class="mb-2">
                <span class="fw-bold">Section :</span> {{ $currentSection->name ?? 'Non défini' }}
              </div>
              <div class="mb-2">
                <span class="fw-bold">Module :</span> {{ $currentModule->name ?? 'Non défini' }}
              </div>
              <div class="mb-2">
                <span class="fw-bold">Leçon :</span> {{ $currentLesson->title ?? 'Non défini' }}
              </div>
              <div class="mb-2">
                <span class="fw-bold">Professeur :</span> {{ $course->author->firstname ?? 'Teacher' }} {{ $course->author->lastname ?? '' }}
              </div>
              <div class="mb-2">
                <span class="fw-bold">Votre progression</span> <span class="badge bg-primary ms-2">{{ $progress }}%</span>
              </div>
            </div>
            <div class="card-footer bg-transparent border-0 text-end">
              <a href="{{ route('student.courses.show', $course->id) }}" class="btn btn-primary btn-sm">Voir le cours</a>
            </div>
          </div>
        @endforeach
      @else
        <div class="alert alert-info text-center my-5 p-4 rounded-4 shadow-sm" style="font-size:1.2rem;">
          Aucun cours trouvé pour ce statut.<br>
          <span class="text-muted">Essayez un autre filtre ou commencez un nouveau cours.</span>
        </div>
      @endif
    </div>
  </div>
</div>
@endsection
