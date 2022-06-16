<?php
require('../config.php');
require('common_functions.php');
require('CRUD_functions.php');

// echo "<pre>";
// print_r($_POST);
// echo "</pre>";

$message = "";

if(isset($_POST['updateNameBtn'])) {
    $firstName = ucfirst(trim($_POST['firstName']));
    $lastName =  ucfirst(trim($_POST['lastName']));

    $message .= ifEmptyGenerateMessage($firstName, "First name must not be empty.");
    $message .= ifEmptyGenerateMessage($lastName, "Last name must not be empty.");

    $message .= $crudFunctions->updateName($message, $firstName, $lastName, $_SESSION['id']);

    $user = $crudFunctions->fetchUserById($_SESSION['id']);
    
    $data = [
        'message' => $message,
        'user'    => $user
    ];
}

if(isset($_POST['updateEmailBtn'])) {
    $email = trim($_POST['email']);

    $message .= ifEmptyGenerateMessage($email, "E-mail must not be empty.");

    $message .= checkIfEmailIsValid($email);

    $message .= $crudFunctions->updateEmail($message, $email, $_SESSION['id']);
    
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
        $message .= ifEmptyGenerateMessage($newpassword, "New password must not be empty.");
        $message .= ifEmptyGenerateMessage($confirmnewpassword, "Confirm new password must not be empty.");

        $message .= checkIfPasswordsMatch($newpassword, $confirmnewpassword);
            
        $message .= $crudFunctions->updatePassword($message, $newpassword, $_SESSION['id']);

    } 
    else {
        $message .= '<div class="alert alert-danger">The old password is incorrect.</div>';
    }

    $data = [
        'message' => $message,
        'user'    => $user
    ];
}

if(isset($_POST['updateInformationBtn'])) {
    $phone =           trim($_POST['phone']);
    $street =  ucfirst(trim($_POST['street']));
    $postalCode =      trim($_POST['postalcode']);
    $city =    ucfirst(trim($_POST['city']));
    $country = ucfirst(trim($_POST['country']));

    $message .= phoneNumberMustBeTenDigits($phone);
    $message .= ifEmptyGenerateMessage($street, "Street must not be empty.");
    $message .= postalCodeMustBeFiveDigits($postalCode);
    $message .= ifEmptyGenerateMessage($city, "City must not be empty.");
    $message .= ifEmptyGenerateMessage($country, "Country must not be empty.");

    $message .= $crudFunctions->updateInformation($message, $phone, $street, $postalCode, $city, $country, $_SESSION['id']);

    $data = [
        'message' => $message,
        'user'    => $user
    ];
}

echo json_encode($data);