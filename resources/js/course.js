/* Common script for course creation and edition forms */
document.addEventListener('DOMContentLoaded', function () {

    // Determine if we are in creation or editing mode
    const isEditMode = document.body.classList.contains('edit-mode');
    const isCreateMode = document.body.classList.contains('create-mode');

    console.log("Edit mode:", isEditMode);
    console.log("Create mode:", isCreateMode);

    function applyClassesToModules() {
        if (isEditMode || isCreateMode) {
            document.querySelectorAll('.module-group').forEach(el => {
                if (isEditMode) {
                    el.classList.add('edit-module-group');
                    el.classList.remove('create-module-group');
                } else if (isCreateMode) {
                    el.classList.add('create-module-group');
                    el.classList.remove('edit-module-group');
                }
            });
        }
    }

    // Initial class application
    applyClassesToModules();

    // Initialize counters for sections and modules
    let sectionCount = parseInt(document.getElementById('section-container').getAttribute('data-count') || 0);
    let moduleCount = parseInt(document.getElementById('module-container').getAttribute('data-count') || 0);

    // Function to toggle the visibility of section-related elements
    function toggleSections() {
        let includeSections = document.getElementById('include_sections');
        let addSectionButton = document.getElementById('add-section-btn');
        let addModuleButton = document.getElementById('add-module-btn');
        let sectionContainer = document.getElementById('section-container');

        if (includeSections && addSectionButton && addModuleButton) {
            if (includeSections.checked) {
                addSectionButton.style.display = 'block';  // Show the Add Section button
                addModuleButton.style.display = 'none';    // Hide the Add Module button
                sectionContainer.style.display = 'block';  // Show the section container
            } else {
                addSectionButton.style.display = 'none';   // Hide the Add Section button
                addModuleButton.style.display = 'block';   // Show the Add Module button
                sectionContainer.style.display = 'none';   // Hide the section container
            }
        }
    }

    // Toggle sections visibility
    let includeSectionsElement = document.getElementById('include_sections');
    if (includeSectionsElement) {
        includeSectionsElement.addEventListener('change', toggleSections);
    }

    toggleSections();

    // Add Section button
    let addSectionBtn = document.getElementById('add-section-btn');
    if (addSectionBtn) {
        addSectionBtn.addEventListener('click', function () {
            let sectionIndex = sectionCount++;
            let sectionContainer = document.getElementById('section-container');
            let newSection = document.createElement('div');
            newSection.classList.add('form-section', 'section-group');
            newSection.id = `section-group-${sectionIndex}`;
            newSection.innerHTML = `
                <h2>Section Details</h2>
                <div class="form-group">
                    <label for="sections_${sectionIndex}_name">Section Name:</label>
                    <input type="text" id="sections_${sectionIndex}_name" name="sections[${sectionIndex}][name]" class="form-control">
                </div>
                <div class="form-group">
                    <label for="sections_${sectionIndex}_description">Section Description:</label>
                    <textarea id="sections_${sectionIndex}_description" name="sections[${sectionIndex}][description]" class="form-control"></textarea>
                </div>
                <div class="form-group">
                    <label for="sections_${sectionIndex}_level">Section Level:</label>
                    <input type="number" id="sections_${sectionIndex}_level" name="sections[${sectionIndex}][level]" class="form-control">
                </div>
                <div class="d-flex justify-content-between">
                    <button type="button" class="btn btn-secondary add-module-btn desktop-only">Add Module</button>
                    <button type="button" class="btn btn-secondary add-module-btn mobile-only">
                        <i class="fas fa-plus"></i>
                    </button>
                    <button type="button" class="btn btn-danger cancel-section-btn desktop-only" data-index="${sectionIndex}">Cancel</button>
                    <button type="button" class="btn btn-danger cancel-section-btn mobile-only" data-index="${sectionIndex}">
                        <i class="fas fa-arrow-left"></i>
                    </button>
                </div>
                <div class="module-container">
                    <!-- Modules will be added here -->
                </div>
            `;
            sectionContainer.appendChild(newSection);
        });
    }

    // Add Module button in the general container
    let addModuleBtn = document.getElementById('add-module-btn');
    if (addModuleBtn) {
        addModuleBtn.addEventListener('click', function () {
            console.log('Add Module button clicked');
            let moduleIndex = moduleCount++;
            let moduleContainer = document.getElementById('module-container');

            // Ensure the module container is visible
            if (moduleContainer.classList.contains('hidden')) {
                moduleContainer.classList.remove('hidden');
                moduleContainer.classList.add('visible');
            }

            let newModule = document.createElement('div');
            newModule.classList.add('form-section', 'module-group');
            newModule.id = `module-group-${moduleIndex}`;
            newModule.innerHTML = `
                <h2>Module Details</h2>
                <div class="form-group">
                    <label for="modules_${moduleIndex}_name">Module Name:</label>
                    <input type="text" id="modules_${moduleIndex}_name" name="modules[${moduleIndex}][name]" class="form-control">
                </div>
                <div class="form-group">
                    <label for="modules_${moduleIndex}_description">Module Description:</label>
                    <textarea id="modules_${moduleIndex}_description" name="modules[${moduleIndex}][description]" class="form-control"></textarea>
                </div>
                <div class="form-group">
                    <label for="modules_${moduleIndex}_level">Module Level:</label>
                    <input type="number" id="modules_${moduleIndex}_level" name="modules[${moduleIndex}][level]" class="form-control">
                </div>
                <button type="button" class="btn btn-danger cancel-module-btn desktop-only" data-index="${moduleIndex}" data-context="independent">Cancel</button>
                <button type="button" class="btn btn-danger cancel-module-btn mobile-only" data-index="${moduleIndex}" data-context="independent">
                    <i class="fas fa-arrow-left"></i>
                </button>
            `;
            moduleContainer.appendChild(newModule);

            // Reapply classes after adding new module
            applyClassesToModules();
        });
    }

    // Event delegation for dynamically added elements
    document.addEventListener('click', function (event) {
        // Handle cancel button for sections
        if (event.target && event.target.classList.contains('cancel-section-btn')) {
            let sectionIndex = event.target.getAttribute('data-index');
            let sectionGroup = document.querySelector(`#section-group-${sectionIndex}`);
            if (sectionGroup) {
                sectionGroup.remove();
            }
        }

        // Handle cancel button for modules
        if (event.target && event.target.classList.contains('cancel-module-btn')) {
            let moduleIndex = event.target.getAttribute('data-index');
            let moduleGroup = document.querySelector(`#module-group-${moduleIndex}`);
            if (moduleGroup) {
                moduleGroup.remove();
            }
        }

        // Remove section when "Remove Section" button is clicked
        if (event.target && event.target.classList.contains('remove-section-btn')) {
            if (confirm('Are you sure you want to remove this section?')) {
                let sectionGroup = event.target.closest('.section-group');
                if (sectionGroup) {
                    // Mark the section for deletion
                    let deleteInput = sectionGroup.querySelector('input[name$="[delete]"]');
                    if (deleteInput) {
                        deleteInput.value = '1'; // Mark as deleted
                    }
                    sectionGroup.remove();
                }
            }
        }

        // Remove module when "Remove Module" button is clicked
        if (event.target && event.target.classList.contains('remove-module-btn')) {
            if (confirm('Are you sure you want to remove this module?')) {
                let moduleGroup = event.target.closest('.module-group');
                if (moduleGroup) {
                    // Mark the module for deletion
                    let deleteInput = moduleGroup.querySelector('input[name$="[delete]"]');
                    if (deleteInput) {
                        deleteInput.value = '1'; // Mark as deleted
                    }
                    moduleGroup.remove();
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
            newModule.id = `module-group-${moduleIndex}`;
            newModule.innerHTML = `
                <h2>Module Details</h2>
                <div class="form-group">
                    <label for="sections_${sectionIndex}_modules_${moduleIndex}_name">Module Name:</label>
                    <input type="text" id="sections_${sectionIndex}_modules_${moduleIndex}_name" name="sections[${sectionIndex}][modules][${moduleIndex}][name]" class="form-control">
                </div>
                <div class="form-group">
                    <label for="sections_${sectionIndex}_modules_${moduleIndex}_description">Module Description:</label>
                    <textarea id="sections_${sectionIndex}_modules_${moduleIndex}_description" name="sections[${sectionIndex}][modules][${moduleIndex}][description]" class="form-control"></textarea>
                </div>
                <div class="form-group">
                    <label for="sections_${sectionIndex}_modules_${moduleIndex}_level">Module Level:</label>
                    <input type="number" id="sections_${sectionIndex}_modules_${moduleIndex}_level" name="sections[${sectionIndex}][modules][${moduleIndex}][level]" class="form-control">
                </div>
                <button type="button" class="btn btn-danger cancel-module-btn  desktop-only" data-index="${moduleIndex}" data-context="section">Cancel</button>
                <button type="button" class="btn btn-danger cancel-module-btn mobile-only" data-index="${moduleIndex}" data-context="section">
                    <i class="fas fa-arrow-left"></i>
                </button>
            `;
            moduleContainer.appendChild(newModule);

            // Reapply classes after adding new module
            applyClassesToModules();
        }
    });

    /* Script for the “lesson viewed” button */
    // Code for course view

    // Initialize visibility based on the current state
    toggleSections();
});
