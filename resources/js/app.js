import './bootstrap';
import '../css/app.css';

/* Common script for course creation and edition forms */
document.addEventListener('DOMContentLoaded', function() {
    let sectionCount = window.sectionCount || 0;
    let moduleCount = window.moduleCount || 0;

    function toggleSections() {
        let includeSections = document.getElementById('include_sections').checked;
        document.getElementById('section-container').style.display = includeSections ? 'block' : 'none';
        document.getElementById('add-section-btn').style.display = includeSections ? 'inline-block' : 'none';
    }

    document.getElementById('include_sections').addEventListener('change', toggleSections);

    document.getElementById('add-section-btn').addEventListener('click', function() {
        let sectionIndex = sectionCount++;
        let sectionContainer = document.getElementById('section-container');
        let newSection = document.createElement('div');
        newSection.classList.add('form-section', 'section-group');
        newSection.innerHTML = `
            <h2>Section Details</h2>
            <div class="form-group">
                <label for="sections[${sectionIndex}][name]">Section Name:</label>
                <input type="text" id="sections_${sectionIndex}_name" name="sections[${sectionIndex}][name]" class="form-control">
            </div>
            <div class="form-group">
                <label for="sections[${sectionIndex}][description]">Section Description:</label>
                <textarea id="sections_${sectionIndex}_description" name="sections[${sectionIndex}][description]" class="form-control"></textarea>
            </div>
            <div class="form-group">
                <label for="sections[${sectionIndex}][level]">Section Level:</label>
                <input type="number" id="sections_${sectionIndex}_level" name="sections[${sectionIndex}][level]" class="form-control">
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

    document.getElementById('add-module-btn').addEventListener('click', function() {
        let moduleIndex = moduleCount++;
        let moduleContainer = document.getElementById('module-container');
        let newModule = document.createElement('div');
        newModule.classList.add('form-section', 'module-group');
        newModule.innerHTML = `
            <h2>Module Details</h2>
            <div class="form-group">
                <label for="modules[${moduleIndex}][name]">Module Name:</label>
                <input type="text" id="modules_${moduleIndex}_name" name="modules[${moduleIndex}][name]" class="form-control">
            </div>
            <div class="form-group">
                <label for="modules[${moduleIndex}][description]">Module Description:</label>
                <textarea id="modules_${moduleIndex}_description" name="modules[${moduleIndex}][description]" class="form-control"></textarea>
            </div>
            <div class="form-group">
                <label for="modules[${moduleIndex}][level]">Module Level:</label>
                <input type="number" id="modules_${moduleIndex}_level" name="modules[${moduleIndex}][level]" class="form-control">
            </div>
            <button type="button" class="btn btn-danger remove-module-btn">Remove Module</button>
        `;
        moduleContainer.appendChild(newModule);
    });

    document.addEventListener('click', function(event) {
        if (event.target && event.target.classList.contains('remove-module-btn')) {
            if (confirm('Are you sure you want to remove this module?')) {
                event.target.closest('.module-group').remove();
            }
        }

        if (event.target && event.target.classList.contains('remove-section-btn')) {
            if (confirm('Are you sure you want to remove this section?')) {
                event.target.closest('.section-group').remove();
            }
        }

        if (event.target && event.target.classList.contains('add-module-btn')) {
            let sectionGroup = event.target.closest('.section-group');
            let moduleContainer = sectionGroup.querySelector('.module-container');
            let sectionIndex = Array.from(sectionGroup.parentNode.children).indexOf(sectionGroup);
            let moduleIndex = moduleContainer.querySelectorAll('.module-group').length;
            let newModule = document.createElement('div');
            newModule.classList.add('form-section', 'module-group');
            newModule.innerHTML = `
                <h2>Module Details</h2>
                <div class="form-group">
                    <label for="sections[${sectionIndex}][modules][${moduleIndex}][name]">Module Name:</label>
                    <input type="text" id="sections_${sectionIndex}_modules_${moduleIndex}_name" name="sections[${sectionIndex}][modules][${moduleIndex}][name]" class="form-control">
                </div>
                <div class="form-group">
                    <label for="sections[${sectionIndex}][modules][${moduleIndex}][description]">Module Description:</label>
                    <textarea id="sections_${sectionIndex}_modules_${moduleIndex}_description" name="sections[${sectionIndex}][modules][${moduleIndex}][description]" class="form-control"></textarea>
                </div>
                <div class="form-group">
                    <label for="sections[${sectionIndex}][modules][${moduleIndex}][level]">Module Level:</label>
                    <input type="number" id="sections_${sectionIndex}_modules_${moduleIndex}_level" name="sections[${sectionIndex}][modules][${moduleIndex}][level]" class="form-control">
                </div>
                <button type="button" class="btn btn-danger remove-module-btn">Remove Module</button>
            `;
            moduleContainer.appendChild(newModule);
        }
    });

    // Initialize visibility based on the current state
    toggleSections();
});

/* Common script for lesson creation and edition forms */

document.addEventListener('DOMContentLoaded', function() {
    // Fetch sections and modules from the data attributes
    var sections = JSON.parse(document.getElementById('data-sections').getAttribute('data-sections'));
    var modules = JSON.parse(document.getElementById('data-modules').getAttribute('data-modules'));

    var courseSelect = document.getElementById('course_id');
    var sectionSelect = document.getElementById('section_id');
    var moduleSelect = document.getElementById('module_id');
    var sectionContainer = document.getElementById('section-container');
    var moduleContainer = document.getElementById('module-container');

    // Function to populate sections and modules based on selected course and section
    function populateSectionsAndModules() {
        var selectedCourseId = parseInt(courseSelect.value);
        var selectedSectionId = parseInt(sectionSelect.dataset.selected) || null;
        var selectedModuleId = parseInt(moduleSelect.dataset.selected) || null;

        // Clear previous options
        sectionSelect.innerHTML = '<option value="" selected>No section</option>';
        moduleSelect.innerHTML = '<option value="" selected>No module</option>';

        var hasSections = false;
        var hasModules = false;

        // Populate sections based on the selected course
        sections.forEach(function(section) {
            if (section.course_id === selectedCourseId) {
                var selected = section.id === selectedSectionId ? 'selected' : '';
                sectionSelect.innerHTML += `<option value="${section.id}" ${selected}>${section.name}</option>`;
                hasSections = true;
            }
        });

        // Populate modules based on the selected course
        modules.forEach(function(module) {
            if (module.course_id === selectedCourseId) {
                var selected = module.id === selectedModuleId ? 'selected' : '';
                moduleSelect.innerHTML += `<option value="${module.id}" ${selected}>${module.name}</option>`;
                hasModules = true;
            }
        });

        // Show or hide section and module selects based on availability
        sectionContainer.style.display = hasSections ? 'block' : 'none';
        moduleContainer.style.display = hasModules ? 'block' : 'none';

        // Trigger change event for section to update module options
        if (sectionSelect.value) {
            sectionSelect.dispatchEvent(new Event('change'));
        }
    }

    // Event listener for course selection
    courseSelect.addEventListener('change', function() {
        populateSectionsAndModules();
    });

    // Event listener for section selection
    sectionSelect.addEventListener('change', function() {
        var selectedSectionId = parseInt(sectionSelect.value);

        // Clear previous module options
        moduleSelect.innerHTML = '<option value="" selected>No module</option>';

        var hasModules = false;

        // Populate modules based on selected section
        modules.forEach(function(module) {
            if (module.section_id === selectedSectionId) {
                var selected = module.id === parseInt(moduleSelect.dataset.selected) ? 'selected' : '';
                moduleSelect.innerHTML += `<option value="${module.id}" ${selected}>${module.name}</option>`;
                hasModules = true;
            }
        });

        // Show or hide module select based on availability
        moduleContainer.style.display = hasModules ? 'block' : 'none';
    });

    // Initialize select elements with selected values on page load
    function initializeSelections() {
        // Set data attributes for selected values
        sectionSelect.dataset.selected = parseInt(sectionSelect.value) || null;
        moduleSelect.dataset.selected = parseInt(moduleSelect.value) || null;

        // Trigger change event to populate options
        if (courseSelect.value) {
            populateSectionsAndModules();
        }
    }

    initializeSelections();

    // Dynamic video addition script
    let videoIndex = document.querySelectorAll('.video-group').length; // Start indexing from the count of existing videos

    document.getElementById('add-video-button').addEventListener('click', function () {
        const videoSection = document.getElementById('video-section');
        const newVideoGroup = document.createElement('div');
        newVideoGroup.className = 'video-group mt-3';
        newVideoGroup.id = 'video-group-' + videoIndex;

        newVideoGroup.innerHTML = `
            <div class="form-group mt-3">
                <label for="video_title_${videoIndex}">Video Title (Optional)</label>
                <input type="text" class="form-control" id="video_title_${videoIndex}" name="videos[${videoIndex}][title]">
            </div>
            <div class="form-group mt-3">
                <label for="video_url_${videoIndex}">Video URL (Optional)</label>
                <input type="url" class="form-control" id="video_url_${videoIndex}" name="videos[${videoIndex}][url]">
            </div>
            <div class="form-group mt-3">
                <label for="video_description_${videoIndex}">Video Description (Optional)</label>
                <textarea class="form-control" id="video_description_${videoIndex}" name="videos[${videoIndex}][description]" rows="3"></textarea>
            </div>
            <button type="button" class="btn btn-danger cancel-video-button" data-index="${videoIndex}">Cancel</button>
        `;

        videoSection.appendChild(newVideoGroup);

        videoIndex++;
    });

    // Delegate cancel button functionality
    document.getElementById('video-section').addEventListener('click', function (event) {
        if (event.target && event.target.classList.contains('cancel-video-button')) {
            const index = event.target.getAttribute('data-index');
            const videoGroup = document.getElementById('video-group-' + index);
            if (videoGroup) {
                videoGroup.remove();
            }
        }
    });
});
