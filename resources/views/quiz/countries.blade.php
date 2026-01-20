@extends('layouts.minimal')

@section('content')
<style>
    .page-header {
        text-align: center;
        margin-bottom: 50px;
        color: white;
    }

    .page-header h1 {
        font-size: 3rem;
        font-weight: 800;
        margin-bottom: 10px;
        text-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
    }

    .page-header p {
        font-size: 1.2rem;
        opacity: 0.95;
        margin: 0;
    }

    .countries-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 25px;
        margin-bottom: 40px;
    }

    .country-card {
        background: white;
        border-radius: 20px;
        overflow: hidden;
        transition: all 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        cursor: pointer;
        border: none;
        position: relative;
        height: 100%;
    }

    .country-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 5px;
        background: linear-gradient(90deg, #6366f1, #8b5cf6, #ec4899);
        z-index: 10;
    }

    .country-card:hover {
        transform: translateY(-12px) scale(1.02);
        box-shadow: 0 25px 50px rgba(0, 0, 0, 0.15);
    }

    .country-card-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        padding: 30px 20px;
        text-align: center;
        color: white;
    }

    .country-flag {
        font-size: 4rem;
        margin-bottom: 10px;
        animation: float 3s ease-in-out infinite;
    }

    @keyframes float {
        0%, 100% { transform: translateY(0px); }
        50% { transform: translateY(-10px); }
    }

    .country-card-header h3 {
        font-size: 1.5rem;
        font-weight: 700;
        margin: 0;
        letter-spacing: 0.5px;
    }

    .country-card-body {
        padding: 20px;
    }

    .difficulty-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 12px;
        background: #f8f9fa;
        border-radius: 10px;
        margin-bottom: 10px;
        transition: all 0.3s ease;
    }

    .difficulty-item:hover {
        background: #f0f0f0;
        transform: translateX(5px);
    }

    .difficulty-badge {
        padding: 6px 14px;
        border-radius: 20px;
        font-weight: 700;
        font-size: 0.85rem;
        letter-spacing: 0.5px;
    }

    .difficulty-badge.easy {
        background: linear-gradient(135deg, #10b981, #34d399);
        color: white;
    }

    .difficulty-badge.medium {
        background: linear-gradient(135deg, #f59e0b, #fbbf24);
        color: white;
    }

    .difficulty-badge.hard {
        background: linear-gradient(135deg, #ef4444, #f87171);
        color: white;
    }

    .score-display {
        font-size: 0.9rem;
        color: #6b7280;
        font-weight: 600;
    }

    .select-btn {
        width: 100%;
        padding: 12px;
        margin-top: 15px;
        background: linear-gradient(135deg, #6366f1, #8b5cf6);
        color: white;
        border: none;
        border-radius: 10px;
        font-weight: 700;
        font-size: 1rem;
        transition: all 0.3s ease;
        cursor: pointer;
        position: relative;
        overflow: hidden;
    }

    .select-btn::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: rgba(255, 255, 255, 0.2);
        transition: left 0.5s ease;
        z-index: 1;
    }

    .select-btn:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 25px rgba(99, 102, 241, 0.4);
    }

    .select-btn:hover::before {
        left: 100%;
    }

    .select-btn span {
        position: relative;
        z-index: 2;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
    }

    .empty-state {
        text-align: center;
        color: white;
        padding: 60px 20px;
    }

    .empty-state i {
        font-size: 4rem;
        margin-bottom: 20px;
        opacity: 0.7;
    }

    .empty-state h2 {
        font-size: 2rem;
        margin-bottom: 10px;
    }
</style>

<div class="page-header">
    <h1><i class="fas fa-quiz"></i> Select a Country</h1>
    <p>Choose a country and test your knowledge across different difficulty levels</p>
</div>

@if($countries && $countries->count() > 0)
    <div class="countries-grid">
        @foreach($countries as $country)
        <div class="country-card">
            <div class="country-card-header">
                <div class="country-flag">{{ $country->flag_emoji ?? '🏴' }}</div>
                <h3>{{ $country->name }}</h3>
            </div>
            
            <div class="country-card-body">
                @if($country->difficulties && $country->difficulties->count() > 0)
                    @foreach($country->difficulties as $difficulty)
                    <div class="difficulty-item">
                        <span class="difficulty-badge {{ $difficulty->level }}">
                            {{ ucfirst($difficulty->level) }}
                        </span>
                        <span class="score-display">
                            @if($difficulty->userScores && $difficulty->userScores->first())
                                ✓ {{ $difficulty->userScores->first()->score }} pts
                            @else
                                <i class="fas fa-lock"></i> Locked
                            @endif
                        </span>
                    </div>
                    @endforeach
                @endif
                
                <a href="{{ route('country.difficulties', $country) }}" class="select-btn">
                    <span>
                        <i class="fas fa-arrow-right"></i> Start Quiz
                    </span>
                </a>
            </div>
        </div>
        @endforeach
    </div>
@else
    <div class="empty-state">
        <i class="fas fa-inbox"></i>
        <h2>No Countries Available</h2>
        <p>Check back soon for new quizzes!</p>
    </div>
@endif

@endsection
