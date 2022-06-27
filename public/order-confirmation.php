<?php
    $pageTitle = "Order-Confirmation";

    require('../src/config.php');

    if(empty($_SESSION['orderId'])) {
        header('Location: checkout.php');
        exit;
    }
    unset($_SESSION['orderId']);

    $orderedItems = $_SESSION['cartItems'];
    unset($_SESSION['cartItems']);

    $itemsOrdered = 0;
    $orderCost = 0;
    foreach($orderedItems as $item) {
        $orderCost += $item['price'] * $item['quantity'];
        $itemsOrdered += $item['quantity'];
    }

    include('layout/header.php');
?>
<div class="container">
    <h1>Thank you for your order!</h1>
    <p><b>You have ordered <?=$itemsOrdered?> products with a total cost of <?=$orderCost?> kr.</b></p>
    <p>We have sent you a confirmation via email. If you have any questions please contact us.</p>
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

    <?php foreach($orderedItems as $item) { ?>
        <tbody>
            <tr>
                <td><img src="<?=$item['img_url']?>" width="100px" height="100px"></td>
                <td><?=$item['title']?></td>
                <td></td>
                <td><?=$item['quantity']?> st</td>
                <td><?=$item['price']?> kr</td>
            </tr>
    <?php } ?>
        </tbody>
    </table>
    <a href="index.php">Back to shop</a>
</div>

<?php include('layout/footer.php') ?>