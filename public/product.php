<?php
	$pageTitle = "Shop page";

	require('../src/config.php');
    require('../src/app/CRUD_functions.php');
 
    $product =$crudFunctions->fetchProductById($_GET['product']);

	include('layout/header.php');
?>

<div id="product-con">
    
    <div id="img-desc">
        <img src="<?=$product['img_url']?>" alt="Picture of pralin">
    </div>
    
    
    
    <div id="about-con">
        <div id="title">
            <h3><?= htmlentities($product['title']) ?></h3>
        </div>
        <p id="p-flavour"><i><?= htmlentities($product['flavour']) ?></i></p>
        <p id="p-desc"><?= htmlentities($product['description']) ?></p>
        <p id="p-stock"><?= htmlentities($product['stock']) ?> stk i lager</p>
        <h4><?= htmlentities($product['price']) ?> kr</h4>
        <div id="buy-sec">
            <button class="minusBtn plusMinus plusMinusSingle">-</button>
            <span>1</span>
            <button class="plusBtn plusMinus plusMinusSingle">+</button>

            <form action="addToCart.php" method="POST">
                <input type="hidden" name="productId" value="<?= ($product['id']) ?>">
                <input type="hidden" name="quantity" value="1">
                <button type="submit" class="btn btn-success" name="addToCartBtn"><i class="fa-solid fa-cart-plus"></i></button>
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