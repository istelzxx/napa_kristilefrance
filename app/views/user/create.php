<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User/create</title>
</head>
<body>
    <h1>Welcome to User/create View</h1>
    <form action="<?=site_url('user/create');?>" method="post">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required><br><br>
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required><br><br>
        <input type="submit" value="Create User">
        <a href="/"><input type="button" value="Go Back"></a>
    </form>
</body>
</html>