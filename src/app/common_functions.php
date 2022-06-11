<script>
    function showHidePassword(e) {
        var x = e.previousSibling.previousSibling;
        if (x.type === "password") {
            x.type = "text";
        } else {
            x.type = "password";
        }
    }
</script>

<?php
    function ifEmptyGenerateMessage($variableToCheck, $message) {
        if (empty($variableToCheck)) {
			$output = '<div class="">' . $message . '</div>';
            return $output;
		}
    }

    function phoneNumberMustBeTenDigits($phone) {
        if (strlen((string)$phone) != 10) {
            $message .= '<div class="">Phone number must be 10 digits.</div>';
            return $message;
        }
    }

    function postalCodeMustBeFiveDigits($postalCode) {
        if (strlen((string)$postalCode) != 5) {
            $message .= '<div class="">Postal code must be 5 digits.</div>';
            return $message;
        }
    }
    
    function checkIfEmailIsValid($email) {
        if (!empty($email) && filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
            $message = '<div class="">E-mail must be a valid e-mail.</div>';
            return $message;
        }
        return "";
    }

    function checkIfPasswordsMatch($password, $confirmedPassword) {
        if (!empty($confirmedPassword) && !empty($password) && $password !== $confirmedPassword) {
            $message = '<div class="">"Password" and "Confirm password" must match.</div>';
            return $message;
        }
    }

    function encryptPassword($password) {
        return password_hash($password, PASSWORD_BCRYPT, ['cost' => 12]);
    }

    function checkIfPasswordIsCorrect($passwordToCheck, $encryptedPasswordToCheckAgainst) {
        if(password_verify($passwordToCheck, $encryptedPasswordToCheckAgainst)) {
            return true;
        }
        return false;
    }

    function setLoginSession($id) {
        $_SESSION['id'] = $id;
    }
?>