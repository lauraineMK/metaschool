/* Common script for course creation and edition forms */
document.addEventListener('DOMContentLoaded', function () {

    // Determine if we are in creation or editing mode
    const isEditMode = document.body.classList.contains('edit-mode');
    const isCreateMode = document.body.classList.contains('create-mode');

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

    // Initialize counters for sections and modules using the greater value between data-count and actual elements count
    let sectionCount = Math.max(
        parseInt(document.getElementById('section-container').getAttribute('data-count') || 0),
        document.querySelectorAll('.section-group').length
    );

    // Count for standalone modules
    let moduleCount = Math.max(
        parseInt(document.getElementById('module-container').getAttribute('data-count') || 0),
        document.querySelectorAll('.module-group').length // Select standalone modules
    );

    // Count for section modules
    // let sectionModuleCount = Math.max(
    //     parseInt(document.getElementById('module-container').getAttribute('data-count') || 0),
    //     document.querySelectorAll('.module-group').length // Select section modules
    // );

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
                <h2>${translations.sectionDetails}</h2>
                <div class="form-group">
                    <label for="sections_${sectionIndex}_name">${translations.sectionName}</label>
                    <input type="text" id="sections_${sectionIndex}_name" name="sections[${sectionIndex}][name]" class="form-control">
                </div>
                <div class="form-group">
                    <label for="sections_${sectionIndex}_description">${translations.sectionDescription}</label>
                    <textarea id="sections_${sectionIndex}_description" name="sections[${sectionIndex}][description]" class="form-control"></textarea>
                </div>
                <div class="form-group">
                    <label for="sections_${sectionIndex}_level">${translations.sectionLevel}</label>
                    <input type="number" id="sections_${sectionIndex}_level" name="sections[${sectionIndex}][level]" class="form-control">
                </div>
                <div class="d-flex justify-content-between">
                    <button type="button" class="btn btn-secondary add-module-btn desktop-only">${translations.addModule}</button>
                    <button type="button" class="btn btn-secondary add-module-btn mobile-only">
                        <i class="fas fa-plus"></i>
                    </button>
                    <button type="button" class="btn btn-danger cancel-section-btn desktop-only" data-index="${sectionIndex}">${translations.cancel}</button>
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
                <h2>${translations.moduleDetails}</h2>
                <div class="form-group">
                    <label for="modules_${moduleIndex}_name">${translations.moduleName}</label>
                    <input type="text" id="modules_${moduleIndex}_name" name="modules[${moduleIndex}][name]" class="form-control">
                </div>
                <div class="form-group">
                    <label for="modules_${moduleIndex}_description">${translations.moduleDescription}</label>
                    <textarea id="modules_${moduleIndex}_description" name="modules[${moduleIndex}][description]" class="form-control"></textarea>
                </div>
                <div class="form-group">
                    <label for="modules_${moduleIndex}_level">${translations.moduleLevel}</label>
                    <input type="number" id="modules_${moduleIndex}_level" name="modules[${moduleIndex}][level]" class="form-control">
                </div>
                <button type="button" class="btn btn-danger cancel-module-btn desktop-only" data-index="${moduleIndex}" data-context="independent">${translations.cancel}</button>
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
            let sectionIndex = event.target.getAttribute('data-index');
            let moduleIndex = event.target.getAttribute('data-index');
            let moduleGroup = document.querySelector(
                `#module-group-${moduleIndex}, #section-${sectionIndex}-module-group-${moduleIndex}`
            );
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

                    const deleteCourseSession = async (sessionId) => {
                        try {
                            const response = await fetch(`/section/${sessionId}`, {
                                method: 'DELETE',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                                }
                            });

                            if (response.ok) {
                                // The request was successful, you can process the response here
                                console.log('Session successfully deleted.');
                            } else {
                                console.error('Session deletion error.');
                            }
                        } catch (error) {
                            console.error('An error has occurred :', error);
                        }
                    };


                    const sectionId = event.target.getAttribute('data-section-id');

                    if (sectionId) {
                        // Example of function call
                        deleteCourseSession(sectionId);
                    } else {
                        console.error('Section ID not found');
                    }

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

                    const deleteModule = async (moduleId) => {
                        try {
                            const response = await fetch(`/module/${moduleId}`, {
                                method: 'DELETE',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                                }
                            });

                            if (response.ok) {
                                console.log('Module successfully deleted.');
                                // Here you can add actions such as updating the UI
                            } else {
                                console.error('Module deletion error.');
                            }
                        } catch (error) {
                            console.error('An error has occurred :', error);
                        }
                    };

                    const moduleId = event.target.getAttribute('data-module-id');

                    if (moduleId) {
                        // Example of function call
                        deleteModule(moduleId);
                    } else {
                        console.error('Module ID not found');
                    }
                }
            }
        }

        // Add a new module to a specific section when "Add Module" button is clicked
        if (event.target && event.target.classList.contains('add-module-btn')) {
            let sectionGroup = event.target.closest('.section-group');
            let moduleContainer = sectionGroup.querySelector('.module-container');
            let sectionIndex = Array.from(sectionGroup.parentNode.children).indexOf(sectionGroup);

            // Set moduleIndex based on existing modules in the specific section
            let moduleIndex = moduleContainer.querySelectorAll('.module-group').length;

            // Module creation
            let newModule = document.createElement('div');
            newModule.classList.add('form-section', 'module-group');
            newModule.id = `section-${sectionIndex}-module-group-${moduleIndex}`; // Updated ID for uniqueness
            newModule.innerHTML = `
                <h2>${translations.moduleDetails}</h2>
                <div class="form-group">
                    <label for="sections_${sectionIndex}_modules_${moduleIndex}_name">${translations.moduleName}</label>
                    <input type="text" id="sections_${sectionIndex}_modules_${moduleIndex}_name" name="sections[${sectionIndex}][modules][${moduleIndex}][name]" class="form-control">
                </div>
                <div class="form-group">
                    <label for="sections_${sectionIndex}_modules_${moduleIndex}_description">${translations.moduleDescription}</label>
                    <textarea id="sections_${sectionIndex}_modules_${moduleIndex}_description" name="sections[${sectionIndex}][modules][${moduleIndex}][description]" class="form-control"></textarea>
                </div>
                <div class="form-group">
                    <label for="sections_${sectionIndex}_modules_${moduleIndex}_level">${translations.moduleLevel}</label>
                    <input type="number" id="sections_${sectionIndex}_modules_${moduleIndex}_level" name="sections[${sectionIndex}][modules][${moduleIndex}][level]" class="form-control">
                </div>
                <button type="button" class="btn btn-danger cancel-module-btn  desktop-only" data-index="${moduleIndex}" data-context="section">${translations.cancel}</button>
                <button type="button" class="btn btn-danger cancel-module-btn mobile-only" data-index="${moduleIndex}" data-context="section">
                    <i class="fas fa-arrow-left"></i>
                </button>
            `;
            moduleContainer.appendChild(newModule);

            // Reapply classes after adding new module
            applyClassesToModules();
        }
    });

    // Initialize visibility based on the current state
    toggleSections();
});
