<?php

namespace App\Http\Controllers;

use App\Models\Country;
use App\Models\Difficulty;
use App\Models\Question;
use App\Models\Choice;
use App\Models\UserAnswer;
use App\Models\UserScore;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log; 
class QuizController extends Controller
{
    public function countries()
    {
        $countries = Country::with(['difficulties.userScores' => function($query) {
            $query->where('user_id', auth()->id());
        }])->get();

        return view('quiz.countries', compact('countries'));
    }

    public function difficulties(Country $country)
    {
        $difficulties = $country->difficulties()->with(['userScores' => function($query) {
            $query->where('user_id', auth()->id());
        }])->get();

        return view('quiz.difficulties', compact('country', 'difficulties'));
    }

    public function showQuiz(Difficulty $difficulty)
    {
        $questions = $difficulty->questions()
            ->with(['choices'])
            ->inRandomOrder()
            ->limit(5) // Show 5 questions per quiz
            ->get();

        return view('quiz.show', compact('difficulty', 'questions'));
    }

public function submitQuiz(Request $request, Difficulty $difficulty)
    {
        Log::info('=== QUIZ SUBMISSION START ===');
        Log::info('User ID: ' . auth()->id());
        Log::info('Difficulty ID: ' . $difficulty->id);
        Log::info('Answers received:', $request->all());

        $request->validate([
            'answers' => 'array',
            'traps' => 'array'
        ]);

        $user = auth()->user();
        $questions = Question::with('choices')
            ->where('difficulty_id', $difficulty->id)
            ->get();

        $totalScore = 0;
        $correctAnswers = 0;
        $totalQuestions = $questions->count();

        $traps = $request->input('traps', []);

        foreach ($questions as $question) {
            $questionId = $question->id;
            $selectedChoices = $request->input("answers.{$questionId}", []);
            $isTrapMarked = isset($traps[$questionId]); // Only if user marks trap

            $correctChoiceIds = $question->choices
                ->where('is_correct', true)
                ->pluck('id')
                ->toArray();

            sort($selectedChoices);
            sort($correctChoiceIds);

            if ($isTrapMarked) {
                // User explicitly marked trap → +2 points
                $points = 2;
                $isCorrect = true;
            } else {
                // If user didn't mark trap
                if (empty($selectedChoices)) {
                    // No selection for normal question → 0 points, not correct
                    $points = 0;
                    $isCorrect = false;
                } else {
                    // User selected choices → check correctness
                    $isCorrect = $selectedChoices == $correctChoiceIds;
                    $points = $isCorrect ? $difficulty->points_per_question : -2;
                }
            }

            if ($isCorrect) $correctAnswers++;
            $totalScore += $points;

            // Save or update user's answer
            UserAnswer::updateOrCreate(
                [
                    'user_id' => $user->id,
                    'question_id' => $questionId
                ],
                [
                    'choice_ids' => json_encode($selectedChoices),
                    'is_trap' => $isTrapMarked,
                    'is_correct' => $isCorrect,
                    'points_earned' => $points
                ]
            );
        }

        // Ensure total score never goes below 0
        $totalScore = max(0, $totalScore);

        // Update or create user score
        $userScore = UserScore::updateOrCreate(
            [
                'user_id' => $user->id,
                'difficulty_id' => $difficulty->id,
            ],
            [
                'country_id' => $difficulty->country_id,
                'score' => $totalScore,
                'total_questions' => $totalQuestions,
                'correct_answers' => $correctAnswers,
                'incorrect_answers' => $totalQuestions - $correctAnswers,
                'completed_at' => now(),
            ]
        );

        Log::info("Quiz completed. Total score: {$totalScore}, Correct: {$correctAnswers}/{$totalQuestions}");
        Log::info('UserScore ID: ' . $userScore->id);
        Log::info('=== QUIZ SUBMISSION END ===');

        return redirect()->route('quiz.result-details', $userScore)
            ->with('success', 'Quiz submitted successfully! Your score: ' . $totalScore);
    }


public function results()
{
    $userScores = UserScore::with(['country', 'difficulty'])
        ->where('user_id', auth()->id())
        ->latest()
        ->paginate(10);

    return view('quiz.results', compact('userScores'));
}

public function resultDetails(UserScore $userScore)
{
    if ($userScore->user_id !== auth()->id()) {
        abort(403);
    }

    // Get user answers for this quiz
    $userAnswers = UserAnswer::with(['question.choices'])
        ->where('user_id', auth()->id())
        ->whereIn('question_id', function($query) use ($userScore) {
            $query->select('id')
                  ->from('questions')
                  ->where('difficulty_id', $userScore->difficulty_id);
        })
        ->get();

    // Decode JSON choice_ids for each answer
    foreach ($userAnswers as $answer) {
        $answer->selected_choices = json_decode($answer->choice_ids, true) ?? [];
    }

    return view('quiz.result-details', compact('userScore', 'userAnswers'));
}
}