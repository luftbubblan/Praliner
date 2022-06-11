<?php
	$pageTitle = "Login";

	require('../src/config.php');
    require('../src/app/common_functions.php');

    if (isset($_GET['mustLogin'])) {
        $message = '
            <div class="">
                You need to login to access this.
            </div>
        ';
    }

    if (isset($_POST['loginBtn'])) {
        $email    = trim($_POST['email']);
        $password = trim($_POST['password']);

        $sql = "
            SELECT id, password FROM users
            WHERE email = :email
        ";

        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['id'] = $user['id'];
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