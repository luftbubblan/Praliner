<?php
	$pageTitle = "Register User";

	require('../src/config.php');

    // echo "<pre>";
    // print_r($_POST);
    // echo "</pre>";

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
        $firstName = trim($_POST['firstName']);
        $lastName = trim($_POST['lastName']);
        $email = trim($_POST['email']);
        $password = trim($_POST['password']);
        $confirmedPassword = trim($_POST['confirmedPassword']);
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
		}
        
        if (empty($confirmedPassword)) {
			$message .= '
                <div class="">
                    Confirm password must not be empty.
                </div>
            ';
		}

        if (!empty($confirmedPassword) && !empty($password) && $password !== $confirmedPassword) {
            $message .= '
                <div class="">
                    "Password" and "Confirm password" must match.
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
                    Postal code must not be empty.
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
                        country)
                    VALUES (
                        :firstName,
                        :lastName,
                        :email,
                        :encryptedPassword,
                        :phone,
                        :street,
                        :postalCode,
                        :city,
                        :country)
                    ";
            
                $stmt = $pdo->prepare($sql);
                $stmt->bindParam(':firstName', $firstName);
                $stmt->bindParam(':lastName', $lastName);
                $stmt->bindParam(':email', $email);
                $stmt->bindParam(':encryptedPassword', $encryptedPassword);
                $stmt->bindParam(':phone', $phone);
                $stmt->bindParam(':street', $street);
                $stmt->bindParam(':postalCode', $postalCode);
                $stmt->bindParam(':city', $city);
                $stmt->bindParam(':country', $country);
                $stmt->execute();
                header('Location: myPage.php');
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
    }


	include('layout/header.php');
?>


<h1>Register User</h1>
<hr>

<?=$message?>

<form action="" method="POST">
    <input type="text" name="firstName" placeholder="Firstname" value="<?=$_POST['firstName']?>">
    <input type="text" name="lastName" placeholder="Lastname" value="<?=$_POST['lastName']?>"><br>
    <input type="text" name="email" placeholder="E-mail" value="<?=$_POST['email']?>"><br>
    <input type="text" name="password" placeholder="Password" value="<?=$_POST['password']?>">
    <input type="text" name="confirmedPassword" placeholder="Confirm password" value="<?=$_POST['confirmedPassword']?>"><br>
    <input type="text" name="phone" placeholder="Phone" value="<?=$_POST['phone']?>"><br>
    <input type="text" name="street" placeholder="Street" value="<?=$_POST['street']?>">
    <input type="text" name="postalCode" placeholder="Postal code" value="<?=$_POST['postalCode']?>">
    <input type="text" name="city" placeholder="City" value="<?=$_POST['city']?>">
    <input type="text" name="country" placeholder="Country" value="<?=$_POST['country']?>">
    <input type="submit" name="registerUserBtn" value="Register User">
</form>




<?php include('layout/footer.php') ?>