<?php
    require('../src/config.php');
    require('../src/app/common_functions.php');
    require('../src/app/CRUD_functions.php');

    if(isset($_POST['PayNowBtn']) && !empty($_SESSION['cartItems'])) {
        $userId =      null;
        $guest =       null;
        $firstname =   ucfirst(trim($_POST['firstname']));
        $lastname =    ucfirst(trim($_POST['lastname']));
        $fullName =    $firstname . " " . $lastname;
        $email =       trim($_POST['email']);
        $phone =       trim($_POST['phone']);
        $street =      ucfirst(trim($_POST['street']));
        $postalCode =  trim($_POST['postalCode']);
        $city =        ucfirst(trim($_POST['city']));
        $country =     ucfirst(trim($_POST['country']));
        $message =     "";

        $message .= ifEmptyGenerateMessage($firstname, "Förnamn måste fyllas i.");
        $message .= ifEmptyGenerateMessage($lastname, "Efternamn måste fyllas i.");
        $message .= ifEmptyGenerateMessage($email, "E-mail måste fyllas i.");
        $message .= phoneNumberMustBeTenDigits($phone);
        $message .= ifEmptyGenerateMessage($street, "Gatuadress måste fyllas i.");
        $message .= postalCodeMustBeFiveDigits($postalCode);
        $message .= ifEmptyGenerateMessage($city, "Stad måste fyllas i.");
        $message .= ifEmptyGenerateMessage($country, "Land måste fyllas i.");
        
        $message .= checkIfEmailIsValid($email);

        if(!isset($_POST['termsAgreed'])) {
            $message .= errorMessage("Måste godkänna de allmänna villkoren");
        }

        if(!isset($_SESSION['id'])) {
            $guest = "yes";
        } else {
            $userId = $_SESSION['id'];
        }

        if(empty($message)) {
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
        } else {
            header('Location: checkout.php?message=' . $message);
            exit;
        }

        
    }

    include('layout/header.php');
?>