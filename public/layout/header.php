<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?=$pageTitle ?></title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
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


    <div id="header-container">
        <div id="nav-1">
            <a href="index.php">Shop</a>
            <a href="admin">Admin</a>
            <?= $menu ?>
        </div>

        <div id="logo-con">
            <h3>LOGO</h3>
        </div>

        <div id="nav-2">
        <a href="index.php">Shop</a> 
        <a href="about">Om</a>
        <a href="about">Hitta hit</a>
        </div>
    </div>