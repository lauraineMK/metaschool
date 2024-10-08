# Document Management in Lessons

## Summary

There are issues with handling documents in the lesson editing functionality. The creation of a lesson with one or more documents works perfectly. However, updating a lesson that includes one or more documents poses a problem: the lesson updates successfully, but modifications (addition, editing, or deletion) of the documents are not taken into account, despite seemingly correct code in the necessary areas.

## Detailed Description

- **Former Issue**: When editing a lesson, the management of documents did not function correctly. This included adding, updating, or deleting documents associated with a lesson.
- **Resolved Issue**: Adding, modifying or deleting documents while updating a lesson is fully functional.
- **Scope**:
  - **Creation**: Adding documents to a lesson.
  - **Modification**: Updating document details or replacing existing documents.
  - **Deletion**: Removing documents from a lesson, ensuring they are deleted appropriately.

### Controller

An `update` method is implemented in the controller located at `app/Http/Controllers/Teacher/LessonController.php`, which is intended to handle the document storage logic.
The part of the code that is not functioning as intended is separated in red for easier identification.

### JavaScript

The script responsible for the dynamic content of the lesson is placed on line 228 of the following file:

`resources/js/lesson.js`

The script is designed for creating and updating lessons.

- Creating and updating lessons with or without videos works perfectly.
- Creating lessons with documents also works.
- Only updating with documents is dysfunctional: the lesson update works, but documents (additions, modifications, deletions) are not updated.

## Tasks

### Work on Document Management in Lessons

- **Objective**: Improve the handling of documents within lesson editing to ensure proper functionality.
- **Details**:
  - **Creation**: Verify that adding documents to a lesson works as intended.
  - **Modification**: Ensure that updating or replacing documents within a lesson operates correctly.
  - **Deletion**: Confirm that documents can be removed from a lesson, and ensure that all associated files are deleted appropriately.

## How to Test

1. **Set up**:
   - Clone the repository and set up the development environment.
   - Ensure you have the necessary tools and dependencies installed.

2. **Manage Documents in Lessons**:
   - Add documents to lessons, update existing documents, and remove documents to ensure that all document management features work correctly.

3. **Review**:
   - Review the changes to ensure that they align with the requirements and that no functionality is broken.

## Additional Notes

- Make sure to write unit tests for the new functionality related to document management.
- Document any changes made in the `CHANGELOG.md` file.
- If you encounter any issues or need further clarification, please reach out on the project's issue tracker.

Thank you for addressing these issues!
