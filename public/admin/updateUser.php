<?php
	$pageTitle = "Update user";

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

        $message .= ifEmptyGenerateMessage($firstName, "Firstname must not be empty.");
        $message .= ifEmptyGenerateMessage($lastName, "Lastname must not be empty.");
        $message .= ifEmptyGenerateMessage($email, "E-mail must not be empty.");
        $message .= phoneNumberMustBeTenDigits($phone);
        $message .= ifEmptyGenerateMessage($street, "Street must not be empty.");
        $message .= postalCodeMustBeFiveDigits($postalCode);
        $message .= ifEmptyGenerateMessage($city, "City must not be empty.");
        $message .= ifEmptyGenerateMessage($country, "Country must not be empty.");

        $message .= checkIfEmailIsValid($email);

        if(empty($password)) {
            $message .= $crudFunctions->updateUser($firstName, $lastName, $email, $user['password'], $phone, $street, $postalCode, $city, $country, $message);
        } else {
            $message .= $crudFunctions->updateUser($firstName, $lastName, $email, $password, $phone, $street, $postalCode, $city, $country, $message);
        }
    }

include('layout/header.php');

?>

<div id="content">
    <article class="border">
        <form method="POST" action="#">
            <fieldset>
                <legend>Uppdatera användare</legend>


                <?=$message ?>
                
                <p>
                    <label for="first_name">First name:</label> <br>
                    <input type="text" class="text" name="first_name" value="<?=htmlentities($user['first_name']) ?>">
                </p>

                <p>
                    <label for="last_name">Last Name:</label> <br>
                    <input type="text" class="text" name="last_name" value="<?=htmlentities($user['last_name']) ?>">
                </p>

                <p>
                    <label for="email">Email:</label> <br>
                    <input type="text" class="text" name="email" value="<?=htmlentities($user['email']) ?>">
                </p>

                <p>
                    <label for="password">New password:</label> <br>
                    <input type="text" class="text" name="password">
                </p>

                <p>
                    <label for="phone">Phone:</label> <br>
                    <input type="number" class="phone" name="phone" value="<?=htmlentities($user['phone']) ?>">
                </p>

                <p>
                    <label for="street">Street:</label> <br>
                    <input type="text" class="street" name="street" value="<?=htmlentities($user['street']) ?>">
                </p>

                <p>
                    <label for="postal_code">Postal code:</label> <br>
                    <input type="number" class="postal_code" name="postal_code" value="<?=htmlentities($user['postal_code']) ?>">
                </p>

                <p>
                    <label for="city">City:</label> <br>
                    <input type="text" class="city" name="city" value="<?=htmlentities($user['city']) ?>">
                </p>

                <p>
                    <label for="country">Country:</label> <br>
                    <input type="text" class="country" name="country" value="<?=htmlentities($user['country']) ?>">
                </p>

                <p>
                    <input type="submit" name="updateUserBtn" value="Uppdatera"> | 
                    <a href="users.php">To users</a>
                </p>
            </fieldset>
        </form>
    
        <hr>
    </article>
</div>

<?php include('layout/footer.php'); ?>
