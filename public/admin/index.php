<?php
	$pageTitle = "Admin page";

	require('../../src/config.php');

	// READ
    $stmt = $pdo->query("
        SELECT *
        FROM products
        ORDER BY id DESC
    ");
    $products = $stmt->fetchAll();

	include('layout/header.php');
?>


<h1>Admin page</h1>
<a href="http://localhost/Praliner/public">Shop</a>

<form action="addNewProduct.php">
	<input type="submit" value="Create new product">
</form>

<table id="products-tbl">
	<thead>
		<tr>
			<th>Id</th>
			<th>Title</th>
			<th>Description</th>
			<th>Price</th>
			<th>Stock</th>
			<th>Img</th>
		</tr>
	</thead>

	<?php foreach($products as $product) { ?>
		<tbody>
			<tr>
				<td><?=htmlentities($product['id'])?></td>
				<td><?=htmlentities($product['title'])?></td>
				<td><?=htmlentities($product['description'])?></td>
				<td><?=htmlentities($product['price'])?></td>      
				<td><?=htmlentities($product['stock'])?></td>
				<td><?=htmlentities($product['img_url'])?></td>
			</tr>
		</tbody>
	<?php } ?>
</table>


















<?php include('layouts/footer.php') ?>