@extends('layouts.minimal')

@section('content')
<style>
    .back-btn {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        color: white;
        text-decoration: none;
        font-weight: 600;
        margin-bottom: 30px;
        transition: all 0.3s ease;
        padding: 10px 20px;
        border-radius: 10px;
        background: rgba(255, 255, 255, 0.1);
    }

    .back-btn:hover {
        background: rgba(255, 255, 255, 0.2);
        transform: translateX(-5px);
        color: white;
    }

    .page-hero {
        text-align: center;
        margin-bottom: 60px;
        color: white;
        position: relative;
    }

    .hero-flag {
        font-size: 5rem;
        margin-bottom: 20px;
        animation: bounce 2s infinite;
    }

    @keyframes bounce {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-15px); }
    }

    .hero-title {
        font-size: 2.8rem;
        font-weight: 900;
        margin-bottom: 10px;
        text-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        letter-spacing: -1px;
    }

    .hero-subtitle {
        font-size: 1.2rem;
        opacity: 0.95;
        margin: 0;
        font-weight: 500;
    }

    .difficulties-wrapper {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
        gap: 35px;
        margin-bottom: 40px;
    }

    .difficulty-card-modern {
        background: white;
        border-radius: 25px;
        overflow: hidden;
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.12);
        transition: all 0.5s cubic-bezier(0.34, 1.56, 0.64, 1);
        cursor: pointer;
        position: relative;
        height: 100%;
        display: flex;
        flex-direction: column;
        border: 3px solid transparent;
    }

    .difficulty-card-modern.easy {
        border-top-color: #10b981;
        border-left-color: #10b981;
    }

    .difficulty-card-modern.medium {
        border-top-color: #f59e0b;
        border-left-color: #f59e0b;
    }

    .difficulty-card-modern.hard {
        border-top-color: #ef4444;
        border-left-color: #ef4444;
    }

    .difficulty-card-modern:hover {
        transform: translateY(-20px) scale(1.05);
        box-shadow: 0 40px 80px rgba(0, 0, 0, 0.2);
        border-top-width: 5px;
        border-left-width: 5px;
    }

    .difficulty-visual {
        width: 100%;
        padding: 50px 30px;
        text-align: center;
        font-size: 4rem;
        position: relative;
    }

    .difficulty-visual.easy {
        background: linear-gradient(135deg, #d1fae5, #a7f3d0);
    }

    .difficulty-visual.medium {
        background: linear-gradient(135deg, #fef3c7, #fde68a);
    }

    .difficulty-visual.hard {
        background: linear-gradient(135deg, #fee2e2, #fecaca);
    }

    .difficulty-content {
        padding: 35px;
        flex-grow: 1;
        display: flex;
        flex-direction: column;
    }

    .difficulty-label {
        font-size: 2rem;
        font-weight: 900;
        margin-bottom: 10px;
        background: linear-gradient(135deg, #6366f1, #8b5cf6);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    .difficulty-points {
        display: inline-block;
        padding: 8px 16px;
        background: #f3f4f6;
        border-radius: 20px;
        font-weight: 700;
        font-size: 0.85rem;
        color: #6b7280;
        margin-bottom: 20px;
        width: fit-content;
    }

    .difficulty-description {
        color: #6b7280;
        margin-bottom: 20px;
        font-size: 0.95rem;
        line-height: 1.6;
        flex-grow: 1;
    }

    .score-badge-modern {
        background: linear-gradient(135deg, #f0f9ff, #e0f2fe);
        padding: 18px;
        border-radius: 15px;
        margin-bottom: 20px;
        border-left: 4px solid #0284c7;
    }

    .score-badge-modern.medium {
        background: linear-gradient(135deg, #fffbeb, #fef3c7);
        border-left-color: #f59e0b;
    }

    .score-badge-modern.hard {
        background: linear-gradient(135deg, #fef2f2, #fee2e2);
        border-left-color: #ef4444;
    }

    .score-label-modern {
        font-size: 0.75rem;
        color: #6b7280;
        text-transform: uppercase;
        letter-spacing: 1.5px;
        font-weight: 800;
        margin-bottom: 8px;
    }

    .score-value-modern {
        font-size: 1.8rem;
        font-weight: 900;
        background: linear-gradient(135deg, #0284c7, #0369a1);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    .score-badge-modern.medium .score-value-modern {
        background: linear-gradient(135deg, #f59e0b, #d97706);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    .score-badge-modern.hard .score-value-modern {
        background: linear-gradient(135deg, #ef4444, #dc2626);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    .score-details {
        font-size: 0.85rem;
        color: #9ca3af;
        margin-top: 8px;
    }

    .start-btn {
        display: inline-block;
        width: 100%;
        padding: 14px;
        background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 100%);
        color: white !important;
        border: 2px solid transparent;
        border-radius: 10px;
        font-weight: 700;
        font-size: 1rem;
        margin-top: 15px;
        text-decoration: none;
        text-align: center;
        box-shadow: 0 8px 25px rgba(99, 102, 241, 0.3);
        cursor: pointer;
        transition: all 0.3s ease;
        box-sizing: border-box;
    }

    .start-btn:hover {
        transform: translateY(-3px);
        box-shadow: 0 12px 35px rgba(99, 102, 241, 0.4);
        color: white !important;
        text-decoration: none;
    }

    .start-btn i {
        margin-right: 8px;
    }

    .footer-nav {
        text-align: center;
        padding: 30px;
    }

    @media (max-width: 768px) {
        .hero-title {
            font-size: 2rem;
        }

        .hero-flag {
            font-size: 3rem;
        }

        .difficulties-wrapper {
            grid-template-columns: 1fr;
        }
    }
</style>

<a href="/countries" class="back-btn">
    <i class="fas fa-arrow-left"></i> Back to Countries
</a>

<div class="page-hero">
    <div class="hero-flag">{{ $country->flag_emoji ?? '🏴' }}</div>
    <h1 class="hero-title">{{ $country->name }}</h1>
    <p class="hero-subtitle">🎯 Choose your difficulty and challenge yourself</p>
</div>

@php
    $order = ['easy', 'medium', 'hard'];
    $sortedDifficulties = $difficulties->sortBy(fn($d) => array_search($d->level, $order));
@endphp

<div class="difficulties-wrapper">
    @foreach($sortedDifficulties as $difficulty)
    <div class="difficulty-card-modern {{ $difficulty->level }}">
        <div class="difficulty-visual {{ $difficulty->level }}">
            @if($difficulty->level === 'easy')
                🎯
            @elseif($difficulty->level === 'medium')
                ⚡
            @else
                🔥
            @endif
        </div>
        
        <div class="difficulty-content">
            <div class="difficulty-label">{{ ucfirst($difficulty->level) }}</div>
            
            <div class="difficulty-points">
                <i class="fas fa-star"></i> {{ $difficulty->points_per_question }} points/question
            </div>

            <p class="difficulty-description">
                @if($difficulty->level === 'easy')
                    Start your journey here! Perfect for beginners to build confidence and warm up.
                @elseif($difficulty->level === 'medium')
                    Level up your skills! A good balance of challenge and learning.
                @else
                    Master level! Only for the truly dedicated. Push your limits!
                @endif
            </p>

            @if($difficulty->userScores && $difficulty->userScores->first())
                <div class="score-badge-modern {{ $difficulty->level }}">
                    <div class="score-label-modern">✓ Your Best Score</div>
                    <div class="score-value-modern">
                        {{ $difficulty->userScores->first()->score }}
                    </div>
                    <div class="score-details">
                        {{ $difficulty->userScores->first()->correct_answers }}/{{ $difficulty->userScores->first()->total_questions }} correct
                    </div>
                </div>
            @endif
            <a href="{{ route('quiz.show', $difficulty) }}" class="start-btn">
                <i class="fas fa-{{ $difficulty->userScores && $difficulty->userScores->first() ? 'redo' : 'play' }}"></i> 
                {{ $difficulty->userScores && $difficulty->userScores->first() ? 'Retake Quiz' : 'Start Quiz' }}
            </a>
        </div>
    </div>
    @endforeach
</div>

@endsection
