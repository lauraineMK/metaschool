<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Course;
use App\Models\Section;
use App\Models\Module;
use App\Models\Lesson;
use App\Models\User;
use App\Models\Video;

class FinalFantasySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create a user to be the author
        $author = User::firstOrCreate([
            'email' => 'author@example.com',
        ], [
            'firstname' => 'Aurélien',
            'surname' => 'ROUCHETTE',
            'password' => bcrypt('password'),
            'role' => 'teacher',
        ]);

        // Create the course
        $course = Course::create([
            'name' => 'Final Fantasy',
            'description' => 'Explore the world of Final Fantasy, focusing on its various themes and characters across different games.',
            'author_id' => $author->id,
        ]);

        // Section 1: Final Fantasy VII
        $section1 = Section::create([
            'name' => 'Final Fantasy VII',
            'description' => 'A game by Square released in 1997.',
            'course_id' => $course->id,
        ]);

        // Module 1: Character Themes
        $module1_1 = Module::create([
            'name' => 'Character Themes',
            'description' => 'Characters from FFVII.',
            'course_id' => $course->id,
            'section_id' => $section1->id,
        ]);

        // Lessons for Module 1
        $lesson1_1 = Lesson::create([
            'title' => 'Tifa',
            'content' => 'Character profile of Tifa Lockhart, a strong fighter and a key member of the party.',
            'course_id' => $course->id,
            'section_id' => $section1->id,
            'module_id' => $module1_1->id,
        ]);

        Video::create([
            'title' => 'Tifa\'s Story',
            'url' => 'https://youtu.be/y9OwMPZppMg?si=iDGAjc-nLoRFG6fL',
            'description' => 'Introduction to Tifa Lockhart’s character.',
            'lesson_id' => $lesson1_1->id,
        ]);

        $lesson1_2 = Lesson::create([
            'title' => 'Aeris',
            'content' => 'Character profile of Aeris Gainsborough, a beloved character with a mysterious background.',
            'course_id' => $course->id,
            'section_id' => $section1->id,
            'module_id' => $module1_1->id,
        ]);

        Video::create([
            'title' => 'Aeris\'s Story',
            'url' => 'https://youtu.be/U12eoGz4q38?si=AO2lFQC_FIap7-2Y',
            'description' => 'Introduction to Aeris Gainsborough’s character.',
            'lesson_id' => $lesson1_2->id,
        ]);

        $lesson1_3 = Lesson::create([
            'title' => 'Jessie',
            'content' => 'Character profile of Jessie, a member of the AVALANCHE group.',
            'course_id' => $course->id,
            'section_id' => $section1->id,
            'module_id' => $module1_1->id,
        ]);

        Video::create([
            'title' => 'Jessie\'s Role',
            'url' => 'https://youtu.be/BS4FcVXbDM4?si=6icWzRt5dXb5TlKJ',
            'description' => 'Introduction to Jessie’s character and role in the game.',
            'lesson_id' => $lesson1_3->id,
        ]);

        // Module 2: City Themes
        $module1_2 = Module::create([
            'name' => 'City Themes',
            'description' => 'Important cities in FFVII.',
            'course_id' => $course->id,
            'section_id' => $section1->id,
        ]);

        // Lessons for Module 2
        $lesson2_1 = Lesson::create([
            'title' => 'Midgar',
            'content' => 'Overview of Midgar, the central city in FFVII.',
            'course_id' => $course->id,
            'section_id' => $section1->id,
            'module_id' => $module1_2->id,
        ]);

        Video::create([
            'title' => 'Midgar Overview',
            'url' => 'https://youtu.be/Ee2U-Iq9M6Q?si=fAXF51Me6Rmpfrll',
            'description' => 'Introduction to the city of Midgar.',
            'lesson_id' => $lesson2_1->id,
        ]);

        $lesson2_2 = Lesson::create([
            'title' => 'Kalm',
            'content' => 'Exploration of the town of Kalm and its significance.',
            'course_id' => $course->id,
            'section_id' => $section1->id,
            'module_id' => $module1_2->id,
        ]);

        Video::create([
            'title' => 'Kalm Town',
            'url' => 'https://youtu.be/bAmXtabhI7o?si=PzuBhgyS_izjJqNY',
            'description' => 'Introduction to the town of Kalm.',
            'lesson_id' => $lesson2_2->id,
        ]);

        $lesson2_3 = Lesson::create([
            'title' => 'Junon',
            'content' => 'Details about Junon, a port town in FFVII.',
            'course_id' => $course->id,
            'section_id' => $section1->id,
            'module_id' => $module1_2->id,
        ]);

        Video::create([
            'title' => 'Junon City',
            'url' => 'https://youtu.be/7eznBiyXCYc?si=K_YJCwAssTcng9wt',
            'description' => 'Introduction to the city of Junon.',
            'lesson_id' => $lesson2_3->id,
        ]);

        // Section 2: Final Fantasy VIII
        $section2 = Section::create([
            'name' => 'Final Fantasy VIII',
            'description' => 'Square Enix game from 1999',
            'course_id' => $course->id,
        ]);

        // Module 1: Character Themes
        $module3 = Module::create([
            'name' => 'Character Themes',
            'description' => 'Characters from FFVIII',
            'course_id' => $course->id,
            'section_id' => $section2->id,
        ]);

        // Lessons for Module 1
        $lesson3_1 = Lesson::create([
            'title' => 'Squall',
            'content' => 'Details about Squall Leonhart from Final Fantasy VIII.',
            'course_id' => $course->id,
            'section_id' => $section2->id,
            'module_id' => $module3->id,
        ]);

        Video::create([
            'title' => 'Squall Character Overview',
            'url' => 'https://youtu.be/nCroZAqp5WY?si=JcmRl1QqBWuWkGb9',
            'description' => 'Introduction to Squall Leonhart.',
            'lesson_id' => $lesson3_1->id,
        ]);

        $lesson3_2 = Lesson::create([
            'title' => 'Rinoa',
            'content' => 'Details about Rinoa Heartilly from Final Fantasy VIII.',
            'course_id' => $course->id,
            'section_id' => $section2->id,
            'module_id' => $module3->id,
        ]);

        Video::create([
            'title' => 'Rinoa Character Overview',
            'url' => 'https://youtu.be/sbgtlcAonOM?si=IpXufPF5HsDhH8Ce',
            'description' => 'Introduction to Rinoa Heartilly.',
            'lesson_id' => $lesson3_2->id,
        ]);

        $lesson3_3 = Lesson::create([
            'title' => 'Edea',
            'content' => 'Details about Edea from Final Fantasy VIII.',
            'course_id' => $course->id,
            'section_id' => $section2->id,
            'module_id' => $module3->id,
        ]);

        Video::create([
            'title' => 'Edea Character Overview',
            'url' => 'https://youtu.be/WRIfahXuCUg?si=sfOkU_I_lRAc9ZN6',
            'description' => 'Introduction to Edea.',
            'lesson_id' => $lesson3_3->id,
        ]);

        // Section 3: Final Fantasy IX
        $section3 = Section::create([
            'name' => 'Final Fantasy IX',
            'description' => 'Square Enix game from 2000',
            'course_id' => $course->id,
        ]);

        // Module 1: Character Themes
        $module4 = Module::create([
            'name' => 'Character Themes',
            'description' => 'Characters from FFIX',
            'course_id' => $course->id,
            'section_id' => $section3->id,
        ]);

        // Lessons for Module 1
        $lesson4_1 = Lesson::create([
            'title' => 'Vivi',
            'content' => 'Details about Vivi Ornitier from Final Fantasy IX.',
            'course_id' => $course->id,
            'section_id' => $section3->id,
            'module_id' => $module4->id,
        ]);

        Video::create([
            'title' => 'Vivi Character Overview',
            'url' => 'https://youtu.be/zGfgM_3-A1k?si=Xz1HsIHI070D5eBh',
            'description' => 'Introduction to Vivi Ornitier.',
            'lesson_id' => $lesson4_1->id,
        ]);

        $lesson4_2 = Lesson::create([
            'title' => 'Steiner',
            'content' => 'Details about Adelbert Steiner from Final Fantasy IX.',
            'course_id' => $course->id,
            'section_id' => $section3->id,
            'module_id' => $module4->id,
        ]);

        Video::create([
            'title' => 'Steiner Character Overview',
            'url' => 'https://youtu.be/OQOxCygN3TQ?si=MCEceC08F2j3Wb1Y',
            'description' => 'Introduction to Adelbert Steiner.',
            'lesson_id' => $lesson4_2->id,
        ]);

        $lesson4_3 = Lesson::create([
            'title' => 'Beatrix',
            'content' => 'Details about General Beatrix from Final Fantasy IX.',
            'course_id' => $course->id,
            'section_id' => $section3->id,
            'module_id' => $module4->id,
        ]);

        Video::create([
            'title' => 'Beatrix Character Overview',
            'url' => 'https://youtu.be/djz5LAkV1so?si=xSasUHMhs1Oc1101',
            'description' => 'Introduction to General Beatrix.',
            'lesson_id' => $lesson4_3->id,
        ]);

        // Module 2: City Themes
        $module5 = Module::create([
            'name' => 'City Themes',
            'description' => 'Cities from FFIX',
            'course_id' => $course->id,
            'section_id' => $section3->id,
        ]);

        // Lessons for Module 2
        $lesson5_1 = Lesson::create([
            'title' => 'Lindblum',
            'content' => 'Details about the city of Lindblum from Final Fantasy IX.',
            'course_id' => $course->id,
            'section_id' => $section3->id,
            'module_id' => $module5->id,
        ]);

        Video::create([
            'title' => 'Lindblum City Overview',
            'url' => 'https://youtu.be/xzdgIYzoZUY?si=O1V5nLc0Y4lsKcgG',
            'description' => 'Introduction to the city of Lindblum.',
            'lesson_id' => $lesson5_1->id,
        ]);

        $lesson5_2 = Lesson::create([
            'title' => 'Burmecia',
            'content' => 'Details about the city of Burmecia from Final Fantasy IX.',
            'course_id' => $course->id,
            'section_id' => $section3->id,
            'module_id' => $module5->id,
        ]);

        Video::create([
            'title' => 'Burmecia City Overview',
            'url' => 'https://youtu.be/Bsb4VTueU7U?si=NSYceiJ8pYnFRvti',
            'description' => 'Introduction to the city of Burmecia.',
            'lesson_id' => $lesson5_2->id,
        ]);

        $lesson5_3 = Lesson::create([
            'title' => 'Treno',
            'content' => 'Details about the city of Treno from Final Fantasy IX.',
            'course_id' => $course->id,
            'section_id' => $section3->id,
            'module_id' => $module5->id,
        ]);

        Video::create([
            'title' => 'Treno City Overview',
            'url' => 'https://youtu.be/GQYshDvTqJM?si=AtYEZYlgb7SaFHQ1',
            'description' => 'Introduction to the city of Treno.',
            'lesson_id' => $lesson5_3->id,
        ]);
    }
}
