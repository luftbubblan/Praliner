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
}

$user = $crudFunctions->fetchUserById($_SESSION['id']);

$data = [
    'message' => $message,
    'user'    => $user
];

echo json_encode($data);