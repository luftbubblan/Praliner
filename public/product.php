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
    </div>
    
    
    
    <div id="about-con">
        <div id="title">
            <h3><?= htmlentities($product['title']) ?></h3>
        </div>
        <p><i><?= htmlentities($product['flavour']) ?></i></p>
        <p id="p-stock">stock: <?= htmlentities($product['stock']) ?></p>
            <p><?= htmlentities($product['description']) ?></p>
        <h4><?= htmlentities($product['price']) ?> kr</h4>
        <div id="buy-sec">
            <form action="addToCart.php" method="POST">
                <input type="hidden" name="productId" value="<?= ($product['id']) ?>">
                <input type="number" name="quantity" value="1" min="1" max="<?= ($product['stock']) ?>">
                <input type="submit" name="addToCartBtn" value="Köp">
            </form>
        </div>
        
    </div>
</div>

<?php include('layout/footer.php') ?>