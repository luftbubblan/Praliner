<?php
	$pageTitle = "Login";

	require('../src/config.php');
    require('../src/app/common_functions.php');
    require('../src/app/CRUD_functions.php');

    $message = "";

    if(isset($_SESSION['id'])) {
        header('Location: myPage.php');
        exit;
    }
    
    if (isset($_GET['mustLogin'])) {
        $message .= errorMessage("You need to login to access this.");
    }
    if (isset($_GET['deleted'])) {
        $message .= warningMessage("Your account has successfully been deleted.");
    }

    if (isset($_POST['loginBtn'])) {
        $email    = trim($_POST['email']);
        $password = trim($_POST['password']);

        if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $message .= errorMessage("Invalid login credentials. Please try again.");
        } else {
            $userPasswordAndId = $crudFunctions->fetchPasswordAndIdByEmail($email);
    
            if(checkIfPasswordIsCorrect($password, $userPasswordAndId['password'])) {
                setLoginSession($userPasswordAndId['id']);
                header('Location: myPage.php');
                exit;
            }
            $message .= errorMessage("Invalid login credentials. Please try again.");
        }

    }

	include('layout/header.php');
?>


<h1>Login</h1>
<hr>

<?=$message?>

<form action="" method="POST">
    <input type="text" name="email" placeholder="E-mail">
    <input type="password" name="password" placeholder="Password">
    <input type="checkbox" onclick="showHidePassword(this)">Show Password<br>
    <input type="submit" name="loginBtn" value="Login">
</form>

<script src="../src/app/js_functions.js"></script>

<?php include('layout/footer.php') ?>