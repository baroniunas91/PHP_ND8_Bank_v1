<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accounts list</title>
    <link rel="stylesheet" href="./assets/style.css">
</head>
<body>
    <div class="header">
        <p class="employee"><?= $_SESSION['name']?> is logged in</p>
        <div class="links">
            <form action="" method="get">
                <button class="header-button" type="submit" name="logout" value="1">Logout</button>
            </form>
        </div>
    </div>