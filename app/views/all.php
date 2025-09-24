<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Student Management Dashboard</title>
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

        .pagination {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 0.5rem;
            margin-top: 2rem;
        }

        .pagination .page-item {
            list-style: none;
        }

        .pagination .page-link {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            color: #374151;
            font-size: 0.875rem;
            font-weight: 500;
            text-decoration: none;
            transition: all 0.2s ease;
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .pagination .page-link:hover {
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            transform: scale(1.1);
        }

        .pagination .page-item.active .page-link {
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
        }

        .search-container {
            position: relative;
            max-width: 400px;
        }

        .search-input {
            background: rgba(255, 255, 255, 0.9);
            border: 2px solid transparent;
            border-radius: 25px;
            padding: 12px 20px 12px 50px;
            width: 100%;
            transition: all 0.3s ease;
            color: #374151;
        }

        .search-input:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 20px rgba(102, 126, 234, 0.3);
        }

        .search-icon {
            position: absolute;
            left: 18px;
            top: 50%;
            transform: translateY(-50%);
            color: #9CA3AF;
        }

        .student-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border-radius: 16px;
            border: 1px solid rgba(255, 255, 255, 0.3);
            color: #374151;
            transition: all 0.3s ease;
        }

        .student-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
        }

        .action-btn {
            padding: 8px 16px;
            border-radius: 20px;
            font-size: 0.875rem;
            font-weight: 500;
            transition: all 0.2s ease;
            text-decoration: none;
            display: inline-block;
        }

        .edit-btn {
            background: linear-gradient(135deg, #fbbf24, #f59e0b);
            color: white;
        }

        .edit-btn:hover {
            transform: scale(1.05);
            box-shadow: 0 4px 15px rgba(251, 191, 36, 0.4);
        }

        .delete-btn {
            background: linear-gradient(135deg, #ef4444, #dc2626);
            color: white;
        }

        .delete-btn:hover {
            transform: scale(1.05);
            box-shadow: 0 4px 15px rgba(239, 68, 68, 0.4);
        }

        .floating-nav {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.3);
        }

        .add-student-btn {
            background: linear-gradient(135deg, #10b981, #059669);
            color: white;
            padding: 10px 20px;
            border-radius: 25px;
            font-weight: 600;
            transition: all 0.2s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .add-student-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(16, 185, 129, 0.4);
        }
    </style>
</head>
<body class="min-h-screen bg-gradient-to-br from-purple-100 via-pink-50 to-indigo-100">
    <!-- Navigation -->
    <nav class="fixed top-0 w-full floating-nav shadow-lg z-50">
        <div class="max-w-7xl mx-auto px-6 py-4 flex justify-between items-center">
            <div class="flex items-center space-x-3">
                <div class="w-10 h-10 bg-gradient-to-r from-purple-500 to-indigo-600 rounded-full flex items-center justify-center">
                    <i class="fas fa-graduation-cap text-white text-lg"></i>
                </div>
                <span class="text-xl font-bold gradient-text">StudentHub</span>
            </div>
            <a href="/students/create" class="add-student-btn">
                <i class="fas fa-plus"></i>
                Add Student
            </a>
        </div>
    </nav>

    <!-- Header Section -->
    <section class="pt-32 pb-16 text-center">
        <div class="max-w-4xl mx-auto px-6">
            <h1 class="text-5xl md:text-7xl font-bold gradient-text mb-4">
                Student Management
            </h1>
            <p class="text-gray-600 text-lg">Manage your students with style and efficiency</p>
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

        <!-- Search and Controls -->
        <div class="mb-8 flex flex-col md:flex-row gap-6 items-center justify-between">
            <form method="GET" action="/students" class="search-container">
                <?php if (isset($per_page) && $per_page != 10): ?>
                    <input type="hidden" name="per_page" value="<?= $per_page ?>">
                <?php endif; ?>
                <div class="relative">
                    <i class="fas fa-search search-icon"></i>
                    <input type="text" 
                           name="search"
                           id="searchInput"
                           value="<?= htmlspecialchars($search ?? '') ?>"
                           placeholder="Search students by name or email..."
                           class="search-input">
                    <?php if (!empty($search)): ?>
                        <a href="/students" class="absolute right-4 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-gray-600">
                            <i class="fas fa-times"></i>
                        </a>
                    <?php endif; ?>
                </div>
            </form>

            <!-- Per Page Selector -->
            <form method="GET" action="/" class="flex items-center space-x-3">
                <?php if (!empty($search)): ?>
                    <input type="hidden" name="search" value="<?= htmlspecialchars($search) ?>">
                <?php endif; ?>
                <span class="text-gray-600 font-medium">Show:</span>
                <select name="per_page" 
                        id="per_page" 
                        class="bg-white border border-gray-300 rounded-lg px-3 py-2 text-gray-700 focus:outline-none focus:ring-2 focus:ring-purple-500"
                        onchange="this.form.submit()">
                    <option value="10" <?= ($per_page ?? 10) == 10 ? 'selected' : '' ?>>10</option>
                    <option value="25" <?= ($per_page ?? 10) == 25 ? 'selected' : '' ?>>25</option>
                    <option value="50" <?= ($per_page ?? 10) == 50 ? 'selected' : '' ?>>50</option>
                    <option value="100" <?= ($per_page ?? 10) == 100 ? 'selected' : '' ?>>100</option>
                </select>
                <span class="text-gray-600 font-medium">per page</span>
            </form>
        </div>

        <!-- Pagination Info -->
        <?php if (isset($pagination_info) && !empty($pagination_info)): ?>
            <div class="text-center mb-6">
                <p class="text-gray-600 font-medium"><?= $pagination_info ?></p>
            </div>
        <?php endif; ?>

        <!-- Students Grid -->
        <div class="space-y-4">
            <?php if (!empty($students)): ?>
                <!-- Desktop Table View -->
                <div class="hidden md:block">
                    <div class="student-card overflow-hidden">
                        <div class="bg-gradient-to-r from-purple-500 to-indigo-600 text-white p-4">
                            <div class="grid grid-cols-5 gap-4 font-semibold">
                                <div>Student ID</div>
                                <div>Last Name</div>
                                <div>First Name</div>
                                <div>Email Address</div>
                                <div class="text-center">Actions</div>
                            </div>
                        </div>
                        <div class="divide-y divide-gray-200">
                            <?php foreach($students as $s): ?>
                                <div class="grid grid-cols-5 gap-4 p-4 hover:bg-purple-50 transition-colors">
                                    <div class="font-semibold text-purple-600">#<?= htmlspecialchars($s['id']) ?></div>
                                    <div class="font-medium"><?= htmlspecialchars($s['last_name']) ?></div>
                                    <div class="font-medium"><?= htmlspecialchars($s['first_name']) ?></div>
                                    <div class="text-gray-600"><?= htmlspecialchars($s['email']) ?></div>
                                    <div class="flex justify-center space-x-2">
                                        <a href="students/edit/<?= $s['id'] ?>" class="action-btn edit-btn">
                                            <i class="fas fa-edit mr-1"></i>Edit
                                        </a>
                                        <a href="/students/delete/<?= $s['id'] ?>" 
                                           onclick="return confirm('Are you sure you want to delete this student?')" 
                                           class="action-btn delete-btn">
                                            <i class="fas fa-trash mr-1"></i>Delete
                                        </a>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>

                <!-- Mobile Card View -->
                <div class="md:hidden space-y-4">
                    <?php foreach($students as $s): ?>
                        <div class="student-card p-6 card-hover">
                            <div class="flex items-start justify-between mb-4">
                                <div>
                                    <h3 class="text-lg font-bold text-gray-800">
                                        <?= htmlspecialchars($s['first_name']) ?> <?= htmlspecialchars($s['last_name']) ?>
                                    </h3>
                                    <p class="text-purple-600 font-semibold">#<?= htmlspecialchars($s['id']) ?></p>
                                </div>
                                <div class="w-12 h-12 bg-gradient-to-r from-purple-500 to-indigo-600 rounded-full flex items-center justify-center">
                                    <i class="fas fa-user text-white"></i>
                                </div>
                            </div>
                            <div class="mb-4">
                                <p class="text-gray-600 flex items-center">
                                    <i class="fas fa-envelope mr-2 text-purple-500"></i>
                                    <?= htmlspecialchars($s['email']) ?>
                                </p>
                            </div>
                            <div class="flex space-x-2">
                                <a href="students/edit/<?= $s['id'] ?>" class="action-btn edit-btn flex-1 text-center">
                                    <i class="fas fa-edit mr-1"></i>Edit
                                </a>
                                <a href="/students/delete/<?= $s['id'] ?>" 
                                   onclick="return confirm('Are you sure you want to delete this student?')" 
                                   class="action-btn delete-btn flex-1 text-center">
                                    <i class="fas fa-trash mr-1"></i>Delete
                                </a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <div class="student-card p-12 text-center">
                    <div class="w-20 h-20 bg-gradient-to-r from-purple-500 to-indigo-600 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-users text-white text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-2">
                        <?php if (!empty($search)): ?>
                            No students found matching "<?= htmlspecialchars($search) ?>"
                        <?php else: ?>
                            No students found
                        <?php endif; ?>
                    </h3>
                    <p class="text-gray-600 mb-4">
                        <?php if (!empty($search)): ?>
                            Try adjusting your search criteria or browse all students.
                        <?else: ?>
                            Start by adding your first student to the system.
                        <?php endif; ?>
                    </p>
                    <?php if (!empty($search)): ?>
                        <a href="/students" class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-purple-500 to-indigo-600 text-white rounded-lg hover:shadow-lg transition-all">
                            <i class="fas fa-list mr-2"></i>
                            Show all students
                        </a>
                    <?php else: ?>
                        <a href="/students/create" class="add-student-btn">
                            <i class="fas fa-plus"></i>
                            Add your first student
                        </a>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        </div>

        <!-- Pagination Controls -->
        <?php if (isset($pagination_html) && !empty($pagination_html)): ?>
            <div class="pagination-wrapper mt-8">
                <?= $pagination_html ?>
            </div>
        <?php endif; ?>

        <!-- Additional pagination info -->
        <?php if (isset($current_page) && isset($total_pages)): ?>
            <div class="text-center text-gray-600 mt-4">
                <span class="px-3 py-1 bg-white rounded-full shadow-sm border">
                    Page <?= $current_page ?> of <?= $total_pages ?>
                </span>
            </div>
        <?php endif; ?>
    </div>

    <script>
        // Auto-submit search form on input with debounce
        let searchTimeout;
        document.getElementById("searchInput").addEventListener("input", function() {
            clearTimeout(searchTimeout);
            const form = this.form;
            searchTimeout = setTimeout(() => {
                form.submit();
            }, 500); // 500ms delay
        });

        // Handle browser back/forward buttons
        window.addEventListener('popstate', function(e) {
            window.location.reload();
        });

        // Show loading state for better UX
        document.querySelectorAll('form').forEach(form => {
            form.addEventListener('submit', function() {
                const submitBtn = form.querySelector('input[type="submit"], button[type="submit"]');
                if (submitBtn) {
                    submitBtn.disabled = true;
                    submitBtn.textContent = 'Loading...';
                }
            });
        });

        // Add smooth scroll behavior
        document.documentElement.style.scrollBehavior = 'smooth';
    </script>
</body>
</html>