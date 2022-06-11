<?php
    $pageTitle = "My Page";

    require('../src/config.php');
    require('../src/app/common_functions.php');
    require('../src/app/CRUD_functions.php');

    if (!isset($_SESSION['id'])) {
        header('Location: login.php?mustLogin');
    }

    $message = "";

    if(isset($_POST['updateNameBtn'])) {
        $firstName = ucfirst(trim($_POST['firstName']));
        $lastName =  ucfirst(trim($_POST['lastName']));

        $message .= ifEmptyGenerateMessage($firstName, "Firstname must not be empty.");
        $message .= ifEmptyGenerateMessage($lastName, "Lastname must not be empty.");

        $message .= $crudFunctions->updateName($message, $firstName, $lastName, $_SESSION['id']);
    }

    if(isset($_POST['updateEmailBtn'])) {
        $email = trim($_POST['email']);

        $message .= ifEmptyGenerateMessage($email, "E-mail must not be empty.");

        $message .= checkIfEmailIsValid($email);

        $message .= $crudFunctions->updateEmail($message, $email, $_SESSION['id']);
    }

    if(isset($_POST['changePasswordBtn'])) {
        $oldpassword =        trim($_POST['oldpassword']);
        $newpassword =        trim($_POST['newpassword']);
        $confirmnewpassword = trim($_POST['confirmnewpassword']);

        $userspassword = $crudFunctions->fetchPasswordById($_SESSION['id']);

        if (checkIfPasswordIsCorrect($oldpassword, $userspassword['password'])) {
            $message .= ifEmptyGenerateMessage($newpassword, "New password must not be empty.");
            $message .= ifEmptyGenerateMessage($confirmnewpassword, "Confirm new password must not be empty.");
    
            $message .= checkIfPasswordsMatch($newpassword, $confirmnewpassword); 
                
            $message .= $crudFunctions->updatePassword($message, $newpassword, $_SESSION['id']);
        } else {
            $message = '
                <div class="">
                    The old password is incorrect.
                </div>
            ';
        }
    }

    if(isset($_POST['updateInformationBtn'])) {
        $phone =           trim($_POST['phone']);
        $street =  ucfirst(trim($_POST['street']));
        $postalCode =      trim($_POST['postalCode']);
        $city =    ucfirst(trim($_POST['city']));
        $country = ucfirst(trim($_POST['country']));

        $message .= ifEmptyGenerateMessage($phone, "Phone must not be empty.");
        $message .= ifEmptyGenerateMessage($street, "Street must not be empty.");
        $message .= ifEmptyGenerateMessage($postalCode, "Postal code must not be empty.");
        $message .= ifEmptyGenerateMessage($city, "City must not be empty.");
        $message .= ifEmptyGenerateMessage($country, "Country must not be empty.");

        $message .= $crudFunctions->updateInformation($message, $phone, $street, $postalCode, $city, $country, $_SESSION['id']);
    }

    $user = $crudFunctions->fetchUserById($_SESSION['id']);

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