<?php
    function ifEmptyGenerateMessage($variableToCheck, $message) {
        if (empty($variableToCheck)) {
			$output = errorMessage($message);
            return $output;
		}
    }

    function phoneNumberMustBeTenDigits($phone) {
        if (strlen((string)$phone) != 10) {
            $output = errorMessage("Phone number must be 10 digits.");
            return $output;
        }
    }

    function postalCodeMustBeFiveDigits($postalCode) {
        if (strlen((string)$postalCode) != 5) {
            $output = errorMessage("Postal code must be 5 digits.");
            return $output;
        }
    }
    
    function checkIfEmailIsValid($email) {
        if (!empty($email) && filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
            $output = errorMessage("E-mail must be a valid e-mail.");
            return $output;
        }
        return "";
    }

    function checkIfPasswordsMatch($password, $confirmedPassword) {
        if (!empty($confirmedPassword) && !empty($password) && $password !== $confirmedPassword) {
            $output = errorMessage('"Password" and "Confirm password" must match.');
            return $output;
        }
    }

    function encryptPassword($password) {
        return password_hash($password, PASSWORD_BCRYPT, ['cost' => 12]);
    }

    function checkIfPasswordIsCorrect($passwordToCheck, $userPasswordAndId) {
        if($userPasswordAndId && password_verify($passwordToCheck, $userPasswordAndId['password'])) {
            setLoginSession($userPasswordAndId['id']);
            header('Location: myPage.php');
            exit;
        }
        $output .= errorMessage("Invalid login credentials. Please try again.");
        return $output;
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
        $output = '<div class="alert alert-danger">E-mail is already taked, please use another e-mail.</div>';
        return $output;
    }
?>