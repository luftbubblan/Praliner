<?php
	$pageTitle = "Skapa ny produkt";

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

		$message .= ifEmptyGenerateMessage($title, "Namn måste vara ifyllt.");
        $message .= ifEmptyGenerateMessage($flavour, "Smak måste vara ifyllt.");
        $message .= ifEmptyGenerateMessage($description, "Beskrivning måste vara ifyllt.");
        $message .= ifEmptyGenerateMessage($price, "Pris måste vara ifyllt.");
		if (empty($stock) && $stock != 0) {
			$message .= errorMessage("Lagerstatus måste vara ifyllt.");
		}

		$message = $crudFunctions->addNewProduct($message, $title, $flavour, $description, $price, $stock);
	}

	include('layout/header.php');
?>
<?=$message?>

<div class="form-style">
<form action="" method="POST" enctype="multipart/form-data">
    <h2>Admin</h2>
    <h4>Lägg till ny produkt</h4>
    <div class="form-gap">
        <label for="first_name">Namn:</label><br>
		<input type="text" name="title" placeholder="Namn" value="<?=$_POST['title'] ?? "" ?>">
	</div>
    <div class="form-gap">
        <label for="first_name">Smak:</label><br>
		<input type="text" name="flavour" placeholder="Smak" value="<?=$_POST['flavour'] ?? "" ?>">
	</div>
    <div class="form-gap">
        <label for="first_name">Beskrivning:</label><br>
		<textarea name="description" placeholder="Beskrivning"><?=$_POST['description'] ?? "" ?></textarea>
	</div>
    <div class="form-gap">
        <label for="first_name">Pris:</label><br>
		<input type="number" name="price" placeholder="Pris" value="<?=$_POST['price'] ?? "" ?>">
	</div>
    <div class="form-gap">
        <label for="first_name">Lagerstatus:</label><br>
		<input type="number" name="stock" placeholder="Lagerstatus" value="<?=$_POST['stock'] ?? "" ?>" min="0">
	</div>
	<lable>Bild:</lable>
	<input type="file" name="img_url">
        <div class="form-gap">
		<input type="submit" class="edit-btn btn btn-success" name="createProductBtn" value="Lägg till">
		<button type="button" class="btn btn-secondary" onclick="window.location.href='index.php'">Tillbaka</button>
    </div>
</form>
</div>


<?php include('layout/footer.php') ?>