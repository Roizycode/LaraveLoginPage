<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Question Bank - QuizMaster</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="icon" type="image/png" href="/people.png">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            color: #FFFFFF;
            overflow-x: hidden;
        }

        .dashboard-layout {
            display: flex;
            min-height: 100vh;
        }

        /* Sidebar */
        .sidebar {
            width: 280px;
            background: linear-gradient(180deg, #1e3a8a 0%, #1e40af 100%);
            box-shadow: 4px 0 20px rgba(0, 0, 0, 0.1);
            position: fixed;
            height: 100vh;
            overflow-y: auto;
            z-index: 1000;
            transition: transform 0.3s ease;
        }

        .sidebar-header {
            padding: 24px 20px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .logo {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .logo-icon {
            width: 40px;
            height: 40px;
            background: linear-gradient(45deg, #9BD3DD, #667eea);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            color: white;
        }

        .logo-text h3 {
            font-size: 18px;
            font-weight: 700;
            color: white;
            margin-bottom: 4px;
        }

        .logo-text p {
            font-size: 12px;
            color: rgba(255, 255, 255, 0.7);
        }

        .sidebar-nav {
            padding: 20px 0;
        }

        .nav-section {
            margin-bottom: 32px;
        }

        .nav-section-title {
            font-size: 12px;
            font-weight: 600;
            color: rgba(255, 255, 255, 0.6);
            text-transform: uppercase;
            letter-spacing: 1px;
            padding: 0 20px;
            margin-bottom: 16px;
        }

        .nav-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 20px;
            color: rgba(255, 255, 255, 0.8);
            text-decoration: none;
            transition: all 0.3s ease;
            border-left: 3px solid transparent;
        }

        .nav-item:hover {
            background: rgba(255, 255, 255, 0.1);
            color: white;
            border-left-color: #9BD3DD;
        }

        .nav-item.active {
            background: linear-gradient(90deg, rgba(155, 211, 221, 0.2), transparent);
            color: #9BD3DD;
            border-left-color: #9BD3DD;
        }

        .nav-item i {
            width: 20px;
            text-align: center;
            font-size: 16px;
        }

        .nav-item span {
            font-size: 14px;
            font-weight: 500;
        }

        .sidebar-footer {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            padding: 20px;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
        }

        .action-btn {
            width: 100%;
            padding: 12px 16px;
            background: linear-gradient(45deg, #9BD3DD, #667eea);
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-bottom: 8px;
            text-decoration: none;
            display: block;
            text-align: center;
        }

        .action-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(155, 211, 221, 0.3);
        }

        /* Main Content */
        .main-content {
            flex: 1;
            margin-left: 280px;
            padding: 24px;
            background: #f8fafc;
        }

        .content-header {
            background: white;
            border-radius: 16px;
            padding: 24px;
            margin-bottom: 24px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        }

        .header-top {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 24px;
        }

        .page-title {
            font-size: 28px;
            font-weight: 700;
            color: #1e293b;
            margin-bottom: 8px;
        }

        .page-subtitle {
            color: #64748b;
            font-size: 16px;
        }

        .header-actions {
            display: flex;
            gap: 12px;
        }

        .btn {
            padding: 12px 24px;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .btn-primary {
            background: linear-gradient(45deg, #9BD3DD, #667eea);
            color: white;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(155, 211, 221, 0.3);
        }

        .btn-secondary {
            background: #f3f4f6;
            color: #374151;
            border: 1px solid #d1d5db;
        }

        .btn-secondary:hover {
            background: #e5e7eb;
        }

        .btn-success {
            background: #10b981;
            color: white;
        }

        .btn-success:hover {
            background: #059669;
        }

        .btn-danger {
            background: #ef4444;
            color: white;
        }

        .btn-danger:hover {
            background: #dc2626;
        }

        .btn-warning {
            background: #f59e0b;
            color: white;
        }

        .btn-warning:hover {
            background: #d97706;
        }

        /* Filters */
        .filters {
            display: flex;
            gap: 16px;
            align-items: center;
            flex-wrap: wrap;
        }

        .filter-group {
            display: flex;
            flex-direction: column;
            gap: 4px;
        }

        .filter-label {
            font-size: 12px;
            font-weight: 600;
            color: #6b7280;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .filter-select {
            padding: 8px 12px;
            border: 1px solid #d1d5db;
            border-radius: 6px;
            background: white;
            font-size: 14px;
            color: #374151;
        }

        .search-box {
            position: relative;
            flex: 1;
            max-width: 300px;
        }

        .search-input {
            width: 100%;
            padding: 12px 16px 12px 40px;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            background: white;
            font-size: 14px;
            color: #374151;
        }

        .search-icon {
            position: absolute;
            left: 12px;
            top: 50%;
            transform: translateY(-50%);
            color: #9ca3af;
        }

        /* Questions Grid */
        .questions-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(400px, 1fr));
            gap: 24px;
            margin-bottom: 32px;
        }

        .question-card {
            background: white;
            border-radius: 16px;
            padding: 24px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            transition: transform 0.3s ease;
            position: relative;
        }

        .question-card:hover {
            transform: translateY(-4px);
        }

        .question-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 16px;
        }

        .question-type {
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
        }

        .type-multiple-choice {
            background: #dbeafe;
            color: #1e40af;
        }

        .type-true-false {
            background: #dcfce7;
            color: #166534;
        }

        .type-fill-blank {
            background: #fef3c7;
            color: #92400e;
        }

        .type-short-answer {
            background: #fce7f3;
            color: #be185d;
        }

        .question-difficulty {
            display: flex;
            align-items: center;
            gap: 4px;
        }

        .difficulty-stars {
            color: #f59e0b;
        }

        .question-content {
            margin-bottom: 16px;
        }

        .question-text {
            font-size: 16px;
            font-weight: 500;
            color: #1e293b;
            margin-bottom: 12px;
            line-height: 1.5;
        }

        .question-options {
            margin-left: 16px;
        }

        .option-item {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 8px;
            font-size: 14px;
            color: #6b7280;
        }

        .option-correct {
            color: #10b981;
            font-weight: 600;
        }

        .question-meta {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 16px;
            padding-top: 16px;
            border-top: 1px solid #f1f5f9;
        }

        .question-category {
            font-size: 12px;
            color: #6b7280;
            background: #f1f5f9;
            padding: 4px 8px;
            border-radius: 6px;
        }

        .question-points {
            font-size: 14px;
            font-weight: 600;
            color: #1e293b;
        }

        .question-actions {
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
        }

        .question-actions .btn {
            padding: 8px 16px;
            font-size: 14px;
            flex: 1;
            min-width: 80px;
            text-align: center;
        }

        /* Stats Cards */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 16px;
            margin-bottom: 24px;
        }

        .stat-card {
            background: white;
            border-radius: 12px;
            padding: 20px;
            text-align: center;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        }

        .stat-value {
            font-size: 24px;
            font-weight: 700;
            color: #1e293b;
            margin-bottom: 4px;
        }

        .stat-label {
            font-size: 14px;
            color: #6b7280;
        }

        /* Pagination */
        .pagination {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 8px;
            margin-top: 24px;
        }

        .pagination-btn {
            padding: 8px 12px;
            border: 1px solid #d1d5db;
            background: white;
            color: #374151;
            border-radius: 6px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .pagination-btn:hover {
            background: #f3f4f6;
        }

        .pagination-btn.active {
            background: #9BD3DD;
            color: white;
            border-color: #9BD3DD;
        }

        .pagination-btn:disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }

        /* Mobile Responsive */
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
            }

            .sidebar.open {
                transform: translateX(0);
            }

            .main-content {
                margin-left: 0;
                padding: 16px;
            }

            .header-top {
                flex-direction: column;
                align-items: flex-start;
                gap: 16px;
            }

            .filters {
                flex-direction: column;
                align-items: stretch;
            }

            .questions-grid {
                grid-template-columns: 1fr;
            }

            .question-actions {
                flex-direction: column;
            }
        }
    </style>
