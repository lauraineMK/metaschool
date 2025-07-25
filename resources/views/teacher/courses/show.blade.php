@extends('layouts.app')

@section('title', 'Course Details - MetaSchool')

@section('content')
<div class="container mt-5">
    <div class="wrapper">
        <!-- Left sidebar for buttons -->
        <div class="sidebar">
            <!-- Button to edit the course -->
            <a href="{{ route('teacher.courses.edit', $course->id) }}" class="btn btn-warning mb-3 btn-block d-none d-md-block">{{ __('messages.edit_course') }}</a>
            <a href="{{ route('teacher.courses.edit', $course->id) }}" class="btn btn-warning mb-3 btn-block d-block d-md-none">
                <i class="fa fa-pencil-alt"></i>
            </a>

            <!-- Button to delete the course -->
            <form action="{{ route('teacher.courses.destroy', $course->id) }}" method="POST" style="display: inline;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger mb-3 btn-block d-none d-md-block" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce cours ?');">{{ __('messages.delete_course') }}</button>
                <button type="submit" class="btn btn-danger mb-3 btn-block d-block d-md-none" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce cours ?');">
                    <i class="fa fa-trash-alt"></i>
                </button>
            </form>

            <!-- Button to go back to the courses list -->
            <a href="{{ route('teacher.courses.index') }}" class="btn btn-secondary mt-4 btn-block d-none d-md-block">{{ __('messages.back_to_courses') }}</a>
            <a href="{{ route('teacher.courses.index') }}" class="btn btn-secondary mt-4 btn-block d-block d-md-none">
                <i class="fa fa-arrow-left"></i>
            </a>
        </div>

        <!-- Right section for course details -->
        <div class="content">
            <h1>{{ $course->name }}</h1>

            <!-- Course Description -->
            <p>{{ $course->description }}</p>

            <!-- Course Content -->
            <h2 class="mt-5">{{ __('messages.course_content') }}</h2>

        <!-- Boutons d'ajout -->
        <div class="mb-4 d-flex gap-3">
            <button class="btn btn-primary" type="button" data-bs-toggle="collapse" data-bs-target="#addSectionForm" aria-expanded="false" aria-controls="addSectionForm">
                + Ajouter une section
            </button>
            <button class="btn btn-success" type="button" data-bs-toggle="collapse" data-bs-target="#addModuleForm" aria-expanded="false" aria-controls="addModuleForm">
                + Ajouter un module
            </button>
        </div>

        <!-- Formulaire ajout section -->
        <div class="collapse mb-3" id="addSectionForm">
            <form method="POST" action="{{ route('teachers.sections.store') }}">
                @csrf
                <input type="hidden" name="course_id" value="{{ $course->id }}">
                <div class="mb-2">
                    <label for="sectionName" class="form-label">Nom de la section</label>
                    <input type="text" class="form-control" id="sectionName" name="name" required>
                </div>
                <div class="mb-2">
                    <label for="sectionDesc" class="form-label">Description</label>
                    <textarea class="form-control" id="sectionDesc" name="description"></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Ajouter la section</button>
            </form>
        </div>

        <!-- Formulaire ajout module -->
        <div class="collapse mb-3" id="addModuleForm">
            <form method="POST" action="{{ route('teachers.modules.store') }}">
                @csrf
                <input type="hidden" name="course_id" value="{{ $course->id }}">
                <div class="mb-2">
                    <label for="moduleName" class="form-label">Nom du module</label>
                    <input type="text" class="form-control" id="moduleName" name="name" required>
                </div>
                <div class="mb-2">
                    <label for="moduleDesc" class="form-label">Description</label>
                    <textarea class="form-control" id="moduleDesc" name="description"></textarea>
                </div>
                <button type="submit" class="btn btn-success">Ajouter le module</button>
            </form>
        </div>

            <!-- First case: Sections -> Modules -> Lessons -->
            @if (!$course->sections->isEmpty())
            @foreach ($course->sections as $section)
            <div class="section mb-4 d-flex align-items-center justify-content-between">
                <div>
                    <h3>{{ __('messages.section') }} {{ $section->name }}</h3>
                    <p>{{ $section->description }}</p>
                </div>
                <form method="POST" action="{{ route('teacher.section.destroy', $section->id) }}" onsubmit="return confirm('Supprimer cette section ?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-outline-danger btn-sm"><i class="fa fa-trash"></i> Supprimer</button>
                </form>
                @if (!$section->modules->isEmpty())
                @foreach ($section->modules as $module)
                <div class="module ml-4 mb-3 d-flex align-items-center justify-content-between">
                    <div>
                        <h4>{{ __('messages.module') }} {{ $module->name }}</h4>
                        <p>{{ $module->description }}</p>
                    </div>
                    <form method="POST" action="{{ route('teacher.module.destroy', $module->id) }}" onsubmit="return confirm('Supprimer ce module ?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-outline-danger btn-sm"><i class="fa fa-trash"></i> Supprimer</button>
                    </form>
                    @if (!$module->lessons->isEmpty())
                    <ul class="list-group ml-4">
                        @foreach ($module->lessons as $lesson)
                        <li class="list-group-item">
                            <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center">
                                <div>
                                    <a href="{{ route('teacher.lessons.show', $lesson->id) }}">{{ $lesson->title }}</a>
                                    <span class="badge badge-info ml-2">{{ __('messages.lesson') }}</span>
                                </div>
                                <!-- Resources for this lesson -->
                                <div class="mt-2 mt-md-0">
                                    @if (!$lesson->documents->isEmpty())
                                        <span class="mr-2"><i class="fa fa-file-alt text-primary"></i> {{ $lesson->documents->count() }} {{ __('messages.documents') }}</span>
                                    @endif
                                    @if (!empty($lesson->video_path))
                                        <span class="mr-2"><i class="fa fa-video text-success"></i> {{ __('messages.video') }}</span>
                                    @endif
                                    @if (!empty($lesson->quizzes) && $lesson->quizzes instanceof \Illuminate\Support\Collection && $lesson->quizzes->isNotEmpty())
                                        <span class="mr-2"><i class="fa fa-question-circle text-warning"></i> {{ $lesson->quizzes->count() }} {{ __('messages.quizzes') }}</span>
                                    @endif
                                </div>
                            </div>
                            <!-- Optionally: Preview video (if exists) -->
                            @if (!empty($lesson->video_path))
                            <div class="mt-2">
                                <video controls style="max-width: 320px; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.08);">
                                    <source src="{{ route('video.stream', $lesson->id) }}" type="video/mp4">
                                    {{ __('messages.your_browser_does_not_support_video') }}
                                </video>
                            </div>
                            @endif
                            <!-- Optionally: List documents -->
                            @if (!$lesson->documents->isEmpty())
                            <div class="mt-2">
                                <ul class="list-unstyled">
                                    @foreach ($lesson->documents as $doc)
                                    <li><a href="{{ route('documents.download', $doc->id) }}" target="_blank"><i class="fa fa-file-alt mr-1"></i> {{ $doc->name }}</a></li>
                                    @endforeach
                                </ul>
                            </div>
                            @endif
                            <!-- Optionally: List quizzes -->
                            @if (!empty($lesson->quizzes) && $lesson->quizzes instanceof \Illuminate\Support\Collection && $lesson->quizzes->isNotEmpty())
                            <div class="mt-2">
                                <ul class="list-unstyled">
                                    @foreach ($lesson->quizzes as $quiz)
                                    <li><a href="{{ route('teacher.quizzes.show', $quiz->id) }}"><i class="fa fa-question-circle mr-1"></i> {{ $quiz->title }}</a></li>
                                    @endforeach
                                </ul>
                            </div>
                            @endif
                        </li>
                        @endforeach
                    </ul>
                    @else
                    <p>{{ __('messages.no_lessons_available_in_this_module') }}</p>
                    @endif
                </div>
                @endforeach
                @else
                <p>{{ __('messages.no_modules_available_in_this_section') }}</p>
                @endif
            </div>
            @endforeach
            <!-- Second case: Modules -> Lessons -->
            @elseif (!$course->modules->isEmpty())
            @foreach ($course->modules as $module)
            <div class="module mb-4">
                <h4>{{ __('messages.module') }} {{ $module->name }}</h4>

                @if (!$module->lessons->isEmpty())
                <ul class="list-group ml-4">
                    @foreach ($module->lessons as $lesson)
                    <li class="list-group-item">
                        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center">
                            <div>
                                <a href="{{ route('teacher.lessons.show', $lesson->id) }}">{{ $lesson->title }}</a>
                                <span class="badge badge-info ml-2">{{ __('messages.lesson') }}</span>
                            </div>
                            <!-- Resources for this lesson -->
                            <div class="mt-2 mt-md-0">
                                @if (!$lesson->documents->isEmpty())
                                    <span class="mr-2"><i class="fa fa-file-alt text-primary"></i> {{ $lesson->documents->count() }} {{ __('messages.documents') }}</span>
                                @endif
                                @if (!empty($lesson->video_path))
                                    <span class="mr-2"><i class="fa fa-video text-success"></i> {{ __('messages.video') }}</span>
                                @endif
                                @if (!empty($lesson->quizzes) && $lesson->quizzes instanceof \Illuminate\Support\Collection && $lesson->quizzes->isNotEmpty())
                                    <span class="mr-2"><i class="fa fa-question-circle text-warning"></i> {{ $lesson->quizzes->count() }} {{ __('messages.quizzes') }}</span>
                                @endif
                            </div>
                        </div>
                        <!-- Optionally: Preview video (if exists) -->
                        @if (!empty($lesson->video_path))
                        <div class="mt-2">
                            <video controls style="max-width: 320px; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.08);">
                                <source src="{{ route('video.stream', $lesson->id) }}" type="video/mp4">
                                {{ __('messages.your_browser_does_not_support_video') }}
                            </video>
                        </div>
                        @endif
                        <!-- Optionally: List documents -->
                        @if (!$lesson->documents->isEmpty())
                        <div class="mt-2">
                            <ul class="list-unstyled">
                                @foreach ($lesson->documents as $doc)
                                <li><a href="{{ route('documents.download', $doc->id) }}" target="_blank"><i class="fa fa-file-alt mr-1"></i> {{ $doc->name }}</a></li>
                                @endforeach
                            </ul>
                        </div>
                        @endif
                        <!-- Optionally: List quizzes -->
                        @if (!empty($lesson->quizzes) && $lesson->quizzes instanceof \Illuminate\Support\Collection && $lesson->quizzes->isNotEmpty())
                        <div class="mt-2">
                            <ul class="list-unstyled">
                                @foreach ($lesson->quizzes as $quiz)
                                <li><a href="{{ route('teacher.quizzes.show', $quiz->id) }}"><i class="fa fa-question-circle mr-1"></i> {{ $quiz->title }}</a></li>
                                @endforeach
                            </ul>
                        </div>
                        @endif
                    </li>
                    @endforeach
                </ul>
                @else
                <p>{{ __('messages.no_lessons_available_in_this_module') }}</p>
                @endif
            </div>
            @endforeach
            <!-- Third case: Direct lessons from the course -->
            @elseif (!$course->lessons->isEmpty())
            <ul class="list-group">
                @foreach ($course->lessons as $lesson)
                <li class="list-group-item">
                    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center">
                        <div>
                            <a href="{{ route('teacher.lessons.show', $lesson->id) }}">{{ $lesson->title }}</a>
                            <span class="badge badge-info ml-2">{{ __('messages.lesson') }}</span>
                        </div>
                        <!-- Resources for this lesson -->
                        <div class="mt-2 mt-md-0">
                            @if (!$lesson->documents->isEmpty())
                                <span class="mr-2"><i class="fa fa-file-alt text-primary"></i> {{ $lesson->documents->count() }} {{ __('messages.documents') }}</span>
                            @endif
                            @if (!empty($lesson->video_path))
                                <span class="mr-2"><i class="fa fa-video text-success"></i> {{ __('messages.video') }}</span>
                            @endif
                            @if (!$lesson->quizzes->isEmpty())
                                <span class="mr-2"><i class="fa fa-question-circle text-warning"></i> {{ $lesson->quizzes->count() }} {{ __('messages.quizzes') }}</span>
                            @endif
                        </div>
                    </div>
                    <!-- Optionally: Preview video (if exists) -->
                    @if (!empty($lesson->video_path))
                    <div class="mt-2">
                        <video controls style="max-width: 320px; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.08);">
                            <source src="{{ route('video.stream', $lesson->id) }}" type="video/mp4">
                            {{ __('messages.your_browser_does_not_support_video') }}
                        </video>
                    </div>
                    @endif
                    <!-- Optionally: List documents -->
                    @if (!$lesson->documents->isEmpty())
                    <div class="mt-2">
                        <ul class="list-unstyled">
                            @foreach ($lesson->documents as $doc)
                            <li><a href="{{ route('documents.download', $doc->id) }}" target="_blank"><i class="fa fa-file-alt mr-1"></i> {{ $doc->name }}</a></li>
                            @endforeach
                        </ul>
                    </div>
                    @endif
                    <!-- Optionally: List quizzes -->
                    @if (!$lesson->quizzes->isEmpty())
                    <div class="mt-2">
                        <ul class="list-unstyled">
                            @foreach ($lesson->quizzes as $quiz)
                            <li><a href="{{ route('teacher.quizzes.show', $quiz->id) }}"><i class="fa fa-question-circle mr-1"></i> {{ $quiz->title }}</a></li>
                            @endforeach
                        </ul>
                    </div>
                    @endif
                </li>
                @endforeach
            </ul>
            @else
            <p>{{ __('messages.no_lessons_available_for_this_course') }}</p>
            @endif
        </div>
    </div>
</div>
@endsection
