# Contributing to the Project

Thank you for contributing to our project! To help streamline the process, please follow the guidelines below, especially when addressing issues related to code functionality and improvements.

## Problem Description

### Course Editing

#### Summary

The current implementation of the course editing functionality has the following issues:

- **Creation and Modification**: Creation and Modification: The addition of new sections and modules is not functioning correctly. Instead of creating new entries, they seem to replace or merge with existing ones.
- **Deletion**: The deletion feature for sections and modules works in most cases but fails for the last section or the last module, which does not delete properly.

#### Detailed Description

- **Issue**:  When editing a course, if a new section and its modules are created, they replace the existing ones rather than being added as new entries. For example, if Section 1 has Module 1A and Module 2A, creating Section X with Module X during the edit process results in Section 1 being replaced by Section X, Module 1A being replaced by Module X, and no new section or module being created. Additionally, while the deletion of sections and modules works correctly, the last section or module does not delete as expected, leaving remnants in the system.
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

### 1. Work on Creation Functionality

- **Objective**: Ensure that the addition of new sections and modules works without merging or replacing existing entries.
- **Details*:
  - Implement functionality to create new sections and modules independently without affecting existing ones.
  - Verify that creating a section and adding modules does not result in the overwriting of existing data.

### 2. Work on Deletion (Partial Functionality)

- **Objective**: Ensure that the deletion of sections and their main modules works correctly.
- **Details**:
  - Implement functionality to delete sections and their associated main modules properly.
  - Confirm that deleting a section removes all related data and does not leave any orphaned modules or sections in the system, except for the last section or module.

### 3. Verify Creation Functionality

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
