<?php
    require('../src/config.php');
    require('../src/app/CRUD_functions.php');

    if(!empty($_POST['quantity'])) {
        $productId = $_POST['productId'];
        $quantity = $_POST['quantity'];
    }

    $product = $crudFunctions->fetchProductById($productId);

    
    if($product) {
        $product = array_merge($product, ['quantity' => $quantity]);

        $cartItem = [$productId => $product];

        if(empty($_SESSION['cartItems'])) {
            $_SESSION['cartItems'] = $cartItem;
        } else {
            if(isset($_SESSION['cartItems'][$productId])) {
                $_SESSION['cartItems'][$productId]['quantity'] += $quantity;
            } else {
                $_SESSION['cartItems'] += $cartItem;
            }
        }
    }
    header('Location: ' . $_SERVER['HTTP_REFERER']);
    exit;
?>