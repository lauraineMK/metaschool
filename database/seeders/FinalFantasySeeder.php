<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use App\Models\Course;
use App\Models\Section;
use App\Models\Module;
use App\Models\Lesson;
use App\Models\User;
use App\Models\Video;
use App\Models\Document;

class FinalFantasySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // // Path to the directory containing the files to copy
        // $sourcePath = database_path('seeders/files');

        // // Path to the destination directory
        // $destinationPath = 'public/documents'; // This is relative to the 'storage/app' directory

        // // Create the destination directory if it does not exist
        // if (!Storage::exists($destinationPath)) {
        //     Storage::makeDirectory($destinationPath, 0755, true);
        // }

        // // Get the list of files in the source directory
        // $files = File::files($sourcePath);

        // foreach ($files as $file) {
        //     // File name
        //     $fileName = basename($file);

        //     // Full path of the destination file
        //     $destinationFile = $destinationPath . '/' . $fileName;

        //     // Copy the file to the destination directory
        //     Storage::copy('seeders/files/' . $fileName, $destinationFile);
        // }

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
        $course = Course::firstOrCreate([
            'name' => 'Final Fantasy',
            'description' => 'Explore the world of Final Fantasy, focusing on its various themes and characters across different games.',
            'author_id' => $author->id,
        ]);

        // Section 1: Final Fantasy VII
        $section1 = Section::firstOrCreate([
            'name' => 'Final Fantasy VII',
            'description' => 'A game by Square released in 1997.',
            'course_id' => $course->id,
        ]);

        // Module 1: Character Themes
        $module1_1 = Module::firstOrCreate([
            'name' => 'Character Themes',
            'description' => 'Characters from FFVII.',
            'course_id' => $course->id,
            'section_id' => $section1->id,
        ]);

        // Lessons for Module 1
        $lesson1_1 = Lesson::firstOrCreate([
            'title' => 'Tifa Lockhart',
            'content' => 'Character profile of Tifa Lockhart, a strong fighter and a key member of the party.',
            'course_id' => $course->id,
            'section_id' => $section1->id,
            'module_id' => $module1_1->id,
        ]);

        Video::firstOrCreate([
            'title' => 'Tifa\'s Story',
            'url' => 'https://youtu.be/y9OwMPZppMg?si=iDGAjc-nLoRFG6fL',
            'description' => 'Introduction to Tifa Lockhart’s character.',
            'lesson_id' => $lesson1_1->id,
        ]);

        // Document::firstOrCreate([
        //     'title' => 'Tifa Lockhart Profile',
        //     'file' => 'documents/Tifa-Lockhart.pdf',
        //     'description' => 'Detailed profile of Tifa Lockhart.',
        //     'lesson_id' => $lesson1_1->id,
        // ]);

        $lesson1_2 = Lesson::firstOrCreate([
            'title' => 'Aeris Gainsborough',
            'content' => 'Character profile of Aeris Gainsborough, a beloved character with a mysterious background.',
            'course_id' => $course->id,
            'section_id' => $section1->id,
            'module_id' => $module1_1->id,
        ]);

        Video::firstOrCreate([
            'title' => 'Aeris\'s Story',
            'url' => 'https://youtu.be/U12eoGz4q38?si=AO2lFQC_FIap7-2Y',
            'description' => 'Introduction to Aeris Gainsborough’s character.',
            'lesson_id' => $lesson1_2->id,
        ]);

        // Document::firstOrCreate([
        //     'title' => 'Aeris Gainsborough Profile',
        //     'file' => 'documents/Aerith-Gainsborough.pdf',
        //     'description' => 'Detailed profile of Aeris Gainsborough.',
        //     'lesson_id' => $lesson1_2->id,
        // ]);


        $lesson1_3 = Lesson::firstOrCreate([
            'title' => 'Jessie Raspberry',
            'content' => 'Character profile of Jessie, a member of the AVALANCHE group.',
            'course_id' => $course->id,
            'section_id' => $section1->id,
            'module_id' => $module1_1->id,
        ]);

        Video::firstOrCreate([
            'title' => 'Jessie\'s Role',
            'url' => 'https://youtu.be/BS4FcVXbDM4?si=6icWzRt5dXb5TlKJ',
            'description' => 'Introduction to Jessie’s character and role in the game.',
            'lesson_id' => $lesson1_3->id,
        ]);

        // Document::firstOrCreate([
        //     'title' => 'Jessie Raspberry Profile',
        //     'file' => 'documents/Jessie-Raspberry.pdf',
        //     'description' => 'Detailed profile of Jessie Raspberry.',
        //     'lesson_id' => $lesson1_3->id,
        // ]);

        // Module 2: City Themes
        $module1_2 = Module::firstOrCreate([
            'name' => 'City Themes',
            'description' => 'Important cities in FFVII.',
            'course_id' => $course->id,
            'section_id' => $section1->id,
        ]);

        // Lessons for Module 2
        $lesson2_1 = Lesson::firstOrCreate([
            'title' => 'Midgar',
            'content' => 'Overview of Midgar, the central city in FFVII.',
            'course_id' => $course->id,
            'section_id' => $section1->id,
            'module_id' => $module1_2->id,
        ]);

        Video::firstOrCreate([
            'title' => 'Midgar Overview',
            'url' => 'https://youtu.be/Ee2U-Iq9M6Q?si=fAXF51Me6Rmpfrll',
            'description' => 'Introduction to the city of Midgar.',
            'lesson_id' => $lesson2_1->id,
        ]);

        // Document::firstOrCreate([
        //     'title' => 'Midgar City Guide',
        //     'file' => 'documents/Midgar.pdf',
        //     'description' => 'Detailed guide to the city of Midgar.',
        //     'lesson_id' => $lesson2_1->id,
        // ]);

        $lesson2_2 = Lesson::firstOrCreate([
            'title' => 'Kalm',
            'content' => 'Exploration of the town of Kalm and its significance.',
            'course_id' => $course->id,
            'section_id' => $section1->id,
            'module_id' => $module1_2->id,
        ]);

        Video::firstOrCreate([
            'title' => 'Kalm Town',
            'url' => 'https://youtu.be/bAmXtabhI7o?si=PzuBhgyS_izjJqNY',
            'description' => 'Introduction to the town of Kalm.',
            'lesson_id' => $lesson2_2->id,
        ]);

        // Document::firstOrCreate([
        //     'title' => 'Kalm Town Overview',
        //     'file' => 'documents/Kalm.pdf',
        //     'description' => 'Detailed overview of the town of Kalm.',
        //     'lesson_id' => $lesson2_2->id,
        // ]);

        $lesson2_3 = Lesson::firstOrCreate([
            'title' => 'Junon',
            'content' => 'Details about Junon, a port town in FFVII.',
            'course_id' => $course->id,
            'section_id' => $section1->id,
            'module_id' => $module1_2->id,
        ]);

        Video::firstOrCreate([
            'title' => 'Junon City',
            'url' => 'https://youtu.be/7eznBiyXCYc?si=K_YJCwAssTcng9wt',
            'description' => 'Introduction to the city of Junon.',
            'lesson_id' => $lesson2_3->id,
        ]);

        // Document::firstOrCreate([
        //     'title' => 'Junon Port Guide',
        //     'file' => 'documents/Junon.pdf',
        //     'description' => 'Detailed guide to the port town of Junon.',
        //     'lesson_id' => $lesson2_3->id,
        // ]);

        // Section 2: Final Fantasy VIII
        $section2 = Section::firstOrCreate([
            'name' => 'Final Fantasy VIII',
            'description' => 'Square Enix game from 1999',
            'course_id' => $course->id,
        ]);

        // Module 1: Character Themes
        $module3 = Module::firstOrCreate([
            'name' => 'Character Themes',
            'description' => 'Characters from FFVIII',
            'course_id' => $course->id,
            'section_id' => $section2->id,
        ]);

        // Lessons for Module 1
        $lesson3_1 = Lesson::firstOrCreate([
            'title' => 'Squall Leonhart',
            'content' => 'Details about Squall Leonhart from Final Fantasy VIII.',
            'course_id' => $course->id,
            'section_id' => $section2->id,
            'module_id' => $module3->id,
        ]);

        Video::firstOrCreate([
            'title' => 'Squall Character Overview',
            'url' => 'https://youtu.be/nCroZAqp5WY?si=JcmRl1QqBWuWkGb9',
            'description' => 'Introduction to Squall Leonhart.',
            'lesson_id' => $lesson3_1->id,
        ]);

        // Document::firstOrCreate([
        //     'title' => 'Squall Leonhart Profile',
        //     'file' => 'documents/Squall-Leonhart.pdf',
        //     'description' => 'Detailed profile of Squall Leonhart.',
        //     'lesson_id' => $lesson3_1->id,
        // ]);

        $lesson3_2 = Lesson::firstOrCreate([
            'title' => 'Rinoa Heartilly',
            'content' => 'Details about Rinoa Heartilly from Final Fantasy VIII.',
            'course_id' => $course->id,
            'section_id' => $section2->id,
            'module_id' => $module3->id,
        ]);

        Video::firstOrCreate([
            'title' => 'Rinoa Character Overview',
            'url' => 'https://youtu.be/sbgtlcAonOM?si=IpXufPF5HsDhH8Ce',
            'description' => 'Introduction to Rinoa Heartilly.',
            'lesson_id' => $lesson3_2->id,
        ]);

        // Document::firstOrCreate([
        //     'title' => 'Rinoa Heartilly Profile',
        //     'file' => 'documents/Rinoa-Heartilly.pdf',
        //     'description' => 'Detailed profile of Rinoa Heartilly.',
        //     'lesson_id' => $lesson3_2->id,
        // ]);

        $lesson3_3 = Lesson::firstOrCreate([
            'title' => 'Edea Kramer',
            'content' => 'Details about Edea from Final Fantasy VIII.',
            'course_id' => $course->id,
            'section_id' => $section2->id,
            'module_id' => $module3->id,
        ]);

        Video::firstOrCreate([
            'title' => 'Edea Character Overview',
            'url' => 'https://youtu.be/WRIfahXuCUg?si=sfOkU_I_lRAc9ZN6',
            'description' => 'Introduction to Edea.',
            'lesson_id' => $lesson3_3->id,
        ]);

        // Document::firstOrCreate([
        //     'title' => 'Edea Kramer Profile',
        //     'file' => 'documents/Edea-Kramer.pdf',
        //     'description' => 'Detailed profile of Edea Kramer.',
        //     'lesson_id' => $lesson3_3->id,
        // ]);

        // Module 2: City Themes
        $module4 = Module::firstOrCreate([
            'name' => 'City Themes',
            'description' => 'Cities from FFVIII',
            'course_id' => $course->id,
            'section_id' => $section2->id,
        ]);

        // Lessons for Module 2
        $lesson4_1 = Lesson::firstOrCreate([
            'title' => 'Dollet',
            'content' => 'Details about Dollet from Final Fantasy VIII.',
            'course_id' => $course->id,
            'section_id' => $section2->id,
            'module_id' => $module4->id,
        ]);

        Video::firstOrCreate([
            'title' => 'Dollet Overview',
            'url' => 'https://youtu.be/It0njYYmEL8?si=9L4tnyuBSVmawICc',
            'description' => 'Introduction to Dollet.',
            'lesson_id' => $lesson4_1->id,
        ]);

        // Document::firstOrCreate([
        //     'title' => 'Dollet Guide',
        //     'file' => 'documents/Dollet.pdf',
        //     'description' => 'Detailed guide to Dollet.',
        //     'lesson_id' => $lesson4_1->id,
        // ]);

        $lesson4_2 = Lesson::firstOrCreate([
            'title' => 'Timber',
            'content' => 'Details about Timber from Final Fantasy VIII.',
            'course_id' => $course->id,
            'section_id' => $section2->id,
            'module_id' => $module4->id,
        ]);

        Video::firstOrCreate([
            'title' => 'Timber Overview',
            'url' => 'https://youtu.be/NzalzY223ew?si=85kE1FL9v9GBduhE',
            'description' => 'Introduction to Timber.',
            'lesson_id' => $lesson4_2->id,
        ]);

        // Document::firstOrCreate([
        //     'title' => 'Timber Guide',
        //     'file' => 'documents/Timberpdf',
        //     'description' => 'Detailed guide to Timber.',
        //     'lesson_id' => $lesson4_2->id,
        // ]);

        $lesson4_3 = Lesson::firstOrCreate([
            'title' => 'Deling City',
            'content' => 'Details about Deling City from Final Fantasy VIII.',
            'course_id' => $course->id,
            'section_id' => $section2->id,
            'module_id' => $module4->id,
        ]);

        Video::firstOrCreate([
            'title' => 'Deling City Overview',
            'url' => 'https://youtu.be/8-TBDaoYbZY?si=jXhYyxTsmUunCEMj',
            'description' => 'Introduction to Deling City.',
            'lesson_id' => $lesson4_3->id,
        ]);

        // Document::firstOrCreate([
        //     'title' => 'Deling City Guide',
        //     'file' => 'documents/Deling-City.pdf',
        //     'description' => 'Detailed guide to Deling City.',
        //     'lesson_id' => $lesson4_3->id,
        // ]);

        // Section 3: Final Fantasy IX
        $section3 = Section::firstOrCreate([
            'name' => 'Final Fantasy IX',
            'description' => 'Square Enix game from 2000',
            'course_id' => $course->id,
        ]);

        // Module 1: Character Themes
        $module5 = Module::firstOrCreate([
            'name' => 'Character Themes',
            'description' => 'Characters from FFIX',
            'course_id' => $course->id,
            'section_id' => $section3->id,
        ]);

        // Lessons for Module 1
        $lesson5_1 = Lesson::firstOrCreate([
            'title' => 'Vivi Ornitier',
            'content' => 'Details about Vivi Ornitier from Final Fantasy IX.',
            'course_id' => $course->id,
            'section_id' => $section3->id,
            'module_id' => $module5->id,
        ]);

        Video::firstOrCreate([
            'title' => 'Vivi Character Overview',
            'url' => 'https://youtu.be/zGfgM_3-A1k?si=Xz1HsIHI070D5eBh',
            'description' => 'Introduction to Vivi Ornitier.',
            'lesson_id' => $lesson5_1->id,
        ]);

        // Document::firstOrCreate([
        //     'title' => 'Vivi Ornitier Profile',
        //     'file' => 'documents/Vivi-Ornitier.pdf',
        //     'description' => 'Detailed profile of Vivi Ornitier.',
        //     'lesson_id' => $lesson5_1->id,
        // ]);

        $lesson5_2 = Lesson::firstOrCreate([
            'title' => 'Adelbert Steiner',
            'content' => 'Details about Adelbert Steiner from Final Fantasy IX.',
            'course_id' => $course->id,
            'section_id' => $section3->id,
            'module_id' => $module5->id,
        ]);

        Video::firstOrCreate([
            'title' => 'Steiner Character Overview',
            'url' => 'https://youtu.be/OQOxCygN3TQ?si=MCEceC08F2j3Wb1Y',
            'description' => 'Introduction to Adelbert Steiner.',
            'lesson_id' => $lesson5_2->id,
        ]);

        // Document::firstOrCreate([
        //     'title' => 'Adelbert Steiner Profile',
        //     'file' => 'documents/Adelbert-Steiner.pdf',
        //     'description' => 'Detailed profile of Adelbert Steiner.',
        //     'lesson_id' => $lesson5_2->id,
        // ]);

        $lesson5_3 = Lesson::firstOrCreate([
            'title' => 'Beatrix',
            'content' => 'Details about General Beatrix from Final Fantasy IX.',
            'course_id' => $course->id,
            'section_id' => $section3->id,
            'module_id' => $module5->id,
        ]);

        Video::firstOrCreate([
            'title' => 'Beatrix Character Overview',
            'url' => 'https://youtu.be/djz5LAkV1so?si=xSasUHMhs1Oc1101',
            'description' => 'Introduction to General Beatrix.',
            'lesson_id' => $lesson5_3->id,
        ]);

        // Document::firstOrCreate([
        //     'title' => 'Beatrix Profile',
        //     'file' => 'documents/Beatrix.pdf',
        //     'description' => 'Detailed profile of Beatrix.',
        //     'lesson_id' => $lesson5_3->id,
        // ]);

        // Module 2: City Themes
        $module6 = Module::firstOrCreate([
            'name' => 'City Themes',
            'description' => 'Cities from FFIX',
            'course_id' => $course->id,
            'section_id' => $section3->id,
        ]);

        // Lessons for Module 2
        $lesson6_1 = Lesson::firstOrCreate([
            'title' => 'Lindblum',
            'content' => 'Details about the city of Lindblum from Final Fantasy IX.',
            'course_id' => $course->id,
            'section_id' => $section3->id,
            'module_id' => $module6->id,
        ]);

        Video::firstOrCreate([
            'title' => 'Lindblum City Overview',
            'url' => 'https://youtu.be/xzdgIYzoZUY?si=O1V5nLc0Y4lsKcgG',
            'description' => 'Introduction to the city of Lindblum.',
            'lesson_id' => $lesson6_1->id,
        ]);

        // Document::firstOrCreate([
        //     'title' => 'Lindblum City',
        //     'file' => 'documents/Lindblum.pdf',
        //     'description' => 'Details about the city of Lindblum.',
        //     'lesson_id' => $lesson6_1->id,
        // ]);

        $lesson6_2 = Lesson::firstOrCreate([
            'title' => 'Burmecia',
            'content' => 'Details about the kingdom of Burmecia from Final Fantasy IX.',
            'course_id' => $course->id,
            'section_id' => $section3->id,
            'module_id' => $module6->id,
        ]);

        Video::firstOrCreate([
            'title' => 'Kingdom of Burmecia Overview',
            'url' => 'https://youtu.be/Bsb4VTueU7U?si=NSYceiJ8pYnFRvti',
            'description' => 'Introduction to the kingdom of Burmecia.',
            'lesson_id' => $lesson6_2->id,
        ]);

        // Document::firstOrCreate([
        //     'title' => 'Kingdom of Burmecia',
        //     'file' => 'documents/Burmecia.pdf',
        //     'description' => 'Details about the kingdom of Burmecia.',
        //     'lesson_id' => $lesson6_2->id,
        // ]);

        $lesson6_3 = Lesson::firstOrCreate([
            'title' => 'Treno',
            'content' => 'Details about the city of Treno from Final Fantasy IX.',
            'course_id' => $course->id,
            'section_id' => $section3->id,
            'module_id' => $module6->id,
        ]);

        Video::firstOrCreate([
            'title' => 'Treno City Overview',
            'url' => 'https://youtu.be/GQYshDvTqJM?si=AtYEZYlgb7SaFHQ1',
            'description' => 'Introduction to the city of Treno.',
            'lesson_id' => $lesson6_3->id,
        ]);

        // Document::firstOrCreate([
        //     'title' => 'Treno City',
        //     'file' => 'documents/Treno.pdf',
        //     'description' => 'Details about the city of Treno.',
        //     'lesson_id' => $lesson6_3->id,
        // ]);
    }
}
