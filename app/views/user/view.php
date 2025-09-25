<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View</title>
    <!-- CSS link -->
    <link rel="stylesheet" href="<?=base_url();?>public/style.css">
    <style>
        body {
            background-color: #f5f5dc; /* beige background */
            font-family: Arial, sans-serif;
            display: flex;              /* enable flexbox */
            justify-content: center;    /* center horizontally */
            align-items: center;        /* center vertically */
            min-height: 100vh;          /* occupy full viewport height */
            margin: 0;                  /* remove default margin */
            flex-direction: column;     /* stack h1 and table vertically */
        }

        h1 {
            text-align: center;
            color: #5a4a42; /* darker beige/brown for text */
        }

        table {
            margin: auto;
            border-collapse: collapse;
            width: 70%;
            background-color: #fffaf0; /* light beige for table */
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            border-radius: 10px;
            overflow: hidden;
        }

        th {
            background-color: #deb887; /* burlywood/beige tone */
            color: white;
            padding: 12px;
            text-align: left;
        }

        /* Iba ang kulay ng Action header */
        th.action-header {
            background-color: #deb887; /* sienna/darker brown */
            text-align: center; 
            vertical-align: left; /* para pantay sa Edit/Delete */
        }

        td {
            padding: 10px;
            border-bottom: 1px solid #ddd;
            vertical-align: middle; /* para kapantay din ng header */
        }

        tr:hover {
            background-color: #f0e6d6; /* hover effect beige */
        }

        .action-buttons {
            text-align: center; /* align center yung buttons */
            vertical-align: middle;
        }

        .action-buttons a {
            display: inline-block;
            background-color: #deb887; /* beige buttons */
            color: white;
            padding: 6px 12px;
            margin: 2px;
            border-radius: 5px;
            text-decoration: none;
            font-weight: bold;
        }

        .action-buttons a:hover {
            background-color: #cdaa7d; /* darker beige on hover */
        }
</style>
<!-- Custom Pagination CSS -->
<style>
    .pagination-nav {
        display: flex;
        justify-content: center;
        margin-top: 1rem;
    }
    .pagination-list {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        list-style: none;
        padding: 0;
        margin: 0;
    }
    .pagination-item {
        margin: 0;
    }
    .pagination-link {
        display: flex;
        align-items: center;
        justify-content: center;
        min-width: 2.5rem;
        height: 2.5rem;
        padding: 0.5rem;
        font-size: 0.875rem;
        font-weight: 500;
        color: #6b7280;
        background-color: #ffffff;
        border: 1px solid #d1d5db;
        border-radius: 0.375rem;
        text-decoration: none;
        transition: all 0.2s ease-in-out;
        box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
    }
    .pagination-link:hover {
        background-color: #f9fafb;
        color: #374151;
        border-color: #9ca3af;
        transform: translateY(-1px);
        box-shadow: 0 2px 4px 0 rgba(0, 0, 0, 0.1);
    }
    .pagination-item.active .pagination-link {
        background-color: #3b82f6;
        color: #ffffff;
        border-color: #3b82f6;
        font-weight: 600;
        box-shadow: 0 2px 4px 0 rgba(59, 130, 246, 0.3);
    }
    .pagination-item.active .pagination-link:hover {
        background-color: #2563eb;
        border-color: #2563eb;
        transform: translateY(-1px);
        box-shadow: 0 4px 6px 0 rgba(59, 130, 246, 0.4);
    }
    .pagination-item:first-child .pagination-link,
    .pagination-item:last-child .pagination-link {
        background-color: #f8fafc;
        border-color: #e2e8f0;
        color: #64748b;
        font-weight: 500;
    }
    .pagination-item:first-child .pagination-link:hover,
    .pagination-item:last-child .pagination-link:hover {
        background-color: #f1f5f9;
        border-color: #cbd5e1;
        color: #475569;
    }
    .pagination-item.disabled .pagination-link {
        background-color: #f8fafc;
        border-color: #e2e8f0;
        color: #cbd5e1;
        cursor: not-allowed;
        pointer-events: none;
    }
</style>
</head>
<body>
    <h1>Welcome to View View</h1>
    <table>
        <tr>
            <th>ID</th>
            <th>Username</th>
            <th>Email</th>
            <th class="action-header">Action</th>
            <a href="<?=site_url('user/create/');?>" id="create"><button>Create User</button></a>
        </tr> 
        <?php foreach(html_escape($users) as $user): ?>
            <tr>
                <td><?=$user['id'];?></td>
                <td><?=$user['username'];?></td>
                <td><?=$user['email'];?></td>
                <td class="action-buttons">
                    <a href="<?=site_url('user/update/'. $user['id']);?>">Edit</a>
                    <a href="<?=site_url('user/delete/'. $user['id']);?>" onclick="return confirm('Are you sure you want to delete this user?');">Delete</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>

    <!-- Pagination Controls -->
    <?php if (isset($pagination_data)): ?>
        <div class="mt-8">
            <!-- Pagination Links -->
            <?php if (isset($pagination_links) && !empty($pagination_links)): ?>
                <div class="flex justify-center mb-4">
                    <?php echo $pagination_links; ?>
                </div>
            <?php endif; ?>
            <!-- Results and Items Per Page -->
            <div class="flex justify-between items-center text-sm text-gray-600">
                <div>
                    <?php echo $pagination_data['info']; ?>
                </div>
                <div class="flex items-center space-x-2">
                    <span>Items per page:</span>
                    <select id="itemsPerPage" class="px-3 py-1 bg-gray-200 border border-gray-300 rounded-lg text-gray-700">
                        <option value="10" <?php echo (isset($_GET['per_page']) && $_GET['per_page'] == 10) ? 'selected' : ''; ?>>10</option>
                        <option value="25" <?php echo (isset($_GET['per_page']) && $_GET['per_page'] == 25) ? 'selected' : ''; ?>>25</option>
                        <option value="50" <?php echo (isset($_GET['per_page']) && $_GET['per_page'] == 50) ? 'selected' : ''; ?>>50</option>
                        <option value="100" <?php echo (isset($_GET['per_page']) && $_GET['per_page'] == 100) ? 'selected' : ''; ?>>100</option>
                    </select>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <script>
    // Handle items per page dropdown
    document.addEventListener('DOMContentLoaded', function() {
        const itemsPerPageSelect = document.getElementById('itemsPerPage');
        if (itemsPerPageSelect) {
            itemsPerPageSelect.addEventListener('change', function() {
                const selectedValue = this.value;
                const currentUrl = new URL(window.location.href);
                currentUrl.searchParams.set('per_page', selectedValue);
                // Reset to page 1 when changing items per page
                if (currentUrl.pathname.includes('/index/')) {
                    currentUrl.pathname = currentUrl.pathname.replace(/\/index\/\d+/, '/index/1');
                }
                window.location.href = currentUrl.toString();
            });
        }
    });
    </script>
</body>
</html>
