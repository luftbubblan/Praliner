<?php
	$pageTitle = "Product admin page";

	require('../../src/config.php');
	require('../../src/app/common_functions.php');
	require('../../src/app/CRUD_functions.php');

    $message = "";

    if (isset($_POST['deleteProductBtn'])) {
        $crudFunctions->deleteProduct($_POST['id']);
    }

	if (isset($_GET['added'])) {
        $message .= successMessage("Product successfully created.");
    }

	if (isset($_GET['deleted'])) {
        $message .= successMessage("Product successfully deleted.");
    }

	if (isset($_GET['updated'])) {
        $message .= successMessage("Product successfully updated.");
    }

    $products = $crudFunctions->fetchAllProductsDESC();

	include('layout/header.php');
?>

<div id="content-products">
<h2>Product admin page</h2>

<form action="addNewProduct.php">
	<input type="submit" value="Create new product">
</form>

<?=$message?>

<table id="products-tbl">
	<thead>
		<tr id="product-list">
			<th>Id</th>
			<th>Title</th>
			<th>Flavour</th>
			<th>Description</th>
			<th>Price</th>
			<th>Stock</th>
			<th>Img</th>
			<th>Action</th>
		</tr>
	</thead>

    <tbody>
	    <?php foreach($products as $product) { ?>
			<tr>
				<td><?=htmlentities($product['id'])?></td>
				<td><?=htmlentities($product['title'])?></td>
				<td><?=htmlentities($product['flavour'])?></td>
				<td><?=htmlentities($product['description'])?></td>
				<td><?=htmlentities($product['price'])?></td>      
				<td><?=htmlentities($product['stock'])?></td>
				<td><?=htmlentities($product['img_url'])?></td>
				<td>
                    <!-- Edit -->
                    <form action="edit.php" method="POST">
                        <input type="hidden" name="id" value="<?=$product['id'] ?>">
                        <input type="hidden" name="title" value="<?=$product['title'] ?>">
                        <input type="hidden" name="flavour" value="<?=$product['flavour'] ?>">
                        <input type="hidden" name="description" value="<?=$product['description'] ?>">
                        <input type="hidden" name="price" value="<?=$product['price'] ?>">
                        <input type="hidden" name="stock" value="<?=$product['stock'] ?>">
                        <input type="hidden" name="img_url" value="<?=$product['img_url'] ?>">
                        <input type="submit" value="Edit">
                    </form>

                    <!-- Delete -->
                    <form action="" method="POST">
                        <input type="hidden" name="id" value="<?=$product['id'] ?>">
                        <input type="submit" name="deleteProductBtn" value="Delete">
                    </form>
                </td>
			</tr>
        <?php } ?>
	</tbody>
</table>
</div>


















<?php include('layout/footer.php') ?>