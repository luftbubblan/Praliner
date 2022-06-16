<?php
	$pageTitle = "Edit product";

	require('../../src/config.php');
    require('../../src/app/CRUD_functions.php');

	// echo "<pre>";
    // print_r($_POST);
    // echo "</pre>";
    
	// UPDATE
    $message = "";
	$title = "";
	$flavour = "";
	$description = "";
	$price = "";
	$stock = "";
    
    if (isset($_POST['updateProductBtn'])) {
        $title = trim($_POST['title']);
        $flavour = trim($_POST['flavour']);
		$description = trim($_POST['description']);
		$price = trim($_POST['price']);
		$stock = trim($_POST['stock']);

        if (empty($title)) {
			$message .= '
                <div class="">
                    Title must not be empty.
                </div>
            ';
		}
        if (empty($flavour)) {
			$message .= '
                <div class="">
                    Flavour must not be empty.
                </div>
            ';
		}

		if (empty($description)) {
			$message .= '
                <div class="">
                    Description must not be empty.
                </div>
            ';
		}

		if (empty($price)) {
			$message .= '
                <div class="">
                    Price must not be empty.
                </div>
            ';
		}

		if (empty($stock)) {
			$message .= '
                <div class="">
                    Stock must not be empty.
                </div>
            ';
		}
        
        $crudFunctions->updateProduct($message, $title, $flavour, $description, $price, $stock);
    
    }



	include('layout/header.php');
?>


<h1>Edit product</h1>
<!-- <a href="index.php">Admin</a> -->

<?=$message?>

<div>
    <form action="" method="POST">
        <input type="text" name="title" placeholder="Title" value="<?=$_POST['title']?>">
        <input type="text" name="flavour" placeholder="Flavour" value="<?=$_POST['flavour']?>">
        <textarea name="description" placeholder="Description"><?=$_POST['description']?></textarea>
        <input type="number" name="price" placeholder="Price" value="<?=$_POST['price']?>">
        <input type="number" name="stock" placeholder="Stock" value="<?=$_POST['stock']?>">
        <input type="hidden" name="id" value="<?=$_POST['id'] ?>">
        <input type="submit" name="updateProductBtn" value="Update Product">
    </form>
</div>

















<?php include('layout/footer.php') ?>