<?php
    $pageTitle = "My Page";

    require('../src/config.php');
    require('../src/app/common_functions.php');
    require('../src/app/CRUD_functions.php');

    // echo "<pre>";
    // print_r($_SESSION);
    // print_r($_POST);
    // echo "</pre>";

    if (!isset($_SESSION['id'])) {
        header('Location: login.php?mustLogin=true');
    }

    $message = "";

    if (isset($_GET['nameUpdated'])) {
        $message = '
            <div class="alert alert-success">
                Name has been updated.
            </div>
        ';
    }

    if (isset($_GET['emailUpdated'])) {
        $message = '
            <div class="alert alert-success">
                Email has been updated.
            </div>
        ';
    }

    if (isset($_GET['passwordUpdated'])) {
        $message = '
            <div class="alert alert-success">
                Password has been updated.
            </div>
        ';
    }

    if (isset($_GET['informationUpdated'])) {
        $message = '
            <div class="alert alert-success">
                Information has been updated.
            </div>
        ';
    }

    // if(isset($_POST['updateNameBtn'])) {
    //     $firstName = ucfirst(trim($_POST['firstName']));
    //     $lastName =  ucfirst(trim($_POST['lastName']));

    //     $message .= ifEmptyGenerateMessage($firstName, "Firstname must not be empty.");
    //     $message .= ifEmptyGenerateMessage($lastName, "Lastname must not be empty.");

    //     $message .= $crudFunctions->updateName($message, $firstName, $lastName, $_SESSION['id']);
    // }

    // if(isset($_POST['updateEmailBtn'])) {
        // $email = trim($_POST['email']);

        // $message .= ifEmptyGenerateMessage($email, "E-mail must not be empty.");

        // $message .= checkIfEmailIsValid($email);

        // $message .= $crudFunctions->updateEmail($message, $email, $_SESSION['id']);
    // }

    // if(isset($_POST['changePasswordBtn'])) {
    //     $oldpassword =        trim($_POST['oldpassword']);
    //     $newpassword =        trim($_POST['newpassword']);
    //     $confirmnewpassword = trim($_POST['confirmnewpassword']);

    //     $userspassword = $crudFunctions->fetchPasswordById($_SESSION['id']);

    //     if (checkIfPasswordIsCorrect($oldpassword, $userspassword['password'])) {
    //         $message .= ifEmptyGenerateMessage($newpassword, "New password must not be empty.");
    //         $message .= ifEmptyGenerateMessage($confirmnewpassword, "Confirm new password must not be empty.");
    
    //         $message .= checkIfPasswordsMatch($newpassword, $confirmnewpassword); 
                
    //         $message .= $crudFunctions->updatePassword($message, $newpassword, $_SESSION['id']);
    //     } else {
    //         $message = '
    //             <div class="">
    //                 The old password is incorrect.
    //             </div>
    //         ';
    //     }
    // }

    // if(isset($_POST['updateInformationBtn'])) {
    //     $phone =           trim($_POST['phone']);
    //     $street =  ucfirst(trim($_POST['street']));
    //     $postalCode =      trim($_POST['postalCode']);
    //     $city =    ucfirst(trim($_POST['city']));
    //     $country = ucfirst(trim($_POST['country']));

    //     $message .= phoneNumberMustBeTenDigits($phone);
    //     $message .= ifEmptyGenerateMessage($street, "Street must not be empty.");
    //     $message .= postalCodeMustBeFiveDigits($postalCode);
    //     $message .= ifEmptyGenerateMessage($city, "City must not be empty.");
    //     $message .= ifEmptyGenerateMessage($country, "Country must not be empty.");

    //     $message .= $crudFunctions->updateInformation($message, $phone, $street, $postalCode, $city, $country, $_SESSION['id']);
    // }

    // if(isset($_POST['deleteAccountBtn'])) {
    //     $sql = "
    //         DELETE FROM users
    //         WHERE id = :id
    //     ";
    //     $stmt = $pdo->prepare($sql);
    //     $stmt->bindParam(":id", $_SESSION['id']);
    //     $stmt->execute();

    //     $_SESSION = [];
    //     session_destroy();
        
    //     header('Location: login.php?deleted=true');
    //     exit;
    // }

    $user = $crudFunctions->fetchUserById($_SESSION['id']);

	include('layout/header.php');
?>

<h1>My Page</h1>

<?=$message?>
<hr>
<!-- 

<div>
    <b>Phone:</b> <?=$user['phone']?> |
    <b>Street:</b> <?=$user['street']?> |
    <b>Postal code:</b> <?=$user['postal_code']?> |
    <b>City:</b> <?=$user['city']?> |
    <b>Country:</b> <?=$user['country']?> <br>
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#informationModal">Update information</button>
</div>

<form action="" method="POST">
    <input type="submit" name="deleteAccountBtn" value="Delete your account">
</form> -->

<!-- <div class="modal fade" id="informationModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
</div> -->


























































































































<div>
    <b>Firstname:</b> <?=$user['first_name']?> |
    <b>Lastname:</b> <?=$user['last_name']?><br>
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#nameModal" data-firstname="<?=$user['first_name']?>" data-lastname="<?=$user['last_name']?>">Update Name</button>
</div>

