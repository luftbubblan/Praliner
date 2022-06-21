<?php
    require('../src/config.php');

    include('layout/header.php');
?>

<div class="container">
    <!-- <?php include('cart.php') ?> -->

    <br>

    <table class="table tabel-borderless">
        <thead>
            <tr>
                <th style="width: 15%">Produkt</th>
                <th style="width: 50%">Info</th>
                <th style="width: 10%"></th>
                <th style="width: 10%">Antal</th>
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
                            <input type="submit" class="btn btn-danger" value="Delete">
                        </form>
                    </td>
                    <td>
                        <form class="updateCartForm" action="updateCartItem.php" method="POST">
                            <input type="hidden" name="cartId" value="<?=$cartid?>">
                            <input type="number" name="quantity" value="<?=$cartItem['quantity']?>" min="1">
                            <input type="submit" class="btn btn-primary" value="Updatera antal">
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
                <td></td>
                <td><b>Total kostnad <?=$TotalSum?> kr</b></td>
            </tr>
        </tbody>             
</div>

<?php include('layout/footer.php') ?>