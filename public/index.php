<?php
	$pageTitle = "Shop page";

	require('../src/config.php');
	require('../src/app/CRUD_functions.php');

	$products = $crudFunctions->fetchAllProductsDESC();

	include('layout/header.php');
?>

<div id="homepage-con">

	<div id="front-info">
	<h2>Pralinerpralinerpraliner</h2>
		<p>
		Välkommen till Marias Söta i Vejbystrand. 
		Jag bakar med smakrikedom och blomsterpilleri, där ögat får sitt innan smaken tar vid.
		</p>
	</div>

	<div id="shop-con">
		<?php foreach ($products as $product) { ?>
			<div id="single-con">
				<div id="single">
				
				<a href="product.php?product=<?=$product['id']?>">
					<img src="<?= $product['img_url']?>" alt="Picture of pralin" width="100" height="100">
				</a>
				<h3><?= htmlentities($product['title']) ?></h3>
				<p><?= htmlentities($product['flavour']) ?></p>
				
				<p><?= htmlentities($product['price']) ?>kr</p>
				<p>stock: <?= htmlentities($product['stock']) ?></p>
				<button id="buy-btn">Lägg till i varukorg</button>
				
				</div>
			</div>
		<?php }?>
	</div>
</div>

<?php include('layout/footer.php') ?> 