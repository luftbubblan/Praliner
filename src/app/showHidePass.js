function showHidePassword(checkBox) {
    var passwordInputField = checkBox.previousSibling.previousSibling;
    if (passwordInputField.type === "password") {
        passwordInputField.type = "text";
    } else {
        passwordInputField.type = "password";
    }
}