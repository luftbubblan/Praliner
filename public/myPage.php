<?php
    $pageTitle = "My Page";

    require('../src/config.php');
    require('../src/app/common_functions.php');

    if (!isset($_SESSION['id'])) {
        header('Location: login.php?mustLogin');
    }

    //UPDATE NAME
    if(isset($_POST['updateNameBtn'])) {
        $firstName = ucfirst(trim($_POST['firstName']));
        $lastName = ucfirst(trim($_POST['lastName']));

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

        if (empty($message)) {
            $sql = "
                UPDATE users
                SET
                    first_name = :firstName,
                    last_name = :lastName
                WHERE id = :id
            ";
        
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':firstName', $firstName);
            $stmt->bindParam(':lastName', $lastName);
            $stmt->bindParam(':id', $_SESSION['id']);
            $stmt->execute();

            $message .= '
                <div class="">
                    Name has been updated.
                </div>
            ';
        }
    }

    //UPDATE EMAIL
    if(isset($_POST['updateEmailBtn'])) {
        $email = trim($_POST['email']);

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

        if (empty($message)) {
            try {
                $sql = "
                    UPDATE users
                    SET
                        email = :email
                    WHERE id = :id
                ";
            
                $stmt = $pdo->prepare($sql);
                $stmt->bindParam(':email', $email);
                $stmt->bindParam(':id', $_SESSION['id']);
                $stmt->execute();

                $message .= '
                    <div class="">
                        E-mail has been updated.
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

    //UPDATE PASSWORD
    if(isset($_POST['changePasswordBtn'])) {
        $oldpassword = trim($_POST['oldpassword']);
        $newpassword = trim($_POST['newpassword']);
        $confirmnewpassword = trim($_POST['confirmnewpassword']);

        $sql = "
            SELECT password FROM users
            WHERE id = :id
        ";

        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':id', $_SESSION['id']);
        $stmt->execute();
        $userspassword = $stmt->fetch();

        if ( !password_verify($oldpassword, $userspassword['password']) ) {
            $message = '
                <div class="">
                    The old password is incorrect.
                </div>
            ';
        } else {
            if (empty($newpassword)) {
                $message .= '
                    <div class="">
                        New password must not be empty.
                    </div>
                ';
            }
            
            if (empty($confirmnewpassword)) {
                $message .= '
                    <div class="">
                        Confirm new password must not be empty.
                    </div>
                ';
            }
    
            if (!empty($confirmnewpassword) && !empty($newpassword) && $newpassword !== $confirmnewpassword) {
                $message .= '
                    <div class="">
                        "Password" and "Confirm password" must match.
                    </div>
                ';
            } 
            
            if (empty($message)) {
                $encryptedPassword = password_hash($newpassword, PASSWORD_BCRYPT, ['cost' => 12]);

                $sql = "
                    UPDATE users
                    SET
                        password = :password
                    WHERE id = :id
                ";
            
                $stmt = $pdo->prepare($sql);
                $stmt->bindParam(":password", $encryptedPassword);
                $stmt->bindParam(':id', $_SESSION['id']);
                $stmt->execute();

                $message .= '
                    <div class="">
                        Password has been updated.
                    </div>
                ';
            }
        }
    }

    //UPDATE INFORMATION
    if(isset($_POST['updateInformationBtn'])) {
        $phone = trim($_POST['phone']);
        $street = ucfirst(trim($_POST['street']));
        $postalCode = trim($_POST['postalCode']);
        $city = ucfirst(trim($_POST['city']));
        $country = ucfirst(trim($_POST['country']));

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
            $sql = "
                UPDATE users
                SET
                    phone = :phone,
                    street = :street,
                    postal_code = :postal_code,
                    city = :city,
                    country = :country
                WHERE id = :id
            ";
        
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':phone', $phone);
            $stmt->bindParam(':street', $street);
            $stmt->bindParam(':postal_code', $postalCode);
            $stmt->bindParam(':city', $city);
            $stmt->bindParam(':country', $country);
            $stmt->bindParam(':id', $_SESSION['id']);
            $stmt->execute();

            $message .= '
                <div class="">
                    Information has been updated.
                </div>
            ';
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

<?=$message?>
<hr>

<div>
    <b>Firstname:</b> <?=$user['first_name']?> |
    <b>Lastname:</b> <?=$user['last_name']?> <br>
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#nameModal">Update Name</button>
</div>
<div>
    <b>E-mail:</b> <?=$user['email']?> <br>
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#emailModal">Update E-mail</button> <br>
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#passwordModal">Change password</button>
</div>
<div>
    <b>Phone:</b> <?=$user['phone']?> |
    <b>Street:</b> <?=$user['street']?> |
    <b>Postal code:</b> <?=$user['postal_code']?> |
    <b>City:</b> <?=$user['city']?> |
    <b>Country:</b> <?=$user['country']?> <br>
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#informationModal">Update information</button>
</div>


<!-- MODALS -->
<div class="modal fade" id="nameModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Update Name</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="" method="POST">
                    <div class="form-group">
                        <label for="firstName" class="col-form-label">Firstname:</label>
                        <input type="text" class="form-control" name="firstName" value="<?=$user['first_name']?>">
                    </div>
                    <div class="form-group">
                        <label for="lastName" class="col-form-label">Lastname:</label>
                        <input type="text" class="form-control" name="lastName" value="<?=$user['last_name']?>">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <input type="submit" class="btn btn-primary" name="updateNameBtn" value="Update">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="emailModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Update E-mail</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="" method="POST">
                    <div class="form-group">
                        <label for="email" class="col-form-label">E-mail:</label>
                        <input type="text" class="form-control" name="email" value="<?=$user['email']?>">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <input type="submit" class="btn btn-primary" name="updateEmailBtn" value="Update">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="passwordModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Change password</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="" method="POST">
                    <div class="form-group">
                        <label for="oldpassword" class="col-form-label">Old password:</label>
                        <input type="password" class="form-control" name="oldpassword">
                        <input type="checkbox" onclick="showHidePassword(this)">Show Password
                    </div>
                    <div class="form-group">
                        <label for="newpassword" class="col-form-label">New password:</label>
                        <input type="password" class="form-control" name="newpassword">
                        <input type="checkbox" onclick="showHidePassword(this)">Show Password
                    </div>
                    <div class="form-group">
                        <label for="confirmnewpassword" class="col-form-label">Confirm new password:</label>
                        <input type="password" class="form-control" name="confirmnewpassword">
                        <input type="checkbox" onclick="showHidePassword(this)">Show Password
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <input type="submit" class="btn btn-primary" name="changePasswordBtn" value="Update">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="informationModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Update Information</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="" method="POST">
                    <div class="form-group">
                        <label for="phone" class="col-form-label">Phone:</label>
                        <input type="text" class="form-control" name="phone" value="<?=$user['phone']?>">
                    </div>
                    <div class="form-group">
                        <label for="street" class="col-form-label">Street:</label>
                        <input type="text" class="form-control" name="street" value="<?=$user['street']?>">
                    </div>
                    <div class="form-group">
                        <label for="postalCode" class="col-form-label">Postal code:</label>
                        <input type="text" class="form-control" name="postalCode" value="<?=$user['postal_code']?>">
                    </div>
                    <div class="form-group">
                        <label for="city" class="col-form-label">City:</label>
                        <input type="text" class="form-control" name="city" value="<?=$user['city']?>">
                    </div>
                    <div class="form-group">
                        <label for="country" class="col-form-label">Country:</label>
                        <input type="text" class="form-control" name="country" value="<?=$user['country']?>">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <input type="submit" class="btn btn-primary" name="updateInformationBtn" value="Update">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- JQUERY AND BOOTSTRAP -->
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

<?php include('layout/footer.php') ?>