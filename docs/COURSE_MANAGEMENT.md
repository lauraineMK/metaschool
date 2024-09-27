# Contributing to the Project

Thank you for contributing to our project! To help streamline the process, please follow the guidelines below, especially when addressing issues related to code functionality and improvements.

## Problem Description

### Course Editing

#### Summary

The current implementation of the course editing functionality has the following issues:

- **Creation and Modification**: These functionalities work most of the time but might have edge cases that need attention.
- **Deletion**: This feature does not work as expected. Specifically, modules that belong to any section become independent when the section is deleted, rather than being deleted along with it.

#### Detailed Description

- **Issue**: When editing a course, if a section is deleted, the modules that were part of that section should also be deleted. However, currently, these modules become standalone and remain in the system.
- **Scope**:
  - Creation of new sections and modules
  - Modification of existing sections and modules
  - Deletion of sections and modules

#### Controller

An `update` method is implemented in the controller located at `app/Http/Controllers/Teacher/CourseController.php`, which is intended to handle the course logic.
The part of the code is commented in red, orange and blue for easier identification.

#### JavaScript

The script responsible for the dynamic content of the course is placed at the end of the following file:

`resources/js/course.js`

The script is designed for creating and updating courses. The creation of courses with sections and modules or with modules or on their own, is fully functional.

## Tasks

### 1. Work on Deletion

- **Objective**: Ensure that each section, each section module, and each standalone module can be deleted appropriately.
- **Details**:
  - Implement functionality to delete all modules associated with a section when the section is deleted.
  - Verify that no orphaned modules remain after the deletion of a section.

### 2. Verify Creation Functionality

- **Objective**: Ensure that the creation functionality still works correctly after multiple sections and modules have been added.
- **Details**:
  - Create multiple sections, each containing several modules.
  - Confirm that the creation process works smoothly and that all sections and modules are created as expected.

### 3. Verify Update Functionality

- **Objective**: Test the update functionality thoroughly to ensure all changes are reflected correctly.
- **Details**:
  - Create a new section and add a module to it.
  - Modify fields in both the section and the module.
  - Delete all modules within the section and then delete the section itself.
  - Delete another section with modules but without deleting the modules first.
  - Check that all modifications, deletions, and updates have been executed correctly.
  - Perform the same checks with a course containing standalone modules:
    - Create a new course with standalone modules.
    - Edit fields of some modules.
    - Delete some of the modules.

## How to Test

1. **Set up**:
   - Clone the repository and set up the development environment.
   - Ensure you have the necessary tools and dependencies installed.

2. **Create Sections and Modules**:
   - Follow the process to create multiple sections and modules, ensuring that the creation functionality is working correctly.

3. **Modify Sections and Modules**:
   - Edit sections and modules, checking that updates are saved and reflected correctly.

4. **Delete Sections and Modules**:
   - Delete sections and modules as described, verifying that all deletions occur as expected and no orphaned data remains.

5. **Review**:
   - Review the changes to ensure that they align with the requirements and that no functionality is broken.

## Additional Notes

- Make sure to write unit tests for the new deletion logic.
- Document any changes made in the `CHANGELOG.md` file.
- If you encounter any issues or need further clarification, please reach out on the project's issue tracker.

Thank you for your contributions!
