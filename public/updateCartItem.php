<?php 
    require('../src/config.php');

    if(isset($_POST['cartId'])
        && !empty($_POST['quantity'])
        && isset($_SESSION['cartItems'][$_POST['cartId']])
    ) {
        if(isset($_POST['plus'])) {
            $_SESSION['cartItems'][$_POST['cartId']]['quantity'] += 1;
        } else if(isset($_POST['minus'])) {
            $_SESSION['cartItems'][$_POST['cartId']]['quantity'] -= 1;
        }
    }

    header('Location: ' . $_SERVER['HTTP_REFERER']);
    exit;
 ?>