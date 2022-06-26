<?php 
    require('../src/config.php');

    if(isset($_POST['cartId'])
        && isset($_SESSION['cartItems'][$_POST['cartId']])
    ) {
        unset($_SESSION['cartItems'][$_POST['cartId']]);
    }

    header('Location: ' . $_SERVER['HTTP_REFERER']);
    exit;
 ?>