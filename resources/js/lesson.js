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
                <label for="video_title_${videoIndex}">Video Title</label>
                <input type="text" class="form-control" id="video_title_${videoIndex}" name="videos[${videoIndex}][title]">
            </div>
            <div class="form-group mt-3">
                <label for="video_url_${videoIndex}">Video URL</label>
                <input type="url" class="form-control" id="video_url_${videoIndex}" name="videos[${videoIndex}][url]">
            </div>
            <div class="form-group mt-3">
                <label for="video_description_${videoIndex}">Video Description</label>
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
