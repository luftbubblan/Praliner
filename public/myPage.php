<?php

    $pageTitle = "My Page";

    require('../src/config.php');

    if (!isset($_SESSION['id'])) {
        header('Location: login.php?mustLogin');
    }

    
    $sql = "
        SELECT * FROM users
        WHERE id = :id
    ";
    
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id', $_SESSION['id']);
    $stmt->execute();
    $user = $stmt->fetch();
    
    
    // echo "<pre>";
    // print_r($user);
    // echo "</pre>";

	include('layout/header.php');
?>


<h1>My Page</h1>
<!-- <a href="index.php">Shop</a> -->
<!-- <a href='logout.php'>Logout</a> -->

<p>Welcome <?=$user['first_name']?></p>


<?php include('layout/footer.php') ?>