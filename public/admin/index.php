<?php
	$pageTitle = "Admin page";

	require('../../src/config.php');

	echo "<pre>";
    print_r($_POST);
    echo "</pre>";

	// DELETE
    if (isset($_POST['deleteProductBtn'])) {
        $sql = "
        DELETE FROM products
        WHERE id = :id
        ";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(":id", $_POST['id']);
        $stmt->execute();
        header('Location: index.php?deleted');
        exit;
    }

	if (isset($_GET['deleted'])) {
        $message = '
            <div class="">
                Product successfully deleted.
            </div>
        ';
    }
	if (isset($_GET['updated'])) {
        $message = '
            <div class="">
                Product successfully updated.
            </div>
        ';
    }

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

<?=$message?>

<table id="products-tbl">
	<thead>
		<tr>
			<th>Id</th>
			<th>Title</th>
			<th>Description</th>
			<th>Price</th>
			<th>Stock</th>
			<th>Img</th>
			<th>Action</th>
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
				<td>
                    <!-- Edit -->
                    <form action="edit.php" method="POST">
                        <input type="hidden" name="id" value="<?= htmlentities($product['id']) ?>">
                        <input type="submit" value="Edit">
                    </form>

                    <!-- Delete -->
                    <form action="" method="POST" id="deleteBtn">
                        <input type="hidden" name="id" value="<?= htmlentities($product['id']) ?>">
                        <input type="submit" name="deleteProductBtn" value="Delete">
                    </form>
                </td>
			</tr>
		</tbody>
	<?php } ?>
</table>


















<?php include('layouts/footer.php') ?>