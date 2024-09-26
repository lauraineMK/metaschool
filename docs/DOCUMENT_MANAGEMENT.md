# Document Management in Lessons

## Summary

There are issues with handling documents in the lesson editing functionality. The creation of a lesson with one or more documents works perfectly. However, updating a lesson that includes one or more documents poses a problem: the lesson updates successfully, but modifications (addition, editing, or deletion) of the documents are not taken into account, despite seemingly correct code in the necessary areas.

## Detailed Description

- **Issue**: When editing a lesson, the management of documents does not function correctly. This includes adding, updating, or deleting documents associated with a lesson.
- **Scope**:
  - **Creation**: Adding documents to a lesson.
  - **Modification**: Updating document details or replacing existing documents.
  - **Deletion**: Removing documents from a lesson, ensuring they are deleted appropriately.

## Tasks

### 1. Work on Document Management in Lessons

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
