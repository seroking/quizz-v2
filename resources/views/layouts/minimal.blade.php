<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>QuizMaster</title>
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        :root {
            --primary: #6366f1;
            --secondary: #8b5cf6;
            --success: #10b981;
            --danger: #ef4444;
            --warning: #f59e0b;
            --info: #06b6d4;
        }

        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: #333;
        }

        /* Navbar Styling */
        .navbar {
            background: rgba(255, 255, 255, 0.95) !important;
            backdrop-filter: blur(10px);
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            border-bottom: 3px solid var(--primary);
        }

        .navbar-brand {
            font-weight: 700;
            font-size: 1.5rem;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .navbar-brand i {
            font-size: 1.8rem;
            margin-right: 8px;
        }

        .nav-buttons {
            display: flex;
            gap: 10px;
            align-items: center;
        }

        .nav-buttons .btn {
            border-radius: 25px;
            padding: 6px 16px;
            font-weight: 600;
            transition: all 0.3s ease;
            border: 2px solid transparent;
        }

        .nav-buttons .btn-results {
            background: var(--primary);
            color: white;
        }

        .nav-buttons .btn-results:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(99, 102, 241, 0.3);
            color: white;
        }

        .nav-buttons .btn-logout {
            background: var(--danger);
            color: white;
        }

        .nav-buttons .btn-logout:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(239, 68, 68, 0.3);
            color: white;
        }

        .user-info {
            font-weight: 600;
            color: var(--primary);
            margin: 0 15px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        /* Container Styling */
        .container {
            padding: 40px 20px;
            max-width: 1200px;
        }

        @media (max-width: 768px) {
            .container {
                padding: 20px 10px;
            }
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light mb-4">
        <div class="container-fluid px-4">
            <a class="navbar-brand" href="/dashboard">
                <i class="fas fa-brain"></i> QuizMaster
            </a>
            <div class="nav-buttons ms-auto">
                <a href="/results" class="btn btn-results btn-sm">
                    <i class="fas fa-chart-bar"></i> Results
                </a>
                <span class="user-info">
                    <i class="fas fa-user-circle"></i>
                    {{ auth()->user()->name ?? 'User' }}
                </span>
                <form method="POST" action="{{ route('logout') }}" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-logout btn-sm">
                        <i class="fas fa-sign-out-alt"></i> Logout
                    </button>
                </form>
            </div>
        </div>
    </nav>
    
    <div class="container">
        @yield('content')
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
