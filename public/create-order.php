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

        $message .= ifEmptyGenerateMessage($firstname, "Vänligen fyll i ditt förnamn.");
        $message .= ifEmptyGenerateMessage($lastname, "Vänligen fyll i ditt efternamn.");
        $message .= ifEmptyGenerateMessage($email, "Vänligen fyll i din email.");
        $message .= phoneNumberMustBeTenDigits($phone);
        $message .= ifEmptyGenerateMessage($street, "Vänligen fyll i adress.");
        $message .= postalCodeMustBeFiveDigits($postalCode);
        $message .= ifEmptyGenerateMessage($city, "Vänligen fyll i ort.");
        $message .= ifEmptyGenerateMessage($country, "Vänligen fyll i land.");
        
        $message .= checkIfEmailIsValid($email);

        if(!isset($_POST['termsAgreed'])) {
            $message .= errorMessage("Måste godkänna de allmänna villkoren.");
        }

        if(!isset($_SESSION['id'])) {
            $guest = "yes";
        } else {
            $userId = $_SESSION['id'];
        }

        $crudFunctions->createOrder($message, $userId, $guest, $fullName, $email, $phone, $street, $postalCode, $city, $country);
    }

    include('layout/header.php');
?>