# Contributing to the Project

Thank you for contributing to our project! To help streamline the process, please follow the guidelines below, especially when addressing issues related to code functionality and improvements.

## Problem Description

### Course Editing

#### Summary

The current implementation of the course editing functionality has the following issues:

- **Creation and Modification**:  The addition of new sections or new standalone modules is functioning properly; However, there is still a problem with section modules if they are added with a section, all at once.
- **Deletion**: The deletion feature for sections and standalone modules works correctly, including for the last section or module.

#### Detailed Description

- **Resolved Issues**:  
  - The issue of deleting sections and standalone modules, including the last ones, has been fixed.
  - The addition of new sections or standalone modules during the update process is now functioning correctly.
  - Updating a course with sections or standalone modules now works perfectly, including creation, modification, and deletion.

- **Resolved Issues**:
  - Updating a course with sections and modules within those sections works partially. While existing modules within sections are functioning correctly, the issue arises when creating a new section with a module in it. In this case, the new section is created, but the module may not be created properly. It could lead to either:
    - Only the section being created.
    - A second section being created with the title of the desired module instead of a new module being added to the created section.
  - This inconsistency results in errors during the update process.

- **Scope**:
Creation of a new module within a new section, all created with the same update

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
