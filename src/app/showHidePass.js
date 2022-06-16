function showHidePassword(e) {
    var x = e.previousSibling.previousSibling;
    if (x.type === "password") {
        x.type = "text";
    } else {
        x.type = "password";
    }
}