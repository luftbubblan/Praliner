<?php

    $pageTitle = "My Page";

    require('../src/config.php');

    if (!isset($_SESSION['id'])) {
        header('Location: login.php?mustLogin');
    }
    
    echo "<pre>";
    print_r($_POST);
    echo "</pre>";

    //UPPDATE
    if(isset($_POST['informationBtn'])) {
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
                    UPDATE users
                    SET
                        first_name = :firstName,
                        last_name = :lastName,
                        email = :email,
                        password = :password,
                        phone = :phone,
                        street = :street,
                        postal_code = :postalCode,
                        city = :city,
                        country = :country
                    WHERE id = :id
                ";
            
                $stmt = $pdo->prepare($sql);
                $stmt->bindParam(':firstName', $firstName);
                $stmt->bindParam(':lastName', $lastName);
                $stmt->bindParam(':email', $email);
                $stmt->bindParam(':password', $encryptedPassword);
                $stmt->bindParam(':phone', $phone);
                $stmt->bindParam(':street', $street);
                $stmt->bindParam(':postalCode', $postalCode);
                $stmt->bindParam(':city', $city);
                $stmt->bindParam(':country', $country);
                $stmt->bindParam(':id', $_SESSION['id']);
                $stmt->execute();

                $message .= '
                    <div class="">
                        Your information has been updated.
                    </div>
                ';
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

    //READ
    $sql = "
        SELECT * FROM users
        WHERE id = :id
    ";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id', $_SESSION['id']);
    $stmt->execute();
    $user = $stmt->fetch();

	include('layout/header.php');
?>


<h1>My Page</h1>
<!-- <a href="index.php">Shop</a> -->
<!-- <a href='logout.php'>Logout</a> -->

<p>Welcome <?=$user['first_name']?></p>

<?=$message?>

<form action="" method="POST">
    <lable for ="firstname">Firstname:</lable>
    <input type="text" name="firstName" value="<?=$user['first_name']?>">
    <lable for ="firstname">Lastname:</lable>
    <input type="text" name="lastName" value="<?=$user['last_name']?>"><br>
    <lable for ="firstname">E-mail:</lable>
    <input type="text" name="email" value="<?=$user['email']?>"><br>
    <lable for ="firstname">New password:</lable>
    <input type="text" name="password">
    <lable for ="firstname">Confirm new password:</lable>
    <input type="text" name="confirmedPassword"><br>
    <lable for ="firstname">Phone:</lable>
    <input type="text" name="phone" value="<?=$user['phone']?>"><br>
    <lable for ="firstname">Street:</lable>
    <input type="text" name="street" value="<?=$user['street']?>">
    <lable for ="firstname">Postal code:</lable>
    <input type="text" name="postalCode" value="<?=$user['postal_code']?>">
    <lable for ="firstname">City:</lable>
    <input type="text" name="city" value="<?=$user['city']?>">
    <lable for ="firstname">Country:</lable>
    <input type="text" name="country" value="<?=$user['country']?>"><br>
    <input type="submit" name="informationBtn" value="Update Information">
</form>














<?php include('layout/footer.php') ?>