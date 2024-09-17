@extends('layouts.app')

@section('title', 'Edit Course')

@section('content')
<div class="container  mt-5">
    <div class="header">
        <h1>Edit Course</h1>
        <a href="{{ route('teacher.courses.index') }}" class="btn btn-secondary">Cancel</a>
    </div>

    <form action="{{ route('teacher.courses.update', $course->id) }}" method="POST">
        @csrf
        @method('PUT')

        <!-- Course Details -->
        <div class="form-section">
            <h2>Course Details</h2>

            <div class="form-group">
                <label for="course_name">Course Name:</label>
                <input type="text" id="course_name" name="name" class="form-control" value="{{ old('name', $course->name) }}" required>
            </div>

            <div class="form-group">
                <label for="course_description">Course Description:</label>
                <textarea id="course_description" name="description" class="form-control">{{ old('description', $course->description) }}</textarea>
            </div>

            <div class="form-group">
                <label for="course_price">Course Price:</label>
                <input type="number" id="course_price" name="price" class="form-control" value="{{ old('price', $course->price) }}">
            </div>

            <div class="form-group">
                <label for="course_creation_date">Creation Date:</label>
                <input type="date" id="course_creation_date" name="creation_date" class="form-control" value="{{ old('creation_date', $course->creation_date instanceof \DateTime ? $course->creation_date->format('Y-m-d') : $course->creation_date) }}">
            </div>

            <input type="hidden" name="author_id" value="{{ $course->author_id }}">
        </div>

        <!-- Toggle to show/hide sections and modules -->
        <div class="form-group">
            <label for="include_sections">
                <input type="checkbox" id="include_sections" name="include_sections" {{ old('include_sections', $course->sections->count() > 0 ? 'checked' : '') }}> Include Sections and Modules
            </label>
        </div>

        <!-- Section Details -->
        <div id="section-container" class="{{ $course->sections->count() > 0 ? 'visible' : 'hidden' }}">
            @foreach ($course->sections as $index => $section)
            <div class="form-section section-group">
                <h2>Section Details</h2>
                <input type="hidden" name="sections[{{ $index }}][id]" value="{{ old('sections.' . $index . '.id', $section->id) }}">
                <input type="hidden" name="sections[{{ $index }}][_delete]" value="0">
                <div class="form-group">
                    <label for="sections_{{ $index }}_name">Section Name:</label>
                    <input type="text" id="sections_{{ $index }}_name" name="sections[{{ $index }}][name]" class="form-control" value="{{ old('sections.' . $index . '.name', $section->name) }}">
                </div>
                <div class="form-group">
                    <label for="sections_{{ $index }}_description">Section Description:</label>
                    <textarea id="sections_{{ $index }}_description" name="sections[{{ $index }}][description]" class="form-control">{{ old('sections.' . $index . '.description', $section->description) }}</textarea>
                </div>
                <div class="form-group">
                    <label for="sections_{{ $index }}_level">Section Level:</label>
                    <input type="number" id="sections_{{ $index }}_level" name="sections[{{ $index }}][level]" class="form-control" value="{{ old('sections.' . $index . '.level', $section->level) }}">
                </div>
                <div class="d-flex justify-content-between">
                    <button type="button" class="btn btn-secondary add-module-btn desktop-only">Add Module</button>
                    <button type="button" class="btn btn-secondary add-module-btn mobile-only">
                        <i class="fas fa-plus"></i>
                    </button>
                    <button type="button" class="btn btn-danger remove-section-btn desktop-only">Remove Section</button>
                    <button type="button" class="btn btn-danger remove-section-btn mobile-only">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
                <div class="module-container">
                    @foreach ($section->modules as $moduleIndex => $module)
                    <div class="form-section module-group">
                        <h2>Module Details</h2>
                        <input type="hidden" name="sections[{{ $index }}][modules][{{ $moduleIndex }}][id]" value="{{ old('sections.' . $index . '.modules.' . $moduleIndex . '.id', $module->id) }}">
                        <input type="hidden" name="sections[{{ $index }}][modules][{{ $moduleIndex }}][_delete]" value="0">
                        <div class="form-group">
                            <label for="sections_{{ $index }}_modules_{{ $moduleIndex }}_name">Module Name:</label>
                            <input type="text" id="sections_{{ $index }}_modules_{{ $moduleIndex }}_name" name="sections[{{ $index }}][modules][{{ $moduleIndex }}][name]" class="form-control" value="{{ old('sections.' . $index . '.modules.' . $moduleIndex . '.name', $module->name) }}">
                        </div>
                        <div class="form-group">
                            <label for="sections_{{ $index }}_modules_{{ $moduleIndex }}_description">Module Description:</label>
                            <textarea id="sections_{{ $index }}_modules_{{ $moduleIndex }}_description" name="sections[{{ $index }}][modules][{{ $moduleIndex }}][description]" class="form-control">{{ old('sections.' . $index . '.modules.' . $moduleIndex . '.description', $module->description) }}</textarea>
                        </div>
                        <div class="form-group">
                            <label for="sesections_{{ $index }}_modules_{{ $moduleIndex }}_level">Module Level:</label>
                            <input type="number" id="sections_{{ $index }}_modules_{{ $moduleIndex }}_level" name="sections[{{ $index }}][modules][{{ $moduleIndex }}][level]" class="form-control" value="{{ old('sections.' . $index . '.modules.' . $moduleIndex . '.level', $module->level) }}">
                        </div>
                        <button type="button" class="btn btn-danger remove-module-btn desktop-only">Remove Module</button>
                        <button type="button" class="btn btn-danger remove-module-btn mobile-only">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                    @endforeach
                </div>
            </div>
            @endforeach
        </div>

        <!-- Module Details -->
        <div id="module-container" class="{{ $course->modules->whereNull('section_id')->count() > 0 ? 'visible' : 'hidden' }}">
            @foreach ($course->modules->whereNull('section_id') as $moduleIndex => $module)
            <div class="form-section module-group">
                <h2>Module Details</h2>
                <input type="hidden" name="modules[{{ $moduleIndex }}][id]" value="{{ old('modules.' . $moduleIndex . '.id', $module->id) }}">
                <div class="form-group">
                    <label for="modules_{{ $moduleIndex }}_name">Module Name:</label>
                    <input type="text" id="modules_{{ $moduleIndex }}_name" name="modules[{{ $moduleIndex }}][name]" class="form-control" value="{{ old('modules.' . $moduleIndex . '.name', $module->name) }}">
                </div>
                <div class="form-group">
                    <label for="modules_{{ $moduleIndex }}_description">Module Description:</label>
                    <textarea id="modules_{{ $moduleIndex }}_description" name="modules[{{ $moduleIndex }}][description]" class="form-control">{{ old('modules.' . $moduleIndex . '.description', $module->description) }}</textarea>
                </div>
                <div class="form-group">
                    <label for="modules_{{ $moduleIndex }}_level">Module Level:</label>
                    <input type="number" id="modules_{{ $moduleIndex }}_level" name="modules[{{ $moduleIndex }}][level]" class="form-control" value="{{ old('modules.' . $moduleIndex . '.level', $module->level) }}">
                </div>
                <button type="button" class="btn btn-danger remove-module-btn desktop-only">Remove Module</button>
                <button type="button" class="btn btn-danger remove-module-btn mobile-only">
                    <i class="fas fa-trash"></i>
                </button>
            </div>
            @endforeach
        </div>

        <!-- Action Buttons -->
        <div class="d-flex justify-content-between mt-3">
            <button type="button" class="btn btn-secondary desktop-only {{ $course->sections->count() > 0 ? 'hidden' : 'visible' }}" id="add-section-btn">Add Section</button>
            <button type="button" class="btn btn-secondary desktop-only" id="add-module-btn">Add Module</button>
            <button type="submit" class="btn btn-primary">Update Course</button>
        </div>
    </form>
</div>
@endsection
