<?php
	$pageTitle = "Shop page";

	require('../src/config.php');

	echo "<pre>";
    print_r($_GET);
    echo "</pre>";

	// READ
    $sql = "
        SELECT * 
        FROM products 
        WHERE id = :id
    ";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(":id", $_GET['product']);
    $stmt->execute();
    $product = $stmt->fetch();
	
	echo "<pre>";
    print_r($product);
    echo "</pre>";

	include('layout/header.php');
?>


<h1>Single product page</h1>
<a href="http://localhost/Praliner/public/index.php">Shop</a>

<div>
    <h3><?= htmlentities($product['title']) ?></h3>
    <img src='img_url' alt="Pralin!!!" width="300" height="300">
    <p><?= htmlentities($product['flavour']) ?></p>
    <p><?= htmlentities($product['description']) ?></p>
    <p><?= htmlentities($product['price']) ?>kr</p>
    <p>stock: <?= htmlentities($product['stock']) ?></p>
</div>

	


<?php include('layouts/footer.php') ?>