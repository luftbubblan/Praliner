<?php 
    $cartItemsInCart = 0;
    $TotalSum = 0;
    foreach($_SESSION['cartItems'] as $cartid => $cartItem) {
        $TotalSum += $cartItem['price'] * $cartItem['quantity'];
        $cartItemsInCart += $cartItem['quantity'];
    }
?>


<div class="dropdown">
    <button class="dropbtn">
        <span><?=$cartItemsInCart?></span>
        Cart
    </button>
    <div class="dropdown-content">
        <div class="shopping-cart">
            <div class="shopping-cart-header">
                <span class="items-in-cart"><?=$cartItemsInCart?> Praliner</span>
                <div class="shopping-cart-total">
                    <span>Total kostnad: <?=$TotalSum?> kr</span>
                </div>
            </div>

            <div class="shopping-cart-items">
                <?php foreach($_SESSION['cartItems'] as $cartid => $cartItem) { ?>
                    <div class="clearfix">
                        <img src="<?=$cartItem['img_url']?>" alt="item1" />
                        <span class="item-name"><?=$cartItem['title']?></span>
                        <span class="item-price"><?=$cartItem['price']?> kr</span>
                        <span class="item-quantity">Antal: <?=$cartItem['quantity']?></span>
                    </div>
                <?php } ?>
            </div>

            <a href="checkout.php" class="checkoutBtn">Checkout</a>
        </div>
    </div>
</div>







