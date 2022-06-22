<?php
	$pageTitle = "Shop page";

	require('../src/config.php');
    require('../src/app/CRUD_functions.php');
 

    $product =$crudFunctions->fetchProductById($_GET['product']);

	include('layout/header.php');
?>


<div id="product-con">
    
    <div id="img-desc">
        <img src="<?=$product['img_url']?>" alt="Picture of pralin" width="500" height="500">
        <div id="desc">
            <p><?= htmlentities($product['description']) ?></p>
        </div>
    </div>


    
    <div id="about-con">
        <div id="title">
            <h3><?= htmlentities($product['title']) ?></h3>
        </div>
        <p><?= htmlentities($product['flavour']) ?></p>
        <p>stock: <?= htmlentities($product['stock']) ?></p>
        <h4><?= htmlentities($product['price']) ?> kr</h4>
        <div id="buy-sec">
            <input type="number" value="1" min="1" max="<?= htmlentities($product['stock']) ?>">
            <button id="buy-btn">Lägg till i varukorg</button>
        </div>
    </div>
</div>

<?php include('layout/footer.php') ?>

<!-- Koppla cart.php till varukorg-dropdown på sidan? -->
<!-- KOD att lägga under produktsidan? Saknar integrity?-->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js">
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"> 