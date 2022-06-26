<?php
    require('../src/config.php');
    // require('../src/app/CRUD_functions.php');

    echo "<pre>";
    echo "SESSION---SESSION---SESSION---SESSION---SESSION---SESSION---SESSION---SESSION---SESSION---SESSION---SESSION <br>";
    print_r($_SESSION);
    echo "</pre>";
    
    echo "<pre>";
    echo "POST---POST---POST---POST---POST---POST---POST---POST---POST---POST---POST---POST---POST---POST---POST---POST <br>";
    print_r($_POST);
    echo "</pre>";

    if(isset($_POST['PayNowBtn']) && !empty($_SESSION['cartItems'])) {
        $userId =      null;
        $guest =       null;
        $firstname =   trim($_POST['firstname']);
        $lastname =    trim($_POST['lastname']);
        $fullName =    $firstname . " " . $lastname;
        $email =       null;
        $phone =       null;
        $street =      trim($_POST['street']);
        $postalCode =  trim($_POST['postalCode']);
        $city =        trim($_POST['city']);
        $country =     trim($_POST['country']);
        if(!isset($_SESSION['id'])) {
            $guest =       "yes";
            $email =       trim($_POST['email']);
            $phone =       trim($_POST['phone']);
        } else {
            $userId =      $_SESSION['id'];
        }

        $sql = "
            INSERT INTO orders (
                user_id,
                total_price,
                guest,
                billing_full_name,
                email,
                phone,
                billing_street,
                billing_postal_code,
                billing_city,
                billing_country)
            VALUES (
                :user_id,
                :total_price,
                :guest,
                :billing_full_name,
                :email,
                :phone,
                :billing_street,
                :billing_postal_code,
                :billing_city,
                :billing_country)
        ";
            
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':user_id', $userId);
        $stmt->bindParam(':total_price', $_POST['totalSum']);
        $stmt->bindParam(':guest', $guest);
        $stmt->bindParam(':billing_full_name', $fullName);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':phone', $phone);
        $stmt->bindParam(':billing_street', $street);
        $stmt->bindParam(':billing_postal_code', $postalCode);
        $stmt->bindParam(':billing_city', $city);
        $stmt->bindParam(':billing_country', $country);
        $stmt->execute();
        $orderId = $pdo->lastInsertId();

        foreach($_SESSION['cartItems'] as $item) {
            $sql = "
                INSERT INTO order_items (
                    order_id,
                    product_id,
                    product_title,
                    quantity,
                    unit_price)
                VALUES (
                    :order_id,
                    :product_id,
                    :product_title,
                    :quantity,
                    :unit_price)
            "; 
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':order_id', $orderId);
            $stmt->bindParam(':product_id', $item['id']);
            $stmt->bindParam(':product_title', $item['title']);
            $stmt->bindParam(':quantity', $item['quantity']);
            $stmt->bindParam(':unit_price', $item['price']);
            $stmt->execute();
        }

        $_SESSION['orderId'] = $orderId;
        header('Location: order-confirmation.php');
        exit;
    }

    include('layout/header.php');
?>