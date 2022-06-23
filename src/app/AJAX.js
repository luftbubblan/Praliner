$('#updateNameForm').on('submit', updateName);
$('#updateEmailForm').on('submit', updateEmail);
$('#updatePasswordForm').on('submit', updatePassword);
$('#updateInformationForm').on('submit', updateInformation);
$('#deleteForm').on('submit', deleteAccount);
$('#searchByTitleForm input').on('propertychange input',searchForProduct);
$('#searchByFlavourForm input').on('propertychange input',searchForProduct);

$('form button').on('click', close)

async function updateName(e) {
    e.preventDefault();
    console.log(e.target)

    const formData = new FormData(e.target);
    formData.set('updateNameBtn', true);
    console.log(formData)
    
    try {
        const response = await fetch('../src/app/API.php', {
            method: 'POST',
            
            body: formData
        });
        console.log(response)

        const data = await response.json();

        // if(data['message'].includes("success")) {
        //     window.location.replace("myPage.php?nameUpdated");
        // } else {
        //     $('.formMessage').html(data['message']);
        // }
        
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

async function updateInformation(e) {
    e.preventDefault();

    const formData = new FormData(e.target);
    formData.set('updateInformationBtn', true);

    try {
        const response = await fetch('../src/app/API.php', {
            method: 'POST',
            
            body: formData
        });

        const data = await response.json();

        if(data['message'].includes("success")) {
            window.location.replace("myPage.php?informationUpdated");
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
                            <img id="product-img" src=" ${product['img_url']}" alt="Picture of pralin">
                        </div>
                    </a>
                    <h3> ${product['title']} </h3>
                    <p><i> ${product['flavour']} </i></p>
                    
                    <p>Left in stock: ${product['stock']} </p>
                    <h6>${product['price']} kr</h6>
                    <div id="buy-sec">
                        <button class="minusBtn plusMinus plusMinusFront">-</button>
                        <span>1</span>
                        <button class="plusBtn plusMinus plusMinusFront">+</button>

                        <form action="addToCart.php" method="POST">
                            <input type="hidden" name="productId" value="${product['id']}">
                            <input type="hidden" name="quantity" value="1">
                            <input type="submit" class="btn btn-success" name="addToCartBtn" value="Köp">
                        </form>
                    </div>                
                </div>
            </div>
        `
    }
    $('#shop-con').html(html);
}