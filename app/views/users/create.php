<?php
// Ensure $logged_in_user is defined to avoid undefined variable error
if (!isset($logged_in_user)) {
    $logged_in_user = ['role' => 'user']; // default to normal user if not set
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Create User</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
  <style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');

    body { font-family: 'Poppins', sans-serif; }

    :root {
      --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
      --accent-gradient: linear-gradient(135deg, #10b981, #059669);
    }

    .glass-card {
      background: rgba(255, 255, 255, 0.95);
      backdrop-filter: blur(20px);
      border: 1px solid rgba(255, 255, 255, 0.3);
      box-shadow: 0 8px 32px rgba(0, 0, 0, 0.07);
    }

    .glass-input {
      background: rgba(255,255,255,0.9);
      border: 2px solid rgba(255,255,255,0.3);
      transition: all 0.25s ease;
    }
    .glass-input:focus {
      outline: none;
      border-color: #667eea;
      box-shadow: 0 0 18px rgba(102,126,234,0.18);
      background: rgba(255,255,255,1);
    }

    .gradient-text {
      background: var(--primary-gradient);
      -webkit-background-clip: text;
      background-clip: text;
      -webkit-text-fill-color: transparent;
    }

    .btn-primary {
      background: var(--primary-gradient);
      color: white;
      transition: all 0.25s ease;
    }
    .btn-primary:hover { transform: translateY(-2px); box-shadow: 0 10px 30px rgba(102,126,234,0.25); }

    .btn-secondary {
      background: rgba(255,255,255,0.9);
      border: 2px solid rgba(255,255,255,0.3);
      color: #374151;
    }
    .btn-secondary:hover { border-color: #667eea; transform: translateY(-2px); }

    .preview-card { border-left: 4px solid; transition: all 0.18s ease; }
    .preview-card:hover { transform: translateX(6px); }

    /* Floating shapes (subtle) */
    .floating-shape {
      position: absolute;
      border-radius: 50%;
      filter: blur(40px);
      opacity: 0.18;
      animation: float 6s ease-in-out infinite;
      pointer-events: none;
    }
    .floating-shape.shape-1 { background: linear-gradient(135deg,#667eea,#764ba2); width:260px;height:260px; top:6%; right:6%; }
    .floating-shape.shape-2 { background: linear-gradient(135deg,#f093fb,#f5576c); width:200px;height:200px; bottom:6%; left:6%; animation-delay: 2s; }
    @keyframes float { 0%,100%{transform: translateY(0)} 50%{transform: translateY(-18px)} }

    /* small helpers */
    .card-hover { transition: all .25s ease; }
    .card-hover:hover { transform: translateY(-6px); box-shadow: 0 18px 40px rgba(0,0,0,0.08); }
  </style>
</head>
<body class="min-h-screen bg-gradient-to-br from-purple-100 via-pink-50 to-indigo-100 relative overflow-hidden">

  <!-- Floating shapes -->
  <div class="fixed inset-0 pointer-events-none">
    <div class="floating-shape shape-1"></div>
    <div class="floating-shape shape-2"></div>
  </div>

  <div class="container mx-auto p-6 max-w-6xl relative z-10">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row items-start gap-4 mb-8">
      <a href="<?= site_url('/users'); ?>" class="glass-card rounded-xl px-4 py-2 inline-flex items-center gap-2 text-gray-700 hover:scale-105 transition-all shadow-lg">
        <i class="fas fa-arrow-left"></i>
        Back to Users
      </a>

      <div class="flex items-center gap-4">
        <div class="w-12 h-12 bg-gradient-to-r from-purple-500 to-indigo-600 rounded-xl flex items-center justify-center shadow-lg">
          <i class="fas fa-user-plus text-white text-lg"></i>
        </div>
        <div>
          <h1 class="text-4xl font-bold gradient-text">Create New User</h1>
          <p class="text-gray-600 mt-1">Add a user to the system — fields are required.</p>
        </div>
      </div>
    </div>

    <div class="grid lg:grid-cols-2 gap-8">
      <!-- Form -->
      <div class="glass-card rounded-2xl p-8 card-hover">
        <div class="flex items-center gap-3 mb-6">
          <div class="w-8 h-8 bg-gradient-to-r from-purple-500 to-indigo-600 rounded-lg flex items-center justify-center">
            <i class="fas fa-edit text-white text-sm"></i>
          </div>
          <h2 class="text-xl font-semibold text-gray-800">Account Details</h2>
        </div>

        <form id="user-form" action="<?= site_url('users/create/') ?>" method="POST" class="space-y-5">
          <!-- Username -->
          <div>
            <label class="flex items-center gap-2 text-base font-medium text-gray-700 mb-2">
              <i class="fas fa-user text-purple-500"></i> Username
            </label>
            <input type="text" name="username" placeholder="Username" required
              value="<?= isset($username) ? html_escape($username) : '' ?>"
              class="w-full rounded-xl h-12 px-4 glass-input text-gray-700"
              oninput="updatePreview()">
          </div>

          <!-- Email -->
          <div>
            <label class="flex items-center gap-2 text-base font-medium text-gray-700 mb-2">
              <i class="fas fa-envelope text-indigo-500"></i> Email Address
            </label>
            <input type="email" name="email" placeholder="Email" required
              value="<?= isset($email) ? html_escape($email) : '' ?>"
              class="w-full rounded-xl h-12 px-4 glass-input text-gray-700"
              oninput="updatePreview()">
          </div>

          <!-- Password with toggle -->
          <div>
            <label class="flex items-center gap-2 text-base font-medium text-gray-700 mb-2">
              <i class="fas fa-lock text-purple-500"></i> Password
            </label>
            <div class="relative">
              <input type="password" name="password" id="password" placeholder="Password" required
                class="w-full rounded-xl h-12 px-4 glass-input text-gray-700">
              <i class="fa-solid fa-eye absolute right-4 top-1/2 -translate-y-1/2 cursor-pointer text-purple-600" id="togglePassword"></i>
            </div>
          </div>

          <!-- Role (visible for admin only) -->
          <?php if ($logged_in_user['role'] === 'admin'): ?>
            <div>
              <label class="flex items-center gap-2 text-base font-medium text-gray-700 mb-2">
                <i class="fas fa-user-shield text-indigo-500"></i> Role
              </label>
              <select name="role" id="roleSelect" required
                class="w-full rounded-xl h-12 px-4 glass-input text-gray-700"
                onchange="updatePreview()">
                <option value="" disabled <?= empty($role) ? 'selected' : '' ?>>Select Role</option>
                <option value="user" <?= (isset($role) && $role === 'user') ? 'selected' : '' ?>>User</option>
                <option value="admin" <?= (isset($role) && $role === 'admin') ? 'selected' : '' ?>>Admin</option>
              </select>
            </div>
          <?php else: ?>
            <input type="hidden" name="role" id="roleSelect" value="user">
          <?php endif; ?>

          <!-- Submit -->
          <div class="flex gap-4 pt-4">
            <button type="submit" class="flex-1 btn-primary rounded-xl h-12 inline-flex items-center justify-center gap-2 font-semibold">
              <i class="fas fa-user-plus"></i> Create User
            </button>
            <a href="<?= site_url('/users'); ?>" class="px-6 rounded-xl btn-secondary inline-flex items-center justify-center font-medium h-12">
              Cancel
            </a>
          </div>
        </form>
      </div>

      <!-- Live Preview -->
      <div class="space-y-6">
        <div class="glass-card rounded-2xl p-6 card-hover">
          <div class="flex items-center gap-3 mb-4">
            <div class="w-8 h-8 bg-gradient-to-r from-green-500 to-emerald-600 rounded-lg flex items-center justify-center">
              <i class="fas fa-eye text-white text-sm"></i>
            </div>
            <h2 class="text-lg font-semibold text-gray-800">Live Preview</h2>
          </div>

          <div class="space-y-4">
            <div class="preview-card glass-card rounded-xl p-4" style="border-left-color: #667eea;">
              <p class="text-sm text-gray-500 mb-1">Username</p>
              <p class="font-semibold text-gray-800" id="preview-username"><?= isset($username) ? html_escape($username) : 'username_here' ?></p>
            </div>

            <div class="preview-card glass-card rounded-xl p-4" style="border-left-color: #764ba2;">
              <p class="text-sm text-gray-500 mb-1">Email</p>
              <p class="font-semibold text-gray-800" id="preview-email"><?= isset($email) ? html_escape($email) : 'email@example.com' ?></p>
            </div>

            <div class="preview-card glass-card rounded-xl p-4" style="border-left-color: #10b981;">
              <p class="text-sm text-gray-500 mb-1">Role</p>
              <p class="font-semibold text-gray-800" id="preview-role"><?= isset($role) ? html_escape($role) : 'user' ?></p>
            </div>
          </div>
        </div>

        <!-- Optional small help card -->
        <div class="glass-card rounded-2xl p-4">
          <p class="text-sm text-gray-600">Make sure the email is valid and password is strong. Admin role can only be assigned by admins.</p>
        </div>
      </div>
    </div>
  </div>

  <!-- FontAwesome JS for icon toggles (optional) -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/js/all.min.js"></script>

  <script>
    // Live preview updater
    function updatePreview() {
      const usernameEl = document.querySelector('input[name="username"]');
      const emailEl = document.querySelector('input[name="email"]');
      const roleEl = document.querySelector('#roleSelect');

      const previewUsername = document.getElementById('preview-username');
      const previewEmail = document.getElementById('preview-email');
      const previewRole = document.getElementById('preview-role');

      previewUsername.textContent = (usernameEl && usernameEl.value.trim()) ? usernameEl.value.trim() : 'username_here';
      previewEmail.textContent = (emailEl && emailEl.value.trim()) ? emailEl.value.trim() : 'email@example.com';
      previewRole.textContent = (roleEl && roleEl.value) ? roleEl.value : 'user';
    }

    // Password toggle
    document.addEventListener("DOMContentLoaded", function () {
      const togglePassword = document.getElementById('togglePassword');
      const password = document.getElementById('password');

      if (togglePassword && password) {
        togglePassword.addEventListener('click', function () {
          const type = password.type === 'password' ? 'text' : 'password';
          password.type = type;
          this.classList.toggle('fa-eye');
          this.classList.toggle('fa-eye-slash');
        });
      }

      // Initialize preview with any server-provided values
      updatePreview();
    });
  </script>
</body>
</html>
