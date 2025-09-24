<?php
// This view is called by StudentsController->edit($id)
// $student data is passed from the controller
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Edit Student - Student Portal</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">

  <style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');
    body{font-family:'Poppins',sans-serif;}

    :root {
      --primary-gradient: linear-gradient(135deg,#667eea 0%,#764ba2 100%);
      --secondary-gradient: linear-gradient(135deg,#f093fb 0%,#f5576c 100%);
      --accent-gradient: linear-gradient(135deg,#4facfe 0%,#00f2fe 100%);
    }

    .glass-card{background:rgba(255,255,255,.95);backdrop-filter:blur(20px);border:1px solid rgba(255,255,255,.3);box-shadow:0 8px 32px rgba(0,0,0,.1);}
    .glass-input{background:rgba(255,255,255,.9);backdrop-filter:blur(10px);border:2px solid rgba(255,255,255,.3);transition:.3s;}
    .glass-input:focus{outline:none;border-color:#667eea;box-shadow:0 0 20px rgba(102,126,234,.3);background:#fff;}
    .btn-primary{background:var(--primary-gradient);color:#fff;transition:.3s;}
    .btn-primary:hover{transform:translateY(-2px);box-shadow:0 8px 25px rgba(102,126,234,.4);}
    .btn-secondary{background:rgba(255,255,255,.9);border:2px solid rgba(255,255,255,.3);color:#374151;transition:.3s;}
    .btn-secondary:hover{background:#fff;border-color:#667eea;transform:translateY(-2px);}
    .floating-shape{position:absolute;border-radius:50%;filter:blur(40px);opacity:.3;animation:float 6s ease-in-out infinite;}
    .floating-shape:nth-child(1){background:var(--primary-gradient);width:300px;height:300px;top:10%;right:10%;}
    .floating-shape:nth-child(2){background:var(--secondary-gradient);width:250px;height:250px;bottom:10%;left:10%;animation-delay:2s;}
    .floating-shape:nth-child(3){background:var(--accent-gradient);width:200px;height:200px;top:50%;left:50%;transform:translate(-50%,-50%);animation-delay:4s;}
    @keyframes float{0%,100%{transform:translateY(0) scale(1);}50%{transform:translateY(-20px) scale(1.05);}}
    .gradient-text{background:var(--primary-gradient);-webkit-background-clip:text;background-clip:text;-webkit-text-fill-color:transparent;}
    .status-badge{display:inline-flex;align-items:center;padding:6px 12px;border-radius:20px;font-size:.875rem;font-weight:500;background:linear-gradient(135deg,#10b981,#059669);color:white;}
  </style>
</head>
<body class="min-h-screen bg-gradient-to-br from-purple-100 via-pink-50 to-indigo-100 relative overflow-hidden">
  <!-- Floating background -->
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
          <i class="fas fa-user-edit text-white text-lg"></i>
        </div>
        <div>
          <h1 class="text-4xl font-bold gradient-text">Edit Student</h1>
          <p class="text-gray-600 mt-1">Update student record (ID: <?= $student['id'] ?>)</p>
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
          <span id="modified-badge" class="hidden ml-3 status-badge bg-gradient-to-r from-yellow-400 to-orange-500">
            Modified
          </span>
        </div>

        <form method="POST" action="/students/edit/<?= $student['id'] ?>" class="space-y-6">
          <div class="space-y-3">
            <label for="first_name" class="flex items-center gap-2 text-base font-medium text-gray-700">
              <i class="fas fa-user text-purple-500"></i>
              First Name
            </label>
            <input id="first_name" name="first_name" type="text"
                   value="<?= htmlspecialchars($student['first_name']) ?>"
                   required data-original="<?= htmlspecialchars($student['first_name']) ?>"
                   oninput="checkChanges()"
                   class="w-full rounded-xl h-12 px-4 glass-input text-gray-700"
                   placeholder="Enter first name"/>
          </div>

          <div class="space-y-3">
            <label for="last_name" class="flex items-center gap-2 text-base font-medium text-gray-700">
              <i class="fas fa-user text-indigo-500"></i>
              Last Name
            </label>
            <input id="last_name" name="last_name" type="text"
                   value="<?= htmlspecialchars($student['last_name']) ?>"
                   required data-original="<?= htmlspecialchars($student['last_name']) ?>"
                   oninput="checkChanges()"
                   class="w-full rounded-xl h-12 px-4 glass-input text-gray-700"
                   placeholder="Enter last name"/>
          </div>

          <div class="space-y-3">
            <label for="email" class="flex items-center gap-2 text-base font-medium text-gray-700">
              <i class="fas fa-envelope text-purple-500"></i>
              Email Address
            </label>
            <input id="email" name="email" type="email"
                   value="<?= htmlspecialchars($student['email']) ?>"
                   required data-original="<?= htmlspecialchars($student['email']) ?>"
                   oninput="checkChanges()"
                   class="w-full rounded-xl h-12 px-4 glass-input text-gray-700"
                   placeholder="Enter email address"/>
          </div>

          <div class="flex gap-4 pt-6">
            <button type="submit" id="update-btn" disabled
              class="flex-1 btn-primary rounded-xl h-12 shadow-lg hover:shadow-xl inline-flex items-center justify-center gap-2 font-semibold disabled:opacity-50 disabled:cursor-not-allowed">
              <i class="fas fa-save"></i>
              Update Student
            </button>
            <a href="/" class="px-8 rounded-xl btn-secondary inline-flex items-center justify-center font-medium">
              Cancel
            </a>
          </div>
        </form>
      </div>

      <!-- Preview Section -->
      <div class="space-y-6">
        <div class="glass-card rounded-2xl p-8 shadow-xl hover:shadow-2xl transition-all">
          <div class="flex items-center gap-3 mb-8">
            <div class="w-8 h-8 bg-gradient-to-r from-green-500 to-emerald-600 rounded-lg flex items-center justify-center">
              <i class="fas fa-eye text-white text-sm"></i>
            </div>
            <h2 class="text-xl font-semibold text-gray-800">Current vs Updated</h2>
          </div>
          <div class="space-y-4">
            <div class="grid grid-cols-2 gap-4">
              <div class="glass-card rounded-lg p-3">
                <p class="text-sm text-gray-500 mb-1">Current Name</p>
                <p class="font-medium text-gray-800" id="current-name">
                  <?= htmlspecialchars($student['first_name']) ?> <?= htmlspecialchars($student['last_name']) ?>
                </p>
              </div>
              <div class="glass-card rounded-lg p-3">
                <p class="text-sm text-gray-500 mb-1">Updated Name</p>
                <p class="font-medium text-gray-800" id="updated-name">
                  <?= htmlspecialchars($student['first_name']) ?> <?= htmlspecialchars($student['last_name']) ?>
                </p>
              </div>
            </div>

            <div class="grid grid-cols-2 gap-4">
              <div class="glass-card rounded-lg p-3">
                <p class="text-sm text-gray-500 mb-1">Current Email</p>
                <p class="font-medium text-gray-800" id="current-email">
                  <?= htmlspecialchars($student['email']) ?>
                </p>
              </div>
              <div class="glass-card rounded-lg p-3">
                <p class="text-sm text-gray-500 mb-1">Updated Email</p>
                <p class="font-medium text-gray-800" id="updated-email">
                  <?= htmlspecialchars($student['email']) ?>
                </p>
              </div>
            </div>
          </div>
        </div>

        <!-- Status -->
        <div class="glass-card rounded-2xl p-6 shadow-xl">
          <h3 class="font-semibold text-gray-800 mb-4">Update Status</h3>
          <div class="space-y-3">
            <div class="flex items-center justify-between">
              <span class="text-sm">Changes Detected</span>
              <span id="changes-badge" class="status-badge bg-gradient-to-r from-gray-200 to-gray-300 text-gray-700">
                No
              </span>
            </div>
            <div class="flex items-center justify-between">
              <span class="text-sm">Ready to Update</span>
              <span id="ready-badge" class="status-badge bg-gradient-to-r from-gray-200 to-gray-300 text-gray-700">
                No Changes
              </span>
            </div>
          </div>
        </div>

        <!-- Tips -->
        <div class="glass-card rounded-2xl p-6 shadow-xl">
          <div class="flex items-center gap-3 mb-4">
            <div class="w-8 h-8 bg-gradient-to-r from-yellow-500 to-orange-500 rounded-lg flex items-center justify-center">
              <i class="fas fa-lightbulb text-white text-sm"></i>
            </div>
            <h3 class="font-semibold text-gray-800">Update Tips</h3>
          </div>
          <ul class="space-y-2 text-sm text-gray-600">
            <li class="flex items-start gap-2">
              <i class="fas fa-check text-green-500 mt-1 text-xs"></i>
              Ensure all fields are accurate before updating
            </li>
            <li class="flex items-start gap-2">
              <i class="fas fa-check text-green-500 mt-1 text-xs"></i>
              The update button activates only when changes are made
            </li>
          </ul>
        </div>
      </div>
    </div>
  </div>

  <script>
    function checkChanges() {
      const firstName = document.getElementById('first_name');
      const lastName  = document.getElementById('last_name');
      const email     = document.getElementById('email');

      const origFirst = firstName.dataset.original ?? '';
      const origLast  = lastName.dataset.original ?? '';
      const origEmail = email.dataset.original ?? '';

      const hasChanges =
        firstName.value.trim() !== origFirst ||
        lastName.value.trim() !== origLast ||
        email.value.trim() !== origEmail;

      // update preview
      document.getElementById('updated-name').textContent = (firstName.value || origFirst) + ' ' + (lastName.value || origLast);
      document.getElementById('updated-email').textContent = email.value || origEmail;

      const modifiedBadge = document.getElementById('modified-badge');
      const changesBadge  = document.getElementById('changes-badge');
      const readyBadge    = document.getElementById('ready-badge');
      const updateBtn     = document.getElementById('update-btn');

      if (hasChanges) {
        modifiedBadge.classList.remove('hidden');
        changesBadge.textContent = 'Yes';
        changesBadge.className = 'status-badge bg-gradient-to-r from-blue-500 to-indigo-500';
        readyBadge.textContent = 'Ready';
        readyBadge.className = 'status-badge bg-gradient-to-r from-green-500 to-emerald-600';
        updateBtn.disabled = false;
      } else {
        modifiedBadge.classList.add('hidden');
        changesBadge.textContent = 'No';
        changesBadge.className = 'status-badge bg-gradient-to-r from-gray-200 to-gray-300 text-gray-700';
        readyBadge.textContent = 'No Changes';
        readyBadge.className = 'status-badge bg-gradient-to-r from-gray-200 to-gray-300 text-gray-700';
        updateBtn.disabled = true;
      }
    }

    document.addEventListener('DOMContentLoaded', checkChanges);
  </script>
</body>
</html>
