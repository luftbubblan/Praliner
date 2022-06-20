<?php
	$pageTitle = "Admin page";

	require('../../src/config.php');
	require('../../src/app/common_functions.php');
	require('../../src/app/CRUD_functions.php');

	$message = "";
	$title = "";
	$flavour = "";
	$description = "";
	$price = "";
	$stock = "";

	if (isset($_POST['createProductBtn'])) {
		$title = 	   ucfirst(trim($_POST['title']));
		$flavour = 	   ucwords(trim($_POST['flavour']));
		$description = ucfirst(trim($_POST['description']));
		$price = 			   trim($_POST['price']);
		$stock = 			   trim($_POST['stock']);

		$message .= ifEmptyGenerateMessage($title, "Title must not be empty.");
        $message .= ifEmptyGenerateMessage($flavour, "Flavour must not be empty.");
        $message .= ifEmptyGenerateMessage($description, "Description must not be empty.");
        $message .= ifEmptyGenerateMessage($price, "Price must not be empty.");
		if (empty($stock) && $stock != 0) {
			$message .= errorMessage("Stock must not be empty.");
		}

		$message = $crudFunctions->addNewProduct($message, $title, $flavour, $description, $price, $stock);
	}

	include('layout/header.php');
?>

<h1>Add new product</h1>

<?=$message?>

<form action="" method="POST" enctype="multipart/form-data">
    <input type="text" name="title" placeholder="Title" value="<?=$_POST['title'] ?? "" ?>">
    <input type="text" name="flavour" placeholder="Flavour" value="<?=$_POST['flavour'] ?? "" ?>">
    <textarea name="description" placeholder="Description"><?=$_POST['description'] ?? "" ?></textarea>
    <input type="number" name="price" placeholder="Price" value="<?=$_POST['price'] ?? "" ?>">
    <input type="number" name="stock" placeholder="Stock" value="<?=$_POST['stock'] ?? "" ?>" min="0">
    <lable>Picture:</lable>
	<input type="file" name="img_url">
    <input type="submit" name="createProductBtn" value="List Product">
</form>



<?php include('layout/footer.php') ?>