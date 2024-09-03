@extends('layouts.app')

@section('title', 'Edit Course')

@section('content')
<div class="container">
    <h1>Edit Course</h1>

    <!-- Form to edit an existing course -->
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
                <input type="date" id="course_creation_date" name="creation_date" class="form-control" value="{{ old('creation_date', $course->creation_date) }}">
            </div>

            <input type="hidden" name="author_id" value="{{ auth()->user()->id }}">
        </div>

        <!-- Toggle to show/hide sections and modules -->
        <div class="form-group">
            <label for="include_sections">
                <input type="checkbox" id="include_sections" name="include_sections" {{ $course->sections->isNotEmpty() ? 'checked' : '' }}> Include Sections and Modules
            </label>
        </div>

        <!-- Section Details -->
        <div id="section-container" style="{{ $course->sections->isEmpty() ? 'display: none;' : '' }}">
            @foreach ($course->sections as $index => $section)
                <div class="form-section section-group">
                    <h2>Section Details</h2>
                    <div class="form-group">
                        <label for="sections[{{ $index }}][name]">Section Name:</label>
                        <input type="text" id="sections_{{ $index }}_name" name="sections[{{ $index }}][name]" class="form-control" value="{{ old('sections.' . $index . '.name', $section->name) }}">
                    </div>
                    <div class="form-group">
                        <label for="sections[{{ $index }}][description]">Section Description:</label>
                        <textarea id="sections_{{ $index }}_description" name="sections[{{ $index }}][description]" class="form-control">{{ old('sections.' . $index . '.description', $section->description) }}</textarea>
                    </div>
                    <div class="form-group">
                        <label for="sections[{{ $index }}][level]">Section Level:</label>
                        <input type="number" id="sections_{{ $index }}_level" name="sections[{{ $index }}][level]" class="form-control" value="{{ old('sections.' . $index . '.level', $section->level) }}">
                    </div>
                    <div class="d-flex justify-content-between">
                        <button type="button" class="btn btn-secondary add-module-btn">Add Module</button>
                        <button type="button" class="btn btn-danger remove-section-btn">Remove Section</button>
                    </div>
                    <div class="module-container">
                        @foreach ($section->modules as $mIndex => $module)
                            <div class="form-section module-group">
                                <h2>Module Details</h2>
                                <div class="form-group">
                                    <label for="sections[{{ $index }}][modules][{{ $mIndex }}][name]">Module Name:</label>
                                    <input type="text" id="sections_{{ $index }}_modules_{{ $mIndex }}_name" name="sections[{{ $index }}][modules][{{ $mIndex }}][name]" class="form-control" value="{{ old('sections.' . $index . '.modules.' . $mIndex . '.name', $module->name) }}">
                                </div>
                                <div class="form-group">
                                    <label for="sections[{{ $index }}][modules][{{ $mIndex }}][description]">Module Description:</label>
                                    <textarea id="sections_{{ $index }}_modules_{{ $mIndex }}_description" name="sections[{{ $index }}][modules][{{ $mIndex }}][description]" class="form-control">{{ old('sections.' . $index . '.modules.' . $mIndex . '.description', $module->description) }}</textarea>
                                </div>
                                <div class="form-group">
                                    <label for="sections[{{ $index }}][modules][{{ $mIndex }}][level]">Module Level:</label>
                                    <input type="number" id="sections_{{ $index }}_modules_{{ $mIndex }}_level" name="sections[{{ $index }}][modules][{{ $mIndex }}][level]" class="form-control" value="{{ old('sections.' . $index . '.modules.' . $mIndex . '.level', $module->level) }}">
                                </div>
                                <button type="button" class="btn btn-danger remove-module-btn">Remove Module</button>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Module Details (Standalone Modules) -->
        <div id="module-container">
            @foreach ($course->modules->where('section_id', null) as $mIndex => $module)
                <div class="form-section module-group">
                    <h2>Module Details</h2>
                    <div class="form-group">
                        <label for="modules[{{ $mIndex }}][name]">Module Name:</label>
                        <input type="text" id="modules_{{ $mIndex }}_name" name="modules[{{ $mIndex }}][name]" class="form-control" value="{{ old('modules.' . $mIndex . '.name', $module->name) }}">
                    </div>
                    <div class="form-group">
                        <label for="modules[{{ $mIndex }}][description]">Module Description:</label>
                        <textarea id="modules_{{ $mIndex }}_description" name="modules[{{ $mIndex }}][description]" class="form-control">{{ old('modules.' . $mIndex . '.description', $module->description) }}</textarea>
                    </div>
                    <div class="form-group">
                        <label for="modules[{{ $mIndex }}][level]">Module Level:</label>
                        <input type="number" id="modules_{{ $mIndex }}_level" name="modules[{{ $mIndex }}][level]" class="form-control" value="{{ old('modules.' . $mIndex . '.level', $module->level) }}">
                    </div>
                    <button type="button" class="btn btn-danger remove-module-btn">Remove Module</button>
                </div>
            @endforeach
        </div>

        <div class="d-flex justify-content-between mt-3">
            <button type="button" class="btn btn-secondary" id="add-section-btn" style="{{ $course->sections->isEmpty() ? 'display: none;' : '' }}">Add Section</button>
            <button type="button" class="btn btn-secondary" id="add-module-btn">Add Module</button>
            <button type="submit" class="btn btn-primary">Update Course</button>
        </div>
    </form>
</div>

