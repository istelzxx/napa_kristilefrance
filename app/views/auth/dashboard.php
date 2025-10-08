<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Dashboard - Student Management</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');
        
        body {
            font-family: 'Poppins', sans-serif;
        }

        .glass-effect {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .gradient-text {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            -webkit-background-clip: text;
            background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .card-hover {
            transition: all 0.3s ease;
        }

        .card-hover:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
        }

        .floating-nav {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.3);
        }

        .dashboard-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border-radius: 16px;
            border: 1px solid rgba(255, 255, 255, 0.3);
            color: #374151;
            transition: all 0.3s ease;
        }

        .dashboard-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
        }

        .action-btn {
            padding: 12px 24px;
            border-radius: 25px;
            font-size: 0.875rem;
            font-weight: 600;
            transition: all 0.2s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .primary-btn {
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
        }

        .primary-btn:hover {
            transform: scale(1.05);
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
        }

        .secondary-btn {
            background: linear-gradient(135deg, #10b981, #059669);
            color: white;
        }

        .secondary-btn:hover {
            transform: scale(1.05);
            box-shadow: 0 4px 15px rgba(16, 185, 129, 0.4);
        }

        .danger-btn {
            background: linear-gradient(135deg, #ef4444, #dc2626);
            color: white;
        }

        .danger-btn:hover {
            transform: scale(1.05);
            box-shadow: 0 4px 15px rgba(239, 68, 68, 0.4);
        }

        .stats-card {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(20px);
            border-radius: 16px;
            border: 1px solid rgba(255, 255, 255, 0.3);
            transition: all 0.3s ease;
        }

        .stats-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body class="min-h-screen bg-gradient-to-br from-purple-100 via-pink-50 to-indigo-100">
    <?php $session = lava_instance()->session; ?>
    
    <!-- Navigation -->
    <nav class="fixed top-0 w-full floating-nav shadow-lg z-50">
        <div class="max-w-7xl mx-auto px-6 py-4 flex justify-between items-center">
            <div class="flex items-center space-x-3">
                <div class="w-10 h-10 bg-gradient-to-r from-purple-500 to-indigo-600 rounded-full flex items-center justify-center">
                    <i class="fas fa-graduation-cap text-white text-lg"></i>
                </div>
                <span class="text-xl font-bold gradient-text">StudentHub</span>
            </div>
            <div class="flex items-center space-x-4">
                <span class="text-gray-600">Welcome, <span class="font-semibold text-purple-600"><?= $session->userdata('first_name') ?> <?= $session->userdata('last_name') ?></span></span>
                <a href="<?= site_url('auth/logout') ?>" 
                   class="danger-btn"
                   onclick="return confirm('Are you sure you want to log out?')">
                    <i class="fas fa-sign-out-alt"></i>
                    Logout
                </a>
            </div>
        </div>
    </nav>

    <!-- Header Section -->
    <section class="pt-32 pb-16 text-center">
        <div class="max-w-4xl mx-auto px-6">
            <h1 class="text-5xl md:text-7xl font-bold gradient-text mb-4">
                Welcome to Dashboard
            </h1>
            <p class="text-gray-600 text-lg">Manage your student management system efficiently</p>
        </div>
    </section>

    <div class="max-w-7xl mx-auto px-6 pb-16">
        <!-- Success/Error Messages -->
        <?php if (isset($_SESSION['success'])): ?>
            <div class="mb-6 bg-green-100 border border-green-300 text-green-700 px-6 py-4 rounded-xl flex items-center space-x-3">
                <i class="fas fa-check-circle text-green-500"></i>
                <span><?= $_SESSION['success']; unset($_SESSION['success']); ?></span>
            </div>
        <?php endif; ?>
        
        <?php if (isset($_SESSION['error'])): ?>
            <div class="mb-6 bg-red-100 border border-red-300 text-red-700 px-6 py-4 rounded-xl flex items-center space-x-3">
                <i class="fas fa-exclamation-circle text-red-500"></i>
                <span><?= $_SESSION['error']; unset($_SESSION['error']); ?></span>
            </div>
        <?php endif; ?>

        <!-- User Info Card -->
        <div class="dashboard-card p-8 mb-8 card-hover">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-6">
                    <div class="w-20 h-20 bg-gradient-to-r from-purple-500 to-indigo-600 rounded-full flex items-center justify-center">
                        <i class="fas fa-user text-white text-2xl"></i>
                    </div>
                    <div>
                        <h2 class="text-2xl font-bold text-gray-800 mb-2">
                            <?= $session->userdata('first_name') ?> <?= $session->userdata('last_name') ?>
                        </h2>
                        <div class="flex items-center space-x-4">
                            <span class="px-3 py-1 bg-purple-100 text-purple-700 rounded-full text-sm font-medium">
                                <i class="fas fa-user-tag mr-1"></i>
                                <?= ucfirst($session->userdata('role')) ?>
                            </span>
                            <span class="text-gray-600">
                                <i class="fas fa-envelope mr-1"></i>
                                <?= $session->userdata('email') ?>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="text-right">
                    <p class="text-sm text-gray-500 mb-2">Last Login</p>
                    <p class="text-gray-700 font-medium"><?= date('M d, Y \a\t g:i A') ?></p>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="mb-8">
            <h3 class="text-2xl font-bold text-gray-800 mb-6">Quick Actions</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <a href="/students" class="dashboard-card p-6 text-center card-hover group">
                    <div class="w-16 h-16 bg-gradient-to-r from-blue-500 to-cyan-600 rounded-full flex items-center justify-center mx-auto mb-4 group-hover:scale-110 transition-transform">
                        <i class="fas fa-users text-white text-2xl"></i>
                    </div>
                    <h4 class="text-lg font-semibold text-gray-800 mb-2">View Students</h4>
                    <p class="text-gray-600 text-sm">Browse and manage all students</p>
                </a>

                <a href="/students/create" class="dashboard-card p-6 text-center card-hover group">
                    <div class="w-16 h-16 bg-gradient-to-r from-green-500 to-emerald-600 rounded-full flex items-center justify-center mx-auto mb-4 group-hover:scale-110 transition-transform">
                        <i class="fas fa-user-plus text-white text-2xl"></i>
                    </div>
                    <h4 class="text-lg font-semibold text-gray-800 mb-2">Add Student</h4>
                    <p class="text-gray-600 text-sm">Register a new student</p>
                </a>

                <a href="/students" class="dashboard-card p-6 text-center card-hover group">
                    <div class="w-16 h-16 bg-gradient-to-r from-yellow-500 to-orange-600 rounded-full flex items-center justify-center mx-auto mb-4 group-hover:scale-110 transition-transform">
                        <i class="fas fa-search text-white text-2xl"></i>
                    </div>
                    <h4 class="text-lg font-semibold text-gray-800 mb-2">Search Students</h4>
                    <p class="text-gray-600 text-sm">Find specific students quickly</p>
                </a>

                <a href="<?= site_url('auth/logout') ?>" 
                   onclick="return confirm('Are you sure you want to log out?')"
                   class="dashboard-card p-6 text-center card-hover group">
                    <div class="w-16 h-16 bg-gradient-to-r from-red-500 to-pink-600 rounded-full flex items-center justify-center mx-auto mb-4 group-hover:scale-110 transition-transform">
                        <i class="fas fa-sign-out-alt text-white text-2xl"></i>
                    </div>
                    <h4 class="text-lg font-semibold text-gray-800 mb-2">Logout</h4>
                    <p class="text-gray-600 text-sm">Sign out of your account</p>
                </a>
            </div>
        </div>

        <!-- Statistics Cards -->
        <div class="mb-8">
            <h3 class="text-2xl font-bold text-gray-800 mb-6">System Overview</h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="stats-card p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-600 text-sm font-medium">Total Students</p>
                            <p class="text-3xl font-bold text-gray-800">0</p>
                        </div>
                        <div class="w-12 h-12 bg-gradient-to-r from-blue-500 to-cyan-600 rounded-full flex items-center justify-center">
                            <i class="fas fa-users text-white"></i>
                        </div>
                    </div>
                </div>

                <div class="stats-card p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-600 text-sm font-medium">Active Users</p>
                            <p class="text-3xl font-bold text-gray-800">1</p>
                        </div>
                        <div class="w-12 h-12 bg-gradient-to-r from-green-500 to-emerald-600 rounded-full flex items-center justify-center">
                            <i class="fas fa-user-check text-white"></i>
                        </div>
                    </div>
                </div>

                <div class="stats-card p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-600 text-sm font-medium">System Status</p>
                            <p class="text-lg font-bold text-green-600">Online</p>
                        </div>
                        <div class="w-12 h-12 bg-gradient-to-r from-green-500 to-emerald-600 rounded-full flex items-center justify-center">
                            <i class="fas fa-check-circle text-white"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Activity -->
        <div class="dashboard-card p-8">
            <h3 class="text-2xl font-bold text-gray-800 mb-6">Recent Activity</h3>
            <div class="space-y-4">
                <div class="flex items-center space-x-4 p-4 bg-gray-50 rounded-lg">
                    <div class="w-10 h-10 bg-gradient-to-r from-purple-500 to-indigo-600 rounded-full flex items-center justify-center">
                        <i class="fas fa-sign-in-alt text-white text-sm"></i>
                    </div>
                    <div class="flex-1">
                        <p class="text-gray-800 font-medium">You logged in successfully</p>
                        <p class="text-gray-600 text-sm"><?= date('M d, Y \a\t g:i A') ?></p>
                    </div>
                </div>
                
                <div class="flex items-center space-x-4 p-4 bg-gray-50 rounded-lg">
                    <div class="w-10 h-10 bg-gradient-to-r from-green-500 to-emerald-600 rounded-full flex items-center justify-center">
                        <i class="fas fa-user-plus text-white text-sm"></i>
                    </div>
                    <div class="flex-1">
                        <p class="text-gray-800 font-medium">Account created successfully</p>
                        <p class="text-gray-600 text-sm">Welcome to StudentHub!</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Add smooth animations
        document.addEventListener('DOMContentLoaded', function() {
            const cards = document.querySelectorAll('.dashboard-card, .stats-card');
            cards.forEach((card, index) => {
                card.style.opacity = '0';
                card.style.transform = 'translateY(20px)';
                
                setTimeout(() => {
                    card.style.transition = 'all 0.6s ease';
                    card.style.opacity = '1';
                    card.style.transform = 'translateY(0)';
                }, 100 + (index * 100));
            });
        });

        // Add smooth scroll behavior
        document.documentElement.style.scrollBehavior = 'smooth';
    </script>
</body>
</html>

