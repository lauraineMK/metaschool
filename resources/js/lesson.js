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

    // Start indexing from the count of existing videos
    let videoIndex = document.querySelectorAll('.video-group').length;

    // Add "Remove Video" buttons for existing videos in edit mode
    function addRemoveButtonsForEditing() {
        document.querySelectorAll('.video-group').forEach(function(videoGroup, index) {
            if (index > 0 && !videoGroup.querySelector('.remove-video-button')) { // Exclude the first video
                const removeButton = document.createElement('button');
                removeButton.type = 'button';
                removeButton.className = 'btn btn-danger remove-video-button mt-3';
                removeButton.textContent = 'Remove Video';
                removeButton.setAttribute('data-index', index); // Add index to button

                videoGroup.appendChild(removeButton);
            }
        });
    }

    const videoSection = document.getElementById('video-section');
    const isEditMode = videoSection.dataset.editMode === 'true';

    if (isEditMode) {
        addRemoveButtonsForEditing();
    }

    // Dynamic video addition script
    document.getElementById('add-video-button').addEventListener('click', function () {
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
            <button type="button" class="btn btn-danger cancel-video-button mt-3" data-index="${videoIndex}">Cancel</button>
        `;

        videoSection.appendChild(newVideoGroup);
        videoIndex++;
    });

    // Function to clear fields for a specific video group
    function clearVideoGroupFields(index) {
        const videoGroup = document.getElementById('video-group-' + index);
        if (videoGroup) {
            const titleInput = videoGroup.querySelector('input[name="videos[' + index + '][title]"]');
            const urlInput = videoGroup.querySelector('input[name="videos[' + index + '][url]"]');
            const descriptionTextarea = videoGroup.querySelector('textarea[name="videos[' + index + '][description]"]');

            if (titleInput) titleInput.value = '';
            if (urlInput) urlInput.value = '';
            if (descriptionTextarea) descriptionTextarea.value = '';
        }
    }

    // Delegate clear button functionality
    document.getElementById('video-section').addEventListener('click', function(event) {
        if (event.target && event.target.classList.contains('clear-video-button')) {
            const index = event.target.getAttribute('data-index');
            clearVideoGroupFields(index);
        }
    });

    // Delegate cancel button functionality for dynamically added videos
    videoSection.addEventListener('click', function(event) {
        if (event.target && event.target.classList.contains('cancel-video-button')) {
            const index = event.target.getAttribute('data-index');
            const videoGroup = document.getElementById('video-group-' + index);
            if (videoGroup) {
                videoGroup.remove();
            }
        }
    });

    // Delegate remove video button functionality
    videoSection.addEventListener('click', function(event) {
        if (event.target && event.target.classList.contains('remove-video-button')) {
            const index = event.target.getAttribute('data-index');
            const videoGroup = document.getElementById('video-group-' + index);

            if (videoGroup) {
                // Mark the video for deletion
                const deleteInput = videoGroup.querySelector('input[name="videos[' + index + '][_delete]"]');
                if (deleteInput) {
                    deleteInput.value = '1'; // Mark as deleted
                }

                // Remove the video group from the DOM
                videoGroup.remove();
            }
        }
    });
});
