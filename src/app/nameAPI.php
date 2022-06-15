<?php
require('../config.php');
require('CRUD_functions.php');

// echo "<pre>";
// print_r($_POST);
// echo "</pre>";

$message = "";

if(isset($_POST['updateNameBtn'])) {
    $firstName = ucfirst(trim($_POST['firstName']));
    $lastName =  ucfirst(trim($_POST['lastName']));

    if (empty($firstName)) {
        $message .= '<div class="">Firstname must not be empty.</div>';
    }
    if (empty($lastName)) {
        $message .= '<div class="">Lastname must not be empty.</div>';
    }

    $message = $crudFunctions->updateName($message, $firstName, $lastName, $_SESSION['id']);
}

$user = $crudFunctions->fetchUserById($_SESSION['id']);

$data = [
    'message' => $message,
    'user'    => $user
];


echo json_encode($data);