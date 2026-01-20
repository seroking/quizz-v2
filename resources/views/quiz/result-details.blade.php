@extends('layouts.minimal')

@section('content')
<style>
    .results-container {
        max-width: 900px;
        margin: 0 auto;
    }

    .celebration-banner {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 20px;
        padding: 40px;
        color: white;
        text-align: center;
        margin-bottom: 30px;
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.15);
        position: relative;
        overflow: hidden;
    }

    .celebration-banner::before {
        content: '🎉';
        position: absolute;
        font-size: 5rem;
        opacity: 0.1;
        left: -20px;
        top: -20px;
    }

    .celebration-banner::after {
        content: '✨';
        position: absolute;
        font-size: 4rem;
        opacity: 0.1;
        right: -20px;
        bottom: -20px;
    }

    .celebration-content {
        position: relative;
        z-index: 2;
    }

    .result-emoji {
        font-size: 4rem;
        margin-bottom: 15px;
        animation: bounce 0.6s ease-in-out;
    }

    @keyframes bounce {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-20px); }
    }

    .result-message {
        font-size: 2rem;
        font-weight: 800;
        margin-bottom: 10px;
        letter-spacing: 0.5px;
    }

    .result-subtitle {
        font-size: 1.1rem;
        opacity: 0.95;
    }

    .score-display {
        background: white;
        border-radius: 20px;
        padding: 40px;
        margin-bottom: 30px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
    }

    .score-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
        gap: 20px;
        margin-bottom: 20px;
    }

    .score-item {
        text-align: center;
        padding: 20px;
        background: linear-gradient(135deg, #f9fafb, #f3f4f6);
        border-radius: 15px;
        border-top: 3px solid var(--primary);
    }

    .score-item.success {
        border-top-color: var(--success);
    }

    .score-item.info {
        border-top-color: var(--info);
    }

    .score-item.warning {
        border-top-color: var(--warning);
    }

    .score-label {
        font-size: 0.85rem;
        color: #6b7280;
        text-transform: uppercase;
        letter-spacing: 1px;
        font-weight: 700;
        margin-bottom: 8px;
    }

    .score-value {
        font-size: 2rem;
        font-weight: 800;
        background: linear-gradient(135deg, var(--primary), var(--secondary));
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    .score-item.success .score-value {
        background: linear-gradient(135deg, var(--success), #059669);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    .score-item.info .score-value {
        background: linear-gradient(135deg, var(--info), #0891b2);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    .score-item.warning .score-value {
        background: linear-gradient(135deg, var(--warning), #d97706);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    .score-percentage {
        width: 100%;
        height: 6px;
        background: #e5e7eb;
        border-radius: 10px;
        margin-top: 15px;
        overflow: hidden;
    }

    .score-percentage-bar {
        height: 100%;
        background: linear-gradient(90deg, var(--primary), var(--secondary));
        border-radius: 10px;
        transition: width 1.5s cubic-bezier(0.34, 1.56, 0.64, 1);
        animation: fillBar 1.5s ease-in-out;
    }

    @keyframes fillBar {
        from { width: 0%; }
    }

    .knowledge-badge {
        display: inline-block;
        padding: 10px 25px;
        border-radius: 25px;
        font-weight: 700;
        font-size: 1rem;
        margin-top: 15px;
    }

    .knowledge-badge.excellent {
        background: linear-gradient(135deg, #dbeafe, #bfdbfe);
        color: #0c4a6e;
    }

    .knowledge-badge.good {
        background: linear-gradient(135deg, #dcfce7, #bbf7d0);
        color: #14532d;
    }

    .knowledge-badge.average {
        background: linear-gradient(135deg, #fef3c7, #fde68a);
        color: #78350f;
    }

    .knowledge-badge.poor {
        background: linear-gradient(135deg, #fee2e2, #fecaca);
        color: #7c2d12;
    }

    .questions-section {
        margin-bottom: 40px;
    }

    .section-title {
        font-size: 1.8rem;
        font-weight: 800;
        color: var(--primary);
        margin-bottom: 25px;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .question-result {
        background: white;
        border-radius: 15px;
        overflow: hidden;
        margin-bottom: 20px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
        border-left: 5px solid transparent;
        transition: all 0.3s ease;
    }

    .question-result:hover {
        transform: translateX(5px);
        box-shadow: 0 15px 40px rgba(0, 0, 0, 0.12);
    }

    .question-result.correct {
        border-left-color: var(--success);
    }

    .question-result.incorrect {
        border-left-color: var(--danger);
    }

    .question-result.trap {
        border-left-color: var(--info);
    }

    .result-header {
        padding: 20px;
        background: #f9fafb;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .result-status {
        display: flex;
        align-items: center;
        gap: 10px;
        font-weight: 700;
    }

    .result-status.correct {
        color: var(--success);
    }

    .result-status.incorrect {
        color: var(--danger);
    }

    .result-status.trap {
        color: var(--info);
    }

    .points-earned {
        font-weight: 700;
        font-size: 1.1rem;
    }

    .points-earned.positive {
        color: var(--success);
    }

    .points-earned.negative {
        color: var(--danger);
    }

    .result-body {
        padding: 20px;
    }

    .question-text {
        font-size: 1.1rem;
        font-weight: 700;
        color: #1f2937;
        margin-bottom: 20px;
    }

    .question-explanation {
        background: #fef3c7;
        border-left: 4px solid var(--warning);
        padding: 15px;
        border-radius: 8px;
        margin-bottom: 20px;
        color: #78350f;
    }

    .answer-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 15px;
    }

    .answer-box {
        padding: 15px;
        background: #f9fafb;
        border-radius: 10px;
        border-left: 4px solid #d1d5db;
    }

    .answer-box.correct {
        background: #f0fdf4;
        border-left-color: var(--success);
    }

    .answer-box.wrong {
        background: #fef2f2;
        border-left-color: var(--danger);
    }

    .answer-box-label {
        font-size: 0.85rem;
        color: #6b7280;
        text-transform: uppercase;
        letter-spacing: 1px;
        font-weight: 700;
        margin-bottom: 8px;
    }

    .answer-box-content {
        color: #374151;
        font-size: 0.95rem;
        line-height: 1.6;
    }

    .action-buttons {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
        gap: 15px;
        margin-top: 40px;
        padding-top: 30px;
        border-top: 2px solid #e5e7eb;
    }

    .action-btn {
        padding: 14px;
        border-radius: 10px;
        font-weight: 700;
        text-decoration: none;
        text-align: center;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        border: none;
        cursor: pointer;
    }

    .action-btn.primary {
        background: linear-gradient(135deg, var(--primary), var(--secondary));
        color: white;
    }

    .action-btn.primary:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 25px rgba(99, 102, 241, 0.3);
        color: white;
    }

    .action-btn.secondary {
        background: #f3f4f6;
        color: var(--primary);
        border: 2px solid var(--primary);
    }

    .action-btn.secondary:hover {
        transform: translateY(-3px);
        background: var(--primary);
        color: white;
    }

    .trap-badge {
        display: inline-block;
        background: linear-gradient(135deg, #cffafe, #a5f3fc);
        color: #164e63;
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: 700;
    }
</style>

<div class="results-container">
    @if(session('success'))
    <div style="background: linear-gradient(135deg, #d1fae5, #a7f3d0); color: #065f46; padding: 15px; border-radius: 10px; margin-bottom: 20px; font-weight: 600;">
        <i class="fas fa-check-circle"></i> {{ session('success') }}
    </div>
    @endif

    @php
        $percentage = $userScore->total_questions > 0 
            ? round(($userScore->correct_answers / $userScore->total_questions) * 100) 
            : 0;
        
        if ($percentage == 100) {
            $knowledgeMessage = 'Perfect! Outstanding Knowledge';
            $messageClass = 'excellent';
            $messageIcon = '⭐';
        } elseif ($percentage >= 80) {
            $knowledgeMessage = 'Excellent! Great Knowledge';
            $messageClass = 'excellent';
            $messageIcon = '🌟';
        } elseif ($percentage >= 60) {
            $knowledgeMessage = 'Good! Nice Job';
            $messageClass = 'good';
            $messageIcon = '✨';
        } elseif ($percentage >= 40) {
            $knowledgeMessage = 'Average, Keep Learning';
            $messageClass = 'average';
            $messageIcon = '📚';
        } else {
            $knowledgeMessage = 'Need More Practice';
            $messageClass = 'poor';
            $messageIcon = '💪';
        }
    @endphp

    <div class="celebration-banner">
        <div class="celebration-content">
            <div class="result-emoji">{{ $messageIcon }}</div>
            <div class="result-message">{{ $knowledgeMessage }}</div>
            <div class="result-subtitle">{{ $userScore->country->name }} - {{ ucfirst($userScore->difficulty->level) }} Level</div>
        </div>
    </div>

    <div class="score-display">
        <div class="score-grid">
            <div class="score-item success">
                <div class="score-label">Total Score</div>
                <div class="score-value">{{ $userScore->score }}</div>
            </div>
            <div class="score-item success">
                <div class="score-label">Correct</div>
                <div class="score-value">{{ $userScore->correct_answers }}/{{ $userScore->total_questions }}</div>
            </div>
            <div class="score-item info">
                <div class="score-label">Percentage</div>
                <div class="score-value">{{ $percentage }}%</div>
            </div>
            <div class="score-item warning">
                <div class="score-label">Completed</div>
                <div class="score-value" style="font-size: 0.9rem; line-height: 1.3;">{{ $userScore->completed_at->format('H:i') }}<br><small style="opacity: 0.7; font-size: 0.7rem;">{{ $userScore->completed_at->format('M d') }}</small></div>
            </div>
        </div>

        <div class="score-percentage">
            <div class="score-percentage-bar" style="width: {{ $percentage }}%;"></div>
        </div>

        <div style="text-align: center;">
            <span class="knowledge-badge {{ $messageClass }}">
                {{ $knowledgeMessage }}
            </span>
        </div>
    </div>

    <div class="questions-section">
        <h2 class="section-title">
            <i class="fas fa-list-check"></i> Question Breakdown
        </h2>

        @forelse($userAnswers as $index => $userAnswer)
            @php
                $question = $userAnswer->question;
                $isCorrect = $userAnswer->is_correct;
                $isTrap = $userAnswer->is_trap;
                $points = $userAnswer->points_earned;
            @endphp

            <div class="question-result {{ $isCorrect ? 'correct' : ($isTrap ? 'trap' : 'incorrect') }}">
                <div class="result-header">
                    <div style="flex: 1;">
                        <strong>Question {{ $index + 1 }} of {{ $userAnswers->count() }}</strong>
                    </div>
                    <div class="result-status {{ $isCorrect ? 'correct' : ($isTrap ? 'trap' : 'incorrect') }}">
                        @if($isTrap)
                            <i class="fas fa-exclamation-triangle"></i> Trap Marked
                        @elseif($isCorrect)
                            <i class="fas fa-check-circle"></i> Correct
                        @else
                            <i class="fas fa-times-circle"></i> Incorrect
                        @endif
                    </div>
                    <div class="points-earned {{ $points >= 0 ? 'positive' : 'negative' }}">
                        {{ $points >= 0 ? '+' : '' }}{{ $points }} pts
                    </div>
                </div>

                <div class="result-body">
                    <div class="question-text">{{ $question->question_text }}</div>

                    @if($question->explanation)
                    <div class="question-explanation">
                        <i class="fas fa-lightbulb"></i> <strong>Explanation:</strong> {{ $question->explanation }}
                    </div>
                    @endif

                    <div class="answer-grid">
                        <div class="answer-box correct">
                            <div class="answer-box-label">Correct Answer(s)</div>
                            <div class="answer-box-content">
                                @foreach($question->choices->where('is_correct', true) as $choice)
                                    <div style="margin: 5px 0;">✓ {{ $choice->choice_text }}</div>
                                @endforeach
                            </div>
                        </div>

                        <div class="answer-box {{ $isCorrect ? 'correct' : 'wrong' }}">
                            <div class="answer-box-label">Your Answer{{ count($userAnswer->selected_choices) > 1 ? 's' : '' }}</div>
                            <div class="answer-box-content">
                                @if($isTrap)
                                    <span class="trap-badge"><i class="fas fa-exclamation-triangle"></i> Trap Question</span>
                                @elseif(count($userAnswer->selected_choices) > 0)
                                    @foreach($question->choices->whereIn('id', $userAnswer->selected_choices) as $choice)
                                        <div style="margin: 5px 0;">→ {{ $choice->choice_text }}</div>
                                    @endforeach
                                @else
                                    <em style="color: #9ca3af;">No answer selected</em>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div style="text-align: center; padding: 40px; background: #f9fafb; border-radius: 15px;">
                <i class="fas fa-inbox" style="font-size: 3rem; color: #d1d5db; margin-bottom: 10px;"></i>
                <p style="color: #9ca3af; font-size: 1.1rem;">No questions found</p>
            </div>
        @endforelse
    </div>

    <div class="action-buttons">
        <a href="{{ route('dashboard') }}" class="action-btn secondary">
            <i class="fas fa-home"></i> Dashboard
        </a>
        <a href="{{ route('countries.index') }}" class="action-btn primary">
            <i class="fas fa-redo"></i> New Quiz
        </a>
        <a href="{{ route('quiz.results') }}" class="action-btn secondary">
            <i class="fas fa-history"></i> All Results
        </a>
    </div>
</div>

@endsection