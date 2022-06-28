<?php
	$pageTitle = "Uppdatera användare";

	require('../../src/config.php');
	require('../../src/app/common_functions.php');
	require('../../src/app/CRUD_functions.php');

    $user = $crudFunctions->fetchUserById($_GET['userId']);

	$message = "";
    if (isset($_POST['updateUserBtn'])) {
        $firstName =  ucfirst(trim($_POST['first_name']));
        $lastName =   ucfirst(trim($_POST['last_name']));
        $email =              trim($_POST['email']);
		$password =           trim($_POST['password']);
        $phone =              trim($_POST['phone']);
        $street =     ucfirst(trim($_POST['street']));
        $postalCode =         trim($_POST['postal_code']);
        $city =       ucfirst(trim($_POST['city']));
        $country =    ucfirst(trim($_POST['country']));

        $message .= ifEmptyGenerateMessage($firstName, "Förnamn måste vara ifyllt.");
        $message .= ifEmptyGenerateMessage($lastName, "Efternamn måste vara ifyllt.");
        $message .= ifEmptyGenerateMessage($email, "Email måste vara ifyllt.");
        $message .= phoneNumberMustBeTenDigits($phone);
        $message .= ifEmptyGenerateMessage($street, "Adress måste vara ifyllt.");
        $message .= postalCodeMustBeFiveDigits($postalCode);
        $message .= ifEmptyGenerateMessage($city, "Ort måste vara ifyllt.");
        $message .= ifEmptyGenerateMessage($country, "Land måste vara ifyllt.");

        $message .= checkIfEmailIsValid($email);

        if(empty($password)) {
            $message .= $crudFunctions->updateUser($firstName, $lastName, $email, $user['password'], $phone, $street, $postalCode, $city, $country, $message, $_GET['userId']);
        } else {
            $message .= $crudFunctions->updateUser($firstName, $lastName, $email, $password, $phone, $street, $postalCode, $city, $country, $message, $_GET['userId']);
        }
    }

include('layout/header.php');

?>
    <?=$message ?>
        <div class="form-style">
            <form method="POST" action="#">
                    <h2>Admin</h2>
                    <h4>Redigera användare</h4>
                    <div class="form-gap">
                        <label for="first_name">Förnamn:</label> <br>
                        <input type="text" class="text" name="first_name" value="<?=htmlentities($user['first_name']) ?>">
                    </div>
                    <div class="form-gap">
                        <label for="last_name">Efternamn:</label> <br>
                        <input type="text" class="text" name="last_name" value="<?=htmlentities($user['last_name']) ?>">
                    </div>
                        <label for="email">Email:</label> <br>
                        <input type="text" class="text" name="email" value="<?=htmlentities($user['email']) ?>">
                    <div class="form-gap">
                        <label for="password">Nytt lösenord: (Lämna tom för att behålla gammalt lösenord)</label> <br>
                        <input type="text" class="text" name="password">
                    </div>
                    <div class="form-gap">
                        <label for="phone">Telefon:</label> <br>
                        <input type="number" class="phone" name="phone" value="<?=htmlentities($user['phone']) ?>">
                    </div>
                    <div class="form-gap">
                        <label for="street">Adress:</label> <br>
                        <input type="text" class="street" name="street" value="<?=htmlentities($user['street']) ?>">
                    </div>
                    <div class="form-gap">
                        <label for="postal_code">Postnummer:</label> <br>
                        <input type="number" class="postal_code" name="postal_code" value="<?=htmlentities($user['postal_code']) ?>">
                    </div>
                    <div class="form-gap">
                        <label for="city">Ort:</label> <br>
                        <input type="text" class="city" name="city" value="<?=htmlentities($user['city']) ?>">
                    </div>
                    <div class="form-gap">
                        <label for="country">Land:</label> <br>
                        <input type="text" class="country" name="country" value="<?=htmlentities($user['country']) ?>">
                    </div>
                    <div>
                        <input class="edit-btn btn btn-success" type="submit" name="updateUserBtn" value="Uppdatera">
                        <input class="btn btn-outline-info" type="submit" name="Back to Users" value="Tillbaka">
                    </div>
                        <!--  <a href="users.php">To users</a> -->
                    </div>
            </form>
    
<?php include('layout/footer.php'); ?>
