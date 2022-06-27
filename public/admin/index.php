<?php
	$pageTitle = "Produkt översikt admin";

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

<div class="content-products">
<h2>Admin</h2>
<h4>Hantera produkter</h4>

<form action="addNewProduct.php">
	<input type="submit" class="add-new-btn btn btn-success" value="Lägg till ny produkt">
</form>

<?=$message?>

<table id="admin-tbl">
	<thead>
		<tr id="product-list">
			<th>Namn</th>
			<th>Smak</th>
			<th>Beskrivning</th>
			<th>Pris</th>
			<th>Lagerstatus</th>
			<th>Bild</th>
			<th></th>
		</tr>
	</thead>

    <tbody>
	    <?php foreach($products as $product) { ?>
			<tr>
				<td><?=htmlentities($product['title'])?></td>
				<td><?=htmlentities($product['flavour'])?></td>
				<td><?=substr(htmlentities($product['description']), 0, 170)?></td>
				<td><?=htmlentities($product['price'])?></td>      
				<td><?=htmlentities($product['stock'])?></td>
				<td><?=htmlentities($product['img_url'])?></td>
				<td class="table-btns" >
                    <!-- Edit -->
                    <form action="edit.php" method="POST">
                        <input type="hidden" name="id" value="<?=$product['id'] ?>">
                        <input type="hidden" name="title" value="<?=$product['title'] ?>">
                        <input type="hidden" name="flavour" value="<?=$product['flavour'] ?>">
                        <input type="hidden" name="description" value="<?=$product['description'] ?>">
                        <input type="hidden" name="price" value="<?=$product['price'] ?>">
                        <input type="hidden" name="stock" value="<?=$product['stock'] ?>">
                        <input type="hidden" name="img_url" value="<?=$product['img_url'] ?>">
                        <input type="submit" id="edit-btn" class="edit-btn btn btn-success" value="Redigera">
                    </form>

                    <!-- Delete -->
                    <form action="" method="POST">
                        <input type="hidden" name="id" value="<?=$product['id'] ?>">
                        <input type="submit" class="btn btn-danger" name="deleteProductBtn" value="Radera">
                    </form>
                </td>
			</tr>
        <?php } ?>
	</tbody>
</table>
</div>


<?php include('layout/footer.php') ?>