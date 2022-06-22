<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?=$pageTitle ?></title>
    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <!-- CUSTOM -->
    <link rel="stylesheet" href="./css/style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Potta+One&display=swap" rel="stylesheet">
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
            <?php require('cart.php'); ?>
            <a href="index.php">Shop</a>
            <a href="admin">Admin</a>
            <?= $menu ?>
        </div>

        <div id="logo-con">
            <h3>Marias söta i Vejbystrand</h3>
        </div>

        <div id="nav-2">
        <a href="index.php">Shop</a> 
        <a href="about">Om</a>
        <a href="about">Hitta hit</a>
        </div>
    </div>