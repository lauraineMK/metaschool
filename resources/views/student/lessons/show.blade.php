@extends('layouts.app')

@section('title', 'Lesson Details - MetaSchool')

@section('content')
<div class="container mt-5">
    <div class="wrapper">
        <!-- Left sidebar for buttons -->
        <div class="sidebar">
            <!-- Button to go back to lessons list -->
            <a href="{{ route('student.lessons.index') }}" class="btn btn-secondary mb-3 btn-block d-none d-md-block">Back to Lessons</a>
            <a href="{{ route('student.lessons.index') }}" class="btn btn-secondary mt-4 btn-block d-block d-md-none">
                <i class="fa fa-list"></i>&nbsp;<i class="fa fa-arrow-left"></i>
            </a>

            <!-- Button to go back to course -->
            <a href="{{ route('student.courses.show', $lesson->course->id) }}" class="btn btn-secondary mb-3 btn-block d-none d-md-block">Back to Course</a>
            <a href="{{ route('student.courses.show', $lesson->course->id) }}" class="btn btn-secondary mt-4 btn-block d-block d-md-none">
                <i class="fa fa-book"></i>&nbsp;<i class="fa fa-arrow-left"></i>
            </a>
        </div>

        <!-- Right section for lesson details -->
        <div class="content">
            <div class="d-flex justify-content-between align-items-center">
                <h1>{{ $lesson->title }}</h1>
                <!-- Lesson Viewed Button -->
                <button id="lesson-viewed-btn" data-lesson-id="{{ $lesson->id }}" class="btn btn-outline-secondary">
                    <span class="fa fa-check-circle"></span> Lesson viewed
                </button>
            </div>

            <!-- Lesson Content -->
            <p>{{ $lesson->content }}</p>

            <!-- Lesson Information -->
            <div class="mb-3">
                <strong>Course:</strong>
                <a href="{{ route('student.courses.show', $lesson->course->id) }}">{{ $lesson->course->name }}</a>
            </div>

            @if($lesson->section)
            <div class="mb-3">
                <strong>Section:</strong> {{ $lesson->section->name }}
            </div>
            @endif

            @if($lesson->module)
            <div class="mb-3">
                <strong>Module:</strong> {{ $lesson->module->name }}
            </div>
            @endif

            <!-- Lesson Videos -->
            @if($videos->count() > 0)
            <div class="mt-4">
                <h3>Videos</h3>
                @foreach($videos as $video)
                <div class="mb-3">
                    <h5>{{ $video->title }}</h5>
                    <p>{{ $video->description }}</p>

                    @php
                    $url = $video->url;
                    $videoId = null;

                    // Extract video ID for YouTube
                    if (str_contains($url, 'youtube.com/watch?v=')) {
                    parse_str(parse_url($url, PHP_URL_QUERY), $query);
                    $videoId = $query['v'] ?? null;
                    } elseif (str_contains($url, 'youtu.be/')) {
                    $videoId = basename($url);
                    }
                    @endphp

                    @if($videoId)
                    <div class="video-container">
                        <iframe src="https://www.youtube.com/embed/{{ $videoId }}" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                    </div>
                    @else
                    <p>Unsupported video format or URL.</p>
                    @endif
                </div>
                @endforeach
            </div>
            @else
            <div class="mt-4">
                <p>No videos available for this lesson.</p>
            </div>
            @endif

            <!-- Lesson Documents -->
            @if($documents->count() > 0)
            <div class="mt-4">
                <h3>Documents</h3>
                @foreach($documents as $document)
                <div class="mb-3">
                    <h5>{{ $document->title }}</h5>
                    <p>{{ $document->description }}</p>

                    @if($document->file)
                    @php
                    $fileExtension = strtolower(pathinfo($document->file, PATHINFO_EXTENSION));
                    @endphp

                    @if($fileExtension === 'pdf')
                    <iframe src="{{ url('storage/' . $document->file) }}" width="100%" height="600px" frameborder="0"></iframe>
                    @elseif(in_array($fileExtension, ['jpg', 'jpeg', 'png', 'gif']))
                    <img src="{{ url('storage/' . $document->file) }}" alt="{{ $document->title }}" style="max-width: 100%; height: auto;">
                    @elseif(in_array($fileExtension, ['doc', 'docx']))
                    <a href="https://view.officeapps.live.com/op/view.aspx?src={{ urlencode(Storage::url($document->file)) }}" class="btn btn-info" target="_blank">View {{ $document->title }}</a>
                    @elseif(in_array($fileExtension, ['xls', 'xlsx']))
                    <a href="https://view.officeapps.live.com/op/view.aspx?src={{ urlencode(Storage::url($document->file)) }}" class="btn btn-info" target="_blank">View {{ $document->title }}</a>
                    @elseif($fileExtension === 'txt')
                    <a href="{{ url('storage/' . $document->file) }}" class="btn btn-info" target="_blank">View {{ $document->title }}</a>
                    <a href="{{ url('storage/' . $document->file) }}" class="btn btn-info" download>Download {{ $document->title }}</a>
                    @else
                    <a href="{{ url('storage/' . $document->file) }}" class="btn btn-info" target="_blank">View {{ $document->title }}</a>
                    <a href="{{ url('storage/' . $document->file) }}" class="btn btn-info" download>Download {{ $document->title }}</a>
                    @endif
                    @else
                    <p>No file available for this document.</p>
                    @endif
                </div>
                @endforeach
            </div>
            @else
            <div class="mt-4">
                <p>No documents available for this lesson.</p>
            </div>
            @endif

            <!-- Navigation Buttons -->
            <div class="mt-4">
                @if ($previousLesson)
                <a href="{{ route('student.lessons.show', $previousLesson->id) }}" class="btn btn-primary btn-desktop-only">Previous Lesson</a>
                <a href="{{ route('student.lessons.show', $previousLesson->id) }}" class="btn btn-primary btn-mobile-only btn-icon-space">
                    <i class="fa fa-arrow-left"></i>
                </a>
                @endif

                @if ($nextLesson)
                <a href="{{ route('student.lessons.show', $nextLesson->id) }}" class="btn btn-primary btn-desktop-only">Next Lesson</a>
                <a href="{{ route('student.lessons.show', $nextLesson->id) }}" class="btn btn-primary btn-mobile-only btn-icon-space">
                    <i class="fa fa-arrow-right"></i>
                </a>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
