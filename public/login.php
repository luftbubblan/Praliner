<?php
	$pageTitle = "Login";

	require('../src/config.php');
    require('../src/app/common_functions.php');
    require('../src/app/CRUD_functions.php');

    if (isset($_GET['mustLogin'])) {
        $message = '
            <div class="">
                You need to login to access this.
            </div>
        ';
    }

    if (isset($_GET['deleted'])) {
        $message = '
            <div class="">
                You has successfully been deleted.
            </div>
        ';
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
            $message = '
                <div class="">
                    Invalid login credentials. Please try again.
                </div>
            ';
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


<?php include('layout/footer.php') ?>