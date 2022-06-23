function showHidePassword(checkBox) {
    var passwordInputField = checkBox.previousSibling.previousSibling;
    if (passwordInputField.type === "password") {
        passwordInputField.type = "text";
    } else {
        passwordInputField.type = "password";
    }
}

function showValue() {
    $(".minusBtn").click(function(e) {
        const quantitySpan = $($(e.target).next()[0])[0];
        quantity = $(quantitySpan).html();
        if(quantity > 1) {
            quantity = parseInt(quantity);
            quantity -= 1;
            $(quantitySpan).html(quantity);
            const addToCartFormHiddenInput = $($(e.target).siblings()[2]).children()[1];
            $(addToCartFormHiddenInput).val(quantity);
        }
    });

    $(".plusBtn").click(function(e) {
        const quantitySpan = $($(e.target).prev()[0])[0];
        quantity = $(quantitySpan).html();
        quantity = parseInt(quantity);
        quantity += 1;
        $(quantitySpan).html(quantity);
        const addToCartFormHiddenInput = $($(e.target).next()[0]).children()[1];
        $(addToCartFormHiddenInput).val(quantity);
    });
}