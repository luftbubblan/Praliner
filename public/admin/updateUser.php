<?php
	$pageTitle = "Update user";

	require('../../src/config.php');


/* To check if the user exists in DB */

   /*  if (!isset($_GET['userId']) || !is_numeric($_GET['userId'])) {
        header('Location: users.php?invalidUser');
        exit;
    } */



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
        $street = trim($_POST['street']);
		$postalCode = trim($_POST['postal_code']);
        $city = trim($_POST['city']);
        $country = trim($_POST['country']);

  /*   if {

        
    } */
       
            $sql = "
                UPDATE users
                SET 
                    first_name = :first_name,
                    last_name = :last_name,
                    email = :email,
                    password = :password,
                    phone = :phone,
                    street = :street,
                    postal_code = :postal_code,
                    city = :city,
                    country = :country
                WHERE id = :id
            ";

            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':id', $_GET['userId']);
            $stmt->bindParam(':first_name', $firstName);
            $stmt->bindParam(':last_name', $lastName);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':password', $password);
            $stmt->bindParam(':phone', $phone);
            $stmt->bindParam(':street', $street);
            $stmt->bindParam(':postal_code', $postalCode);
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
                        <input type="password" class="text" name="password">
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
