<?php
	$pageTitle = "Shop page";

	require('../src/config.php');

	// READ
    $stmt = $pdo->query("
	SELECT * 
	FROM products 
	ORDER BY id DESC
    ");
    $products = $stmt->fetchAll();
	
	echo "<pre>";
    print_r($products);
    echo "</pre>";

	include('layout/header.php');
?>


<h1>Shop page</h1>
<a href="http://localhost/Praliner/public/admin">Admin</a>

<?php foreach ($products as $product) { ?>
	<h3><?= htmlentities($product['title']) ?></h3>
	<a href="product.php?product=<?=$product['id']?>">
		<img src='img_url' alt="Pralin!!!" width="100" height="100">
	</a>
	
	<p><?= htmlentities($product['price']) ?>kr</p>
	<p>stock: <?= htmlentities($product['stock']) ?></p>
	<hr>
<?php }?>
	


<?php include('layouts/footer.php') ?>