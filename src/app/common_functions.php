<?php
    function ifEmptyGenerateMessage($variableToCheck, $message) {
        if (empty($variableToCheck)) {
			$output = errorMessage($message);
            return $output;
		}
    }

    function phoneNumberMustBeTenDigits($phone) {
        if (strlen((string)$phone) != 10) {
            $message = errorMessage("Phone number must be 10 digits.");
            return $message;
        }
    }

    function postalCodeMustBeFiveDigits($postalCode) {
        if (strlen((string)$postalCode) != 5) {
            $message = errorMessage("Postal code must be 5 digits.");
            return $message;
        }
    }
    
    function checkIfEmailIsValid($email) {
        if (!empty($email) && filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
            $message = errorMessage("E-mail must be a valid e-mail.");
            return $message;
        }
        return "";
    }

    function checkIfPasswordsMatch($password, $confirmedPassword) {
        if (!empty($confirmedPassword) && !empty($password) && $password !== $confirmedPassword) {
            $message = errorMessage('"Password" and "Confirm password" must match.');
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

    // function isSuperGlobalSet($superGlobal, $message) {
    //     if (isset($superGlobal)) {
    //         $output = errorMessage($message);
    //         return $output;
	// 	}
        
    // }

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
        $output = '<div class="alert alert-danger">E-mail is already taked, please use another e-mail.</div>';
        return $output;
    }
?>