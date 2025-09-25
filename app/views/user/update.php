<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User/update</title>
</head>
<body>
    <h1>Welcome to User/update View</h1>
    <form action="<?=site_url('user/update/'. $user['id']);?>" method="post">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" value="<?=html_escape($user['username']);?>" required><br><br>
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" value="<?=html_escape($user['email']);?>" required><br><br>
        <input type="submit" value="Create User">
        <a href="<?=site_url(url: 'user/');?>"><button>Go back</button></a>
    </form>
</body>
</html>