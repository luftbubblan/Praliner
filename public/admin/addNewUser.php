<?php
	$pageTitle = "Add new user";

	require('../../src/config.php');
	require('../../src/app/common_functions.php');
	require('../../src/app/CRUD_functions.php');

    echo "<pre>";
    print_r($_POST);
    echo "</pre>";

	//CREATE
	$message = "";

	$firstName = "";
	$lastName = "";
	$email = "";
	$password = "";
    $encryptedPassword = "";
	$phone = "";
	$street = "";
    $postalCode = "";
    $city = "";
    $country = "";
	
	if (isset($_POST['addNewUserBtn'])) {
		$firstName =  ucfirst(trim($_POST['firstName']));
        $lastName =   ucfirst(trim($_POST['lastName']));
        $email =              trim($_POST['email']);
		$password =           trim($_POST['password']);
        $phone =              trim($_POST['phone']);
        $street =     ucfirst(trim($_POST['street']));
        $postalCode =         trim($_POST['postalCode']);
        $city =       ucfirst(trim($_POST['city']));
        $country =    ucfirst(trim($_POST['country']));

		$message .= ifEmptyGenerateMessage($firstName, "Firstname must not be empty.");
        $message .= ifEmptyGenerateMessage($lastName, "Lastname must not be empty.");
        $message .= ifEmptyGenerateMessage($email, "E-mail must not be empty.");
        $message .= ifEmptyGenerateMessage($password, "Password must not be empty.");
        $message .= phoneNumberMustBeTenDigits($phone);
        $message .= ifEmptyGenerateMessage($street, "Street must not be empty.");
        $message .= postalCodeMustBeFiveDigits($postalCode);
        $message .= ifEmptyGenerateMessage($city, "City must not be empty.");
        $message .= ifEmptyGenerateMessage($country, "Country must not be empty.");

        $message .= checkIfEmailIsValid($email);

		$message .=$crudFunctions->addNewUser($firstName, $lastName, $email,$password, $phone, $street, $postalCode, $city, $country, $message);
	
    }
	include('layout/header.php');
?>


<h1>Add new user</h1>

<?=$message?>

<form action="" method="POST">
    <input type="text" name="firstName" placeholder="First Name" value="<?=$_POST['first_name'] ?? "" ?>">
    <input type="text" name="lastName" placeholder="Last Name" value="<?=$_POST['last_name'] ?? "" ?>">
    <input type="text" name="email" placeholder="E-mail" value="<?=$_POST['email'] ?? "" ?>">
    <input type="text" name="password" placeholder="Password" value="<?=$_POST['password'] ?? "" ?>">
    <input type="number" name="phone" placeholder="Phone" value="<?=$_POST['phone'] ?? "" ?>">
    <input type="text" name="street" placeholder="Street" value="<?=$_POST['street'] ?? "" ?>">
    <input type="number" name="postalCode" placeholder="Postal code" value="<?=$_POST['postal_code']?>">
    <input type="text" name="city" placeholder="City" value="<?=$_POST['city'] ?? "" ?>">
    <input type="text" name="country" placeholder="Country" value="<?=$_POST['country'] ?? "" ?>">
    <input type="submit" name="addNewUserBtn" value="Add new user">
</form>









<?php include('layout/footer.php') ?>