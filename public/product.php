<?php
	$pageTitle = "Shop page";

	require('../src/config.php');
    require('../src/app/CRUD_functions.php');

    $product =$crudFunctions->fetchProductById($_GET['product']);

	include('layout/header.php');
?>

<div id="title">
    <h3><?= htmlentities($product['title']) ?></h3>
</div>

<div id="product-con">

    <div id="img-con">
        <img src="<?=$product['img_url']?>" alt="Picture of pralin" width="300" height="300">
    </div>
    
    <div id="about-con">
        <p><?= htmlentities($product['flavour']) ?></p>
        <p><?= htmlentities($product['price']) ?>kr</p>
        <p>stock: <?= htmlentities($product['stock']) ?></p>
        <p><?= htmlentities($product['description']) ?></p>
        <div id="buy-sec">
            <input type="number" value="1" min="1" max="<?= htmlentities($product['stock']) ?>">
            <button id="buy-btn">Lägg till i varukorg</button>
        </div>
    </div>
</div>

<?php include('layout/footer.php') ?>

<!-- KOD att lägga under produktsidan?
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js">
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"> -->