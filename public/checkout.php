<?php
    $pageTitle = "Varukorg";

    require('../src/config.php');
    require('../src/app/CRUD_functions.php');
    
    if(isset($_SESSION['id'])) {
        $user = $crudFunctions->fetchUserById($_SESSION['id']);
    }

    include('layout/header.php');
?>

<div class="container">

    <?php if(!empty($_SESSION['cartItems'])) { ?>
        <br>

        <table class="table tabel-borderless">
            <thead>
                <tr>
                    <th class="leadTextColor" style="width: 15%">Produkt</th>
                    <th class="leadTextColor" style="width: 45%">Beskrivning</th>
                    <th class="leadTextColor" style="width: 10%"></th>
                    <th class="leadTextColor" style="width: 15%">Antal</th>
                    <th class="leadTextColor" style="width: 15%">Pris per produkt</th>
                </tr>
            </thead>

            <tbody>
                <?php foreach($_SESSION['cartItems'] as $cartid => $cartItem) { ?>
                    <tr>
                        <td><img src="<?=$cartItem['img_url']?>" width="100px" height="100px"></td>
                        <td class="leadTextColor"><?=$cartItem['title']?></td>
                        <td>
                            <form action="deleteCartItem.php" method="POST">
                                <input type="hidden" name="cartId" value="<?=$cartid?>">
                                <button type="submit" class="btn btn-danger"><i class="fas fa-trash-alt"></i></button>
                            </form>
                        </td>
                        <td>
                            <form class="updateCartForm" action="updateCartItem.php" method="POST">
                                <input type="hidden" name="cartId" value="<?=$cartid?>">
                                <input type="submit" class="minusBtn plusMinus plusMinusWhite" name="minus" value="-">
                                <span class="leadTextColor"><?=$cartItem['quantity']?></span>
                                <input type="hidden" name="quantity" value="<?=$cartItem['quantity']?>">
                                <input type="submit" class="plusBtn plusMinus plusMinusWhite" name="plus" value="+">
                            </form>
                        </td>
                        <td class="leadTextColor"><?=$cartItem['price']?> kr</td>
                    </tr>
                <?php } ?>

                <tr class="border-top">
                    <td></td>
                    <td></td>
                    <td></td>
                    <td class="leadTextColor"><b>Antal produkter<br><?=$cartItemsInCart?> stk</b></td>
                    <td class="leadTextColor"><b>Total summa <br><?=$totalSum?> kr</b></td>
                </tr>
            </tbody>
        </table>

        <?php if(!isset($_SESSION['id'])) { ?>
            <div class="notLoggedinMessage leadTextColor">Du är inte inloggad. Vänligen registrera en användare <a class="linkTextColor" href="registerUser.php">HÄR</a> eller fortsätt med köpet som gäst genom att fylla i din information nedan.</div>
        <?php } ?>

        <div class="col-mdx col-md-4">
            <?php foreach($_GET as $message) { 
                echo $message;
            } ?>
        </div>

        <form action="create-order.php" method="POST">
            <input type="hidden" name="totalSum" value="<?=$totalSum?>">
            <div class="row">
                <div class="col-mdx col-md-3">
                    <input type="text" class="form-control" id="checkoutFirstName" name="firstname" placeholder="Förnamn" value="<?=$user['first_name'] ?? "" ?>">
                </div>
                <div class="col-mdx col-md-3">
                    <input type="text" class="form-control" id="checkoutLastName" name="lastname" placeholder="Efternamn" value="<?=$user['last_name'] ?? "" ?>">
                </div>
            </div>
            <div class="row">
                <div class="col-mdx col-md-3">
                    <input type="email" class="form-control" id="checkoutEmail" name="email" placeholder="Email" value="<?=$user['email'] ?? "" ?>">
                </div>
                <div class="col-mdx col-md-3">
                    <input type="number" class="form-control" id="checkoutPhone" name="phone" placeholder="Telefon" value="<?=$user['phone'] ?? "" ?>">
                    <small id="checkoutPhoneHelpline" class="text-muted">
                        Måste vara 10 siffror.
                    </small>
                </div>
            </div>
            <div class="row">
                <div class="col-mdx col-md-6">
                    <input type="text" class="form-control" id="checkoutStreet" name="street" placeholder="Adress" value="<?=$user['street'] ?? "" ?>">
                </div>
            </div>
            <div class="row">
                <div class="col-mdx col-md-2">
                    <input type="number" class="form-control" id="checkoutPostalcode" name="postalCode" placeholder="Postnummer" value="<?=$user['postal_code'] ?? "" ?>">
                    <small id="checkoutPostalcodeHelpline" class="text-muted">
                        Måste vara 5 siffror.
                    </small>
                </div>
                <div class="col-mdx col-md-2">
                    <input type="text" class="form-control" id="checkoutCity" name="city" placeholder="Ort" value="<?=$user['city'] ?? "" ?>">
                </div>
                <div class="col-mdx col-md-2">
                    <input type="text" class="form-control" id="checkoutCountry" name="country" placeholder="Land" value="<?=$user['country'] ?? "" ?>">
                </div>
                <div class="col-mdx col-md-12">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="checkoutTerms" name="termsAgreed">
                        <label class="form-check-label leadTextColor" for="checkoutTerms" >Jag godkänner de allmänna villkoren</label>
                    </div>
                </div>
            </div>
            <div class="col-mdx col-md-12">
                <input type="submit" class="btn btn-success" name="PayNowBtn" value="Betala">
            </div>
        </form>

    <?php } else { ?>
        <div id="empty-check-div"> 
            <h3>
                Du har inga varor i din kundkorg. Gå tillbaka till <a class="linkTextColor" href="index.php">butiken</a> för att börja handla.
            </h3>
    </div>
            
    <?php }  ?>
</div>

<?php include('layout/footer.php') ?>