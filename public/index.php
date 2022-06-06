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
<a href="myPage.php">My page</a>
<a href="registerUser.php">Register</a>
<a href="login.php">Log in</a>
<hr>

<?php foreach ($products as $product) { ?>
	<a href="product.php?product=<?=$product['id']?>">
		<img src='img_url' alt="Pralin!!!" width="100" height="100">
	</a>
	<h3><?= htmlentities($product['title']) ?></h3>
	<p><?= htmlentities($product['flavour']) ?></p>
	
	<p><?= htmlentities($product['price']) ?>kr</p>
	<p>stock: <?= htmlentities($product['stock']) ?></p>
	<hr>
<?php }?>
	


<?php include('layouts/footer.php') ?>