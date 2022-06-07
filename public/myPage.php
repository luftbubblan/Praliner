<?php
    $pageTitle = "My Page";

    require('../src/config.php');

    if (!isset($_SESSION['id'])) {
        header('Location: login.php?mustLogin');
    }
    
    echo "<pre>";
    print_r($_POST);
    echo "</pre>";

    

    //UPPDATE NAME
    if(isset($_POST['updateNameBtn'])) {
        $firstName = trim($_POST['firstName']);
        $lastName = trim($_POST['lastName']);

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
                    Your name has been updated.
                </div>
            ';
        }
    }

    //UPPDATE EMAIL
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
                        Your E-mail has been updated.
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


    //     $password = trim($_POST['password']);
    //     $confirmedPassword = trim($_POST['confirmedPassword']);
    //     $phone = trim($_POST['phone']);
    //     $street = trim($_POST['street']);
    //     $postalCode = trim($_POST['postalCode']);
    //     $city = trim($_POST['city']);
    //     $country = trim($_POST['country']);
        
    //     if (empty($password)) {
	// 		$message .= '
    //             <div class="">
    //                 Password must not be empty.
    //             </div>
    //         ';
	// 	}
        
    //     if (empty($confirmedPassword)) {
	// 		$message .= '
    //             <div class="">
    //                 Confirm password must not be empty.
    //             </div>
    //         ';
	// 	}

    //     if (!empty($confirmedPassword) && !empty($password) && $password !== $confirmedPassword) {
    //         $message .= '
    //             <div class="">
    //                 "Password" and "Confirm password" must match.
    //             </div>
    //         ';
    //     } else {
    //         $encryptedPassword = password_hash($password, PASSWORD_BCRYPT, ['cost' => 12]);
    //     }
        
    //     if (empty($phone)) {
	// 		$message .= '
    //             <div class="">
    //                 Phone must not be empty.
    //             </div>
    //         ';
	// 	}
        
    //     if (empty($street)) {
	// 		$message .= '
    //             <div class="">
    //                 Street must not be empty.
    //             </div>
    //         ';
	// 	}
        
    //     if (empty($postalCode)) {
	// 		$message .= '
    //             <div class="">
    //                 Postal code must not be empty.
    //             </div>
    //         ';
	// 	}
        
    //     if (empty($city)) {
	// 		$message .= '
    //             <div class="">
    //                 City must not be empty.
    //             </div>
    //         ';
	// 	}

    //     if (empty($country)) {
	// 		$message .= '
    //             <div class="">
    //                 Country must not be empty.
    //             </div>
    //         ';
	// 	}

    //     if (empty($message)) {
    //         try {
    //             $sql = "
    //                 UPDATE users
    //                 SET
    //                     first_name = :firstName,
    //                     last_name = :lastName,
    //                     email = :email,
    //                     password = :password,
    //                     phone = :phone,
    //                     street = :street,
    //                     postal_code = :postalCode,
    //                     city = :city,
    //                     country = :country
    //                 WHERE id = :id
    //             ";
            
    //             $stmt = $pdo->prepare($sql);
    //             $stmt->bindParam(':firstName', $firstName);
    //             $stmt->bindParam(':lastName', $lastName);
    //             $stmt->bindParam(':email', $email);
    //             $stmt->bindParam(':password', $encryptedPassword);
    //             $stmt->bindParam(':phone', $phone);
    //             $stmt->bindParam(':street', $street);
    //             $stmt->bindParam(':postalCode', $postalCode);
    //             $stmt->bindParam(':city', $city);
    //             $stmt->bindParam(':country', $country);
    //             $stmt->bindParam(':id', $_SESSION['id']);
    //             $stmt->execute();

    //             $message .= '
    //                 <div class="">
    //                     Your information has been updated.
    //                 </div>
    //             ';
    //         } catch (\PDOException $e) {
    //             if ((int) $e->getCode() === 23000) {
    //                 $message .= '
    //                     <div class="">
    //                         E-mail is already taked, please use another e-mail.
    //                     </div>
    //                 ';
    //             } else {
    //                 throw new \PDOException($e->getMessage(), (int) $e->getCode());
    //             }
    //         } 
    //     }
    // }


























































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

<p>Firstname: <?=$user['first_name']?></p>
<p>Lastname: <?=$user['last_name']?></p>
<p>E-mail: <?=$user['email']?></p>
<p>Phone: <?=$user['phone']?></p>
<p>Street: <?=$user['street']?></p>
<p>Postal code: <?=$user['postal_code']?></p>
<p>City: <?=$user['city']?></p>
<p>Country: <?=$user['country']?></p>







<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#nameModal" data-firstname="<?=$user['first_name']?>" data-lastname="<?=$user['last_name']?>">Update Name</button>
<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#emailModal" data-email="<?=$user['email']?>">Update E-mail</button>




<!-- MODALS -->
<div class="modal fade" id="nameModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Uppdate Name</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="" method="POST">
                    <div class="form-group">
                        <label for="recipient-name" class="col-form-label">Firstname:</label>
                        <input type="text" class="form-control" name="firstName">
                    </div>
                    <div class="form-group">
                        <label for="message-text" class="col-form-label">Lastname:</label>
                        <input type="text" class="form-control" name="lastName">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <input type="submit" class="btn btn-primary" name="updateNameBtn" value="Uppdate">
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
                <h5 class="modal-title" id="exampleModalLabel">Uppdate E-mail</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="" method="POST">
                    <div class="form-group">
                        <label for="recipient-name" class="col-form-label">E-mail:</label>
                        <input type="text" class="form-control" name="email">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <input type="submit" class="btn btn-primary" name="updateEmailBtn" value="Uppdate">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>












<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>


<script>
    $('#nameModal').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget);
    var firstname = button.data('firstname');
    var lastname = button.data('lastname');
    
    var modal = $(this);
    modal.find(".modal-body input[name='firstName']").val(firstname);
    modal.find(".modal-body input[name='lastName']").val(lastname);
    });

    $('#emailModal').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget);
    var email = button.data('email');
    
    var modal = $(this);
    modal.find(".modal-body input[name='email']").val(email);
    });
</script>

<?php include('layout/footer.php') ?>