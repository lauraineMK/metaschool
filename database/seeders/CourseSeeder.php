<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Course;
use App\Models\Section;
use App\Models\Module;
use App\Models\Lesson;
use App\Models\User;

class CourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        // Create users to be the authors
        $author1 = User::firstOrCreate([
            'email' => 'author1@example.com',
        ], [
            'firstname' => 'John',
            'lastname' => 'Doe',
            'password' => bcrypt('password'),
            'role' => 'teacher',
        ]);

        $author2 = User::firstOrCreate([
            'email' => 'author2@example.com',
        ], [
            'firstname' => 'Jane',
            'lastname' => 'Smith',
            'password' => bcrypt('password'),
            'role' => 'teacher',
        ]);

        // First case of a course with sections, each section with modules, each module with lessons
        $course1 = Course::firstOrCreate([
            'name' => 'Introduction to Programming',
            'description' => 'This course covers the basics of programming, including fundamental data structures and algorithms.',
            'author_id' => $author1->id,
        ]);

        // Create sections for the first course
        $section1_1 = Section::firstOrCreate([
            'name' => 'Basics of Programming',
            'description' => 'Introduction to fundamental programming concepts.',
            'course_id' => $course1->id
        ]);

        $section1_2 = Section::firstOrCreate([
            'name' => 'Advanced Programming',
            'description' => 'Explore more complex programming topics and techniques.',
            'course_id' => $course1->id
        ]);

        // Create modules for the first section
        $module1_1 = Module::firstOrCreate([
            'name' => 'Variables and Data Types',
            'description' => 'Understanding variables and data types in programming.',
            'course_id' => $course1->id,
            'section_id' => $section1_1->id
        ]);

        $module1_2 = Module::firstOrCreate([
            'name' => 'Control Structures',
            'description' => 'Learning about control structures such as loops and conditionals.',
            'course_id' => $course1->id,
            'section_id' => $section1_1->id
        ]);

        $module2_1 = Module::firstOrCreate([
            'name' => 'Sorting Algorithms',
            'description' => 'Introduction to various sorting algorithms and their complexities.',
            'course_id' => $course1->id,
            'section_id' => $section1_2->id
        ]);

        $module2_2 = Module::firstOrCreate([
            'name' => 'Searching Algorithms',
            'description' => 'Understanding different search algorithms and their applications.',
            'course_id' => $course1->id,
            'section_id' => $section1_2->id
        ]);

        // Create lessons for the first module in the first section
        Lesson::firstOrCreate([
            'title' => 'Introduction to Variables',
            'content' => 'Learn what variables are and how to use them.',
            'course_id' => $course1->id,
            'section_id' => $section1_1->id,
            'module_id' => $module1_1->id
        ]);

        Lesson::firstOrCreate([
            'title' => 'Data Types Overview',
            'content' => 'Overview of different data types available in programming.',
            'course_id' => $course1->id,
            'section_id' => $section1_1->id,
            'module_id' => $module1_1->id
        ]);

        Lesson::firstOrCreate([
            'title' => 'Variables in Practice',
            'content' => 'Practical exercises with variables and data types.',
            'course_id' => $course1->id,
            'section_id' => $section1_1->id,
            'module_id' => $module1_1->id
        ]);

        // Repeat for other modules
        Lesson::firstOrCreate([
            'title' => 'Introduction to Loops',
            'content' => 'Learn the basics of loops and their uses.',
            'course_id' => $course1->id,
            'section_id' => $section1_1->id,
            'module_id' => $module1_2->id
        ]);

        Lesson::firstOrCreate([
            'title' => 'Conditionals',
            'content' => 'Understanding conditional statements and their applications.',
            'course_id' => $course1->id,
            'section_id' => $section1_1->id,
            'module_id' => $module1_2->id
        ]);

        Lesson::firstOrCreate([
            'title' => 'Control Structures in Practice',
            'content' => 'Practical exercises with loops and conditionals.',
            'course_id' => $course1->id,
            'section_id' => $section1_1->id,
            'module_id' => $module1_2->id
        ]);

        Lesson::firstOrCreate([
            'title' => 'Bubble Sort Algorithm',
            'content' => 'Understanding the bubble sort algorithm and its implementation.',
            'course_id' => $course1->id,
            'section_id' => $section1_2->id,
            'module_id' => $module2_1->id
        ]);

        Lesson::firstOrCreate([
            'title' => 'Quick Sort Algorithm',
            'content' => 'Learn about the quick sort algorithm and its advantages.',
            'course_id' => $course1->id,
            'section_id' => $section1_2->id,
            'module_id' => $module2_1->id
        ]);

        Lesson::firstOrCreate([
            'title' => 'Merge Sort Algorithm',
            'content' => 'Introduction to merge sort and its applications.',
            'course_id' => $course1->id,
            'section_id' => $section1_2->id,
            'module_id' => $module2_1->id
        ]);

        Lesson::firstOrCreate([
            'title' => 'Binary Search Algorithm',
            'content' => 'Understanding binary search and its efficiency.',
            'course_id' => $course1->id,
            'section_id' => $section1_2->id,
            'module_id' => $module2_2->id
        ]);

        Lesson::firstOrCreate([
            'title' => 'Linear Search Algorithm',
            'content' => 'Learn about linear search and its implementation.',
            'course_id' => $course1->id,
            'section_id' => $section1_2->id,
            'module_id' => $module2_2->id
        ]);

        // Second case of a course with modules, each module with lessons
        $course2 = Course::firstOrCreate([
            'name' => 'Advanced Data Structures',
            'description' => 'An in-depth look into advanced data structures used in computer science.',
            'author_id' => $author2->id,
        ]);

        // Create modules for the second course
        $module2_1 = Module::firstOrCreate([
            'name' => 'Trees and Graphs',
            'description' => 'Study of trees and graphs as advanced data structures.',
            'course_id' => $course2->id
        ]);

        $module2_2 = Module::firstOrCreate([
            'name' => 'Heaps and Hash Tables',
            'description' => 'Exploration of heaps and hash tables for efficient data storage.',
            'course_id' => $course2->id
        ]);

        // Create lessons for the first module
        Lesson::firstOrCreate([
            'title' => 'Introduction to Trees',
            'content' => 'Basics of tree data structures and their uses.',
            'course_id' => $course2->id,
            'module_id' => $module2_1->id
        ]);

        Lesson::firstOrCreate([
            'title' => 'Binary Trees',
            'content' => 'Detailed study of binary trees and their properties.',
            'course_id' => $course2->id,
            'module_id' => $module2_1->id
        ]);

        Lesson::firstOrCreate([
            'title' => 'Graph Algorithms',
            'content' => 'Introduction to graph algorithms and their applications.',
            'course_id' => $course2->id,
            'module_id' => $module2_1->id
        ]);

        // Create lessons for the second module
        Lesson::firstOrCreate([
            'title' => 'Introduction to Heaps',
            'content' => 'Learn about heap data structures and their use cases.',
            'course_id' => $course2->id,
            'module_id' => $module2_2->id
        ]);

        Lesson::firstOrCreate([
            'title' => 'Heap Operations',
            'content' => 'Operations and algorithms associated with heap data structures.',
            'course_id' => $course2->id,
            'module_id' => $module2_2->id
        ]);

        // Third and last case of a course with lessons
        $course3 = Course::firstOrCreate([
            'name' => 'Introduction to Data Science',
            'description' => 'A comprehensive course covering the essentials of data science.',
            'author_id' => $author1->id,
        ]);

        // Create seven lessons for the third course
        Lesson::firstOrCreate([
            'title' => 'What is Data Science?',
            'content' => 'An overview of data science, its scope, and applications.',
            'course_id' => $course3->id
        ]);

        Lesson::firstOrCreate([
            'title' => 'Data Collection and Cleaning',
            'content' => 'Techniques for collecting and cleaning data for analysis.',
            'course_id' => $course3->id
        ]);

        Lesson::firstOrCreate([
            'title' => 'Exploratory Data Analysis',
            'content' => 'Methods for analyzing and visualizing data to extract insights.',
            'course_id' => $course3->id
        ]);

        Lesson::firstOrCreate([
            'title' => 'Statistical Analysis',
            'content' => 'Applying statistical methods to understand data distributions and relationships.',
            'course_id' => $course3->id
        ]);

        Lesson::firstOrCreate([
            'title' => 'Machine Learning Basics',
            'content' => 'Introduction to machine learning algorithms and their applications.',
            'course_id' => $course3->id
        ]);

        Lesson::firstOrCreate([
            'title' => 'Data Visualization',
            'content' => 'Techniques and tools for effectively visualizing data and results.',
            'course_id' => $course3->id
        ]);

        Lesson::firstOrCreate([
            'title' => 'Building Predictive Models',
            'content' => 'Creating and validating predictive models using real-world data.',
            'course_id' => $course3->id
        ]);
    }
}