<style>
    .form-section {
        margin-bottom: 20px;
        padding: 20px;
        border: 1px solid #ddd;
        border-radius: 5px;
        background-color: #f9f9f9;
    }

    .section-group {
        margin-top: 20px;
        padding: 20px;
        border: 1px solid #ddd;
        border-radius: 5px;
        background-color: #fff;
        position: relative;
    }

    .module-group {
        margin: 10px;
        padding: 10px;
        border: 1px solid #ddd;
        border-radius: 5px;
        background-color: #f4f4f4;
        display: inline-block;
        vertical-align: top;
        width: calc(33.333% - 20px);
    }

    .form-group {
        margin-bottom: 15px;
    }

    .form-group label {
        display: block;
        margin-bottom: 5px;
    }

    .d-flex {
        display: flex;
        align-items: center;
    }

    .justify-content-between {
        justify-content: space-between;
    }

    .btn {
        margin-right: 10px;
    }

    .btn-secondary {
        background-color: #6c757d;
        border-color: #6c757d;
    }

    .btn-danger {
        background-color: #dc3545;
        border-color: #dc3545;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        let sectionCount = {{ $course->sections->count() }};
        let moduleCount = {{ $course->modules->count() }};

        function toggleSections() {
            const sectionContainer = document.getElementById('section-container');
            const addSectionBtn = document.getElementById('add-section-btn');
            const includeSectionsCheckbox = document.getElementById('include_sections');

            if (includeSectionsCheckbox.checked) {
                sectionContainer.style.display = '';
                addSectionBtn.style.display = '';
            } else {
                sectionContainer.style.display = 'none';
                addSectionBtn.style.display = 'none';
            }
        }

        document.getElementById('include_sections').addEventListener('change', toggleSections);

        document.getElementById('add-section-btn').addEventListener('click', function() {
            const sectionTemplate = `
                <div class="form-section section-group">
                    <h2>Section Details</h2>
                    <div class="form-group">
                        <label for="sections[${sectionCount}][name]">Section Name:</label>
                        <input type="text" id="sections_${sectionCount}_name" name="sections[${sectionCount}][name]" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="sections[${sectionCount}][description]">Section Description:</label>
                        <textarea id="sections_${sectionCount}_description" name="sections[${sectionCount}][description]" class="form-control"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="sections[${sectionCount}][level]">Section Level:</label>
                        <input type="number" id="sections_${sectionCount}_level" name="sections[${sectionCount}][level]" class="form-control">
                    </div>
                    <div class="d-flex justify-content-between">
                        <button type="button" class="btn btn-secondary add-module-btn">Add Module</button>
                        <button type="button" class="btn btn-danger remove-section-btn">Remove Section</button>
                    </div>
                    <div class="module-container"></div>
                </div>
            `;

            const sectionContainer = document.getElementById('section-container');
            sectionContainer.insertAdjacentHTML('beforeend', sectionTemplate);
            sectionCount++;

            initializeSectionButtons();
        });

        document.getElementById('add-module-btn').addEventListener('click', function() {
            const moduleTemplate = `
                <div class="form-section module-group">
                    <h2>Module Details</h2>
                    <div class="form-group">
                        <label for="modules[${moduleCount}][name]">Module Name:</label>
                        <input type="text" id="modules_${moduleCount}_name" name="modules[${moduleCount}][name]" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="modules[${moduleCount}][description]">Module Description:</label>
                        <textarea id="modules_${moduleCount}_description" name="modules[${moduleCount}][description]" class="form-control"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="modules[${moduleCount}][level]">Module Level:</label>
                        <input type="number" id="modules_${moduleCount}_level" name="modules[${moduleCount}][level]" class="form-control">
                    </div>
                    <button type="button" class="btn btn-danger remove-module-btn">Remove Module</button>
                </div>
            `;

            const moduleContainer = document.getElementById('module-container');
            moduleContainer.insertAdjacentHTML('beforeend', moduleTemplate);
            moduleCount++;

            initializeModuleButtons();
        });

        function initializeSectionButtons() {
            document.querySelectorAll('.remove-section-btn').forEach(function(button) {
                button.addEventListener('click', function() {
                    button.closest('.section-group').remove();
                });
            });

            document.querySelectorAll('.add-module-btn').forEach(function(button) {
                button.addEventListener('click', function() {
                    const sectionIndex = Array.from(document.querySelectorAll('.section-group')).indexOf(button.closest('.section-group'));
                    const moduleContainer = button.closest('.section-group').querySelector('.module-container');

                    const moduleTemplate = `
                        <div class="form-section module-group">
                            <h2>Module Details</h2>
                            <div class="form-group">
                                <label for="sections[${sectionIndex}][modules][${moduleCount}][name]">Module Name:</label>
                                <input type="text" id="sections_${sectionIndex}_modules_${moduleCount}_name" name="sections[${sectionIndex}][modules][${moduleCount}][name]" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="sections[${sectionIndex}][modules][${moduleCount}][description]">Module Description:</label>
                                <textarea id="sections_${sectionIndex}_modules_${moduleCount}_description" name="sections[${sectionIndex}][modules][${moduleCount}][description]" class="form-control"></textarea>
                            </div>
                            <div class="form-group">
                                <label for="sections[${sectionIndex}][modules][${moduleCount}][level]">Module Level:</label>
                                <input type="number" id="sections_${sectionIndex}_modules_${moduleCount}_level" name="sections[${sectionIndex}][modules][${moduleCount}][level]" class="form-control">
                            </div>
                            <button type="button" class="btn btn-danger remove-module-btn">Remove Module</button>
                        </div>
                    `;

                    moduleContainer.insertAdjacentHTML('beforeend', moduleTemplate);
                    moduleCount++;

                    initializeModuleButtons();
                });
            });
        }

        function initializeModuleButtons() {
            document.querySelectorAll('.remove-module-btn').forEach(function(button) {
                button.addEventListener('click', function() {
                    button.closest('.module-group').remove();
                });
            });
        }

        initializeSectionButtons();
        initializeModuleButtons();
        toggleSections();
    });
</script>
@endsection
