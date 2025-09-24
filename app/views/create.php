<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Add New Student - Student Portal</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');
        
        body {
            font-family: 'Poppins', sans-serif;
        }

        :root {
            --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            --secondary-gradient: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            --accent-gradient: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
        }

        .glass-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.3);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
        }

        .glass-input {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            border: 2px solid rgba(255, 255, 255, 0.3);
            transition: all 0.3s ease;
        }

        .glass-input:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 20px rgba(102, 126, 234, 0.3);
            background: rgba(255, 255, 255, 1);
        }

        .btn-primary {
            background: var(--primary-gradient);
            color: white;
            border: none;
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(102, 126, 234, 0.4);
        }

        .btn-secondary {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            border: 2px solid rgba(255, 255, 255, 0.3);
            color: #374151;
            transition: all 0.3s ease;
        }

        .btn-secondary:hover {
            background: rgba(255, 255, 255, 1);
            border-color: #667eea;
            transform: translateY(-2px);
        }

        .floating-shape {
            position: absolute;
            border-radius: 50%;
            filter: blur(40px);
            opacity: 0.3;
            animation: float 6s ease-in-out infinite;
        }

        .floating-shape:nth-child(1) {
            background: var(--primary-gradient);
            width: 300px;
            height: 300px;
            top: 10%;
            right: 10%;
            animation-delay: 0s;
        }

        .floating-shape:nth-child(2) {
            background: var(--secondary-gradient);
            width: 250px;
            height: 250px;
            bottom: 10%;
            left: 10%;
            animation-delay: 2s;
        }

        .floating-shape:nth-child(3) {
            background: var(--accent-gradient);
            width: 200px;
            height: 200px;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            animation-delay: 4s;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0px) scale(1); }
            50% { transform: translateY(-20px) scale(1.05); }
        }

        .gradient-text {
            background: var(--primary-gradient);
            -webkit-background-clip: text;
            background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .preview-card {
            border-left: 4px solid;
            transition: all 0.3s ease;
        }

        .preview-card:hover {
            transform: translateX(5px);
        }

        .status-badge {
            display: inline-flex;
            align-items: center;
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 0.875rem;
            font-weight: 500;
            background: linear-gradient(135deg, #10b981, #059669);
            color: white;
        }
    </style>
</head>
<body class="min-h-screen bg-gradient-to-br from-purple-100 via-pink-50 to-indigo-100 relative overflow-hidden">
    <!-- Animated Background Shapes -->
    <div class="fixed inset-0 overflow-hidden pointer-events-none">
        <div class="floating-shape"></div>
        <div class="floating-shape"></div>
        <div class="floating-shape"></div>
    </div>

    <div class="container mx-auto p-8 max-w-6xl relative z-10">
        <!-- Header -->
        <div class="flex flex-col sm:flex-row items-start gap-4 mb-8">
            <a href="/students" class="glass-card rounded-xl px-4 py-2 inline-flex items-center gap-2 text-gray-700 hover:scale-105 transition-all shadow-lg">
                <i class="fas fa-arrow-left"></i>
                Back to Students
            </a>
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-gradient-to-r from-purple-500 to-indigo-600 rounded-xl flex items-center justify-center shadow-lg">
                    <i class="fas fa-user-plus text-white text-lg"></i>
                </div>
                <div>
                    <h1 class="text-4xl font-bold gradient-text">
                        Add New Student
                    </h1>
                    <p class="text-gray-600 mt-1">Create a new student record</p>
                </div>
            </div>
        </div>

        <div class="grid lg:grid-cols-2 gap-8">
            <!-- Form Section -->
            <div class="glass-card rounded-2xl p-8 shadow-xl hover:shadow-2xl transition-all">
                <div class="flex items-center gap-3 mb-8">
                    <div class="w-8 h-8 bg-gradient-to-r from-purple-500 to-indigo-600 rounded-lg flex items-center justify-center">
                        <i class="fas fa-edit text-white text-sm"></i>
                    </div>
                    <h2 class="text-xl font-semibold text-gray-800">Student Information</h2>
                </div>

                <form method="POST" action="/students/create" class="space-y-6">
                    <div class="space-y-3">
                        <label for="first_name" class="flex items-center gap-2 text-base font-medium text-gray-700">
                            <i class="fas fa-user text-purple-500"></i>
                            First Name
                        </label>
                        <input
                            id="first_name"
                            name="first_name"
                            type="text"
                            required
                            class="w-full rounded-xl h-12 px-4 glass-input text-gray-700"
                            placeholder="Enter first name"
                            oninput="updatePreview()"
                        />
                    </div>

                    <div class="space-y-3">
                        <label for="last_name" class="flex items-center gap-2 text-base font-medium text-gray-700">
                            <i class="fas fa-user text-indigo-500"></i>
                            Last Name
                        </label>
                        <input
                            id="last_name"
                            name="last_name"
                            type="text"
                            required
                            class="w-full rounded-xl h-12 px-4 glass-input text-gray-700"
                            placeholder="Enter last name"
                            oninput="updatePreview()"
                        />
                    </div>

                    <div class="space-y-3">
                        <label for="email" class="flex items-center gap-2 text-base font-medium text-gray-700">
                            <i class="fas fa-envelope text-purple-500"></i>
                            Email Address
                        </label>
                        <input
                            id="email"
                            name="email"
                            type="email"
                            required
                            class="w-full rounded-xl h-12 px-4 glass-input text-gray-700"
                            placeholder="Enter email address"
                            oninput="updatePreview()"
                        />
                    </div>

                    <div class="flex gap-4 pt-6">
                        <button type="submit" class="flex-1 btn-primary rounded-xl h-12 shadow-lg hover:shadow-xl inline-flex items-center justify-center gap-2 font-semibold">
                            <i class="fas fa-save"></i>
                            Save Student
                        </button>
                        <a href="/" class="px-8 rounded-xl btn-secondary inline-flex items-center justify-center font-medium">
                            Cancel
                        </a>
                    </div>
                </form>
            </div>

            <!-- Preview Section -->
            <div class="space-y-6">
                <!-- Live Preview Card -->
                <div class="glass-card rounded-2xl p-8 shadow-xl hover:shadow-2xl transition-all">
                    <div class="flex items-center gap-3 mb-8">
                        <div class="w-8 h-8 bg-gradient-to-r from-green-500 to-emerald-600 rounded-lg flex items-center justify-center">
                            <i class="fas fa-eye text-white text-sm"></i>
                        </div>
                        <h2 class="text-xl font-semibold text-gray-800">Live Preview</h2>
                    </div>

                    <div class="space-y-4">
                        <div class="preview-card glass-card rounded-xl p-4" style="border-left-color: #667eea;">
                            <p class="text-sm text-gray-500 mb-1">Full Name</p>
                            <p class="font-semibold text-gray-800" id="preview-name">First Last</p>
                        </div>

                        <div class="preview-card glass-card rounded-xl p-4" style="border-left-color: #764ba2;">
                            <p class="text-sm text-gray-500 mb-1">Email Address</p>
                            <p class="font-semibold text-gray-800" id="preview-email">email@example.com</p>
                        </div>

                        <div class="preview-card glass-card rounded-xl p-4" style="border-left-color: #10b981;">
                            <p class="text-sm text-gray-500 mb-1">Status</p>
                            <span class="status-badge">
                                <i class="fas fa-check-circle mr-2"></i>
                                Ready to Save
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Tips Card -->
                <div class="glass-card rounded-2xl p-6 shadow-xl">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-8 h-8 bg-gradient-to-r from-yellow-500 to-orange-500 rounded-lg flex items-center justify-center">
                            <i class="fas fa-lightbulb text-white text-sm"></i>
                        </div>
                        <h3 class="font-semibold text-gray-800">Pro Tips</h3>
                    </div>
                    <ul class="space-y-2 text-sm text-gray-600">
                        <li class="flex items-start gap-2">
                            <i class="fas fa-check text-green-500 mt-1 text-xs"></i>
                            Use a valid email address for notifications
                        </li>
                        <li class="flex items-start gap-2">
                            <i class="fas fa-check text-green-500 mt-1 text-xs"></i>
                            Double-check spelling before saving
                        </li>
                        <li class="flex items-start gap-2">
                            <i class="fas fa-check text-green-500 mt-1 text-xs"></i>
                            All fields are required
                        </li>
                    </ul>
                </div>

                <!-- Quick Actions -->
                <div class="glass-card rounded-2xl p-6 shadow-xl">
                    <h3 class="font-semibold text-gray-800 mb-4 flex items-center gap-2">
                        <i class="fas fa-bolt text-purple-500"></i>
                        Quick Actions
                    </h3>
                    <div class="space-y-3">
                        <button type="button" class="w-full p-3 text-left rounded-lg bg-gradient-to-r from-purple-50 to-indigo-50 hover:from-purple-100 hover:to-indigo-100 transition-all border border-purple-200">
                            <div class="flex items-center gap-3">
                                <i class="fas fa-magic text-purple-500"></i>
                                <div>
                                    <p class="font-medium text-gray-800">Auto-fill Demo Data</p>
                                    <p class="text-xs text-gray-500">Fill form with sample data</p>
                                </div>
                            </div>
                        </button>
                        <button type="button" class="w-full p-3 text-left rounded-lg bg-gradient-to-r from-blue-50 to-cyan-50 hover:from-blue-100 hover:to-cyan-100 transition-all border border-blue-200">
                            <div class="flex items-center gap-3">
                                <i class="fas fa-eraser text-blue-500"></i>
                                <div>
                                    <p class="font-medium text-gray-800">Clear All Fields</p>
                                    <p class="text-xs text-gray-500">Reset the form</p>
                                </div>
                            </div>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function updatePreview() {
            const first = document.getElementById('first_name').value || 'First';
            const last = document.getElementById('last_name').value || 'Last';
            const email = document.getElementById('email').value || 'email@example.com';
            
            document.getElementById('preview-name').textContent = first + ' ' + last;
            document.getElementById('preview-email').textContent = email;
        }

        // Quick Actions functionality
        document.addEventListener('DOMContentLoaded', function() {
            // Auto-fill demo data
            document.querySelector('button[type="button"]:first-of-type').addEventListener('click', function() {
                document.getElementById('first_name').value = 'John';
                document.getElementById('last_name').value = 'Doe';
                document.getElementById('email').value = 'john.doe@example.com';
                updatePreview();
            });

            // Clear all fields
            document.querySelector('button[type="button"]:last-of-type').addEventListener('click', function() {
                document.getElementById('first_name').value = '';
                document.getElementById('last_name').value = '';
                document.getElementById('email').value = '';
                updatePreview();
            });
        });
    </script>
</body>
</html>