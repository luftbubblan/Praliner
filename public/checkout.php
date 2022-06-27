<?php
    $pageTitle = "Checkout";

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
                    <th style="width: 15%">Produkt</th>
                    <th style="width: 45%">Info</th>
                    <th style="width: 10%"></th>
                    <th style="width: 15%">Antal</th>
                    <th style="width: 15%">Pris per produkt</th>
                </tr>
            </thead>

            <tbody>
                <?php foreach($_SESSION['cartItems'] as $cartid => $cartItem) { ?>
                    <tr>
                        <td><img src="<?=$cartItem['img_url']?>" width="100px" height="100px"></td>
                        <td><?=$cartItem['title']?></td>
                        <td>
                            <form action="deleteCartItem.php" method="POST">
                                <input type="hidden" name="cartId" value="<?=$cartid?>">
                                <button type="submit" class="btn btn-danger"><i class="fas fa-trash-alt"></i></button>
                            </form>
                        </td>
                        <td>
                            <form class="updateCartForm" action="updateCartItem.php" method="POST">
                                <input type="hidden" name="cartId" value="<?=$cartid?>">
                                <input type="submit" class="minusBtn plusMinus plusMinusSingle" name="minus" value="-">
                                <span><?=$cartItem['quantity']?></span>
                                <input type="hidden" name="quantity" value="<?=$cartItem['quantity']?>">
                                <input type="submit" class="plusBtn plusMinus plusMinusSingle" name="plus" value="+">
                            </form>
                        </td>
                        <td>
                            <?=$cartItem['price']?> kr
                        </td>
                    </tr>
                <?php } ?>

                <tr class="border-top">
                    <td></td>
                    <td></td>
                    <td></td>
                    <td><b>Antal praliner<br><?=$cartItemsInCart?> st</b></td>
                    <td><b>Total kostnad <br><?=$totalSum?> kr</b></td>
                </tr>
            </tbody>
        </table>

        <?php if(!isset($_SESSION['id'])) { ?>
            <div class="notLoggedinMessage">Du är inte inloggad. Vänligen registrera en användare. <a href="registerUser.php">HÄR</a> eller fortsätt med köpet som gäst genom att fylla i din information nedan</div>
        <?php } ?>

        <form action="create-order.php" method="POST">
            <input type="hidden" name="totalSum" value="<?=$totalSum?>">
            <div class="row">
                <div class="col-mdx col-md-3">
                    <input type="text" class="form-control" id="checkoutFirstName" name="firstname" placeholder="Firstname" value="<?=$user['first_name'] ?? "" ?>">
                </div>
                <div class="col-mdx col-md-3">
                    <input type="text" class="form-control" id="checkoutLastName" name="lastname" placeholder="Lastname" value="<?=$user['last_name'] ?? "" ?>">
                </div>
            </div>
            <div class="row">
                <div class="col-mdx col-md-3">
                    <input type="email" class="form-control" id="checkoutEmail" name="email" placeholder="E-mail" value="<?=$user['email'] ?? "" ?>">
                </div>
                <div class="col-mdx col-md-3">
                    <input type="text" class="form-control" id="checkoutPhone" name="phone" placeholder="Phone" value="<?=$user['phone'] ?? "" ?>">
                    <small id="checkoutPhoneHelpline" class="text-muted">
                        Måste vara 10 siffror.
                    </small>
                </div>
            </div>
            <div class="row">
                <div class="col-mdx col-md-6">
                    <input type="text" class="form-control" id="checkoutStreet" name="street" placeholder="Street" value="<?=$user['street'] ?? "" ?>">
                </div>
            </div>
            <div class="row">
                <div class="col-mdx col-md-2">
                    <input type="text" class="form-control" id="checkoutPostalcode" name="postalCode" placeholder="Postal code" value="<?=$user['postal_code'] ?? "" ?>">
                    <small id="checkoutPostalcodeHelpline" class="text-muted">
                        Måste vara 5 siffror.
                    </small>
                </div>
                <div class="col-mdx col-md-2">
                    <input type="text" class="form-control" id="checkoutCity" name="city" placeholder="City" value="<?=$user['city'] ?? "" ?>">
                </div>
                <div class="col-mdx col-md-2">
                    <input type="text" class="form-control" id="checkoutCountry" name="country" placeholder="Country" value="<?=$user['country'] ?? "" ?>">
                </div>
                <div class="col-mdx col-md-12">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="checkoutTerms" name="termsAgreed">
                        <label class="form-check-label" for="checkoutTerms" >Jag godkänner de allmänna villkoren</label>
                    </div>
                </div>
            </div>
            <div class="col-mdx col-md-12">
                <input type="submit" class="btn btn-primary" name="PayNowBtn" value="Betala">
            </div>
        </form>

    <?php } else { ?>
        Du har inga varor i din kundkorg. Gå tillbaka till <a href="index.php">butiken</a> för att börja handla.
    <?php }  ?>
</div>

<?php include('layout/footer.php') ?>