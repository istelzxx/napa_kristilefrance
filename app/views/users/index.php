<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>User Directory</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <style>
    body {
      background-color: #1a1a1a;
    }
    
  .pagination {
    display: flex;
    gap: 10px;
    flex-wrap: wrap; /* optional, prevents overflow */
  }
  .pagination div {
    display: inline-block; /* override Lavalust block */
  }
  .pagination a, .pagination span {
    background-color: #6b21a8; /* purple-700 */
    color: white;
    padding: 8px 12px;
    text-decoration: none;
    border-radius: 5px;
    transition: background-color 0.3s;
  }
  .pagination a:hover {
    background-color: #7c3aed; /* purple-600 */
  }

  

  </style>
</head>
<body class="bg-gray-900 font-sans text-white">

  <!-- Navbar -->
  <nav class="bg-gray-800 border-b border-purple-900">
    <div class="max-w-7xl mx-auto px-6 py-4">
      <a href="#" class="text-white font-semibold text-xl">📊 User Management</a>
    </div>
  </nav>

  <!-- Main Content -->
  <div class="max-w-6xl mx-auto mt-10 px-4">
    <div class="bg-gray-800 shadow-lg rounded-lg p-6 border border-gray-700">
      
      <!-- Header -->
      <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-semibold text-white">👥 User Directory</h1>

        <!-- Search Bar -->
        <form method="get" action="<?=site_url()?>" class="flex">
          <input 
            type="text" 
            name="q" 
            value="<?=html_escape($_GET['q'] ?? '')?>" 
            placeholder="Search user..." 
            class="w-full border border-purple-200 bg-purple-50 rounded-l-xl px-3 py-2 focus:outline-none focus:ring-2 focus:ring-pink-300 text-gray-800">
          <button type="submit" class="bg-purple-500 hover:bg-purple-600 text-white px-4 rounded-r-xl transition">
            🔍
          </button>
        </form>
      </div>
      
      <!-- Table -->
      <div class="overflow-x-auto rounded-lg">
        <table class="w-full text-center border-collapse">
          <thead>
            <tr class="bg-purple-900 text-white">
              <th class="py-3 px-4 font-medium">ID</th>
              <th class="py-3 px-4 font-medium">Lastname</th>
              <th class="py-3 px-4 font-medium">Firstname</th>
              <th class="py-3 px-4 font-medium">Email</th>
              <th class="py-3 px-4 font-medium">Action</th>
            </tr>
          </thead>
          <tbody class="bg-gray-700">
            <?php foreach(html_escape($users) as $user): ?>
              <tr class="border-b border-gray-600 hover:bg-gray-600">
                <td class="py-3 px-4"><?=($user['id']);?></td>
                <td class="py-3 px-4"><?=($user['last_name']);?></td>
                <td class="py-3 px-4"><?=($user['first_name']);?></td>
                <td class="py-3 px-4">
                  <span class="bg-purple-800 text-purple-200 text-sm px-3 py-1 rounded-full">
                    <?=($user['email']);?>
                  </span>
                </td>
                <td class="py-3 px-4 space-x-3">
                  <!-- Update Button -->
                  <a href="<?=site_url('users/update/'.$user['id']);?>"
                     class="text-purple-400 hover:text-purple-300">
                     Update
                  </a>
                  <!-- Delete Button -->
                  <a href="<?=site_url('users/delete/'.$user['id']);?>"
                     onclick="return confirm('Are you sure you want to delete this record?');"
                     class="text-purple-400 hover:text-purple-300;">
                     Delete
                  </a>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>

      <!-- Pagination -->
      <div class="mt-6 flex justify-center">
        <div class="pagination">
          <?php echo $page; ?>
        </div>
      </div>

      <!-- Create New User -->
      <div class="mt-5">
        <a href="<?=site_url('users/create')?>"
           class="inline-block bg-purple-700 hover:bg-purple-600 text-white font-medium px-5 py-2 rounded shadow">
          ➕ Create New User
        </a>
      </div>
    </div>
  </div>

</body>
</html>