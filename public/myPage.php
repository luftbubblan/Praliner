<?php

    $pageTitle = "My Page";

    require('../src/config.php');

    if (!isset($_SESSION['id'])) {
        header('Location: login.php?mustLogin');
    }

    echo "<pre>";
    print_r($_POST);
    echo "</pre>";

    $sql = "
            SELECT * FROM users
            WHERE id = :id
        ";

        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':id', $_SESSION['id']);
        $stmt->execute();
        $user = $stmt->fetch();



	include('layout/header.php');
?>


<h1>My Page</h1>
<a href="index.php">Shop</a>


<?php include('layouts/footer.php') ?>