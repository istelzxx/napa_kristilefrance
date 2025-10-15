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
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Update User</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/js/all.min.js"></script>
</head>
<body class="bg-gradient-to-br from-purple-700 via-indigo-800 to-gray-900 min-h-screen flex items-center justify-center font-sans text-gray-800 relative overflow-hidden">

  <!-- Floating circles background -->
  <div class="absolute top-10 left-10 w-40 h-40 bg-purple-500 opacity-30 rounded-full blur-3xl"></div>
  <div class="absolute bottom-10 right-10 w-60 h-60 bg-indigo-500 opacity-30 rounded-full blur-3xl"></div>

  <div class="bg-white/10 backdrop-blur-md border border-white/20 shadow-lg rounded-2xl p-8 w-full max-w-md text-white relative z-10">
    <h1 class="text-3xl font-bold text-center mb-6 bg-gradient-to-r from-purple-400 to-indigo-400 bg-clip-text text-transparent">📝 Update User</h1>

    <form action="<?=site_url('users/update/'.$user['id'])?>" method="POST" class="space-y-4">

      <!-- Username -->
      <div>
        <label class="block text-gray-200 mb-2 font-medium">Username</label>
        <input type="text" name="username" value="<?= html_escape($user['username'])?>" required
               class="w-full px-4 py-3 rounded-md bg-white/20 text-white border border-white/30 focus:ring-2 focus:ring-purple-400 focus:outline-none placeholder-gray-300">
      </div>

      <!-- Email -->
      <div>
        <label class="block text-gray-200 mb-2 font-medium">Email Address</label>
        <input type="email" name="email" value="<?= html_escape($user['email'])?>" required
               class="w-full px-4 py-3 rounded-md bg-white/20 text-white border border-white/30 focus:ring-2 focus:ring-purple-400 focus:outline-none placeholder-gray-300">
      </div>

      <?php if(!empty($logged_in_user) && $logged_in_user['role'] === 'admin'): ?>
        <!-- Role Dropdown -->
        <div>
          <label class="block text-gray-200 mb-2 font-medium">Role</label>
          <select name="role" required
                  class="w-full px-4 py-3 rounded-md bg-white/20 text-white border border-white/30 focus:ring-2 focus:ring-purple-400 focus:outline-none">
            <option value="user" <?= $user['role'] === 'user' ? 'selected' : ''; ?>>User</option>
            <option value="admin" <?= $user['role'] === 'admin' ? 'selected' : ''; ?>>Admin</option>
          </select>
        </div>

        <!-- Password Field -->
        <div>
          <label class="block text-gray-200 mb-2 font-medium">Password</label>
          <div class="relative">
            <input type="password" name="password" id="password" placeholder="Leave blank to keep current password"
                   class="w-full px-4 py-3 rounded-md bg-white/20 text-white border border-white/30 focus:ring-2 focus:ring-purple-400 focus:outline-none placeholder-gray-300">
            <i class="fa-solid fa-eye absolute right-4 top-1/2 -translate-y-1/2 cursor-pointer text-purple-300" id="togglePassword"></i>
          </div>
        </div>
      <?php endif; ?>

      <!-- Submit Button -->
      <div class="pt-2">
        <button type="submit"
                class="w-full bg-gradient-to-r from-purple-500 to-indigo-500 hover:from-purple-600 hover:to-indigo-600 text-white font-semibold py-3 rounded-lg shadow-md transition duration-200">
          Update User
        </button>
      </div>
    </form>

    <!-- Back Link -->
    <div class="mt-6 text-center">
      <a href="<?=site_url('/users');?>" class="text-purple-300 hover:text-purple-200 text-sm font-medium">
        ← Back to User Directory
      </a>
    </div>
  </div>

  <!-- Password Toggle Script -->
  <script>
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
    });
  </script>

</body>
</html>
