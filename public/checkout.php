<?php
    $pageTitle = "Kassa";

    require('../src/config.php');

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
                <td><b>Total kostnad <br><?=$TotalSum?> kr</b></td>
            </tr>
        </tbody>   
        
        <?php } else { ?>
            You have no items to checkout
        <?php }  ?>
</div>

<?php include('layout/footer.php') ?>