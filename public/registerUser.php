<?php
	$pageTitle = "Register User";

	require('../src/config.php');
    require('../src/app/common_functions.php');

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
        $message .= ifEmptyGenerateMessage($phone, "Phone must not be empty.");
        $message .= ifEmptyGenerateMessage($street, "Street must not be empty.");
        $message .= ifEmptyGenerateMessage($postalCode, "Postal code must not be empty.");
        $message .= ifEmptyGenerateMessage($city, "City must not be empty.");
        $message .= ifEmptyGenerateMessage($country, "Country must not be empty.");

        if (!empty($email) && filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
            $message .= '
            <div class="">
                E-mail must be a valid e-mail.
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

                $sql = "
                    SELECT id FROM users
                    WHERE email = :email
                ";

                $stmt = $pdo->prepare($sql);
                $stmt->bindParam(':email', $email);
                $stmt->execute();
                $user = $stmt->fetch();

                $_SESSION['id'] = $user['id'];

                // echo "<pre>";
                // print_r($user);
                // print_r($_SESSION);
                // echo "</pre>";

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
    <input type="text" name="firstName" placeholder="Firstname" value="<?=$_POST['firstName']?>"><br>
    <input type="text" name="lastName" placeholder="Lastname" value="<?=$_POST['lastName']?>"><br>
    <input type="text" name="email" placeholder="E-mail" value="<?=$_POST['email']?>"><br>
    <input type="password" name="password" placeholder="Password" value="<?=$_POST['password']?>">
    <input type="checkbox" onclick="showHidePassword(this)">Show Password<br>
    <input type="password" name="confirmedPassword" placeholder="Confirm password" value="<?=$_POST['confirmedPassword']?>">
    <input type="checkbox" onclick="showHidePassword(this)">Show Password<br>
    <input type="number" name="phone" placeholder="Phone" value="<?=$_POST['phone']?>"><br>
    <input type="text" name="street" placeholder="Street" value="<?=$_POST['street']?>"><br>
    <input type="number" name="postalCode" placeholder="Postal code" value="<?=$_POST['postalCode']?>"><br>
    <input type="text" name="city" placeholder="City" value="<?=$_POST['city']?>"><br>
    <input type="text" name="country" placeholder="Country" value="<?=$_POST['country']?>"><br>
    <input type="submit" name="registerUserBtn" value="Register User">
</form>




<?php include('layout/footer.php') ?>