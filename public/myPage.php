<?php
    $pageTitle = "Mina sidor";

    require('../src/config.php');
    require('../src/app/common_functions.php');
    require('../src/app/CRUD_functions.php');

    if (!isset($_SESSION['id'])) {
        header('Location: login.php?mustLogin');
    }

    $message = "";

    if (isset($_GET['nameUpdated'])) {
        $message = successMessage("Namnet har uppdaterats.");
    }

    if (isset($_GET['emailUpdated'])) {
        $message = successMessage("Email adressen har uppdaterats.");
    }

    if (isset($_GET['phoneUpdated'])) {
        $message = successMessage("Telefonnummret har uppdaterats.");
    }

    if (isset($_GET['passwordUpdated'])) {
        $message = successMessage("Lösenordet har uppdaterats.");
    }

    if (isset($_GET['adressUpdated'])) {
        $message = successMessage("Adressen har uppdaterats.");
    }

    $user = $crudFunctions->fetchUserById($_SESSION['id']);

	include('layout/header.php');
?>

<div class="form-style">
    <h2>Min sida</h2>
    <h4>Hantera uppgifter</h4>

    <div class="myPageMessage"><?=$message?></div>

    <div class="form-gap">
        <label for="first_name">Förnamn:</label><br>
        <b><?=$user['first_name']?></b><br>
        <label for="last_name">Efternamn:</label><br>
        <b><?=$user['last_name']?></b><br>
        <button type="button" class="my-page-btn btn btn-success" data-toggle="modal" data-target="#nameModal" data-firstname="<?=$user['first_name']?>" data-lastname="<?=$user['last_name']?>">Uppdatera namn</button>
    </div>
    <div class="form-gap">
        <label for="first_name">Email:</label><br>
        <b><?=$user['email']?></b><br>
        <button type="button" class="my-page-btn btn btn-success" data-toggle="modal" data-target="#emailModal" data-email="<?=$user['email']?>">Uppdatera email</button>
    </div>
    <div class="form-gap">
        <label for="first_name">Telefon:</label><br>
        <b><?=$user['phone']?></b><br>
        <button type="button" class="my-page-btn btn btn-success" data-toggle="modal" data-target="#phoneModal" data-phone="<?=$user['phone']?>">Uppdatera telefon</button>
    </div>
    <div class="form-gap">
        <label for="first_name">Lösenord:</label><br>
        <b><i>**skyddat**</i></b><br>
        <button type="button" class="my-page-btn btn btn-warning" data-toggle="modal" data-target="#passwordModal">Uppdatera lösenord</button>
    </div>
    <div class="form-gap">
        <label for="first_name">Adress:</label><br>
        <b><?=$user['street']?></b><br>
        <label for="first_name">Postnummer:</label><br>
        <b><?=$user['postal_code']?></b><br>
        <label for="first_name">Ort:</label><br>
        <b><?=$user['city']?></b><br>
        <label for="first_name">Land:</label><br>
        <b><?=$user['country']?></b><br>
        <button type="button" class="my-page-btn btn btn-success" data-toggle="modal" data-target="#adressModal" data-street="<?=$user['street']?>" data-postalcode="<?=$user['postal_code']?>" data-city="<?=$user['city']?>" data-country="<?=$user['country']?>">Uppdatera adress </button>
    </div>

<div class="form-gap">
    <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#deleteModal">Radera konto</button>
</div>

<!-- NAMEMODAL -->
<div class="modal fade" id="nameModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Uppdatera namn</h5>
            </div>
            <form id="updateNameForm" action="../src/app/API.php" method="POST">
                <div class="modal-body">
                    <div class="formMessage"></div>
                    <div class="form-group">
                        <label for="firstName" class="col-form-label">Förnamn:</label>
                        <input type="text" class="form-control" name="firstName">
                    </div>
                    <div class="form-group">
                        <label for="lastName" class="col-form-label">Efternamn:</label>
                        <input type="text" class="form-control" name="lastName">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary mr-auto" data-dismiss="modal">Stäng</button>
                    <input type="submit" name="updateNameBtn" class="btn btn-success" value="Uppdatera">
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
                <h5 class="modal-title" id="exampleModalLabel">Uppdatera email</h5>
            </div>
            <form id="updateEmailForm" action="../src/app/API.php" method="POST">
                <div class="modal-body">
                    <div class="formMessage"></div>
                    <div class="form-group">
                        <label for="email" class="col-form-label">Email:</label>
                        <input type="text" class="form-control" name="email">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary mr-auto" data-dismiss="modal">Stäng</button>
                    <input type="submit" name="updateEmailBtn" class="btn btn-success" value="Uppdatera">
                </div>
            </form>
        </div>
    </div>
</div>

