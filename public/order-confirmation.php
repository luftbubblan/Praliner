<?php
    $pageTitle = "Order-Confirmation";

    require('../src/config.php');
    // require('../src/app/CRUD_functions.php');

    if(empty($_SESSION['orderId'])) {
        header('Location: checkout.php');
        exit;
    }
    $_SESSION['orderId'] = [];
    unset($_SESSION['orderId']);

    $orderedItems = $_SESSION['cartItems'];
    $_SESSION['cartItems'] = [];
    unset($_SESSION['cartItems']);

    include('layout/header.php');
?>


<?php include('layout/footer.php') ?>