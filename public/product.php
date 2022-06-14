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
        <img src="admin/<?= $product['img_url']?>" alt="Pralin!!!" width="300" height="300">
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