<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>User Management - QuizMaster</title>
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

        /* Users Table */
        .users-table-container {
            background: white;
            border-radius: 16px;
            padding: 24px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            overflow-x: auto;
        }

        .users-table {
            width: 100%;
            border-collapse: collapse;
        }

        .users-table th {
            background: #f8fafc;
            color: #374151;
            font-weight: 600;
            font-size: 14px;
            text-align: left;
            padding: 16px;
            border-bottom: 1px solid #e5e7eb;
        }

        .users-table td {
            padding: 16px;
            border-bottom: 1px solid #f1f5f9;
            color: #374151;
        }

        .users-table tr:hover {
            background: #f8fafc;
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: linear-gradient(45deg, #9BD3DD, #667eea);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
            font-size: 16px;
        }

        .user-details h4 {
            font-size: 14px;
            font-weight: 600;
            color: #1e293b;
            margin-bottom: 2px;
        }

        .user-details p {
            font-size: 12px;
            color: #6b7280;
        }

        .role-badge {
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
        }

        .role-admin {
            background: #fef3c7;
            color: #92400e;
        }

        .role-teacher {
            background: #dbeafe;
            color: #1e40af;
        }

        .role-student {
            background: #dcfce7;
            color: #166534;
        }

        .status-badge {
            padding: 4px 8px;
            border-radius: 6px;
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
        }

        .status-active {
            background: #dcfce7;
            color: #166534;
        }

        .status-inactive {
            background: #fee2e2;
            color: #991b1b;
        }

        .status-pending {
            background: #fef3c7;
            color: #92400e;
        }

        .table-actions {
            display: flex;
            gap: 8px;
        }

        .action-btn-small {
            padding: 6px 12px;
            border: none;
            border-radius: 6px;
            font-size: 12px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 4px;
        }

        .action-btn-small:hover {
            transform: translateY(-1px);
        }

        .btn-edit {
            background: #f3f4f6;
            color: #374151;
        }

        .btn-edit:hover {
            background: #e5e7eb;
        }

        .btn-delete {
            background: #fee2e2;
            color: #991b1b;
        }

        .btn-delete:hover {
            background: #fecaca;
        }

        .btn-view {
            background: #dbeafe;
            color: #1e40af;
        }

        .btn-view:hover {
            background: #bfdbfe;
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

            .users-table-container {
                overflow-x: auto;
            }

            .table-actions {
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
                    <a href="{{ route('users.list') }}" class="nav-item active">
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
                        <h1 class="page-title">User Management</h1>
                        <p class="page-subtitle">Manage users, roles, and permissions</p>
                    </div>
                    <div class="header-actions">
                        <a href="{{ route('users.create') }}" class="btn btn-primary">
                            <i class="fas fa-user-plus"></i>
                            Add User
                        </a>
                        <button class="btn btn-secondary">
                            <i class="fas fa-download"></i>
                            Export Users
                        </button>
                    </div>
                </div>

                <!-- Filters -->
                <div class="filters">
                    <div class="search-box">
                        <i class="fas fa-search search-icon"></i>
                        <input type="text" class="search-input" placeholder="Search users...">
                    </div>
                    <div class="filter-group">
                        <label class="filter-label">Role</label>
                        <select class="filter-select">
                            <option>All Roles</option>
                            <option>Admin</option>
                            <option>Teacher</option>
                            <option>Student</option>
                        </select>
                    </div>
                    <div class="filter-group">
                        <label class="filter-label">Status</label>
                        <select class="filter-select">
                            <option>All Status</option>
                            <option>Active</option>
                            <option>Inactive</option>
                            <option>Pending</option>
                        </select>
                    </div>
                    <div class="filter-group">
                        <label class="filter-label">Sort By</label>
                        <select class="filter-select">
                            <option>Name</option>
                            <option>Email</option>
                            <option>Role</option>
                            <option>Last Login</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Stats -->
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-value">1,234</div>
                    <div class="stat-label">Total Users</div>
                </div>
                <div class="stat-card">
                    <div class="stat-value">45</div>
                    <div class="stat-label">Admins</div>
                </div>
                <div class="stat-card">
                    <div class="stat-value">156</div>
                    <div class="stat-label">Teachers</div>
                </div>
                <div class="stat-card">
                    <div class="stat-value">1,033</div>
                    <div class="stat-label">Students</div>
                </div>
            </div>

            <!-- Users Table -->
            <div class="users-table-container">
                <table class="users-table">
                    <thead>
                        <tr>
                            <th>User</th>
                            <th>Role</th>
                            <th>Status</th>
                            <th>Last Login</th>
                            <th>Quiz Attempts</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                <div class="user-info">
                                    <div class="user-avatar">JD</div>
                                    <div class="user-details">
                                        <h4>John Doe</h4>
                                        <p>john.doe@example.com</p>
                                    </div>
                                </div>
                            </td>
                            <td><span class="role-badge role-admin">Admin</span></td>
                            <td><span class="status-badge status-active">Active</span></td>
                            <td>2 hours ago</td>
                            <td>24</td>
                            <td>
                                <div class="table-actions">
                                    <button class="action-btn-small btn-view">
                                        <i class="fas fa-eye"></i>
                                        View
                                    </button>
                                    <button class="action-btn-small btn-edit">
                                        <i class="fas fa-edit"></i>
                                        Edit
                                    </button>
                                    <button class="action-btn-small btn-delete">
                                        <i class="fas fa-trash"></i>
                                        Delete
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="user-info">
                                    <div class="user-avatar">JS</div>
                                    <div class="user-details">
                                        <h4>Jane Smith</h4>
                                        <p>jane.smith@example.com</p>
                                    </div>
                                </div>
                            </td>
                            <td><span class="role-badge role-teacher">Teacher</span></td>
                            <td><span class="status-badge status-active">Active</span></td>
                            <td>1 day ago</td>
                            <td>12</td>
                            <td>
                                <div class="table-actions">
                                    <button class="action-btn-small btn-view">
                                        <i class="fas fa-eye"></i>
                                        View
                                    </button>
                                    <button class="action-btn-small btn-edit">
                                        <i class="fas fa-edit"></i>
                                        Edit
                                    </button>
                                    <button class="action-btn-small btn-delete">
                                        <i class="fas fa-trash"></i>
                                        Delete
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="user-info">
                                    <div class="user-avatar">MJ</div>
                                    <div class="user-details">
                                        <h4>Mike Johnson</h4>
                                        <p>mike.johnson@example.com</p>
                                    </div>
                                </div>
                            </td>
                            <td><span class="role-badge role-student">Student</span></td>
                            <td><span class="status-badge status-active">Active</span></td>
                            <td>3 hours ago</td>
                            <td>8</td>
                            <td>
                                <div class="table-actions">
                                    <button class="action-btn-small btn-view">
                                        <i class="fas fa-eye"></i>
                                        View
                                    </button>
                                    <button class="action-btn-small btn-edit">
                                        <i class="fas fa-edit"></i>
                                        Edit
                                    </button>
                                    <button class="action-btn-small btn-delete">
                                        <i class="fas fa-trash"></i>
                                        Delete
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="user-info">
                                    <div class="user-avatar">SB</div>
                                    <div class="user-details">
                                        <h4>Sarah Brown</h4>
                                        <p>sarah.brown@example.com</p>
                                    </div>
                                </div>
                            </td>
                            <td><span class="role-badge role-teacher">Teacher</span></td>
                            <td><span class="status-badge status-pending">Pending</span></td>
                            <td>Never</td>
                            <td>0</td>
                            <td>
                                <div class="table-actions">
                                    <button class="action-btn-small btn-view">
                                        <i class="fas fa-eye"></i>
                                        View
                                    </button>
                                    <button class="action-btn-small btn-edit">
                                        <i class="fas fa-edit"></i>
                                        Edit
                                    </button>
                                    <button class="action-btn-small btn-delete">
                                        <i class="fas fa-trash"></i>
                                        Delete
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="user-info">
                                    <div class="user-avatar">DW</div>
                                    <div class="user-details">
                                        <h4>David Wilson</h4>
                                        <p>david.wilson@example.com</p>
                                    </div>
                                </div>
                            </td>
                            <td><span class="role-badge role-student">Student</span></td>
                            <td><span class="status-badge status-inactive">Inactive</span></td>
                            <td>1 week ago</td>
                            <td>15</td>
                            <td>
                                <div class="table-actions">
                                    <button class="action-btn-small btn-view">
                                        <i class="fas fa-eye"></i>
                                        View
                                    </button>
                                    <button class="action-btn-small btn-edit">
                                        <i class="fas fa-edit"></i>
                                        Edit
                                    </button>
                                    <button class="action-btn-small btn-delete">
                                        <i class="fas fa-trash"></i>
                                        Delete
                                    </button>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>

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
    </div>

    <script>
        // Search functionality
        document.querySelector('.search-input').addEventListener('input', function(e) {
            const searchTerm = e.target.value.toLowerCase();
            const tableRows = document.querySelectorAll('.users-table tbody tr');
            
            tableRows.forEach(row => {
                const name = row.querySelector('h4').textContent.toLowerCase();
                const email = row.querySelector('p').textContent.toLowerCase();
                
                if (name.includes(searchTerm) || email.includes(searchTerm)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
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

        // User actions
        document.querySelectorAll('.action-btn-small').forEach(btn => {
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                const action = this.textContent.trim();
                const userName = this.closest('tr').querySelector('h4').textContent;
                
                if (action.includes('Delete')) {
                    Swal.fire({
                        title: 'Delete User',
                        text: `Are you sure you want to delete ${userName}?`,
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#ef4444',
                        cancelButtonColor: '#6b7280',
                        confirmButtonText: 'Yes, delete!',
                        cancelButtonText: 'Cancel'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            Swal.fire('Deleted!', 'User has been deleted.', 'success');
                        }
                    });
                } else {
                    Swal.fire({
                        icon: 'info',
                        title: action,
                        text: `This would ${action.toLowerCase()} the user.`,
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
