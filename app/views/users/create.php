<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Sign Up</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-900 min-h-screen flex items-center justify-center font-sans">

  <div class="bg-white p-8 rounded-lg shadow-sm border border-gray-200 w-full max-w-md">
    <h2 class="text-2xl font-semibold text-center text-gray-900 mb-6">📝 Create Account</h2>

    <form action="<?=site_url('users/create')?>" method="POST" class="space-y-4">
      <!-- First Name -->
      <div>
        <label class="block text-gray-700 mb-2 font-medium">First Name</label>
        <input type="text" name="first_name" placeholder="Enter your first name" required
               class="w-full px-4 py-3 border border-gray-300 rounded-md focus:ring-2 focus:ring-purple-500 focus:border-purple-500 focus:outline-none transition duration-200">
      </div>

      <!-- Last Name -->
      <div>
        <label class="block text-gray-700 mb-2 font-medium">Last Name</label>
        <input type="text" name="last_name" placeholder="Enter your last name" required
               class="w-full px-4 py-3 border border-gray-300 rounded-md focus:ring-2 focus:ring-purple-500 focus:border-purple-500 focus:outline-none transition duration-200">
      </div>

      <!-- Email -->
      <div>
        <label class="block text-gray-700 mb-2 font-medium">Email Address</label>
        <input type="email" name="email" placeholder="Enter your email" required
               class="w-full px-4 py-3 border border-gray-300 rounded-md focus:ring-2 focus:ring-purple-500 focus:border-purple-500 focus:outline-none transition duration-200">
      </div>

      <!-- Button -->
      <div class="pt-2">
        <button type="submit"
                class="w-full bg-purple-600 hover:bg-purple-700 text-white font-medium py-3 rounded-md shadow-sm transition duration-200">
          Create Account
        </button>
      </div>
    </form>

    <!-- Back to Directory Link -->
    <div class="mt-6 text-center">
      <a href="<?=site_url('index.php')?>" class="text-purple-600 hover:text-purple-500 text-sm font-medium">
        ← Back to User Directory
      </a>
    </div>
  </div>

</body>
</html>