<div>
    <b>Email:</b> <?=$user['email']?><br>
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#emailModal" data-email="<?=$user['email']?>">Update Email</button>
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#passwordModal">Update Password</button>
</div>

<div>
    <b>Phone:</b> <?=$user['phone']?> |
    <b>Street:</b> <?=$user['street']?> |
    <b>Postal code:</b> <?=$user['postal_code']?> |
    <b>City:</b> <?=$user['city']?> |
    <b>Country:</b> <?=$user['country']?> <br>
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#informationModal" data-phone="<?=$user['phone']?>" data-street="<?=$user['street']?>" data-postalcode="<?=$user['postal_code']?>" data-city="<?=$user['city']?>" data-country="<?=$user['country']?>">Update information </button>
</div>







<!-- NAMEMODAL -->
<div class="modal fade" id="nameModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Update name</h5>
            </div>
            <form id="updateNameForm" action="../src/app/API.php" method="POST">
                <div class="modal-body">
                    <div class="formMessage"></div>
                    <div class="form-group">
                        <label for="firstName" class="col-form-label">First name:</label>
                        <input type="text" class="form-control" name ="firstName">
                    </div>
                    <div class="form-group">
                        <label for="lastName" class="col-form-label">Last name:</label>
                        <input type="text" class="form-control" name ="lastName">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <input type="submit" name ="updateNameBtn" class="btn btn-primary" value="Update">
                </div>
            </form>
        </div>
    </div>
</div>

<!-- EMAILMODAL -->
<div class="modal fade" id="emailModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Update email</h5>
            </div>
            <form id="updateEmailForm" action="../src/app/API.php" method="POST">
                <div class="modal-body">
                    <div class="formMessage"></div>
                    <div class="form-group">
                        <label for="email" class="col-form-label">Email:</label>
                        <input type="text" class="form-control" name ="email">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <input type="submit" name ="updateEmailBtn" class="btn btn-primary" value="Update">
                </div>
            </form>
        </div>
    </div>
</div>

<!-- PASSWORDMODAL -->
<div class="modal fade" id="passwordModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Update password</h5>
            </div>
            <form id="updatePasswordForm" action="../src/app/API.php" method="POST">
                <div class="modal-body">
                    <div class="formMessage"></div>
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
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <input type="submit" class="btn btn-primary" name="updatePasswordBtn" value="Update">
                </div>
            </form>
        </div>
    </div>
</div>

<!-- INFORMATIONMODAL -->
<div class="modal fade" id="informationModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Update password</h5>
            </div>
            <form id="updateInformationForm" action="../src/app/API.php" method="POST">
                <div class="modal-body">
                    <div class="formMessage"></div>
                    <div class="form-group">
                        <label for="phone" class="col-form-label">Phone:</label>
                        <input type="text" class="form-control" name ="phone">
                    </div>
                    <div class="form-group">
                        <label for="street" class="col-form-label">Street:</label>
                        <input type="text" class="form-control" name ="street">
                    </div>
                    <div class="form-group">
                        <label for="postalcode" class="col-form-label">Postal code:</label>
                        <input type="text" class="form-control" name ="postalcode">
                    </div>
                    <div class="form-group">
                        <label for="city" class="col-form-label">City:</label>
                        <input type="text" class="form-control" name ="city">
                    </div>
                    <div class="form-group">
                        <label for="country" class="col-form-label">Country:</label>
                        <input type="text" class="form-control" name ="country">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <input type="submit" class="btn btn-primary" name="updateInformationBtn" value="Update">
                </div>
            </form>
        </div>
    </div>
</div>

<!-- JQUERY AND BOOTSTRAP -->
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

<!-- MODALS -->
<script>
    $('#nameModal').on('show.bs.modal', function (event) {
        $('.formMessage').html("");
        var button = $(event.relatedTarget);
        var firstName = button.data('firstname');
        var lastName = button.data('lastname');
        
        var modal = $(this);
        modal.find('.modal-body input[name="firstName"]').val(firstName);
        modal.find('.modal-body input[name="lastName"]').val(lastName);
    })
    
    $('#emailModal').on('show.bs.modal', function (event) {
        $('.formMessage').html("");
        var button = $(event.relatedTarget);
        var email = button.data('email');

        var modal = $(this);
        modal.find('.modal-body input[name="email"]').val(email);
    })

    $('#passwordModal').on('show.bs.modal', function (event) {
        $('.formMessage').html("");
    })

    $('#informationModal').on('show.bs.modal', function (event) {
        $('.formMessage').html("");
        var button = $(event.relatedTarget);
        var phone = button.data('phone');
        var street = button.data('street');
        var postalcode = button.data('postalcode');
        var city = button.data('city');
        var country = button.data('country');

        var modal = $(this);
        modal.find('.modal-body input[name="phone"]').val(phone);
        modal.find('.modal-body input[name="street"]').val(street);
        modal.find('.modal-body input[name="postalcode"]').val(postalcode);
        modal.find('.modal-body input[name="city"]').val(city);
        modal.find('.modal-body input[name="country"]').val(country);
    })
</script>

<!-- CUSTOM JavaScript -->
<script src="../src/app/AJAX.js"></script>
<script src="../src/app/showHidePass.js"></script>

<?php include('layout/footer.php') ?>