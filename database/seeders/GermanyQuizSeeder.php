<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Country;
use App\Models\Difficulty;
use App\Models\Question;
use App\Models\Choice;

class GermanyQuizSeeder extends Seeder
{
    public function run(): void
    {
        // Create Germany (avoid duplicates)
        $germany = Country::firstOrCreate(
            ['code' => 'GER'],
            [
                'name' => 'Germany',
                'flag_emoji' => '🇩🇪'
            ]
        );

        // Difficulties
        $easy = Difficulty::firstOrCreate(
            ['country_id' => $germany->id, 'level' => 'easy'],
            ['points_per_question' => 2]
        );

        $medium = Difficulty::firstOrCreate(
            ['country_id' => $germany->id, 'level' => 'medium'],
            ['points_per_question' => 2]
        );

        $hard = Difficulty::firstOrCreate(
            ['country_id' => $germany->id, 'level' => 'hard'],
            ['points_per_question' => 3]
        );

        // EASY QUESTIONS + trap
        $easyQuestions = [
            [
                'question_text' => 'What is the capital of Germany?',
                'explanation' => 'Berlin is the capital city.',
                'choices' => [
                    ['text' => 'Berlin', 'is_correct' => true],
                    ['text' => 'Munich', 'is_correct' => false],
                    ['text' => 'Frankfurt', 'is_correct' => false],
                ]
            ],
            [
                'question_text' => 'Which languages are official in Germany?',
                'explanation' => 'German is the official language.',
                'choices' => [
                    ['text' => 'German', 'is_correct' => true],
                    ['text' => 'English', 'is_correct' => false],
                    ['text' => 'French', 'is_correct' => false],
                ]
            ],
            // EASY TRAP
            [
                'question_text' => 'Trap Question: Do NOT select any option',
                'explanation' => 'This is a trick! Selecting anything gives -2, leaving blank gives +2.',
                'choices' => [
                    ['text' => 'Option A', 'is_correct' => false],
                    ['text' => 'Option B', 'is_correct' => false],
                    ['text' => 'Option C', 'is_correct' => false],
                ]
            ]
        ];

        // MEDIUM QUESTIONS + trap
        $mediumQuestions = [
            [
                'question_text' => 'Which German cities are in Bavaria?',
                'explanation' => 'Munich and Nuremberg are in Bavaria.',
                'choices' => [
                    ['text' => 'Munich', 'is_correct' => true],
                    ['text' => 'Nuremberg', 'is_correct' => true],
                    ['text' => 'Hamburg', 'is_correct' => false],
                    ['text' => 'Cologne', 'is_correct' => false],
                ]
            ],
            [
                'question_text' => 'Select major rivers in Germany.',
                'explanation' => 'The Rhine and Elbe are major rivers.',
                'choices' => [
                    ['text' => 'Rhine', 'is_correct' => true],
                    ['text' => 'Elbe', 'is_correct' => true],
                    ['text' => 'Danube', 'is_correct' => true],
                    ['text' => 'Seine', 'is_correct' => false],
                ]
            ],
            // MEDIUM TRAP
            [
                'question_text' => 'Trap Question: Do NOT select any option',
                'explanation' => 'Trick question! Leave blank to get +2, selecting anything gives -2.',
                'choices' => [
                    ['text' => 'Choice 1', 'is_correct' => false],
                    ['text' => 'Choice 2', 'is_correct' => false],
                    ['text' => 'Choice 3', 'is_correct' => false],
                ]
            ]
        ];

        // HARD QUESTIONS + trap
        $hardQuestions = [
            [
                'question_text' => 'Who was the Chancellor of Germany during reunification?',
                'explanation' => 'Helmut Kohl led Germany during reunification.',
                'choices' => [
                    ['text' => 'Helmut Kohl', 'is_correct' => true],
                    ['text' => 'Angela Merkel', 'is_correct' => false],
                    ['text' => 'Konrad Adenauer', 'is_correct' => false],
                ]
            ],
            [
                'question_text' => 'Which German region is known for the Black Forest?',
                'explanation' => 'The Black Forest is in Baden-Württemberg.',
                'choices' => [
                    ['text' => 'Baden-Württemberg', 'is_correct' => true],
                    ['text' => 'Bavaria', 'is_correct' => false],
                    ['text' => 'Saxony', 'is_correct' => false],
                ]
            ],
            // HARD TRAP
            [
                'question_text' => 'Trap Question: Do NOT select any option',
                'explanation' => 'Tricky! Leave blank for +3 points, selecting anything gives -3.',
                'choices' => [
                    ['text' => 'Option X', 'is_correct' => false],
                    ['text' => 'Option Y', 'is_correct' => false],
                    ['text' => 'Option Z', 'is_correct' => false],
                ]
            ]
        ];

        // Save questions
        $this->createQuestions($easy, $easyQuestions);
        $this->createQuestions($medium, $mediumQuestions);
        $this->createQuestions($hard, $hardQuestions);
    }

    private function createQuestions($difficulty, array $questions)
    {
        foreach ($questions as $q) {
            $question = Question::firstOrCreate(
                ['difficulty_id' => $difficulty->id, 'question_text' => $q['question_text']],
                ['explanation' => $q['explanation']]
            );

            foreach ($q['choices'] as $choice) {
                Choice::firstOrCreate(
                    ['question_id' => $question->id, 'choice_text' => $choice['text']],
                    ['is_correct' => $choice['is_correct']]
                );
            }
        }
    }
}
