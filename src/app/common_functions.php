<?php
    function ifEmptyGenerateMessage($variableToCheck, $message) {
        $output = "";
        if (empty($variableToCheck)) {
			$output = errorMessage($message);
            return $output;
		}
    }

    function phoneNumberMustBeTenDigits($phone) {
        $output = "";
        if (strlen((string)$phone) != 10) {
            $output = errorMessage("Telefonnummer måste vara 10 siffror.");
            return $output;
        }
    }

    function postalCodeMustBeFiveDigits($postalCode) {
        $output = "";
        if (strlen((string)$postalCode) != 5) {
            $output = errorMessage("Postnummer måste vara 5 siffror.");
            return $output;
        }
    }
    
    function checkIfEmailIsValid($email) {
        $output = "";
        if (!empty($email) && filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
            $output = errorMessage("Måste ange en riktigt e-mail.");
            return $output;
        }
        return "";
    }

    function checkIfPasswordsMatch($password, $confirmedPassword) {
        $output = "";
        if (!empty($confirmedPassword) && !empty($password) && $password !== $confirmedPassword) {
            $output = errorMessage('"Lösenord" och "Bekräfta lösenord" måste vara samma.');
            return $output;
        }
    }

    function encryptPassword($password) {
        return password_hash($password, PASSWORD_BCRYPT, ['cost' => 12]);
    }

    function checkIfPasswordIsCorrect($passwordToCheck, $correctEncryptedPassword) {
        $output = "";
        if($correctEncryptedPassword && password_verify($passwordToCheck, $correctEncryptedPassword)) {
            return true;
        }
        return false;
    }

    function setLoginSession($id) {
        $_SESSION['id'] = $id;
    }

    function errorMessage($message) {
        $output = '<div class="alert alert-danger">' . $message . '</div>';
        return $output;
    }

    function successMessage($message) {
        $output = '<div class="alert alert-success">' . $message . '</div>';
        return $output;
    }
    function warningMessage($message) {
        $output = '<div class="alert alert-warning">' . $message . '</div>';
        return $output;
    }

    function errorEmailtaken() {
        $output = '<div class="alert alert-danger">Denna e-mail är redan tagen, var snäl och ange en annan e-mail.</div>';
        return $output;
    }
?>