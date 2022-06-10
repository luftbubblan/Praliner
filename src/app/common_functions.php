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
    function ifEmptyGenerateMessage ($variableToCheck, $message) {
        if (empty($variableToCheck)) {
			$output = '<div class="">' . $message . '</div>';
            return $output;
		}
    }
?>