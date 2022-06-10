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
    
    function checkIfEmailIsValid($email) {
        if (!empty($email) && filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
            $message = '<div class="">E-mail must be a valid e-mail.</div>';
            return $message;
        }
        return "";
    }

    function encryptPassword($password) {
        return password_hash($password, PASSWORD_BCRYPT, ['cost' => 12]);
    }
?>