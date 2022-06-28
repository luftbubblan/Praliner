<?php 
    if(!isset($_SESSION['cartItems'])) {
        $_SESSION['cartItems'] = [];
    }

    $cartItemsInCart = 0;
    $totalSum = 0;
    foreach($_SESSION['cartItems'] as $cartid => $cartItem) {
        $totalSum += $cartItem['price'] * $cartItem['quantity'];
        $cartItemsInCart += $cartItem['quantity'];
    }
?>

<div class="dropdown">
    <button class="btn cart-btn">
        <span class="items-in-cart"><?=$cartItemsInCart?></span>
        <i class="fa-solid fa-cart-shopping"></i>
    </button>
    <div class="dropdown-content">
        <div class="shopping-cart">
            <div class="shopping-cart-header">
                <span class="items-in-cart"><?=$cartItemsInCart?> Produkter</span>
                <div class="shopping-cart-total leadTextColor">
                    <span><b>Totalsumma: <?=$totalSum?> kr</b></span>
                </div>
            </div>

            <div class="shopping-cart-items">
                <?php foreach($_SESSION['cartItems'] as $cartid => $cartItem) { ?>
                    <div class="clearfix">
                        <img src="<?=$cartItem['img_url']?>" alt="item1" />
                        <span class="item-name leadTextColor"><?=$cartItem['title']?></span>
                        <span class="item-price leadTextColor"><?=$cartItem['price']?> kr/stk</span>
                        <span class="item-quantity">Antal: <?=$cartItem['quantity']?></span>
                        <form id="cartDeleteForm" action="deleteCartItem.php" method="POST">
                            <input type="hidden" name="cartId" value="<?=$cartid?>">
                            <button type="submit" class="btn btn-danger"><i class="fas fa-trash-alt"></i></button>
                        </form>
                    </div>
                    <hr>
                <?php } ?>
            </div>

            <button onclick="document.location='checkout.php'" class="btn btn-success">Gå till kassan</button>
        </div>
    </div>
</div>