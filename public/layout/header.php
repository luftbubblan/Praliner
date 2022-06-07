<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?=$pageTitle ?></title>
    <link rel="stylesheet" href="./css/style.css">
</head>
<body>

    <?php
        if (isset($_SESSION['id'])) {
            $menu = '<a href="myPage.php">My page</a> | <a href="logout.php">Logout</a>';
        } else {
            $menu = '<a href="registerUser.php">Register</a> | <a href="login.php">Log in</a>';
        }
    ?>
    <div>
        <a href="http://localhost/Praliner/public">Shop</a> |
        <a href="http://localhost/Praliner/public/admin">Admin</a> |
        <?= $menu ?>
    </div>