<?php
	$pageTitle = "Registrera användare";

	require('../src/config.php');
    require('../src/app/common_functions.php');
    require('../src/app/CRUD_functions.php');

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

        
        $message .= ifEmptyGenerateMessage($firstName, "Vänligen fyll i ditt förnamn.");
        $message .= ifEmptyGenerateMessage($lastName, "Vänligen fyll i ditt efternamn.");
        $message .= ifEmptyGenerateMessage($email, "Vänligen fyll i din email.");
        $message .= ifEmptyGenerateMessage($password, "Vänligen fyll i ditt lösenord.");
        $message .= ifEmptyGenerateMessage($confirmedPassword, "Vänligen konfirmera ditt lösenord.");
        $message .= phoneNumberMustBeTenDigits($phone);
        $message .= ifEmptyGenerateMessage($street, "Vänligen fyll i adress.");
        $message .= postalCodeMustBeFiveDigits($postalCode);
        $message .= ifEmptyGenerateMessage($city, "Vänligen fyll i ort.");
        $message .= ifEmptyGenerateMessage($country, "Vänligen fyll i land.");

        $message .= checkIfEmailIsValid($email);

        $message .= checkIfPasswordsMatch($password, $confirmedPassword);

        $message .= $crudFunctions->registerUser($message, $firstName, $lastName, $email, $password, $phone, $street, $postalCode, $city, $country);
    }

	include('layout/header.php');
?>

<div id="head-line-reg-user">
<h2>Registera användare</h2>
</div>


<div id="registerMessage";>
    <?=$message?>
</div>

<div class="registerContainer">
    <form action="" method="POST">
    <p>
        <input type="text" name="firstName" placeholder="Förnamn" value="<?=isset($_POST['firstName']) ? $_POST['firstName'] : "";?>"><br>
    </p>

    <p>
        <input type="text" name="lastName" placeholder="Efternamn" value="<?=$_POST['lastName'] ?? "" ?>"><br>
    </p>

    <p>
        <input type="text" name="email" placeholder="Email" value="<?=$_POST['email'] ?? ""?>"><br>
    </p>
    <p>
        <input type="password" name="password" placeholder="Lösenord" value="<?=$_POST['password'] ?? ""?>">
       
        <input id="regCheckbox1" type="checkbox" onclick="showHidePassword(this)">Visa lösenord<br>
    </p>
    <p>
        <input type="password" name="confirmedPassword" placeholder="Bekräfta lösenord" value="<?=$_POST['confirmedPassword'] ?? ""?>">
        <input id="regCheckbox2" type="checkbox" onclick="showHidePassword(this)">Visa lösenord<br>
    </p>
      
    <p>
        <input type="number" name="phone" placeholder="Telefon 10 siffror" value="<?=$_POST['phone'] ?? ""?>"><br>
    </p>
    <p>
        <input type="text" name="street" placeholder="Adress" value="<?=$_POST['street'] ?? "" ?>"><br>
    </p>
    <p>
        <input type="number" name="postalCode" placeholder="Postnummer" value="<?=$_POST['postalCode'] ?? ""?>"><br>
    </p>
    <p>
        <input type="text" name="city" placeholder="Ort" value="<?=$_POST['city'] ?? ""?>"><br>
    </p>
    <p>
        <input type="text" name="country" placeholder="Land" value="<?=$_POST['country'] ?? ""?>"><br>
    </p>
    <input id="registerBtn" class="btn btn-success" type="submit" name="registerUserBtn" value="Registrera användare"> 
    </form>
</div>


<script src="../src/app/js_functions.js"></script>

<?php include('layout/footer.php') ?>