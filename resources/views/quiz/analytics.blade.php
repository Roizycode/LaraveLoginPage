<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Analytics - QuizMaster</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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

        /* Analytics Grid */
        .analytics-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 24px;
            margin-bottom: 32px;
        }

        .analytics-card {
            background: white;
            border-radius: 16px;
            padding: 24px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            transition: transform 0.3s ease;
        }

        .analytics-card:hover {
            transform: translateY(-4px);
        }

        .card-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .card-title {
            font-size: 18px;
            font-weight: 600;
            color: #1e293b;
        }

        .chart-container {
            position: relative;
            height: 300px;
        }

        .large-chart {
            height: 400px;
        }

        .stats-row {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 16px;
            margin-bottom: 24px;
        }

        .stat-item {
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
            color: #64748b;
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

            .analytics-grid {
                grid-template-columns: 1fr;
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
                    <a href="{{ route('dashboard.analytics') }}" class="nav-item active">
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
                    <a href="{{ route('questions.list') }}" class="nav-item">
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
                <h1 class="page-title">Analytics Dashboard</h1>
                <p class="page-subtitle">Comprehensive insights into your quiz system performance</p>
            </div>

            <!-- Quick Stats -->
            <div class="stats-row">
                <div class="stat-item">
                    <div class="stat-value">1,234</div>
                    <div class="stat-label">Total Users</div>
                </div>
                <div class="stat-item">
                    <div class="stat-value">5,678</div>
                    <div class="stat-label">Quiz Attempts</div>
                </div>
                <div class="stat-item">
                    <div class="stat-value">87%</div>
                    <div class="stat-label">Average Score</div>
                </div>
                <div class="stat-item">
                    <div class="stat-value">24</div>
                    <div class="stat-label">Active Quizzes</div>
                </div>
            </div>

            <!-- Analytics Grid -->
            <div class="analytics-grid">
                <div class="analytics-card">
                    <div class="card-header">
                        <h3 class="card-title">Quiz Performance Over Time</h3>
                        <select style="padding: 8px 12px; border: 1px solid #e2e8f0; border-radius: 8px; background: white;">
                            <option>Last 7 days</option>
                            <option>Last 30 days</option>
                            <option>Last 3 months</option>
                        </select>
                    </div>
                    <div class="chart-container large-chart">
                        <canvas id="performanceChart"></canvas>
                    </div>
                </div>

                <div class="analytics-card">
                    <div class="card-header">
                        <h3 class="card-title">User Engagement</h3>
                    </div>
                    <div class="chart-container">
                        <canvas id="engagementChart"></canvas>
                    </div>
                </div>

                <div class="analytics-card">
                    <div class="card-header">
                        <h3 class="card-title">Quiz Categories Distribution</h3>
                    </div>
                    <div class="chart-container">
                        <canvas id="categoryChart"></canvas>
                    </div>
                </div>

                <div class="analytics-card">
                    <div class="card-header">
                        <h3 class="card-title">Score Distribution</h3>
                    </div>
                    <div class="chart-container">
                        <canvas id="scoreChart"></canvas>
                    </div>
                </div>

                <div class="analytics-card">
                    <div class="card-header">
                        <h3 class="card-title">Top Performing Quizzes</h3>
                    </div>
                    <div class="chart-container">
                        <canvas id="topQuizzesChart"></canvas>
                    </div>
                </div>

                <div class="analytics-card">
                    <div class="card-header">
                        <h3 class="card-title">User Activity Heatmap</h3>
                    </div>
                    <div class="chart-container">
                        <canvas id="heatmapChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Performance Chart
        const performanceCtx = document.getElementById('performanceChart').getContext('2d');
        new Chart(performanceCtx, {
            type: 'line',
            data: {
                labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
                datasets: [{
                    label: 'Quiz Attempts',
                    data: [12, 19, 3, 5, 2, 3, 8],
                    borderColor: '#9BD3DD',
                    backgroundColor: 'rgba(155, 211, 221, 0.1)',
                    tension: 0.4,
                    fill: true
                }, {
                    label: 'Average Score',
                    data: [85, 92, 78, 88, 95, 82, 90],
                    borderColor: '#667eea',
                    backgroundColor: 'rgba(102, 126, 234, 0.1)',
                    tension: 0.4,
                    fill: true
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'top',
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        // Engagement Chart
        const engagementCtx = document.getElementById('engagementChart').getContext('2d');
        new Chart(engagementCtx, {
            type: 'doughnut',
            data: {
                labels: ['Active Users', 'Inactive Users', 'New Users'],
                datasets: [{
                    data: [60, 25, 15],
                    backgroundColor: ['#9BD3DD', '#667eea', '#10b981']
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                    }
                }
            }
        });

        // Category Chart
        const categoryCtx = document.getElementById('categoryChart').getContext('2d');
        new Chart(categoryCtx, {
            type: 'bar',
            data: {
                labels: ['Math', 'Science', 'History', 'Literature', 'Geography'],
                datasets: [{
                    label: 'Quiz Count',
                    data: [30, 25, 20, 15, 10],
                    backgroundColor: '#9BD3DD'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        // Score Chart
        const scoreCtx = document.getElementById('scoreChart').getContext('2d');
        new Chart(scoreCtx, {
            type: 'bar',
            data: {
                labels: ['0-20%', '21-40%', '41-60%', '61-80%', '81-100%'],
                datasets: [{
                    label: 'Number of Users',
                    data: [5, 12, 25, 35, 23],
                    backgroundColor: '#667eea'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        // Top Quizzes Chart
        const topQuizzesCtx = document.getElementById('topQuizzesChart').getContext('2d');
        new Chart(topQuizzesCtx, {
            type: 'horizontalBar',
            data: {
                labels: ['Math Basics', 'Science Quiz', 'History Test', 'Literature Review', 'Geography Challenge'],
                datasets: [{
                    label: 'Average Score',
                    data: [95, 87, 82, 78, 75],
                    backgroundColor: '#10b981'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    x: {
                        beginAtZero: true,
                        max: 100
                    }
                }
            }
        });

        // Heatmap Chart
        const heatmapCtx = document.getElementById('heatmapChart').getContext('2d');
        new Chart(heatmapCtx, {
            type: 'line',
            data: {
                labels: ['6AM', '9AM', '12PM', '3PM', '6PM', '9PM'],
                datasets: [{
                    label: 'User Activity',
                    data: [5, 25, 45, 35, 20, 10],
                    borderColor: '#f59e0b',
                    backgroundColor: 'rgba(245, 158, 11, 0.1)',
                    tension: 0.4,
                    fill: true
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
</body>
</html>
