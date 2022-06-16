<?php
	$pageTitle = "Login";

	require('../src/config.php');
    require('../src/app/common_functions.php');
    require('../src/app/CRUD_functions.php');

    echo "<pre>";
    print_r($_SESSION);
    echo "</pre>";
    
    $message .= isSuperGlobalSet($_GET['mustLogin'], "You need to login to access this.");
    $message .= isSuperGlobalSet($_GET['deleted'], "Your account has successfully been deleted.");

    if(isset($_SESSION['id'])) {
        header('Location: myPage.php');
        exit;
    }

    if (isset($_POST['loginBtn'])) {
        $email    = trim($_POST['email']);
        $password = trim($_POST['password']);

        $userData = $crudFunctions->fetchPasswordAndIdByEmail($email);

        if ($userData && checkIfPasswordIsCorrect($password, $userData['password'])) {
            setLoginSession($userData['id']);
            header('Location: myPage.php');
            exit;
        } else {
        $message .= errorMessage("Invalid login credentials. Please try again.");
        }
    }

    if (isset($_GET['deleted'])) {
        $message = '
            <div class="alert alert-warning">
                Your account has successfully been deleted.
            </div>
        ';
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

<script src="../src/app/showHidePass.js"></script>

<?php include('layout/footer.php') ?>