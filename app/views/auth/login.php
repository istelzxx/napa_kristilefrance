<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>

<body class="bg-gradient-to-r from-purple-900 via-purple-700 to-purple-500 min-h-screen flex items-center justify-center font-sans">

  <!-- Glass Card -->
  <div class="bg-white/10 backdrop-blur-lg border border-white/20 shadow-lg rounded-2xl p-8 w-full max-w-md text-white">
    <h2 class="text-3xl font-semibold text-center mb-6">🔑 Welcome Back</h2>
    <p class="text-center text-gray-200 mb-6">Sign in to access your account</p>

    <!-- Error Message -->
    <?php if (!empty($error)): ?>
      <div class="bg-red-500/20 border border-red-400 text-red-200 text-sm p-3 rounded mb-4 text-center">
        <?= $error ?>
      </div>
    <?php endif; ?>

    <form method="post" action="<?= site_url('auth/login') ?>" class="space-y-5">
      <!-- Username -->
      <div>
        <label class="block text-gray-200 mb-2 font-medium">Username</label>
        <input type="text" name="username" placeholder="Enter your username" required
               class="w-full px-4 py-3 bg-white/20 border border-white/30 text-white rounded-md focus:ring-2 focus:ring-purple-400 focus:border-purple-400 focus:outline-none placeholder-gray-300 transition duration-200">
      </div>

      <!-- Password -->
      <div class="relative">
        <label class="block text-gray-200 mb-2 font-medium">Password</label>
        <input type="password" name="password" id="password" placeholder="Enter your password" required
               class="w-full px-4 py-3 bg-white/20 border border-white/30 text-white rounded-md focus:ring-2 focus:ring-purple-400 focus:border-purple-400 focus:outline-none placeholder-gray-300 transition duration-200">
        <i class="fa-solid fa-eye toggle-password absolute right-3 top-11 text-gray-300 cursor-pointer"></i>
      </div>

      <!-- Button -->
      <div class="pt-2">
        <button type="submit"
                class="w-full bg-gradient-to-r from-purple-500 to-pink-500 hover:from-pink-600 hover:to-purple-600 text-white font-semibold py-3 rounded-md shadow-md transition duration-300 transform hover:scale-[1.02]">
          Login
        </button>
      </div>
    </form>

    <!-- Register Link -->
    <div class="mt-6 text-center">
      <p class="text-sm text-gray-200">
        Don’t have an account?
        <a href="<?= site_url('auth/register'); ?>" class="text-pink-300 hover:text-pink-200 font-medium transition duration-200">
          Register here
        </a>
      </p>
    </div>
  </div>

  <script>
    const togglePassword = document.querySelector('.toggle-password');
    const password = document.querySelector('#password');

    togglePassword.addEventListener('click', function () {
      const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
      password.setAttribute('type', type);
      this.classList.toggle('fa-eye');
      this.classList.toggle('fa-eye-slash');
    });
  </script>

</body>
</html>
