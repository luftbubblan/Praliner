<?php
	$pageTitle = "Edit product";

	require('../../src/config.php');
    require('../../src/app/common_functions.php');
    require('../../src/app/CRUD_functions.php');

	// echo "<pre>";
    // print_r($_POST);
    // echo "</pre>";
    
    $message = "";
	$title = "";
	$flavour = "";
	$description = "";
	$price = "";
	$stock = "";
    
    if (isset($_POST['updateProductBtn'])) {
        $title = 	   ucfirst(trim($_POST['title']));
		$flavour = 	   ucfirst(trim($_POST['flavour']));
		$description = ucfirst(trim($_POST['description']));
		$price = 			   trim($_POST['price']);
		$stock = 			   trim($_POST['stock']);

        $message .= ifEmptyGenerateMessage($title, "Title must not be empty. (Value taken from database)");
        $message .= ifEmptyGenerateMessage($flavour, "Flavour must not be empty. (Value taken from database)");
        $message .= ifEmptyGenerateMessage($description, "Description must not be empty. (Value taken from database)");
        $message .= ifEmptyGenerateMessage($price, "Price must not be empty. (Value taken from database)");
        $message .= ifEmptyGenerateMessage($stock, "Stock must not be empty. (Value taken from database)");
        
        $crudFunctions->updateProduct($message, $title, $flavour, $description, $price, $stock, $_POST['id']);
    }

    $product =$crudFunctions->fetchProductById($_POST['id']);

	include('layout/header.php');
?>


<?=$message?>

<div id="content-updateUser">
    <form action="" method="POST">
        <h2>Admin</h2>
        <h4>Redigera produkt</h4>
    <div class="form-gap">
        <label for="first_name">Namn:</label><br>
        <input type="text" name="title" placeholder="Title" value="<?=$_POST['title'] ? $_POST['title'] : $product['title'] ?>">
    </div>
    <div class="form-gap">
        <label for="first_name">Smak:</label><br>
        <input type="text" name="flavour" placeholder="Flavour" value="<?=$_POST['flavour'] ? $_POST['flavour'] : $product['flavour'] ?>">
    </div>
    <div class="form-gap">
        <label for="first_name">Beskrivning:</label><br>
        <textarea name="description" placeholder="Description"><?=$_POST['description'] ? $_POST['description'] : $product['description'] ?></textarea>
    </div>
    <div class="form-gap">
        <label for="first_name">Pris:</label><br>
        <input type="number" name="price" placeholder="Price" value="<?=$_POST['price'] ? $_POST['price'] : $product['price'] ?>">
    </div>
    <div class="form-gap">
        <label for="first_name">Lagerstatus:</label><br>
        <input type="number" name="stock" placeholder="Stock" value="<?=$_POST['stock'] ? $_POST['stock'] : $product['stock'] ?>">
    </div>
    <div class="form-gap">
        <input type="hidden" name="id" value="<?=$_POST['id'] ?>">
    </div> 
        <div class="form-gap">
        <input type="submit" class=" btn btn-success" name="updateProductBtn" value="Update Product">
    </div>
    </form>
</div>

















<?php include('layout/footer.php') ?>