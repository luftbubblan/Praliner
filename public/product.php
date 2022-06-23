<?php
	$pageTitle = "Shop page";

	require('../src/config.php');
    require('../src/app/CRUD_functions.php');
 
    $product =$crudFunctions->fetchProductById($_GET['product']);

    // echo "<pre>";
    // print_r($product);
    // echo "</pre>";

    // $quantity = 1;

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
            <button class="minusBtn plusMinus plusMinusSingle">-</button>
            <span>1</span>
            <button class="plusBtn plusMinus plusMinusSingle">+</button>

            <form action="addToCart.php" method="POST">
                <input type="hidden" name="productId" value="<?= ($product['id']) ?>">
                <input type="hidden" name="quantity" value="1">
                <input type="submit" class="btn btn-success" name="addToCartBtn" value="Köp">
            </form>
        </div>
        
    </div>
</div>

<!-- jQuery -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<!-- CUSTOM -->
<script src="../src/app/js_functions.js"></script>
<script>
    showValue();
</script>

<?php include('layout/footer.php')?>