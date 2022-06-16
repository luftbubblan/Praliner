<?php
	$pageTitle = "Register User";

	require('../src/config.php');
    require('../src/app/common_functions.php');
    require('../src/app/CRUD_functions.php');

    //CREATE
    $message = "";
    $firstName = "";
    $lastName = "";
    $email = "";
    $password = "";
    $confirmedPassword = "";
    $encryptedPassword = "";
    $phone = "";
    $street = "";
    $postalCode = "";
    $city = "";
    $country = "";
    $registerUserBtn = "";

    if(isset($_POST['registerUserBtn'])) {
        $firstName =  ucfirst(trim($_POST['firstName']));
        $lastName =   ucfirst(trim($_POST['lastName']));
        $email =              trim($_POST['email']);
        $password =           trim($_POST['password']);
        $confirmedPassword =  trim($_POST['confirmedPassword']);
        $phone =              trim($_POST['phone']);
        $street =     ucfirst(trim($_POST['street']));
        $postalCode =         trim($_POST['postalCode']);
        $city =       ucfirst(trim($_POST['city']));
        $country =    ucfirst(trim($_POST['country']));

        
        $message .= ifEmptyGenerateMessage($firstName, "Firstname must not be empty.");
        $message .= ifEmptyGenerateMessage($lastName, "Lastname must not be empty.");
        $message .= ifEmptyGenerateMessage($email, "E-mail must not be empty.");
        $message .= ifEmptyGenerateMessage($password, "Password must not be empty.");
        $message .= ifEmptyGenerateMessage($confirmedPassword, "Confirm password must not be empty.");
        $message .= phoneNumberMustBeTenDigits($phone);
        $message .= ifEmptyGenerateMessage($street, "Street must not be empty.");
        $message .= postalCodeMustBeFiveDigits($postalCode);
        $message .= ifEmptyGenerateMessage($city, "City must not be empty.");
        $message .= ifEmptyGenerateMessage($country, "Country must not be empty.");

        $message .= checkIfEmailIsValid($email);

        $message .= checkIfPasswordsMatch($password, $confirmedPassword);

        $message .= $crudFunctions->registerUser($message, $firstName, $lastName, $email, $password, $phone, $street, $postalCode, $city, $country);
    }


	include('layout/header.php');
?>


<h1>Register User</h1>
<hr>

<?=$message?>

<form action="" method="POST">
    <input type="text" name="firstName" placeholder="Firstname" value="<?=$_POST['firstName']?>"><br>
    <input type="text" name="lastName" placeholder="Lastname" value="<?=$_POST['lastName']?>"><br>
    <input type="text" name="email" placeholder="E-mail" value="<?=$_POST['email']?>"><br>
    <input type="password" name="password" placeholder="Password" value="<?=$_POST['password']?>">
    <input type="checkbox" onclick="showHidePassword(this)">Show Password<br>
    <input type="password" name="confirmedPassword" placeholder="Confirm password" value="<?=$_POST['confirmedPassword']?>">
    <input type="checkbox" onclick="showHidePassword(this)">Show Password<br>
    <input type="number" name="phone" placeholder="Phone 10 digits" value="<?=$_POST['phone']?>"><br>
    <input type="text" name="street" placeholder="Street" value="<?=$_POST['street']?>"><br>
    <input type="number" name="postalCode" placeholder="Postal code" value="<?=$_POST['postalCode']?>"><br>
    <input type="text" name="city" placeholder="City" value="<?=$_POST['city']?>"><br>
    <input type="text" name="country" placeholder="Country" value="<?=$_POST['country']?>"><br>
    <input type="submit" name="registerUserBtn" value="Register User">
</form>


<script src="../src/app/showHidePass.js"></script>

<?php include('layout/footer.php') ?>