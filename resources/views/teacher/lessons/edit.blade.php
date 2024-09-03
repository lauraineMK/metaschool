@extends('layouts.app')

@section('title', 'Edit Lesson - MetaSchool')

@section('content')
<div class="container mt-5">
    <h1>Edit Lesson</h1>

    <!-- Form to edit an existing lesson -->
    <form action="{{ route('teacher.lessons.update', $lesson->id) }}" method="POST">
        @csrf
        @method('PUT')

        <!-- Title input -->
        <div class="form-group">
            <label for="title">Lesson Title</label>
            <input type="text" class="form-control" id="title" name="title" value="{{ old('title', $lesson->title) }}" required>
        </div>

        <!-- Content input -->
        <div class="form-group mt-3">
            <label for="content">Content</label>
            <textarea class="form-control" id="content" name="content" rows="5" required>{{ old('content', $lesson->content) }}</textarea>
        </div>

        <!-- Course selection -->
        <div class="form-group mt-3">
            <label for="course_id">Course</label>
            <select class="form-control" id="course_id" name="course_id" required>
                <option value="" disabled>Select a course</option>
                @foreach($courses as $course)
                    <option value="{{ $course->id }}" {{ old('course_id', $lesson->course_id) == $course->id ? 'selected' : '' }}>
                        {{ $course->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Section selection (optional) -->
        <div class="form-group mt-3" id="section-container" style="display: none;">
            <label for="section_id">Section (Optional)</label>
            <select class="form-control" id="section_id" name="section_id">
                <option value="">No section</option>
                @foreach($sections as $section)
                    <option value="{{ $section->id }}" {{ old('section_id', $lesson->section_id) == $section->id ? 'selected' : '' }}>
                        {{ $section->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Module selection (optional) -->
        <div class="form-group mt-3" id="module-container" style="display: none;">
            <label for="module_id">Module (Optional)</label>
            <select class="form-control" id="module_id" name="module_id">
                <option value="">No module</option>
                @foreach($modules as $module)
                    <option value="{{ $module->id }}" {{ old('module_id', $lesson->module_id) == $module->id ? 'selected' : '' }}>
                        {{ $module->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Level input -->
        <div class="form-group mt-3">
            <label for="level">Level</label>
            <input type="number" class="form-control" id="level" name="level" value="{{ old('level', $lesson->level) }}" required>
        </div>

        <!-- Submit button -->
        <button type="submit" class="btn btn-primary mt-3">Update Lesson</button>
    </form>
</div>

<!-- Store data in data attributes -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Fetch sections and modules from the data attributes
        var sections = JSON.parse(document.getElementById('data-sections').getAttribute('data-sections'));
        var modules = JSON.parse(document.getElementById('data-modules').getAttribute('data-modules'));

        var courseSelect = document.getElementById('course_id');
        var sectionSelect = document.getElementById('section_id');
        var moduleSelect = document.getElementById('module_id');
        var sectionContainer = document.getElementById('section-container');
        var moduleContainer = document.getElementById('module-container');

        courseSelect.addEventListener('change', function() {
            var selectedCourseId = parseInt(courseSelect.value);

            // Clear previous options
            sectionSelect.innerHTML = '<option value="">No section</option>';
            moduleSelect.innerHTML = '<option value="">No module</option>';

            var hasSections = false;
            var hasModules = false;

            // Populate sections
            sections.forEach(function(section) {
                if (section.course_id === selectedCourseId) {
                    sectionSelect.innerHTML += `<option value="${section.id}">${section.name}</option>`;
                    hasSections = true;
                }
            });

            // Populate modules
            modules.forEach(function(module) {
                if (module.course_id === selectedCourseId) {
                    moduleSelect.innerHTML += `<option value="${module.id}">${module.name}</option>`;
                    hasModules = true;
                }
            });

            // Show or hide section and module selects based on availability
            sectionContainer.style.display = hasSections ? 'block' : 'none';
            moduleContainer.style.display = hasModules ? 'block' : 'none';

            // Show or hide section select based on modules availability
            sectionSelect.style.display = hasModules ? 'block' : 'none';
        });

        // Add event listener for section selection
        sectionSelect.addEventListener('change', function() {
            var selectedSectionId = parseInt(sectionSelect.value);

            // Clear previous module options
            moduleSelect.innerHTML = '<option value="">No module</option>';

            var hasModules = false;

            // Populate modules based on selected section
            modules.forEach(function(module) {
                if (module.section_id === selectedSectionId) {
                    moduleSelect.innerHTML += `<option value="${module.id}">${module.name}</option>`;
                    hasModules = true;
                }
            });

            // Show or hide module select based on availability
            moduleContainer.style.display = hasModules ? 'block' : 'none';
        });

        // Trigger change event on page load to populate section and module selects for the default selected course
        if (courseSelect.value) {
            courseSelect.dispatchEvent(new Event('change'));
        }
    });
</script>

<!-- Data as JSON in hidden elements -->
<div id="data-sections" data-sections='@json($sections)' style="display: none;"></div>
<div id="data-modules" data-modules='@json($modules)' style="display: none;"></div>

@endsection
