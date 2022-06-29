<?php
require('../config.php');
require('common_functions.php');
require('CRUD_functions.php');

$message = "";

if(isset($_POST['updateNameBtn'])) {
    $firstName = ucfirst(trim($_POST['firstName']));
    $lastName =  ucfirst(trim($_POST['lastName']));

    $message .= ifEmptyGenerateMessage($firstName, "Förnamn måste vara ifyllt.");
    $message .= ifEmptyGenerateMessage($lastName, "Efternamn måste vara ifyllt.");

    $message .= $crudFunctions->updateName($message, $firstName, $lastName, $_SESSION['id']);

    $user = $crudFunctions->fetchUserById($_SESSION['id']);

    
    $data = [
        'message' => $message,
        'user'    => $user
    ];
}

if(isset($_POST['updateEmailBtn'])) {
    $email = trim($_POST['email']);

    $message .= ifEmptyGenerateMessage($email, "Email måste vara ifyllt.");

    $message .= checkIfEmailIsValid($email);

    $message .= $crudFunctions->updateEmail($message, $email, $_SESSION['id']);
    
    $data = [
        'message' => $message,
        'user'    => $user
    ];
}

if(isset($_POST['updatePhoneBtn'])) {
    $phone = trim($_POST['phone']);

    $message .= phoneNumberMustBeTenDigits($phone);

    $message .= $crudFunctions->updatePhone($message, $phone, $_SESSION['id']);
    
    $data = [
        'message' => $message,
        'user'    => $user
    ];
}

if(isset($_POST['updatePasswordBtn'])) {
    $oldpassword =        trim($_POST['oldpassword']);
    $newpassword =        trim($_POST['newpassword']);
    $confirmnewpassword = trim($_POST['confirmnewpassword']);
    
    $userspassword = $crudFunctions->fetchPasswordById($_SESSION['id']);

    if(checkIfPasswordIsCorrect($oldpassword, $userspassword['password'])) {
        $message .= ifEmptyGenerateMessage($newpassword, "Nytt lösenord måste vara ifyllt.");
        $message .= ifEmptyGenerateMessage($confirmnewpassword, "Bekräfta nytt lösenord måste vara ifyllt.");

        $message .= checkIfPasswordsMatch($newpassword, $confirmnewpassword);
            
        $message .= $crudFunctions->updatePassword($message, $newpassword, $_SESSION['id']);

    } 
    else {
        $message .= '<div class="alert alert-danger">Det gamla lösenordet stämmer inte, vänligen försök igen.</div>';
    }

    $data = [
        'message' => $message,
        'user'    => $user
    ];
}

if(isset($_POST['updateAdressBtn'])) {
    $street =  ucfirst(trim($_POST['street']));
    $postalCode =      trim($_POST['postalcode']);
    $city =    ucfirst(trim($_POST['city']));
    $country = ucfirst(trim($_POST['country']));

    $message .= ifEmptyGenerateMessage($street, "Adress måste vara ifyllt.");
    $message .= postalCodeMustBeFiveDigits($postalCode);
    $message .= ifEmptyGenerateMessage($city, "Ort måste vara ifyllt.");
    $message .= ifEmptyGenerateMessage($country, "Land måste vara ifyllt.");

    $message .= $crudFunctions->updateAdress($message, $street, $postalCode, $city, $country, $_SESSION['id']);

    $data = [
        'message' => $message,
        'user'    => $user
    ];
}

if(isset($_POST['deleteBtn'])) {
    $sql = "
        DELETE FROM users
        WHERE id = :id
    ";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(":id", $_SESSION['id']);
    $stmt->execute();

    $_SESSION = [];
    session_destroy();
}

if(isset($_POST['searchingByTitle'])) {
    $search = $_POST['searchByTitle'];
    $param = "%$search%";
    $sql = "
        SELECT * 
        FROM products 
        WHERE title LIKE :title
        ORDER BY id DESC
    ";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(":title", $param);
    $stmt->execute();
    $products = $stmt->fetchAll();

    $data = [
        'products' => $products
    ];
}

if(isset($_POST['searchingByFlavour'])) {
    $search = $_POST['searchByFlavour'];
    $param = "%$search%";
    $sql = "
        SELECT * 
        FROM products 
        WHERE flavour LIKE :flavour
        ORDER BY id DESC
    ";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(":flavour", $param);
    $stmt->execute();
    $products = $stmt->fetchAll();

    $data = [
        'products' => $products
    ];
}

echo json_encode($data);