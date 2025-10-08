<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Register - Student Management</title>
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

        .auth-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border-radius: 20px;
            border: 1px solid rgba(255, 255, 255, 0.3);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
        }

        .input-field {
            background: rgba(255, 255, 255, 0.9);
            border: 2px solid transparent;
            border-radius: 15px;
            padding: 15px 20px;
            width: 100%;
            transition: all 0.3s ease;
            color: #374151;
            font-size: 16px;
        }

        .input-field:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 20px rgba(102, 126, 234, 0.3);
            background: rgba(255, 255, 255, 1);
        }

        .input-field::placeholder {
            color: #9CA3AF;
        }

        .select-field {
            background: rgba(255, 255, 255, 0.9);
            border: 2px solid transparent;
            border-radius: 15px;
            padding: 15px 20px;
            width: 100%;
            transition: all 0.3s ease;
            color: #374151;
            font-size: 16px;
            cursor: pointer;
        }

        .select-field:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 20px rgba(102, 126, 234, 0.3);
            background: rgba(255, 255, 255, 1);
        }

        .register-btn {
            background: linear-gradient(135deg, #10b981, #059669);
            color: white;
            padding: 15px 30px;
            border-radius: 15px;
            font-weight: 600;
            font-size: 16px;
            transition: all 0.3s ease;
            border: none;
            cursor: pointer;
            width: 100%;
        }

        .register-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(16, 185, 129, 0.4);
        }

        .register-btn:active {
            transform: translateY(0);
        }

        .floating-nav {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.3);
        }

        .input-group {
            position: relative;
            margin-bottom: 20px;
        }

        .input-icon {
            position: absolute;
            left: 18px;
            top: 50%;
            transform: translateY(-50%);
            color: #9CA3AF;
            z-index: 10;
        }

        .input-field.with-icon {
            padding-left: 50px;
        }

        .select-field.with-icon {
            padding-left: 50px;
        }

        .error-message {
            background: rgba(239, 68, 68, 0.1);
            border: 1px solid rgba(239, 68, 68, 0.3);
            color: #dc2626;
            padding: 12px 16px;
            border-radius: 10px;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .success-message {
            background: rgba(16, 185, 129, 0.1);
            border: 1px solid rgba(16, 185, 129, 0.3);
            color: #059669;
            padding: 12px 16px;
            border-radius: 10px;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .password-strength {
            margin-top: 5px;
            font-size: 12px;
        }

        .strength-weak { color: #ef4444; }
        .strength-medium { color: #f59e0b; }
        .strength-strong { color: #10b981; }
    </style>
</head>
<body class="min-h-screen bg-gradient-to-br from-purple-100 via-pink-50 to-indigo-100 flex items-center justify-center p-4">
    <!-- Navigation -->
    <nav class="fixed top-0 w-full floating-nav shadow-lg z-50">
        <div class="max-w-7xl mx-auto px-6 py-4 flex justify-between items-center">
            <div class="flex items-center space-x-3">
                <div class="w-10 h-10 bg-gradient-to-r from-purple-500 to-indigo-600 rounded-full flex items-center justify-center">
                    <i class="fas fa-graduation-cap text-white text-lg"></i>
                </div>
                <span class="text-xl font-bold gradient-text">StudentHub</span>
            </div>
        </div>
    </nav>

    <!-- Register Card -->
    <div class="w-full max-w-md">
        <div class="auth-card p-8">
            <!-- Header -->
            <div class="text-center mb-8">
                <div class="w-16 h-16 bg-gradient-to-r from-green-500 to-emerald-600 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-user-plus text-white text-2xl"></i>
                </div>
                <h1 class="text-3xl font-bold gradient-text mb-2">Create Account</h1>
                <p class="text-gray-600">Join StudentHub and start managing students</p>
            </div>

            <!-- Error/Success Messages -->
            <?php if (isset($_SESSION['error'])): ?>
                <div class="error-message">
                    <i class="fas fa-exclamation-circle"></i>
                    <span><?= $_SESSION['error']; unset($_SESSION['error']); ?></span>
                </div>
            <?php endif; ?>

            <?php if (isset($_SESSION['success'])): ?>
                <div class="success-message">
                    <i class="fas fa-check-circle"></i>
                    <span><?= $_SESSION['success']; unset($_SESSION['success']); ?></span>
                </div>
            <?php endif; ?>

            <!-- Register Form -->
            <form method="post" action="<?= site_url('auth/register'); ?>" class="space-y-6" id="registerForm">
                <div class="grid grid-cols-2 gap-4">
                    <div class="input-group">
                        <i class="fas fa-user input-icon"></i>
                        <input type="text" 
                               name="first_name" 
                               placeholder="First Name" 
                               class="input-field with-icon"
                               required>
                    </div>

                    <div class="input-group">
                        <i class="fas fa-user input-icon"></i>
                        <input type="text" 
                               name="last_name" 
                               placeholder="Last Name" 
                               class="input-field with-icon"
                               required>
                    </div>
                </div>

                <div class="input-group">
                    <i class="fas fa-envelope input-icon"></i>
                    <input type="email" 
                           name="email" 
                           placeholder="Enter Email Address" 
                           class="input-field with-icon"
                           required>
                </div>

                <div class="input-group">
                    <i class="fas fa-lock input-icon"></i>
                    <input type="password" 
                           name="password" 
                           id="password"
                           placeholder="Create Password" 
                           class="input-field with-icon"
                           required>
                    <div class="password-strength" id="passwordStrength"></div>
                </div>

                <div class="input-group">
                    <i class="fas fa-lock input-icon"></i>
                    <input type="password" 
                           name="confirm_password" 
                           id="confirmPassword"
                           placeholder="Confirm Password" 
                           class="input-field with-icon"
                           required>
                </div>

                <div class="input-group">
                    <i class="fas fa-user-tag input-icon"></i>
                    <select name="role" class="select-field with-icon" required>
                        <option value="user" selected>👤 Regular User</option>
                        <option value="admin">👑 Administrator</option>
                    </select>
                </div>

                <button type="submit" class="register-btn">
                    <i class="fas fa-user-plus mr-2"></i>
                    Create Account
                </button>
            </form>

            <!-- Footer -->
            <div class="text-center mt-8">
                <p class="text-gray-600">
                    Already have an account?
                    <a href="<?= site_url('auth/login'); ?>" 
                       class="text-purple-600 hover:text-purple-700 font-semibold transition-colors">
                        Sign in here
                    </a>
                </p>
            </div>
        </div>
    </div>

    <script>
        // Add smooth animations
        document.addEventListener('DOMContentLoaded', function() {
            const card = document.querySelector('.auth-card');
            card.style.opacity = '0';
            card.style.transform = 'translateY(20px)';
            
            setTimeout(() => {
                card.style.transition = 'all 0.6s ease';
                card.style.opacity = '1';
                card.style.transform = 'translateY(0)';
            }, 100);
        });

        // Password strength indicator
        document.getElementById('password').addEventListener('input', function() {
            const password = this.value;
            const strengthDiv = document.getElementById('passwordStrength');
            
            if (password.length === 0) {
                strengthDiv.textContent = '';
                return;
            }
            
            let strength = 0;
            if (password.length >= 8) strength++;
            if (/[A-Z]/.test(password)) strength++;
            if (/[a-z]/.test(password)) strength++;
            if (/[0-9]/.test(password)) strength++;
            if (/[^A-Za-z0-9]/.test(password)) strength++;
            
            if (strength < 2) {
                strengthDiv.textContent = 'Weak password';
                strengthDiv.className = 'password-strength strength-weak';
            } else if (strength < 4) {
                strengthDiv.textContent = 'Medium strength';
                strengthDiv.className = 'password-strength strength-medium';
            } else {
                strengthDiv.textContent = 'Strong password';
                strengthDiv.className = 'password-strength strength-strong';
            }
        });

        // Password confirmation validation
        document.getElementById('confirmPassword').addEventListener('input', function() {
            const password = document.getElementById('password').value;
            const confirmPassword = this.value;
            
            if (confirmPassword && password !== confirmPassword) {
                this.setCustomValidity('Passwords do not match');
                this.style.borderColor = '#ef4444';
            } else {
                this.setCustomValidity('');
                this.style.borderColor = '';
            }
        });

        // Form validation feedback
        document.getElementById('registerForm').addEventListener('submit', function(e) {
            const password = document.getElementById('password').value;
            const confirmPassword = document.getElementById('confirmPassword').value;
            
            if (password !== confirmPassword) {
                e.preventDefault();
                alert('Passwords do not match!');
                return;
            }
            
            const submitBtn = this.querySelector('button[type="submit"]');
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Creating Account...';
        });

        // Add focus effects
        document.querySelectorAll('.input-field, .select-field').forEach(input => {
            input.addEventListener('focus', function() {
                this.parentElement.classList.add('ring-2', 'ring-purple-500', 'ring-opacity-50');
            });
            
            input.addEventListener('blur', function() {
                this.parentElement.classList.remove('ring-2', 'ring-purple-500', 'ring-opacity-50');
            });
        });
    </script>
</body>
</html>
