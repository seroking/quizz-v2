@extends('layouts.minimal')

@section('content')
<style>
    .quiz-container {
        max-width: 800px;
        margin: 0 auto;
    }

    .quiz-header {
        background: white;
        border-radius: 20px;
        padding: 30px;
        margin-bottom: 30px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
    }

    .quiz-title {
        color: var(--primary);
        font-weight: 800;
        font-size: 1.8rem;
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        gap: 15px;
    }

    .quiz-title .flag {
        font-size: 2.5rem;
    }

    .progress-section {
        margin-bottom: 20px;
    }

    .progress-label {
        display: flex;
        justify-content: space-between;
        margin-bottom: 8px;
        font-weight: 600;
        color: #6b7280;
        font-size: 0.9rem;
    }

    .progress {
        height: 8px;
        background: #e5e7eb;
        border-radius: 10px;
        overflow: hidden;
    }

    .progress-bar {
        background: linear-gradient(90deg, #6366f1, #8b5cf6, #ec4899);
        height: 100%;
        transition: width 0.5s ease;
        border-radius: 10px;
    }

    .rules-box {
        background: linear-gradient(135deg, #f0f9ff, #e0f2fe);
        border-left: 4px solid var(--primary);
        padding: 20px;
        border-radius: 10px;
        margin-bottom: 15px;
    }

    .rules-title {
        font-weight: 700;
        color: var(--primary);
        margin-bottom: 10px;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .rules-list {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .rules-list li {
        padding: 5px 0;
        color: #4b5563;
        font-size: 0.9rem;
        display: flex;
        gap: 8px;
    }

    .rules-list li::before {
        content: '✓';
        color: var(--success);
        font-weight: bold;
        min-width: 20px;
    }

    .question-card {
        background: white;
        border-radius: 20px;
        padding: 30px;
        margin-bottom: 25px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease;
        animation: slideIn 0.5s ease forwards;
        opacity: 0;
    }

    @keyframes slideIn {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @for ($i = 1; $i <= 5; $i++) {
        .question-card:nth-child({{ $i }}) {
            animation-delay: {{ 0.1 * $i }}s;
        }
    }

    .question-number {
        display: inline-block;
        background: linear-gradient(135deg, #6366f1, #8b5cf6);
        color: white;
        padding: 6px 14px;
        border-radius: 20px;
        font-weight: 700;
        font-size: 0.85rem;
        margin-bottom: 15px;
    }

    .question-text {
        font-size: 1.3rem;
        font-weight: 700;
        color: #1f2937;
        margin-bottom: 25px;
        line-height: 1.6;
    }

    .question-explanation {
        background: #fef3c7;
        border-left: 4px solid #f59e0b;
        padding: 15px;
        border-radius: 8px;
        margin-bottom: 20px;
        font-size: 0.95rem;
        color: #78350f;
    }

    .trap-section {
        margin-bottom: 20px;
        padding: 15px;
        background: #fef2f2;
        border-radius: 10px;
        border-left: 4px solid #ef4444;
    }

    .trap-checkbox-wrapper {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .trap-checkbox-wrapper input[type="checkbox"] {
        width: 20px;
        height: 20px;
        cursor: pointer;
        accent-color: #ef4444;
    }

    .trap-checkbox-label {
        font-weight: 700;
        color: #ef4444;
        cursor: pointer;
        user-select: none;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .choices-section {
        margin-bottom: 0;
    }

    .choice-item {
        display: flex;
        align-items: flex-start;
        gap: 12px;
        padding: 15px;
        margin-bottom: 10px;
        background: #f9fafb;
        border-radius: 10px;
        transition: all 0.3s ease;
        cursor: pointer;
        border: 2px solid transparent;
    }

    .choice-item:hover {
        background: #f3f4f6;
        border-color: var(--primary);
        transform: translateX(5px);
    }

    .choice-item input[type="checkbox"] {
        width: 20px;
        height: 20px;
        margin-top: 2px;
        cursor: pointer;
        accent-color: var(--primary);
    }

    .choice-item.disabled {
        opacity: 0.6;
        pointer-events: none;
        background: #e5e7eb;
    }

    .choice-text {
        color: #374151;
        font-size: 1rem;
        line-height: 1.5;
    }

    .submit-section {
        position: sticky;
        bottom: 0;
        background: white;
        padding: 20px;
        border-radius: 20px;
        box-shadow: 0 -10px 30px rgba(0, 0, 0, 0.1);
        margin-top: 30px;
    }

    .submit-btn {
        width: 100%;
        padding: 16px;
        background: linear-gradient(135deg, #6366f1, #8b5cf6);
        color: white;
        border: none;
        border-radius: 10px;
        font-weight: 700;
        font-size: 1.1rem;
        cursor: pointer;
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }

    .submit-btn::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: rgba(255, 255, 255, 0.2);
        transition: left 0.5s ease;
    }

    .submit-btn:hover:not(:disabled) {
        transform: translateY(-3px);
        box-shadow: 0 15px 35px rgba(99, 102, 241, 0.4);
    }

    .submit-btn:hover:not(:disabled)::before {
        left: 100%;
    }

    .submit-btn:disabled {
        opacity: 0.7;
        cursor: not-allowed;
    }

    .question-count {
        text-align: center;
        color: #9ca3af;
        font-size: 0.9rem;
        margin-top: 10px;
    }

    .submit-btn span {
        position: relative;
        z-index: 2;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
    }
</style>

<div class="quiz-container">
    <div class="quiz-header">
        <div class="quiz-title">
            <span class="flag">{{ $difficulty->country->flag_emoji ?? '🏴' }}</span>
            <div>
                <div>{{ $difficulty->country->name }}</div>
                <small style="color: #9ca3af; font-size: 0.9rem;">{{ ucfirst($difficulty->level) }} Level</small>
            </div>
        </div>

        <div class="progress-section">
            <div class="progress-label">
                <span>Progress</span>
                <span id="progress-text">0 / {{ count($questions) }} answered</span>
            </div>
            <div class="progress">
                <div class="progress-bar" id="progress-bar" style="width: 0%;"></div>
            </div>
        </div>

        <div class="rules-box">
            <div class="rules-title">
                <i class="fas fa-info-circle"></i> Scoring Rules
            </div>
            <ul class="rules-list">
                <li>Correct Answer: <strong>+{{ $difficulty->points_per_question }} points</strong></li>
                <li>Wrong Answer: <strong>-2 points</strong></li>
                <li>Trap Marked: <strong>+2 points</strong></li>
                <li>Select ALL correct answers to get points</li>
            </ul>
        </div>
    </div>

    <form action="{{ route('quiz.submit', $difficulty) }}" method="POST" id="quiz-form">
        @csrf
        
        @foreach($questions as $index => $question)
        <div class="question-card" data-question-id="{{ $question->id }}">
            <span class="question-number">Question {{ $index + 1 }} of {{ count($questions) }}</span>
            
            <div class="question-text">{{ $question->question_text }}</div>

            @if($question->explanation)
            <div class="question-explanation">
                <i class="fas fa-lightbulb"></i> {{ $question->explanation }}
            </div>
            @endif
            
            <div class="trap-section">
                <div class="trap-checkbox-wrapper">
                    <input class="form-check-input trap-checkbox" type="checkbox" 
                           name="traps[{{ $question->id }}]" 
                           id="trap{{ $question->id }}" value="1">
                    <label class="trap-checkbox-label" for="trap{{ $question->id }}">
                        <i class="fas fa-exclamation-triangle"></i> Mark as Trap Question
                    </label>
                </div>
            </div>

            <div class="choices-section">
                @foreach($question->choices as $choice)
                <div class="choice-item">
                    <input class="form-check-input choice-checkbox" type="checkbox" 
                           name="answers[{{ $question->id }}][]" 
                           value="{{ $choice->id }}" 
                           id="q{{ $question->id }}c{{ $choice->id }}">
                    <label class="choice-text" for="q{{ $question->id }}c{{ $choice->id }}">
                        {{ $choice->choice_text }}
                    </label>
                </div>
                @endforeach
            </div>
        </div>
        @endforeach
        
        <div class="submit-section">
            <button type="submit" class="submit-btn" id="submit-btn">
                <span>
                    <i class="fas fa-check-circle"></i> Submit Quiz
                </span>
            </button>
            <p class="question-count">
                <i class="fas fa-list"></i> {{ count($questions) }} total questions
            </p>
        </div>
    </form>
</div>

<script>
    // Update progress
    function updateProgress() {
        const totalQuestions = {{ count($questions) }};
        const answeredCount = document.querySelectorAll('input[type="checkbox"]:checked').length;
        const percentage = (answeredCount / totalQuestions) * 100;
        
        document.getElementById('progress-bar').style.width = percentage + '%';
        document.getElementById('progress-text').textContent = answeredCount + ' / ' + totalQuestions + ' answered';
    }

    // Add event listeners to all checkboxes
    document.querySelectorAll('input[type="checkbox"]').forEach(checkbox => {
        checkbox.addEventListener('change', updateProgress);
    });

    // Trap checkbox logic
    document.querySelectorAll('.trap-checkbox').forEach(trapCheckbox => {
        trapCheckbox.addEventListener('change', function() {
            const questionCard = this.closest('.question-card');
            const choiceCheckboxes = questionCard.querySelectorAll('.choice-checkbox');
            
            if (this.checked) {
                choiceCheckboxes.forEach(cb => {
                    cb.checked = false;
                    cb.closest('.choice-item').classList.add('disabled');
                });
            } else {
                choiceCheckboxes.forEach(cb => {
                    cb.closest('.choice-item').classList.remove('disabled');
                });
            }
            updateProgress();
        });
    });

    // Form submission
    document.getElementById('quiz-form').addEventListener('submit', function(e) {
        const submitBtn = document.getElementById('submit-btn');
        const answered = document.querySelectorAll('input[type="checkbox"]:checked');
        
        if (answered.length === 0) {
            if (!confirm('You haven\'t answered any questions. Submit anyway?')) {
                e.preventDefault();
                return false;
            }
        }

        if (!confirm('⚠️ Are you sure? You cannot change answers after submission.')) {
            e.preventDefault();
            return false;
        }

        submitBtn.disabled = true;
        submitBtn.innerHTML = '<span><i class="fas fa-spinner fa-spin"></i> Submitting...</span>';
        return true;
    });

    // Click choice to select checkbox
    document.querySelectorAll('.choice-item').forEach(item => {
        item.addEventListener('click', function(e) {
            if (e.target.tagName !== 'INPUT') {
                const checkbox = this.querySelector('input[type="checkbox"]');
                if (!checkbox.closest('.choice-item').classList.contains('disabled')) {
                    checkbox.checked = !checkbox.checked;
                    updateProgress();
                }
            }
        });
    });

    // Initial progress update
    updateProgress();
</script>

@endsection