<!-- PHONEMODAL -->
<div class="modal fade" id="phoneModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Uppdatera telefonnummer</h5>
            </div>
            <form id="updatePhoneForm" action="../src/app/API.php" method="POST">
                <div class="modal-body">
                    <div class="formMessage"></div>
                    <div class="form-group">
                        <label for="phone" class="col-form-label">Telefon:</label>
                        <input type="number" class="form-control" name="phone">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary mr-auto" data-dismiss="modal">Stäng</button>
                    <input type="submit" name="updatePhoneBtn" class="btn btn-success" value="Uppdatera">
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
                <h5 class="modal-title" id="exampleModalLabel">Uppdatera lösenord</h5>
            </div>
            <form id="updatePasswordForm" action="../src/app/API.php" method="POST">
                <div class="modal-body">
                    <div class="formMessage"></div>
                    <div class="form-group">
                        <label for="oldpassword" class="col-form-label">Gammalt lösenord:</label>
                        <input type="password" class="form-control" name="oldpassword">
                        <input type="checkbox" onclick="showHidePassword(this)">Visa lösenord
                    </div>
                    <div class="form-group">
                        <label for="newpassword" class="col-form-label">Nytt lösenord:</label>
                        <input type="password" class="form-control" name="newpassword">
                        <input type="checkbox" onclick="showHidePassword(this)">Visa lösenord
                    </div>
                    <div class="form-group">
                        <label for="confirmnewpassword" class="col-form-label">Bekräfta nytt lösenord:</label>
                        <input type="password" class="form-control" name="confirmnewpassword">
                        <input type="checkbox" onclick="showHidePassword(this)">Visa lösenord
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary mr-auto" data-dismiss="modal">Stäng</button>
                    <input type="submit" class="btn btn-success" name="updatePasswordBtn" value="Uppdatera">
                </div>
            </form>
        </div>
    </div>
</div>

<!-- ADRESSMODAL -->
<div class="modal fade" id="adressModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Uppdatera lösenord</h5>
            </div>
            <form id="updateAdressForm" action="../src/app/API.php" method="POST">
                <div class="modal-body">
                    <div class="formMessage"></div>
                    <div class="form-group">
                        <label for="street" class="col-form-label">Adress:</label>
                        <input type="text" class="form-control" name ="street">
                    </div>
                    <div class="form-group">
                        <label for="postalcode" class="col-form-label">Postnummer:</label>
                        <input type="number" class="form-control" name ="postalcode">
                    </div>
                    <div class="form-group">
                        <label for="city" class="col-form-label">Ort:</label>
                        <input type="text" class="form-control" name ="city">
                    </div>
                    <div class="form-group">
                        <label for="country" class="col-form-label">Land:</label>
                        <input type="text" class="form-control" name ="country">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary mr-auto" data-dismiss="modal">Stäng</button>
                    <input type="submit" class="btn btn-success" name="updateAdressBtn" value="Uppdatera">
                </div>
            </form>
        </div>
    </div>
</div>

<!-- DELETEMODAL -->
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Radera konto</h5>
            </div>
            <form id="deleteForm" action="../src/app/API.php" method="POST">
                <div class="modal-body">
                    <div class="formMessage"></div>
                    <div class="alert alert-danger" role="alert">
                        Är du säker på att du vill radera ditt konto, detta går inte att ändra.
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary mr-auto" data-dismiss="modal">Stäng</button>
                    <input type="submit" class="btn btn-danger" name="deleteBtn" value="Radera">
                </div>
            </form>
        </div>
    </div>
</div>
</div>


<!-- JQUERY AND BOOTSTRAP -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
<!-- CUSTOM -->
<script src="../src/app/AJAX.js"></script>
<script src="../src/app/js_functions.js"></script>

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

    $('#phoneModal').on('show.bs.modal', function (event) {
        $('.formMessage').html("");
        var button = $(event.relatedTarget);
        var phone = button.data('phone');
        
        var modal = $(this);
        modal.find('.modal-body input[name="phone"]').val(phone);
    })

    $('#passwordModal').on('show.bs.modal', function (event) {
        $('.formMessage').html("");
    })

    $('#adressModal').on('show.bs.modal', function (event) {
        $('.formMessage').html("");
        var button = $(event.relatedTarget);
        var street = button.data('street');
        var postalcode = button.data('postalcode');
        var city = button.data('city');
        var country = button.data('country');

        var modal = $(this);
        modal.find('.modal-body input[name="street"]').val(street);
        modal.find('.modal-body input[name="postalcode"]').val(postalcode);
        modal.find('.modal-body input[name="city"]').val(city);
        modal.find('.modal-body input[name="country"]').val(country);
    })
</script>

<?php include('layout/footer.php') ?>