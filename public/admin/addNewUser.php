<?php
	$pageTitle = "Add new user";

	require('../../src/config.php');
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
		$firstName = trim($_POST['firstName']);
		$lastName = trim($_POST['lastName']);
		$email = trim($_POST['email']);
		$password = trim($_POST['password']);
		$phone = trim($_POST['phone']);
		$street = trim($_POST['street']);
		$postalCode = trim($_POST['postalCode']);
        $city = trim($_POST['city']);
        $country = trim($_POST['country']);

		if (empty($firstName)) {
			$message .= '
                <div class="">
                    Firstname must not be empty.
                </div>
            ';
		}

		if (empty($lastName)) {
			$message .= '
                <div class="">
                    Lastname must not be empty.
                </div>
            ';
		}

		if (empty($email)) {
			$message .= '
                <div class="">
                    E-mail must not be empty.
                </div>
            ';
		}

		if (!empty($email) && filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
            $message .= '
                <div class="">
                    E-mail must be a valid e-mail.
                </div>
            ';
        }

		if (empty($password)) {
			$message .= '
                <div class="">
                    Password must not be empty.
                </div>
            ';
		} else {
			$encryptedPassword = password_hash($password, PASSWORD_BCRYPT, ['cost' => 12]);
		}

		if (empty($phone)) {
			$message .= '
                <div class="">
                    Phone must not be empty.
                </div>
            ';
		}

		if (empty($street)) {
			$message .= '
                <div class="">
                    Street must not be empty.
                </div>
            ';
		}

        if (empty($postalCode)) {
			$message .= '
                <div class="">
                    Postalcode must not be empty.
                </div>
            ';
		}

        if (empty($city)) {
			$message .= '
                <div class="">
                    City must not be empty.
                </div>
            ';
		}

        if (empty($country)) {
			$message .= '
                <div class="">
                    Country must not be empty.
                </div>
            ';
		}

		if (empty($message)) {
			try {
				$crudFunctions->addNewUser($firstName, $lastName, $email,$password, $phone, $street, $postalCode, $city, $country);
				header('Location:users.php');
				exit;

			} catch (\PDOException $e) {
                if ((int) $e->getCode() === 23000) {
                    $message .= '
                        <div class="">
                            E-mail is already taked, please use another e-mail.
                        </div>
                    ';
                } else {
                    throw new \PDOException($e->getMessage(), (int) $e->getCode());
                }
            } 
		}
	

	include('layout/header.php');
?>


<h1>Add new user</h1>

<?=$message?>

<form action="" method="POST">
    <input type="text" name="firstName" placeholder="First Name" value="<?=$_POST['first_name']?>">
    <input type="text" name="lastName" placeholder="Last Name" value="<?=$_POST['last_name']?>">
    <input type="text" name="email" placeholder="E-mail" value="<?=$_POST['email']?>">
    <input type="text" name="password" placeholder="Password" value="<?=$_POST['password']?>">
    <input type="number" name="phone" placeholder="Phone" value="<?=$_POST['phone']?>">
    <input type="text" name="street" placeholder="Street" value="<?=$_POST['street']?>">
    <input type="number" name="postalCode" placeholder="Postal code" value="<?=$_POST['postal_code']?>">
    <input type="text" name="city" placeholder="City" value="<?=$_POST['city']?>">
    <input type="text" name="country" placeholder="Country" value="<?=$_POST['country']?>">
    <input type="submit" name="addNewUserBtn" value="Add new user">
</form>









<?php include('layout/footer.php') ?>