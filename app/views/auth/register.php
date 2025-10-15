<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Register - StudentHub</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
  <style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');
    body {
      font-family: 'Poppins', sans-serif;
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
    .input-icon {
      position: absolute;
      left: 18px;
      top: 50%;
      transform: translateY(-50%);
      color: #9CA3AF;
    }
    .input-group {
      position: relative;
      margin-bottom: 1rem;
    }
    .input-field.with-icon {
      padding-left: 50px;
    }
    .register-btn {
      background: linear-gradient(135deg, #667eea, #764ba2);
      color: white;
      padding: 15px;
      border-radius: 15px;
      font-weight: 600;
      width: 100%;
      transition: all 0.3s ease;
    }
    .register-btn:hover {
      transform: translateY(-2px);
      box-shadow: 0 10px 25px rgba(102, 126, 234, 0.4);
    }
    .gradient-text {
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
    }
  </style>
</head>

<body class="min-h-screen bg-gradient-to-br from-purple-100 via-pink-50 to-indigo-100 flex items-center justify-center p-4">
  <div class="w-full max-w-md">
    <div class="auth-card p-8">
      <div class="text-center mb-8">
        <div class="w-16 h-16 bg-gradient-to-r from-purple-500 to-indigo-600 rounded-full flex items-center justify-center mx-auto mb-4">
          <i class="fas fa-user-plus text-white text-2xl"></i>
        </div>
        <h1 class="text-3xl font-bold gradient-text mb-2">Create Account</h1>
        <p class="text-gray-600">Join StudentHub today</p>
      </div>

      <!-- Registration Form -->
      <form method="POST" action="<?= site_url('auth/register'); ?>" class="space-y-4">
        <!-- Username -->
        <div class="input-group">
          <i class="fas fa-user input-icon"></i>
          <input type="text" name="username" placeholder="Enter your username" required class="input-field with-icon">
        </div>

        <!-- Email -->
        <div class="input-group">
          <i class="fas fa-envelope input-icon"></i>
          <input type="email" name="email" placeholder="Enter your email" required class="input-field with-icon">
        </div>

        <!-- Password -->
        <div class="input-group">
          <i class="fas fa-lock input-icon"></i>
          <input type="password" id="password" name="password" placeholder="Enter your password" required class="input-field with-icon">
          <i class="fa-solid fa-eye absolute right-4 top-4 text-gray-500 cursor-pointer" id="togglePassword"></i>
        </div>

        <!-- Confirm Password -->
        <div class="input-group">
          <i class="fas fa-lock input-icon"></i>
          <input type="password" id="confirmPassword" name="confirm_password" placeholder="Re-enter your password" required class="input-field with-icon">
          <i class="fa-solid fa-eye absolute right-4 top-4 text-gray-500 cursor-pointer" id="toggleConfirmPassword"></i>
        </div>

        <!-- Submit -->
        <button type="submit" class="register-btn">
          <i class="fas fa-user-plus mr-2"></i> Register
        </button>
      </form>

      <!-- Footer -->
      <div class="text-center mt-8">
        <p class="text-gray-600">
          Already have an account?
          <a href="<?= site_url('auth/login'); ?>" class="text-purple-600 hover:text-purple-700 font-semibold transition-colors">
            Login here
          </a>
        </p>
      </div>
    </div>
  </div>

  <!-- Password Toggle Script -->
  <script>
    function toggleVisibility(toggleId, inputId) {
      const toggle = document.getElementById(toggleId);
      const input = document.getElementById(inputId);
      toggle.addEventListener('click', function () {
        const type = input.getAttribute('type') === 'password' ? 'text' : 'password';
        input.setAttribute('type', type);
        this.classList.toggle('fa-eye');
        this.classList.toggle('fa-eye-slash');
      });
    }
    toggleVisibility('togglePassword', 'password');
    toggleVisibility('toggleConfirmPassword', 'confirmPassword');
  </script>
</body>
</html>
