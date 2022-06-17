<?php
    function ifEmptyGenerateMessage($variableToCheck, $message) {
        if (empty($variableToCheck)) {
			$output = '<div class="alert alert-danger">' . $message . '</div>';
            return $output;
		}
    }

    function phoneNumberMustBeTenDigits($phone) {
        if (strlen((string)$phone) != 10) {
            $message .= '<div class="alert alert-danger">Phone number must be 10 digits.</div>';
            return $message;
        }
    }

    function postalCodeMustBeFiveDigits($postalCode) {
        if (strlen((string)$postalCode) != 5) {
            $message .= '<div class="alert alert-danger">Postal code must be 5 digits.</div>';
            return $message;
        }
    }
    
    function checkIfEmailIsValid($email) {
        if (!empty($email) && filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
            $message = '<div class="alert alert-danger">E-mail must be a valid e-mail.</div>';
            return $message;
        }
        return "";
    }

    function checkIfPasswordsMatch($password, $confirmedPassword) {
        if (!empty($confirmedPassword) && !empty($password) && $password !== $confirmedPassword) {
            $message = '<div class="alert alert-danger">"Password" and "Confirm password" must match.</div>';
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

    function isSuperGlobalSet($superGlobal, $message) {
        if ($superGlobal == true) {
            $output = '<div class="alert alert-danger">' . $message . '</div>';
            return $output;
		}
        
    }
    function errorMessage($message) {

        $output = '<div class="alert alert-danger">' . $message . '</div>';
        return $output;

    }
    function successMessage($message) {

        $output = '<div class="alert alert-success">' . $message . '</div>';
        return $output;

    }
?>