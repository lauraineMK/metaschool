@extends('layouts.app')

@section('title', 'Create Course')

@section('content')
<div class="container">
    <h1>Create a New Course</h1>

    <!-- Form to create a new course -->
    <form action="{{ route('teacher.courses.store') }}" method="POST">
        @csrf

        <!-- Course Details -->
        <div class="form-section">
            <h2>Course Details</h2>

            <div class="form-group">
                <label for="course_title">Course Name:</label>
                <input type="text" id="course_title" name="title" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="course_description">Course Description:</label>
                <textarea id="course_description" name="description" class="form-control"></textarea>
            </div>

            <div class="form-group">
                <label for="course_price">Course Price:</label>
                <input type="number" id="course_price" name="price" class="form-control">
            </div>

            <div class="form-group">
                <label for="course_creation_date">Creation Date:</label>
                <input type="date" id="course_creation_date" name="creation_date" class="form-control">
            </div>

            <input type="hidden" name="author_id" value="{{ auth()->user()->id }}">
        </div>

        <!-- Toggle to show/hide sections and modules -->
        <div class="form-group">
            <label for="include_sections">
                <input type="checkbox" id="include_sections" name="include_sections"> Include Sections and Modules
            </label>
        </div>

        <!-- Section Details -->
        <div id="section-container" style="display: none;">
            <!-- Sections will be added here -->
        </div>

        <!-- Module Details -->
        <div id="module-container">
            <!-- Standalone Modules will be added here -->
        </div>

        <div class="d-flex justify-content-between mt-3">
            <button type="button" class="btn btn-secondary" id="add-section-btn" style="display: none;">Add Section</button>
            <button type="button" class="btn btn-secondary" id="add-module-btn">Add Module</button>
            <button type="submit" class="btn btn-primary">Create Course</button>
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
        display: inline-block; /* Align modules horizontally */
        vertical-align: top; /* Aligns module to the top */
        width: calc(33.333% - 20px); /* Adjust width and margin to fit 3 per row */
    }

    .form-group {
        margin-bottom: 15px;
    }

    .form-group label {
        display: block;
        margin-bottom: 5px;
    }

    .form-group input,
    .form-group textarea {
        width: 100%;
    }

    .btn-secondary {
        margin-right: 10px;
    }

    .remove-section-btn,
    .remove-module-btn {
        background-color: #dc3545;
        color: #fff;
        border-color: #dc3545;
        margin-top: 10px;
    }

    .remove-section-btn:hover,
    .remove-module-btn:hover {
        background-color: #c82333;
        border-color: #bd2130;
    }

    .add-module-btn {
        margin-top: 10px;
    }

    .module-container {
        margin-top: 10px;
        overflow: hidden; /* Clearfix for floating modules */
    }

    .module-container .module-group {
        margin-bottom: 10px;
    }

    .d-flex {
        display: flex;
    }

    .justify-content-between {
        justify-content: space-between;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        let sectionCount = 0;
        let moduleCount = 0;

        function toggleSections() {
            let includeSections = document.getElementById('include_sections').checked;
            document.getElementById('section-container').style.display = includeSections ? 'block' : 'none';
            document.getElementById('add-section-btn').style.display = includeSections ? 'inline-block' : 'none';
        }

        document.getElementById('include_sections').addEventListener('change', toggleSections);

        document.getElementById('add-section-btn').addEventListener('click', function () {
            sectionCount++;
            let sectionContainer = document.getElementById('section-container');
            let newSection = document.createElement('div');
            newSection.classList.add('form-section', 'section-group');
            newSection.innerHTML = `
                <h2>Section Details</h2>
                <div class="form-group">
                    <label for="section_title_${sectionCount}">Section Name:</label>
                    <input type="text" id="section_title_${sectionCount}" name="section_title[]" class="form-control">
                </div>
                <div class="form-group">
                    <label for="section_description_${sectionCount}">Section Description:</label>
                    <textarea id="section_description_${sectionCount}" name="section_description[]" class="form-control"></textarea>
                </div>
                <div class="form-group">
                    <label for="section_level_${sectionCount}">Section Level:</label>
                    <input type="number" id="section_level_${sectionCount}" name="section_level[]" class="form-control">
                </div>
                <div class="d-flex justify-content-between">
                    <button type="button" class="btn btn-secondary add-module-btn">Add Module</button>
                    <button type="button" class="btn btn-danger remove-section-btn">Remove Section</button>
                </div>
                <div class="module-container">
                    <!-- Modules will be added here -->
                </div>
            `;
            sectionContainer.appendChild(newSection);
        });

        document.getElementById('add-module-btn').addEventListener('click', function () {
            moduleCount++;
            let moduleContainer = document.getElementById('module-container');
            let newModule = document.createElement('div');
            newModule.classList.add('form-section', 'module-group');
            newModule.innerHTML = `
                <h2>Module Details</h2>
                <div class="form-group">
                    <label for="module_title_${moduleCount}">Module Name:</label>
                    <input type="text" id="module_title_${moduleCount}" name="module_title[]" class="form-control">
                </div>
                <div class="form-group">
                    <label for="module_description_${moduleCount}">Module Description:</label>
                    <textarea id="module_description_${moduleCount}" name="module_description[]" class="form-control"></textarea>
                </div>
                <div class="form-group">
                    <label for="module_level_${moduleCount}">Module Level:</label>
                    <input type="number" id="module_level_${moduleCount}" name="module_level[]" class="form-control">
                </div>
                <button type="button" class="btn btn-danger remove-module-btn">Remove Module</button>
            `;
            moduleContainer.appendChild(newModule);
        });

        document.getElementById('section-container').addEventListener('click', function (event) {
            if (event.target && event.target.classList.contains('add-module-btn')) {
                let moduleContainer = event.target.closest('.section-group').querySelector('.module-container');
                let moduleCount = moduleContainer.querySelectorAll('.module-group').length + 1;
                let newModule = document.createElement('div');
                newModule.classList.add('form-section', 'module-group');
                newModule.innerHTML = `
                    <h2>Module Details</h2>
                    <div class="form-group">
                        <label for="module_title_${moduleCount}">Module Name:</label>
                        <input type="text" id="module_title_${moduleCount}" name="module_title[]" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="module_description_${moduleCount}">Module Description:</label>
                        <textarea id="module_description_${moduleCount}" name="module_description[]" class="form-control"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="module_level_${moduleCount}">Module Level:</label>
                        <input type="number" id="module_level_${moduleCount}" name="module_level[]" class="form-control">
                    </div>
                    <button type="button" class="btn btn-danger remove-module-btn">Remove Module</button>
                `;
                moduleContainer.appendChild(newModule);
            }
            if (event.target && event.target.classList.contains('remove-section-btn')) {
                if (confirm('Are you sure you want to remove this section?')) {
                    event.target.closest('.section-group').remove();
                }
            }
            if (event.target && event.target.classList.contains('remove-module-btn')) {
                if (confirm('Are you sure you want to remove this module?')) {
                    event.target.closest('.module-group').remove();
                }
            }
        });
    });
</script>
@endsection
