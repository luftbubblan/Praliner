<?php
	$pageTitle = "Add new user";

	require('../../src/config.php');

    echo "<pre>";
    print_r($_POST);
    echo "</pre>";

	//CREATE
	$message = "";
	$firstName = "";
	$lastName = "";
	$email = "";
	$password = "";
	$phone = "";
	$street = "";
    $postalCode = "";
    $city = "";
    $country = "";
	$empty = "not empty";
	if (isset($_POST['createProductBtn'])) {
		$firstName = trim($_POST['first_name']);
		$lastName = trim($_POST['last_name']);
		$email = trim($_POST['email']);
		$password = trim($_POST['password']);
		$phone = trim($_POST['phone']);
		$postalCode = trim($_POST['postal_code']);
        $city = trim($_POST['city']);
        $country = trim($_POST['country']);

		if (empty($firstName)) {
			$message .= '
                <div class="">
                    Title must not be empty.
                </div>
            ';
			$empty = "empty";
		}

		if (empty($lastName)) {
			$message .= '
                <div class="">
                    Flavour must not be empty.
                </div>
            ';
			$empty = "empty";
		}

		if (empty($email)) {
			$message .= '
                <div class="">
                    Description must not be empty.
                </div>
            ';
			$empty = "empty";
		}

		if (empty($password)) {
			$message .= '
                <div class="">
                    Price must not be empty.
                </div>
            ';
			$empty = "empty";
		}

		if (empty($phone)) {
			$message .= '
                <div class="">
                    Stock must not be empty.
                </div>
            ';
			$empty = "empty";
		}

		if (empty($street)) {
			$message .= '
                <div class="">
                    Img must not be empty.
                </div>
            ';
			$empty = "empty";
		}

        if (empty($postalCode)) {
			$message .= '
                <div class="">
                    Img must not be empty.
                </div>
            ';
			$empty = "empty";
		}

        if (empty($city)) {
			$message .= '
                <div class="">
                    Img must not be empty.
                </div>
            ';
			$empty = "empty";
		}

        if (empty($country)) {
			$message .= '
                <div class="">
                    Img must not be empty.
                </div>
            ';
			$empty = "empty";
		}



		if ($empty == "not empty") {
			$sql = "
				INSERT INTO users (
				first_name,
	            last_name,
	            email,
	            password,
	            phone,
	            street,
                postal_code,
                city,
                country,
				VALUES (
					:first_name,
					:last_name,
					:email,
					:password,
					:phone,
                    :street,
                    :postal_code,
                    :city,
                    :country)
                    
			";
		
			$stmt = $pdo->prepare($sql);
			$stmt->bindParam(':first_name', $firstName);
			$stmt->bindParam(':last_name', $lastName);
			$stmt->bindParam(':email', $email);
			$stmt->bindParam(':password', $password);
			$stmt->bindParam(':phone', $phone);
			$stmt->bindParam(':street', $street);
            $stmt->bindParam(':postal_code', $postal_code);
            $stmt->bindParam(':city', $city);
            $stmt->bindParam(':country', $country);
			$stmt->execute();
			header('Location: users.php');
			exit;
		}
	}

	include('layout/header.php');
?>


<h1>Add new user</h1>
<a href="index.php">Admin</a>

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
    <input type="submit" name="createNewUserBtn" value="Add new user">
</form>









<?php include('layout/footer.php') ?>