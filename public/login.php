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
        $message .= errorMessage("Du måste vara inloggad för att få tillgång till denna sida.");
    }
    if (isset($_GET['deleted'])) {
        $message .= warningMessage("Ditt konto är nu raderat. Välkommen åter.");
    }

    if (isset($_POST['loginBtn'])) {
        $email    = trim($_POST['email']);
        $password = trim($_POST['password']);

        $message .= checkIfEmailIsValid($email);
        if(!empty($message)) {
            $message = errorMessage("Ogiltiga inloggningsuppgifter. Vänligen försök igen.");
        } else {
            $userPasswordAndId = $crudFunctions->fetchPasswordAndIdByEmail($email);
    

            if(!empty($userPasswordAndId) && checkIfPasswordIsCorrect($password, $userPasswordAndId['password'])) {
                setLoginSession($userPasswordAndId['id']);
                header('Location: myPage.php');
                exit;
            }
            $message .= errorMessage("Felaktiga inloggningsuppgifter. Vänligen försök igen.");
        }

    }

	include('layout/header.php');
?>
<div id="logInContainer">
<div id="head-line-login">
    <h2>Logga in</h2>
</div>

<div id="loginMessage";>
    <?=$message?>
</div>

<div id="loginForm">
    <form action="" method="POST">
        <input type="text" name="email" placeholder="Email">
        <input type="password" name="password" placeholder="Lösenord">
        <input id="loginCheckbox" type="checkbox" onclick="showHidePassword(this)">Visa lösenord<br>
        <input id="loginBtn" class="btn btn-success" type="submit" name="loginBtn" value="Logga in">
    </form>
</div>
<script src="../src/app/js_functions.js"></script>
</div>
<?php include('layout/footer.php') ?>