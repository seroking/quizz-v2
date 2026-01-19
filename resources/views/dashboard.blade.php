@extends('layouts.minimal')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card shadow border-0 rounded-3">
            <div class="card-body">
                <h1 class="card-title mb-4">Welcome, {{ auth()->user()->name }}!</h1>
                
                <div class="row g-4">
                    <!-- Total Score -->
                    <div class="col-md-4">
                        <div class="card text-white rounded-3 shadow-sm h-100" style="background: linear-gradient(135deg, #4a90e2, #357ABD); transition: transform 0.2s;">
                            <div class="card-body text-center">
                                <h2 class="display-4">{{ $totalScore ?? 0 }}</h2>
                                <p class="mb-0 fw-bold">Total Score</p>
                            </div>
                        </div>
                    </div>

                    <!-- Quizzes Done -->
                    <div class="col-md-4">
                        <div class="card text-white rounded-3 shadow-sm h-100" style="background: linear-gradient(135deg, #28a745, #1c7c32); transition: transform 0.2s;">
                            <div class="card-body text-center">
                                <h2 class="display-4">{{ $completedQuizzes ?? 0 }}</h2>
                                <p class="mb-0 fw-bold">Quizzes Completed</p>
                            </div>
                        </div>
                    </div>

                    <!-- Start Quiz -->
                    <div class="col-md-4">
                        <div class="card rounded-3 shadow-sm h-100 d-flex align-items-center justify-content-center" style="background: #f8f9fa; transition: transform 0.2s;">
                            <div class="card-body text-center">
                                <a href="/countries" class="btn btn-primary btn-lg w-100 rounded-pill">
                                    Start Quiz
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Motivational Footer -->
               
            </div>
        </div>
    </div>
</div>

<!-- Hover effects -->
<style>
.card:hover {
    transform: translateY(-5px);
}
</style>
@endsection
