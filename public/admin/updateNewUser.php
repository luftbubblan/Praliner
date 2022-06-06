<?php
	$pageTitle = "Update new user";

	require('../../src/config.php');


/* To check if the user exists in DB */

    if (!isset($_GET['userId']) || !is_numeric($_GET['userId'])) {
        header('Location: users.php?invalidUser');
        exit;
    }



    echo "<pre>";
    print_r($_POST);
    echo "</pre>";

	$message = "";
    if (isset($_POST['updateUserBtn'])) {
        $firstName = trim($_POST['first_name']);
		$lastName = trim($_POST['last_name']);
		$email = trim($_POST['email']);
		$password = trim($_POST['password']);
		$phone = trim($_POST['phone']);
		$postalCode = trim($_POST['postal_code']);
        $city = trim($_POST['city']);
        $country = trim($_POST['country']);

       /*  if ($password !== $confirmPassword) {
            $message = '
                <div class="error_msg">
                    Confirmed password incorrect!
                </div>
            '; */
        } else {
            $sql = "
                UPDATE users
                SET 
                first_name = :first_name,
                last_name = :last_name,
                email = :email,
                password = :password,
                phone = :phone,
                postal_code = :postal_code,
                city = :city,
                country = :country,
                WHERE id = :id
            ";

            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':id', $_GET['userId']);
            $stmt->bindParam(':first_name', $first_name);
            $stmt->bindParam(':last_name', $last_name);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':password', $password);
            $stmt->bindParam(':phone', $phone);
            $stmt->bindParam(':postal_code', $postal_code);
            $stmt->bindParam(':city', $city);
            $stmt->bindParam(':country', $country);
            $stmt->execute();
        }
    


    /**
     * Fetch user
     */
    $sql = "
        SELECT * FROM users
        WHERE id = :id
    ";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id', $_GET['userId']);
    $stmt->execute();
    $user = $stmt->fetch();

    // echo 'User';
    // echo "<pre>";
    // print_r($user);
    // echo "</pre>";

?>
<?php include('layout/header.php'); ?>

    <div id="content">
        <article class="border">
            <form method="POST" action="#">
                <fieldset>
                    <legend>Uppdatera användare</legend>


                    <?=$message ?>
                    
                    <p>
                        <label for="input1">First name:</label> <br>
                        <input type="text" class="text" name="first_name" value="<?=htmlentities($user['first_name']) ?>">
                    </p>

                    <p>
                        <label for="input1">Last Name:</label> <br>
                        <input type="text" class="text" name="last_name" value="<?=htmlentities($user['last_name']) ?>">
                    </p>

                    <p>
                        <label for="input2">Email:</label> <br>
                        <input type="text" class="text" name="email" value="<?=htmlentities($user['email']) ?>">
                    </p>

                    <p>
                        <label for="input3">Password:</label> <br>
                        <input type="password" class="text" name="password">
                    </p>

                    <p>
                        <label for="input4">Phone:</label> <br>
                        <input type="number" class="phone" name="phone" value="<?=htmlentities($user['phone']) ?>">
                    </p>

                    <p>
                        <label for="input5">Phone:</label> <br>
                        <input type="number" class="postal_code" name="postal_code" value="<?=htmlentities($user['postal_code']) ?>">
                    </p>

                    <p>
                        <label for="input6">Email:</label> <br>
                        <input type="text" class="city" name="city" value="<?=htmlentities($user['city']) ?>">
                    </p>

                    <p>
                        <label for="input6">Email:</label> <br>
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
