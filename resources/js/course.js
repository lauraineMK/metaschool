/* Common script for course creation and edition forms */
document.addEventListener('DOMContentLoaded', function() {
    // Initialize counters for sections and modules
    let sectionCount = window.sectionCount || 0;
    let moduleCount = window.moduleCount || 0;

    // Function to toggle the visibility of section-related elements
    function toggleSections() {
        let includeSections = document.getElementById('include_sections');
        if (includeSections) {
            let includeSectionsChecked = includeSections.checked;
            // Show or hide section container and add section button based on checkbox state
            document.getElementById('section-container').style.display = includeSectionsChecked ? 'block' : 'none';
            document.getElementById('add-section-btn').style.display = includeSectionsChecked ? 'inline-block' : 'none';
        }
    }

    // Set up event listener for the checkbox to toggle sections
    let includeSectionsElement = document.getElementById('include_sections');
    if (includeSectionsElement) {
        includeSectionsElement.addEventListener('change', toggleSections);
    }

    // Set up event listener for the "Add Section" button
    let addSectionBtn = document.getElementById('add-section-btn');
    if (addSectionBtn) {
        addSectionBtn.addEventListener('click', function() {
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
    }

    // Set up event listener for the "Add Module" button in the general container
    let addModuleBtn = document.getElementById('add-module-btn');
    if (addModuleBtn) {
        addModuleBtn.addEventListener('click', function() {
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
    }

    // Event delegation for dynamically added elements
    document.addEventListener('click', function(event) {
        // Remove module when "Remove Module" button is clicked
        if (event.target && event.target.classList.contains('remove-module-btn')) {
            if (confirm('Are you sure you want to remove this module?')) {
                let moduleGroup = event.target.closest('.module-group');
                if (moduleGroup) {
                    moduleGroup.remove();
                }
            }
        }

        // Remove section when "Remove Section" button is clicked
        if (event.target && event.target.classList.contains('remove-section-btn')) {
            if (confirm('Are you sure you want to remove this section?')) {
                let sectionGroup = event.target.closest('.section-group');
                if (sectionGroup) {
                    sectionGroup.remove();
                }
            }
        }

        // Add a new module to a specific section when "Add Module" button is clicked
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
