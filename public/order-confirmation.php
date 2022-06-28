<?php
    $pageTitle = "Orderbekräftelse";

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
    <h1>Tack för din beställning!</h1>
    <p><b>Du har beställt <?=$itemsOrdered?> produkter med en totalsumma på <?=$orderCost?> kr.</b></p>
    <p>Vi har skickat ett bekräftelsemail till dig. Om du har några frågor eller funderingar, tveka inte på att höra av dig till oss.</p>
    <table class="table tabel-borderless">
        <thead>
            <tr>
                <th style="width: 15%">Produkt</th>
                <th style="width: 45%">Beskrivning</th>
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
                <td><?=$item['quantity']?> stk</td>
                <td><?=$item['price']?> kr</td>
            </tr>
    <?php } ?>
        </tbody>
    </table>
    <a href="index.php">Tillbaka till butiken</a>
</div>

<?php include('layout/footer.php') ?>