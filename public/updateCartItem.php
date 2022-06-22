<?php 
    require('../src/config.php');

    echo "<pre>";
	print_r($_POST);
	echo "</pre>";

    if(isset($_POST['cartId'])
        && !empty($_POST['quantity'])
        && isset($_SESSION['cartItems'][$_POST['cartId']])
    ) {
        $_SESSION['cartItems'][$_POST['cartId']]['quantity'] = $_POST['quantity'];
    }

    header('Location: ' . $_SERVER['HTTP_REFERER']);
    exit;
 ?>