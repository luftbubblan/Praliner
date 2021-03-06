$('#updateNameForm').on('submit', updateName);
$('#updateEmailForm').on('submit', updateEmail);
$('#updatePhoneForm').on('submit', updatePhone);
$('#updatePasswordForm').on('submit', updatePassword);
$('#updateAdressForm').on('submit', updateAdress);
$('#deleteForm').on('submit', deleteAccount);
$('#searchByTitleForm input').on('propertychange input',searchForProduct);
$('#searchByFlavourForm input').on('propertychange input',searchForProduct);

$('form button').on('click', close)

async function updateName(e) {
    e.preventDefault();

    const formData = new FormData(e.target);
    formData.set('updateNameBtn', true);
    
    try {
        const response = await fetch('../src/app/API.php', {
            method: 'POST',
            
            body: formData
        });

        const data = await response.json();

        if(data['message'].includes("success")) {
            window.location.replace("myPage.php?nameUpdated");
        } else {
            $('.formMessage').html(data['message']);
        }
        
    } catch(error) {
        console.log(error);
    }
}

async function updateEmail(e) {
    e.preventDefault();

    const formData = new FormData(e.target);
    formData.set('updateEmailBtn', true);

    try {
        const response = await fetch('../src/app/API.php', {
            method: 'POST',
            
            body: formData
        });

        const data = await response.json();

        if(data['message'].includes("success")) {
            window.location.replace("myPage.php?emailUpdated");
        } else {
            $('.formMessage').html(data['message']);
        }
        
    } catch(error) {
        console.log(error);
    }
}

async function updatePhone(e) {
    e.preventDefault();

    const formData = new FormData(e.target);
    formData.set('updatePhoneBtn', true);

    try {
        const response = await fetch('../src/app/API.php', {
            method: 'POST',
            
            body: formData
        });

        const data = await response.json();

        if(data['message'].includes("success")) {
            window.location.replace("myPage.php?phoneUpdated");
        } else {
            $('.formMessage').html(data['message']);
        }
        
    } catch(error) {
        console.log(error);
    }
}

async function updatePassword(e) {
    e.preventDefault();

    const formData = new FormData(e.target);
    formData.set('updatePasswordBtn', true);

    try {
        const response = await fetch('../src/app/API.php', {
            method: 'POST',
            
            body: formData
        });

        const data = await response.json();

        if(data['message'].includes("success")) {
            window.location.replace("myPage.php?passwordUpdated");
        } else {
            $('.formMessage').html(data['message']);
        }
        
    } catch(error) {
        console.log(error);
    }
}

async function updateAdress(e) {
    e.preventDefault();

    const formData = new FormData(e.target);
    formData.set('updateAdressBtn', true);

    try {
        const response = await fetch('../src/app/API.php', {
            method: 'POST',
            
            body: formData
        });

        const data = await response.json();

        if(data['message'].includes("success")) {
            window.location.replace("myPage.php?adressUpdated");
        } else {
            $('.formMessage').html(data['message']);
        }
        
    } catch(error) {
        console.log(error);
    }
}

async function deleteAccount(e) {
    e.preventDefault();

    const formData = new FormData(e.target);
    formData.set('deleteBtn', true);

    try {
        await fetch('../src/app/API.php', {
            method: 'POST',
            
            body: formData
        });

        window.location.replace("login.php?deleted");
        
    } catch(error) {
        console.log(error);
    }
}

function close() {
    window.location.replace("myPage.php");
}

async function searchForProductByTitle() {
    const formData = new FormData($(e.target).parent()[0]);
    formData.set('searchingByTitle', true);

    try {
        const response = await fetch('../src/app/API.php', {
            method: 'POST',
            
            body: formData
        });
        const data = await response.json();

        showProducts(data['products']) 

    } catch(error) {
        console.log(error);
    }
}

async function searchForProduct(e) {
    const formData = new FormData($(e.target).parent()[0]);
    const otherInput = $($($(e.target).parent()[0]).siblings()).children()[0];
    $(otherInput).val("");

    try {
        const response = await fetch('../src/app/API.php', {
            method: 'POST',
            
            body: formData
        });
        const data = await response.json();

        showProducts(data['products']);

    } catch(error) {
        console.log(error);
    }
}

function showProducts(products) {
    html = "";
    for (product of products) {
        html += `
            <div id="single-con">
                <div id="single">
                
                    <a href="product.php?product=${product['id']}">
                        <div id="img-div">
                            <img id="product-img" src=" ${product['img_url']}" alt="Bild p?? pralin/t??rta">
                        </div>
                    </a>
                    <h3> ${product['title']} </h3>
                    <p><i> ${product['flavour']} </i></p>
                    
                    <p>${product['stock']} stk i lager</p>
                    <h6>${product['price']} kr</h6>
                    <div id="buy-sec">
                        <button class="minusBtn plusMinus plusMinusGray">-</button>
                        <span>1</span>
                        <button class="plusBtn plusMinus plusMinusGray">+</button>

                        <form action="addToCart.php" method="POST">
                            <input type="hidden" name="productId" value="${product['id']}">
                            <input type="hidden" name="quantity" value="1">
                            <button type="submit" class="btn btn-success" name="addToCartBtn"><i class="fa-solid fa-cart-plus"></i></button>
                        </form>
                    </div>                
                </div>
            </div>
        `
    }
    $('#shop-con').html(html);
}