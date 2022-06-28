<?php
	$pageTitle = "Skapa ny användare";

	require('../../src/config.php');
	require('../../src/app/common_functions.php');
	require('../../src/app/CRUD_functions.php');

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

		$message .= ifEmptyGenerateMessage($firstName, "Förnamn måste vara ifyllt.");
        $message .= ifEmptyGenerateMessage($lastName, "Efternamn måste vara ifyllt.");
        $message .= ifEmptyGenerateMessage($email, "Email måste vara ifyllt.");
        $message .= ifEmptyGenerateMessage($password, "Lösenord måste vara ifyllt.");
        $message .= phoneNumberMustBeTenDigits($phone);
        $message .= ifEmptyGenerateMessage($street, "Adress måste vara ifyllt.");
        $message .= postalCodeMustBeFiveDigits($postalCode);
        $message .= ifEmptyGenerateMessage($city, "Ort måste vara ifyllt.");
        $message .= ifEmptyGenerateMessage($country, "Land måste vara ifyllt.");

        $message .= checkIfEmailIsValid($email);

		$message .=$crudFunctions->addNewUser($firstName, $lastName, $email,$password, $phone, $street, $postalCode, $city, $country, $message);
	
    }
	include('layout/header.php');
?>

<?=$message?>

    <div class="form-style">
    <form action="" method="POST" enctype="multipart/form-data">
        <h2>Admin</h2>
        <h4>Skapa ny användare</h4>
        <div class="form-gap">
            <label for="first_name">Förnamn:</label><br>
            <input type="text" name="firstName" placeholder="First Name" value="<?=$_POST['firstName'] ?? "" ?>">
        </div>
        <div class="form-gap">
            <label for="first_name">Efternamn:</label><br>
            <input type="text" name="lastName" placeholder="Last Name" value="<?=$_POST['lastName'] ?? "" ?>">
        </div>
        <div class="form-gap">
            <label for="first_name">Email:</label><br>
            <input type="text" name="email" placeholder="E-mail" value="<?=$_POST['email'] ?? "" ?>">
        </div>
        <div class="form-gap">
            <label for="first_name">Lösenord:</label><br>
            <input type="text" name="password" placeholder="Password" value="<?=$_POST['password'] ?? "" ?>">
        </div>
        <div class="form-gap">
            <label for="first_name">Telefon:</label><br>
            <input type="number" name="phone" placeholder="Phone" value="<?=$_POST['phone'] ?? "" ?>">
        </div>
        <div class="form-gap">
            <label for="first_name">Adress:</label><br>
            <input type="text" name="street" placeholder="Street" value="<?=$_POST['street'] ?? "" ?>">
        </div>
        <div class="form-gap">
            <label for="first_name">Postnummer:</label><br>
            <input type="number" name="postalCode" placeholder="Postal code" value="<?=$_POST['postalCode'] ?? "" ?>">
        </div>
        <div class="form-gap">
            <label for="first_name">Ort:</label><br>
            <input type="text" name="city" placeholder="City" value="<?=$_POST['city'] ?? "" ?>">
        </div>
        <div class="form-gap">
            <label for="first_name">Land:</label><br>
            <input type="text" name="country" placeholder="Country" value="<?=$_POST['country'] ?? "" ?>">
        </div>
            <div class="form-gap">
            <input type="submit" class="btn btn-success" name="addNewUserBtn" value="Lägg till">
        </div>
    </form>
</div>



<?php include('layout/footer.php') ?>