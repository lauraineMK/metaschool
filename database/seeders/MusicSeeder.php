<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Video;
use App\Models\Course;
use App\Models\Lesson;
use App\Models\Module;
use App\Models\Section;
use Illuminate\Database\Seeder;

class MusicSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $author = User::firstOrCreate([
            'email' => 'author@example.com',
        ], [
            'firstname' => 'Aurélien',
            'lastname' => 'ROUCHETTE',
            'password' => bcrypt('password'),
            'role' => 'teacher',
        ]);

        // Create the music course
        $course = Course::create([
            'name' => 'Music Course',
            'description' => 'A comprehensive course on various music styles, artists, and their works.',
            'author_id' => $author->id,
        ]);

        // Define music styles and artists with their works
        $data = [
            'Classical' => [
                'Anastasia Huppmann' => [
                    'Chopin, Nocturne Op 48 No 1 C minor',
                    'Chopin, Nocturne Op 48 No 2 f-sharp minor',
                ],
                'Valentina Lisitsa' => [
                    'Beethoven, Sonata 14, III "Presto Agitato"',
                ],
            ],
            'Rock' => [
                'Alannah Myles' => [
                    'Black Velvet',
                    'Love Is',
                ],
            ],
            'Country' => [
                'Dolly Parton' => [
                    'Jolene',
                    '9 to 5',
                ],
                'Billy Ray Cyrus' => [
                    'Achy Breaky Heart',
                    'Some Gave All',
                ],
            ],
            'Jazz' => [
                'Tony Bennett and friends' => [
                    'Body and Soul',
                    'The Lady is a Tramp',
                ],
                'Lady Gaga' => [
                    'Nancy Sinatra, Bang Bang',
                    'Frank Sinatra, New-York, New-York',
                ],
            ],
            'Pop' => [
                'Miley Cyrus' => [
                    'Mother\'s Daughter',
                    'The Most',
                ],
                'Labrinth, Sia, Diplo' => [
                    'Thunderstorm',
                    'Audio',
                ],
                'Ariana Grande' => [
                    '7 rings',
                    'Break Up With Your Girlfriend',
                ],
            ],
        ];

        foreach ($data as $sectionName => $artists) {
            $section = Section::create([
                'name' => $sectionName,
                'course_id' => $course->id,
            ]);

            foreach ($artists as $artistName => $works) {
                $module = Module::create([
                    'name' => $artistName,
                    'course_id' => $course->id,
                    'section_id' => $section->id,
                ]);

                foreach ($works as $workTitle) {
                    $lesson = Lesson::create([
                        'title' => $workTitle,
                        'course_id' => $course->id,
                        'section_id' => $section->id,
                        'module_id' => $module->id,
                    ]);

                    // Add videos for each lesson
                    $this->createVideosForLesson($lesson, $workTitle);
                }
            }
        }
    }

    /**
     * Create videos for a given lesson.
     *
     * @param Lesson $lesson
     * @return void
     */
    private function createVideosForLesson(Lesson $lesson, string $workTitle)
    {
        // Example videos associated with lessons
        $videos = [
            'Chopin, Nocturne Op 48 No 1 C minor' => 'https://youtu.be/iMPwW4q1CtI?si=APHObpEruDHodhvY',
            'Chopin, Nocturne Op 48 No 2 f-sharp minor' => 'https://youtu.be/ObFnK_NGOb4?si=V22L3g2RHpc3JGxu',
            'Beethoven, Sonata 14, III "Presto Agitato"' => 'https://youtu.be/zucBfXpCA6s?si=GtPa9utI9hUmdJoT',
            'Black Velvet' => 'https://youtu.be/tT4d1LQy4es?si=y_TALhmcCkfpKq6s',
            'Love Is' => 'https://youtu.be/vQOrMzBewG0?si=NShoVdFFCuuzejyD',
            'Jolene' => 'https://youtu.be/L0eeSoU35wM?si=FVWtf6DDJ-A0WTQI',
            '9 to 5' => 'https://youtu.be/E4OzdyxbOuU?si=l7KUDoEu0fpCknwD',
            'Achy Breaky Heart' => 'https://youtu.be/byQIPdHMpjc?si=KF8zSf4rmvBxrTHl',
            'Some Gave All' => 'https://youtu.be/ydWhRObVxrM?si=EMliYQDz_BELzV1a',
            'Body and Soul' => 'https://youtu.be/_OFMkCeP6ok?si=IvwoJUDvnqaaSsWV',
            'The Lady is a Tramp' => 'https://youtu.be/ZPAmDULCVrU?si=FpddPZf0BJbXOOp4',
            'Nancy Sinatra, Bang Bang' => 'https://youtu.be/-huNrHAou-E?si=czUx_JLI64tZsecl',
            'Frank Sinatra, New-York, New-York' => 'https://youtu.be/hpiw3cDWmvc?si=ajp8-JU1Puvep9rT',
            'Mother\'s Daughter' => 'https://youtu.be/7T2RonyJ_Ts?si=ZATO01I6FhX6yOEm',
            'The Most' => 'https://youtu.be/xvZ15ZyRjnc?si=Lfaw5hvUBd0N-Qca',
            'Thunderstorm' => 'https://youtu.be/kg1BljLu9YY?si=aa_1Njv5Sk2hE2aq',
            'Audio' => 'https://youtu.be/tjA7nAHOAww?si=NYCqZV7OVgtBduHb',
            '7 rings' => 'https://youtu.be/QYh6mYIJG2Y?si=o0ZCLP7uQXQRGco9',
            'Break Up With Your Girlfriend' => 'https://youtu.be/LH4Y1ZUUx2g?si=iGZYIBfhNahVZ39n',
            // Add videos for other works here
        ];

        if (isset($videos[$workTitle])) {
            Video::create([
                'title' => $workTitle,
                'url' => $videos[$workTitle],
                'lesson_id' => $lesson->id,
            ]);
        }
    }
}
