<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>System Settings - QuizMaster</title>
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

        /* Settings Tabs */
        .settings-tabs {
            display: flex;
            gap: 8px;
            margin-bottom: 24px;
            background: #f1f5f9;
            padding: 4px;
            border-radius: 12px;
        }

        .tab-btn {
            flex: 1;
            padding: 12px 16px;
            border: none;
            background: transparent;
            color: #64748b;
            font-size: 14px;
            font-weight: 500;
            cursor: pointer;
            border-radius: 8px;
            transition: all 0.3s ease;
        }

        .tab-btn.active {
            background: white;
            color: #1e293b;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .tab-btn:hover {
            color: #1e293b;
        }

        /* Settings Content */
        .settings-content {
            background: white;
            border-radius: 16px;
            padding: 32px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        }

        .settings-section {
            display: none;
        }

        .settings-section.active {
            display: block;
        }

        .section-title {
            font-size: 20px;
            font-weight: 600;
            color: #1e293b;
            margin-bottom: 24px;
            padding-bottom: 12px;
            border-bottom: 1px solid #e5e7eb;
        }

        .form-group {
            margin-bottom: 24px;
        }

        .form-label {
            display: block;
            color: #374151;
            font-size: 14px;
            font-weight: 600;
            margin-bottom: 8px;
        }

        .form-input {
            width: 100%;
            padding: 12px 16px;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            background: #ffffff;
            font-size: 16px;
            color: #374151;
            transition: all 0.3s ease;
            outline: none;
        }

        .form-input:focus {
            border-color: #9BD3DD;
            background: #ffffff;
            box-shadow: 0 0 0 3px rgba(155, 211, 221, 0.2);
        }

        .form-input:hover {
            border-color: #9BD3DD;
            box-shadow: 0 0 0 2px rgba(155, 211, 221, 0.1);
        }

        .form-textarea {
            width: 100%;
            padding: 12px 16px;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            background: #ffffff;
            font-size: 16px;
            color: #374151;
            transition: all 0.3s ease;
            outline: none;
            resize: vertical;
            min-height: 100px;
        }

        .form-textarea:focus {
            border-color: #9BD3DD;
            background: #ffffff;
            box-shadow: 0 0 0 3px rgba(155, 211, 221, 0.2);
        }

        .form-select {
            width: 100%;
            padding: 12px 16px;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            background: #ffffff;
            font-size: 16px;
            color: #374151;
            transition: all 0.3s ease;
            outline: none;
        }

        .form-select:focus {
            border-color: #9BD3DD;
            background: #ffffff;
            box-shadow: 0 0 0 3px rgba(155, 211, 221, 0.2);
        }

        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px;
        }

        .form-checkbox {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 16px;
        }

        .form-checkbox input[type="checkbox"] {
            width: 20px;
            height: 20px;
            accent-color: #9BD3DD;
        }

        .form-checkbox label {
            color: #374151;
            font-size: 14px;
            font-weight: 500;
            cursor: pointer;
        }

        .form-checkbox .checkbox-desc {
            color: #6b7280;
            font-size: 12px;
            margin-top: 4px;
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

        .form-actions {
            display: flex;
            gap: 16px;
            justify-content: flex-end;
            margin-top: 32px;
            padding-top: 24px;
            border-top: 1px solid #e5e7eb;
        }

        .settings-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 24px;
        }

        .setting-card {
            background: #f8fafc;
            border: 1px solid #e5e7eb;
            border-radius: 12px;
            padding: 20px;
        }

        .setting-title {
            font-size: 16px;
            font-weight: 600;
            color: #1e293b;
            margin-bottom: 8px;
        }

        .setting-desc {
            font-size: 14px;
            color: #6b7280;
            margin-bottom: 16px;
        }

        .setting-value {
            font-size: 14px;
            color: #374151;
            font-weight: 500;
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

            .settings-tabs {
                flex-direction: column;
            }

            .form-row {
                grid-template-columns: 1fr;
            }

            .settings-grid {
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
                    <a href="{{ route('settings.index') }}" class="nav-item active">
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
                <h1 class="page-title">System Settings</h1>
                <p class="page-subtitle">Configure your quiz system preferences and options</p>
            </div>

            <div class="settings-tabs">
                <button class="tab-btn active" data-tab="general">General</button>
                <button class="tab-btn" data-tab="quiz">Quiz Settings</button>
                <button class="tab-btn" data-tab="security">Security</button>
                <button class="tab-btn" data-tab="notifications">Notifications</button>
                <button class="tab-btn" data-tab="integrations">Integrations</button>
            </div>

            <div class="settings-content">
                <!-- General Settings -->
                <div class="settings-section active" id="general">
                    <h3 class="section-title">General Settings</h3>
                    
                    <div class="form-group">
                        <label class="form-label">Site Name</label>
                        <input type="text" class="form-input" value="QuizMaster" placeholder="Enter site name">
                    </div>

                    <div class="form-group">
                        <label class="form-label">Site Description</label>
                        <textarea class="form-textarea" placeholder="Enter site description">A comprehensive online quiz system for educational institutions and corporate training.</textarea>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label">Default Language</label>
                            <select class="form-select">
                                <option>English</option>
                                <option>Spanish</option>
                                <option>French</option>
                                <option>German</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Time Zone</label>
                            <select class="form-select">
                                <option>UTC-8 (Pacific)</option>
                                <option>UTC-5 (Eastern)</option>
                                <option>UTC+0 (GMT)</option>
                                <option>UTC+1 (Central European)</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Contact Email</label>
                        <input type="email" class="form-input" value="admin@quizmaster.com" placeholder="Enter contact email">
                    </div>
                </div>

                <!-- Quiz Settings -->
                <div class="settings-section" id="quiz">
                    <h3 class="section-title">Quiz Settings</h3>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label">Default Quiz Duration (minutes)</label>
                            <input type="number" class="form-input" value="60" min="1" max="300">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Default Passing Score (%)</label>
                            <input type="number" class="form-input" value="70" min="0" max="100">
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label">Maximum Attempts per Quiz</label>
                            <input type="number" class="form-input" value="3" min="1" max="10">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Question Time Limit (seconds)</label>
                            <input type="number" class="form-input" value="30" min="5" max="300">
                        </div>
                    </div>

                    <div class="form-checkbox">
                        <input type="checkbox" id="randomize-questions" checked>
                        <div>
                            <label for="randomize-questions">Randomize Question Order</label>
                            <div class="checkbox-desc">Questions will be displayed in random order for each attempt</div>
                        </div>
                    </div>

                    <div class="form-checkbox">
                        <input type="checkbox" id="show-correct-answers" checked>
                        <div>
                            <label for="show-correct-answers">Show Correct Answers After Completion</label>
                            <div class="checkbox-desc">Students can see the correct answers after finishing the quiz</div>
                        </div>
                    </div>

                    <div class="form-checkbox">
                        <input type="checkbox" id="allow-review">
                        <div>
                            <label for="allow-review">Allow Answer Review</label>
                            <div class="checkbox-desc">Students can review their answers before submitting</div>
                        </div>
                    </div>
                </div>

                <!-- Security Settings -->
                <div class="settings-section" id="security">
                    <h3 class="section-title">Security Settings</h3>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label">Session Timeout (minutes)</label>
                            <input type="number" class="form-input" value="120" min="15" max="480">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Password Minimum Length</label>
                            <input type="number" class="form-input" value="8" min="6" max="20">
                        </div>
                    </div>

                    <div class="form-checkbox">
                        <input type="checkbox" id="require-email-verification" checked>
                        <div>
                            <label for="require-email-verification">Require Email Verification</label>
                            <div class="checkbox-desc">New users must verify their email before accessing the system</div>
                        </div>
                    </div>

                    <div class="form-checkbox">
                        <input type="checkbox" id="enable-2fa">
                        <div>
                            <label for="enable-2fa">Enable Two-Factor Authentication</label>
                            <div class="checkbox-desc">Add an extra layer of security with 2FA</div>
                        </div>
                    </div>

                    <div class="form-checkbox">
                        <input type="checkbox" id="log-user-activity" checked>
                        <div>
                            <label for="log-user-activity">Log User Activity</label>
                            <div class="checkbox-desc">Keep track of user actions for security purposes</div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Allowed IP Addresses (comma-separated)</label>
                        <textarea class="form-textarea" placeholder="192.168.1.1, 10.0.0.1" rows="3"></textarea>
                    </div>
                </div>

                <!-- Notification Settings -->
                <div class="settings-section" id="notifications">
                    <h3 class="section-title">Notification Settings</h3>
                    
                    <div class="form-checkbox">
                        <input type="checkbox" id="email-notifications" checked>
                        <div>
                            <label for="email-notifications">Enable Email Notifications</label>
                            <div class="checkbox-desc">Send email notifications for important events</div>
                        </div>
                    </div>

                    <div class="form-checkbox">
                        <input type="checkbox" id="quiz-completion-notification" checked>
                        <div>
                            <label for="quiz-completion-notification">Quiz Completion Notifications</label>
                            <div class="checkbox-desc">Notify when a student completes a quiz</div>
                        </div>
                    </div>

                    <div class="form-checkbox">
                        <input type="checkbox" id="new-user-notification" checked>
                        <div>
                            <label for="new-user-notification">New User Registration Notifications</label>
                            <div class="checkbox-desc">Notify admins when new users register</div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">SMTP Server</label>
                        <input type="text" class="form-input" value="smtp.gmail.com" placeholder="Enter SMTP server">
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label">SMTP Port</label>
                            <input type="number" class="form-input" value="587" placeholder="587">
                        </div>
                        <div class="form-group">
                            <label class="form-label">SMTP Username</label>
                            <input type="text" class="form-input" placeholder="Enter SMTP username">
                        </div>
                    </div>
                </div>

                <!-- Integration Settings -->
                <div class="settings-section" id="integrations">
                    <h3 class="section-title">Integration Settings</h3>
                    
                    <div class="settings-grid">
                        <div class="setting-card">
                            <div class="setting-title">Google Analytics</div>
                            <div class="setting-desc">Track website analytics and user behavior</div>
                            <div class="setting-value">Not Connected</div>
                        </div>

                        <div class="setting-card">
                            <div class="setting-title">Google Classroom</div>
                            <div class="setting-desc">Integrate with Google Classroom for seamless workflow</div>
                            <div class="setting-value">Not Connected</div>
                        </div>

                        <div class="setting-card">
                            <div class="setting-title">Microsoft Teams</div>
                            <div class="setting-desc">Connect with Microsoft Teams for collaboration</div>
                            <div class="setting-value">Not Connected</div>
                        </div>

                        <div class="setting-card">
                            <div class="setting-title">Zoom Integration</div>
                            <div class="setting-desc">Integrate with Zoom for virtual proctoring</div>
                            <div class="setting-value">Not Connected</div>
                        </div>
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="form-actions">
                    <button class="btn btn-secondary">Reset to Default</button>
                    <button class="btn btn-primary">Save Settings</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Tab functionality
        document.querySelectorAll('.tab-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                // Remove active class from all tabs and sections
                document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
                document.querySelectorAll('.settings-section').forEach(s => s.classList.remove('active'));
                
                // Add active class to clicked tab
                this.classList.add('active');
                
                // Show corresponding section
                const tabId = this.getAttribute('data-tab');
                document.getElementById(tabId).classList.add('active');
            });
        });

        // Save settings
        document.querySelector('.btn-primary').addEventListener('click', function() {
            Swal.fire({
                icon: 'success',
                title: 'Settings Saved!',
                text: 'Your settings have been saved successfully.',
                confirmButtonColor: '#9BD3DD',
                confirmButtonText: 'OK'
            });
        });

        // Reset to default
        document.querySelector('.btn-secondary').addEventListener('click', function() {
            Swal.fire({
                title: 'Reset Settings',
                text: 'Are you sure you want to reset all settings to default values?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ef4444',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Yes, reset!',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire('Reset!', 'Settings have been reset to default values.', 'success');
                }
            });
        });

        // Form validation
        document.querySelectorAll('.form-input, .form-select, .form-textarea').forEach(input => {
            input.addEventListener('blur', function() {
                if (this.hasAttribute('required') && !this.value) {
                    this.style.borderColor = '#ef4444';
                } else {
                    this.style.borderColor = '#d1d5db';
                }
            });
        });
    </script>
</body>
</html>
