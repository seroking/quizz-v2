<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Country;
use App\Models\Difficulty;
use App\Models\Question;
use App\Models\Choice;

class RussiaQuizSeeder extends Seeder
{
    public function run(): void
    {
        // Create Russia
        $russia = Country::create([
            'name' => 'Russia',
            'code' => 'RUS',
            'flag_emoji' => '🇷🇺'
        ]);

        // Difficulties
        $easy = Difficulty::create([
            'country_id' => $russia->id,
            'level' => 'easy',
            'points_per_question' => 2
        ]);

        $medium = Difficulty::create([
            'country_id' => $russia->id,
            'level' => 'medium',
            'points_per_question' => 2
        ]);

        $hard = Difficulty::create([
            'country_id' => $russia->id,
            'level' => 'hard',
            'points_per_question' => 3
        ]);

        // EASY QUESTIONS
        $easyQuestions = [
            [
                'question_text' => 'What is the capital city of Russia?',
                'explanation' => 'Moscow is the capital of Russia.',
                'choices' => [
                    ['text' => 'Moscow', 'is_correct' => true],
                    ['text' => 'Saint Petersburg', 'is_correct' => false],
                    ['text' => 'Novosibirsk', 'is_correct' => false],
                ]
            ],
            [
                'question_text' => 'Which languages are official in Russia?',
                'explanation' => 'Russian is the official language, Tatar is regional.',
                'choices' => [
                    ['text' => 'Russian', 'is_correct' => true],
                    ['text' => 'English', 'is_correct' => false],
                    ['text' => 'Tatar', 'is_correct' => true],
                ]
            ],
            [
                'question_text' => 'Which colors are on the Russian flag?',
                'explanation' => 'The Russian flag has white, blue, and red.',
                'choices' => [
                    ['text' => 'White', 'is_correct' => true],
                    ['text' => 'Blue', 'is_correct' => true],
                    ['text' => 'Green', 'is_correct' => false],
                    ['text' => 'Red', 'is_correct' => true],
                ]
            ],
            // EASY TRAP QUESTION (real-looking)
            [
                'question_text' => 'Which of these animals are native to Russia?',
                'explanation' => 'None of the options are strictly native to Russia. Leaving blank is correct.',
                'choices' => [
                    ['text' => 'Kangaroo', 'is_correct' => false],
                    ['text' => 'Koala', 'is_correct' => false],
                    ['text' => 'Emu', 'is_correct' => false],
                ]
            ]
        ];

        // MEDIUM QUESTIONS
        $mediumQuestions = [
            [
                'question_text' => 'Which of the following are Russian cities?',
                'explanation' => 'Moscow, Saint Petersburg, and Novosibirsk are Russian cities.',
                'choices' => [
                    ['text' => 'Moscow', 'is_correct' => true],
                    ['text' => 'Saint Petersburg', 'is_correct' => true],
                    ['text' => 'Berlin', 'is_correct' => false],
                    ['text' => 'Novosibirsk', 'is_correct' => true],
                ]
            ],
            [
                'question_text' => 'Select the rivers that flow in Russia.',
                'explanation' => 'Volga and Lena are major Russian rivers.',
                'choices' => [
                    ['text' => 'Volga', 'is_correct' => true],
                    ['text' => 'Danube', 'is_correct' => false],
                    ['text' => 'Lena', 'is_correct' => true],
                    ['text' => 'Amazon', 'is_correct' => false],
                ]
            ],
            [
                'question_text' => 'Which mountain ranges are in Russia?',
                'explanation' => 'The Ural and Caucasus mountains are in Russia.',
                'choices' => [
                    ['text' => 'Ural', 'is_correct' => true],
                    ['text' => 'Caucasus', 'is_correct' => true],
                    ['text' => 'Himalayas', 'is_correct' => false],
                    ['text' => 'Andes', 'is_correct' => false],
                ]
            ],
            // MEDIUM TRAP QUESTION (real-looking)
            [
                'question_text' => 'Which of these countries border Russia in Africa?',
                'explanation' => 'Russia does not border any African country. Leave blank.',
                'choices' => [
                    ['text' => 'Egypt', 'is_correct' => false],
                    ['text' => 'South Africa', 'is_correct' => false],
                    ['text' => 'Nigeria', 'is_correct' => false],
                ]
            ]
        ];

        // HARD QUESTIONS
        $hardQuestions = [
            [
                'question_text' => 'Which Russian leader ended the Soviet Union?',
                'explanation' => 'Mikhail Gorbachev played a key role in ending the USSR.',
                'choices' => [
                    ['text' => 'Mikhail Gorbachev', 'is_correct' => true],
                    ['text' => 'Vladimir Putin', 'is_correct' => false],
                    ['text' => 'Boris Yeltsin', 'is_correct' => false],
                ]
            ],
            [
                'question_text' => 'Which sea borders Russia to the south?',
                'explanation' => 'The Caspian Sea borders Russia to the south.',
                'choices' => [
                    ['text' => 'Caspian Sea', 'is_correct' => true],
                    ['text' => 'Black Sea', 'is_correct' => false],
                    ['text' => 'Baltic Sea', 'is_correct' => false],
                ]
            ],
            // HARD TRAP QUESTION (real-looking)
            [
                'question_text' => 'Which of these islands are in the Mediterranean Sea belonging to Russia?',
                'explanation' => 'Russia has no Mediterranean islands. The correct action is to leave blank.',
                'choices' => [
                    ['text' => 'Sicily', 'is_correct' => false],
                    ['text' => 'Corsica', 'is_correct' => false],
                    ['text' => 'Crete', 'is_correct' => false],
                ]
            ]
        ];

        // Create questions in DB
        $this->createQuestions($easy, $easyQuestions);
        $this->createQuestions($medium, $mediumQuestions);
        $this->createQuestions($hard, $hardQuestions);
    }

    private function createQuestions($difficulty, array $questions)
    {
        foreach ($questions as $q) {
            $question = Question::create([
                'difficulty_id' => $difficulty->id,
                'question_text' => $q['question_text'],
                'explanation' => $q['explanation']
            ]);

            foreach ($q['choices'] as $choice) {
                Choice::create([
                    'question_id' => $question->id,
                    'choice_text' => $choice['text'],
                    'is_correct' => $choice['is_correct']
                ]);
            }
        }
    }
}