</head>
<body>
    <div class="dashboard-layout">
        <!-- Sidebar -->
        <div class="sidebar">
            <div class="sidebar-header">
                <div class="logo">
                    <div class="logo-icon">
                        <i class="fas fa-graduation-cap"></i>
                    </div>
                    <div class="logo-text">
                        <h3>QuizMaster</h3>
                        <p>Online Quiz System</p>
                    </div>
                </div>
            </div>

            <nav class="sidebar-nav">
                <div class="nav-section">
                    <div class="nav-section-title">Dashboard</div>
                    <a href="{{ route('dashboard') }}" class="nav-item">
                        <i class="fas fa-chart-pie"></i>
                        <span>Overview</span>
                    </a>
                    <a href="{{ route('dashboard.analytics') }}" class="nav-item">
                        <i class="fas fa-tachometer-alt"></i>
                        <span>Analytics</span>
                    </a>
                </div>

                <div class="nav-section">
                    <div class="nav-section-title">Quiz Management</div>
                    <a href="{{ route('quizzes.create') }}" class="nav-item">
                        <i class="fas fa-plus-circle"></i>
                        <span>Create Quiz</span>
                    </a>
                    <a href="{{ route('quizzes.list') }}" class="nav-item">
                        <i class="fas fa-list"></i>
                        <span>All Quizzes</span>
                    </a>
                    <a href="{{ route('questions.list') }}" class="nav-item active">
                        <i class="fas fa-database"></i>
                        <span>Question Bank</span>
                    </a>
                    <a href="{{ route('categories.list') }}" class="nav-item">
                        <i class="fas fa-tags"></i>
                        <span>Categories</span>
                    </a>
                </div>

                <div class="nav-section">
                    <div class="nav-section-title">User Management</div>
                    <a href="{{ route('users.list') }}" class="nav-item">
                        <i class="fas fa-users"></i>
                        <span>All Users</span>
                    </a>
                    <a href="{{ route('users.create') }}" class="nav-item">
                        <i class="fas fa-user-plus"></i>
                        <span>Add User</span>
                    </a>
                    <a href="{{ route('users.roles') }}" class="nav-item">
                        <i class="fas fa-user-shield"></i>
                        <span>Roles & Permissions</span>
                    </a>
                </div>

                <div class="nav-section">
                    <div class="nav-section-title">Reports</div>
                    <a href="{{ route('reports.performance') }}" class="nav-item">
                        <i class="fas fa-chart-bar"></i>
                        <span>Performance</span>
                    </a>
                    <a href="{{ route('reports.export') }}" class="nav-item">
                        <i class="fas fa-file-export"></i>
                        <span>Export Data</span>
                    </a>
                    <a href="{{ route('reports.notifications') }}" class="nav-item">
                        <i class="fas fa-bell"></i>
                        <span>Notifications</span>
                    </a>
                </div>

                <div class="nav-section">
                    <div class="nav-section-title">Settings</div>
                    <a href="{{ route('settings.index') }}" class="nav-item">
                        <i class="fas fa-cog"></i>
                        <span>System Settings</span>
                    </a>
                    <a href="{{ route('settings.themes') }}" class="nav-item">
                        <i class="fas fa-palette"></i>
                        <span>Themes</span>
                    </a>
                </div>
            </nav>

            <div class="sidebar-footer">
                <a href="#" class="action-btn">
                    <i class="fas fa-download"></i> Free Download
                </a>
                <a href="#" class="action-btn">
                    <i class="fas fa-book"></i> Documentation
                </a>
                <a href="#" class="action-btn">
                    <i class="fas fa-star"></i> Upgrade to Pro
                </a>
            </div>
        </div>

        <!-- Main Content -->
        <div class="main-content">
            <div class="content-header">
                <div class="header-top">
                    <div>
                        <h1 class="page-title">Question Bank</h1>
                        <p class="page-subtitle">Manage and organize your question collection</p>
                    </div>
                    <div class="header-actions">
                        <a href="{{ route('questions.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus"></i>
                            Add Question
                        </a>
                        <button class="btn btn-secondary">
                            <i class="fas fa-download"></i>
                            Export
                        </button>
                    </div>
                </div>

                <!-- Filters -->
                <div class="filters">
                    <div class="search-box">
                        <i class="fas fa-search search-icon"></i>
                        <input type="text" class="search-input" placeholder="Search questions...">
                    </div>
                    <div class="filter-group">
                        <label class="filter-label">Type</label>
                        <select class="filter-select">
                            <option>All Types</option>
                            <option>Multiple Choice</option>
                            <option>True/False</option>
                            <option>Fill in the Blank</option>
                            <option>Short Answer</option>
                        </select>
                    </div>
                    <div class="filter-group">
                        <label class="filter-label">Category</label>
                        <select class="filter-select">
                            <option>All Categories</option>
                            <option>Mathematics</option>
                            <option>Science</option>
                            <option>History</option>
                            <option>Literature</option>
                        </select>
                    </div>
                    <div class="filter-group">
                        <label class="filter-label">Difficulty</label>
                        <select class="filter-select">
                            <option>All Levels</option>
                            <option>Easy</option>
                            <option>Medium</option>
                            <option>Hard</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Stats -->
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-value">1,245</div>
                    <div class="stat-label">Total Questions</div>
                </div>
                <div class="stat-card">
                    <div class="stat-value">856</div>
                    <div class="stat-label">Multiple Choice</div>
                </div>
                <div class="stat-card">
                    <div class="stat-value">234</div>
                    <div class="stat-label">True/False</div>
                </div>
                <div class="stat-card">
                    <div class="stat-value">155</div>
                    <div class="stat-label">Other Types</div>
                </div>
            </div>

            <!-- Questions Grid -->
            <div class="questions-grid">
                <!-- Question Card 1 -->
                <div class="question-card">
                    <div class="question-header">
                        <span class="question-type type-multiple-choice">Multiple Choice</span>
                        <div class="question-difficulty">
                            <div class="difficulty-stars">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="far fa-star"></i>
                                <i class="far fa-star"></i>
                                <i class="far fa-star"></i>
                            </div>
                        </div>
                    </div>
                    <div class="question-content">
                        <div class="question-text">What is the capital of France?</div>
                        <div class="question-options">
                            <div class="option-item option-correct">A) Paris</div>
                            <div class="option-item">B) London</div>
                            <div class="option-item">C) Berlin</div>
                            <div class="option-item">D) Madrid</div>
                        </div>
                    </div>
                    <div class="question-meta">
                        <span class="question-category">Geography</span>
                        <span class="question-points">5 points</span>
                    </div>
                    <div class="question-actions">
                        <button class="btn btn-warning">
                            <i class="fas fa-eye"></i>
                            View
                        </button>
                        <button class="btn btn-secondary">
                            <i class="fas fa-edit"></i>
                            Edit
                        </button>
                        <button class="btn btn-danger">
                            <i class="fas fa-trash"></i>
                            Delete
                        </button>
                    </div>
                </div>

                <!-- Question Card 2 -->
                <div class="question-card">
                    <div class="question-header">
                        <span class="question-type type-true-false">True/False</span>
                        <div class="question-difficulty">
                            <div class="difficulty-stars">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="far fa-star"></i>
                                <i class="far fa-star"></i>
                            </div>
                        </div>
                    </div>
                    <div class="question-content">
                        <div class="question-text">The Earth is the third planet from the Sun.</div>
                        <div class="question-options">
                            <div class="option-item option-correct">True</div>
                            <div class="option-item">False</div>
                        </div>
                    </div>
                    <div class="question-meta">
                        <span class="question-category">Science</span>
                        <span class="question-points">3 points</span>
                    </div>
                    <div class="question-actions">
                        <button class="btn btn-warning">
                            <i class="fas fa-eye"></i>
                            View
                        </button>
                        <button class="btn btn-secondary">
                            <i class="fas fa-edit"></i>
                            Edit
                        </button>
                        <button class="btn btn-danger">
                            <i class="fas fa-trash"></i>
                            Delete
                        </button>
                    </div>
                </div>

                <!-- Question Card 3 -->
                <div class="question-card">
                    <div class="question-header">
                        <span class="question-type type-fill-blank">Fill in the Blank</span>
                        <div class="question-difficulty">
                            <div class="difficulty-stars">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="far fa-star"></i>
                            </div>
                        </div>
                    </div>
                    <div class="question-content">
                        <div class="question-text">The chemical symbol for gold is ____.</div>
                        <div class="question-options">
                            <div class="option-item option-correct">Answer: Au</div>
                        </div>
                    </div>
                    <div class="question-meta">
                        <span class="question-category">Chemistry</span>
                        <span class="question-points">4 points</span>
                    </div>
                    <div class="question-actions">
                        <button class="btn btn-warning">
                            <i class="fas fa-eye"></i>
                            View
                        </button>
                        <button class="btn btn-secondary">
                            <i class="fas fa-edit"></i>
                            Edit
                        </button>
                        <button class="btn btn-danger">
                            <i class="fas fa-trash"></i>
                            Delete
                        </button>
                    </div>
                </div>

                <!-- Question Card 4 -->
                <div class="question-card">
                    <div class="question-header">
                        <span class="question-type type-short-answer">Short Answer</span>
                        <div class="question-difficulty">
                            <div class="difficulty-stars">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                            </div>
                        </div>
                    </div>
                    <div class="question-content">
                        <div class="question-text">Explain the process of photosynthesis in plants.</div>
                        <div class="question-options">
                            <div class="option-item">Expected: Plants convert sunlight, water, and CO2 into glucose and oxygen</div>
                        </div>
                    </div>
                    <div class="question-meta">
                        <span class="question-category">Biology</span>
                        <span class="question-points">10 points</span>
                    </div>
                    <div class="question-actions">
                        <button class="btn btn-warning">
                            <i class="fas fa-eye"></i>
                            View
                        </button>
                        <button class="btn btn-secondary">
                            <i class="fas fa-edit"></i>
                            Edit
                        </button>
                        <button class="btn btn-danger">
                            <i class="fas fa-trash"></i>
                            Delete
                        </button>
                    </div>
                </div>

                <!-- Question Card 5 -->
                <div class="question-card">
                    <div class="question-header">
                        <span class="question-type type-multiple-choice">Multiple Choice</span>
                        <div class="question-difficulty">
                            <div class="difficulty-stars">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="far fa-star"></i>
                                <i class="far fa-star"></i>
                            </div>
                        </div>
                    </div>
                    <div class="question-content">
                        <div class="question-text">Which programming language is known for its use in web development?</div>
                        <div class="question-options">
                            <div class="option-item">A) C++</div>
                            <div class="option-item option-correct">B) JavaScript</div>
                            <div class="option-item">C) Assembly</div>
                            <div class="option-item">D) Fortran</div>
                        </div>
                    </div>
                    <div class="question-meta">
                        <span class="question-category">Computer Science</span>
                        <span class="question-points">5 points</span>
                    </div>
                    <div class="question-actions">
                        <button class="btn btn-warning">
                            <i class="fas fa-eye"></i>
                            View
                        </button>
                        <button class="btn btn-secondary">
                            <i class="fas fa-edit"></i>
                            Edit
                        </button>
                        <button class="btn btn-danger">
                            <i class="fas fa-trash"></i>
                            Delete
                        </button>
                    </div>
                </div>

                <!-- Question Card 6 -->
                <div class="question-card">
                    <div class="question-header">
                        <span class="question-type type-true-false">True/False</span>
                        <div class="question-difficulty">
                            <div class="difficulty-stars">
                                <i class="fas fa-star"></i>
                                <i class="far fa-star"></i>
                                <i class="far fa-star"></i>
                                <i class="far fa-star"></i>
                                <i class="far fa-star"></i>
                            </div>
                        </div>
                    </div>
                    <div class="question-content">
                        <div class="question-text">Shakespeare wrote "Romeo and Juliet".</div>
                        <div class="question-options">
                            <div class="option-item option-correct">True</div>
                            <div class="option-item">False</div>
                        </div>
                    </div>
                    <div class="question-meta">
                        <span class="question-category">Literature</span>
                        <span class="question-points">2 points</span>
                    </div>
                    <div class="question-actions">
                        <button class="btn btn-warning">
                            <i class="fas fa-eye"></i>
                            View
                        </button>
                        <button class="btn btn-secondary">
                            <i class="fas fa-edit"></i>
                            Edit
                        </button>
                        <button class="btn btn-danger">
                            <i class="fas fa-trash"></i>
                            Delete
                        </button>
                    </div>
                </div>
            </div>

            <!-- Pagination -->
            <div class="pagination">
                <button class="pagination-btn" disabled>
                    <i class="fas fa-chevron-left"></i>
                </button>
                <button class="pagination-btn active">1</button>
                <button class="pagination-btn">2</button>
                <button class="pagination-btn">3</button>
                <button class="pagination-btn">
                    <i class="fas fa-chevron-right"></i>
                </button>
            </div>
        </div>
    </div>

    <script>
        // Search functionality
        document.querySelector('.search-input').addEventListener('input', function(e) {
            const searchTerm = e.target.value.toLowerCase();
            const questionCards = document.querySelectorAll('.question-card');
            
            questionCards.forEach(card => {
                const questionText = card.querySelector('.question-text').textContent.toLowerCase();
                
                if (questionText.includes(searchTerm)) {
                    card.style.display = 'block';
                } else {
                    card.style.display = 'none';
                }
            });
        });

        // Filter functionality
        document.querySelectorAll('.filter-select').forEach(select => {
            select.addEventListener('change', function() {
                // Filter logic would go here
                console.log('Filter changed:', this.value);
            });
        });

        // Question actions
        document.querySelectorAll('.question-actions .btn').forEach(btn => {
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                const action = this.textContent.trim();
                
                if (action.includes('Delete')) {
                    Swal.fire({
                        title: 'Delete Question',
                        text: 'Are you sure you want to delete this question?',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#ef4444',
                        cancelButtonColor: '#6b7280',
                        confirmButtonText: 'Yes, delete!',
                        cancelButtonText: 'Cancel'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            Swal.fire('Deleted!', 'Question has been deleted.', 'success');
                        }
                    });
                } else {
                    Swal.fire({
                        icon: 'info',
                        title: action,
                        text: `This would ${action.toLowerCase()} the question.`,
                        confirmButtonColor: '#9BD3DD',
                        confirmButtonText: 'OK'
                    });
                }
            });
        });

        // Pagination
        document.querySelectorAll('.pagination-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                if (!this.disabled) {
                    document.querySelectorAll('.pagination-btn').forEach(b => b.classList.remove('active'));
                    this.classList.add('active');
                }
            });
        });
    </script>
</body>
</html>
