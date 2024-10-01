# Error Management

## Recent Errors

### 1. Errors Related to Undefined Variables and Functions

- ** Undefined variable $lesson
** `Undefined variable $lesson`
  **Date:** 2024-10-01 1:51 PM  
  **File:** `/var/www/html/internship/lms-metaboussole/resources/views/student/quizzes/results.blade.php`  
  **User ID:** 2  
  **Details:**  
  - **Undefined variable $lesson
** `Undefined array key 2`  
**Date:** 2024-10-01 1:41 PM  
**File:** `/var/www/html/internship/lms-metaboussole/resources/views/student/quizzes/results.blade.php`  
**User ID:** 2  
**Details:**

### 2. Other Runtime Errors

- **Undefined variable $lesson
** `Call to undefined function isLessonViewable()`  
**Date:** 2024-09-23 12:59 PM  
**File:** `/var/www/html/internship/lms-metaboussole/resources/views/student/lessons/index.blade.php`  
**User ID:** 2  
**Details:**  
- ** Undefined variable $lesson
** `Undefined variable $viewedLessons`
**Date:** 2024-09-23 1:13 PM  
**File:** `/var/www/html/internship/lms-metaboussole/resources/views/student/lessons/index.blade.php`  
**User ID:** 2  
**Details:**  
- **Undefined variable $lesson
** `Undefined constant "localStorage"`  
**Date:** 2024-09-23 1:21 PM  
**File:** `/var/www/html/internship/lms-metaboussole/resources/views/student/courses/show.blade.php`  
**User ID:** 2  
**Details:**  
- **Undefined variable $lesson
** `Vite manifest not found at`  
**Date:** 2024-09-23 4:13 PM  
**File:** `/var/www/html/internship/lms-metaboussole/resources/views/layouts/head.blade.php`  
**Details:**

## Resolution Suggestions

1. **For Undefined Variables:** Ensure that variables are correctly passed to the view from the controller.
2. **For Undefined Functions:** Make sure all functions used in the views are properly defined and accessible.
3. **For the Vite Manifest Issue:** Check that Vite is correctly configured and that the `manifest.json` file exists at the specified location.

## How to Reset the Logs

To filter out active errors without deleting old log entries, use the following command in your terminal:

```bash
grep "ERROR" storage/logs/laravel.log
```

Feel free to let me know if you want to add any other information or modifications to this file!
