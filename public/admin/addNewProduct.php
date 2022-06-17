<?php
	$pageTitle = "Admin page";

	require('../../src/config.php');
	require('../../src/app/common_functions.php');
	require('../../src/app/CRUD_functions.php');

	//CREATE
	$message = "";
	$title = "";
	$flavour = "";
	$description = "";
	$price = "";
	$stock = "";
	$img_url = "";

	if (isset($_POST['createProductBtn'])) {
		$title = 	   ucfirst(trim($_POST['title']));
		$flavour = 	   ucfirst(trim($_POST['flavour']));
		$description = ucfirst(trim($_POST['description']));
		$price = 			   trim($_POST['price']);
		$stock = 			   trim($_POST['stock']);

		$message .= ifEmptyGenerateMessage($title, "Title must not be empty.");
        $message .= ifEmptyGenerateMessage($flavour, "Flavour must not be empty.");
        $message .= ifEmptyGenerateMessage($description, "Description must not be empty.");
        $message .= ifEmptyGenerateMessage($price, "Price must not be empty.");
        
		
 
		if (empty($stock) && $stock != 0) {
			$message .= errorMessage($message);
		}

		if(!is_uploaded_file($_FILES['img_url']['tmp_name'])) {
			$message .= errorMessage($message); 
			
		}  else {
			$fileName 	    = $_FILES['img_url']['name'];
			$fileType 	    = $_FILES['img_url']['type'];
			$fileTempPath   = $_FILES['img_url']['tmp_name'];
			$path 		    = "img/";
			
			$newFilePath = "../" . $path . $fileName;
			
			$allowedFileTypes = [
				'image/png',
				'image/jpeg',
				'image/gif',
			];
			
			$isFileTypeAllowed = array_search($fileType, $allowedFileTypes, true);
			
			if (!$isFileTypeAllowed) {
				$message .= '
					<div class="">
						Image type is not allowed. Must be: JPEG, PNG or GIF.
					</div>
            	';
				
			} 
			
			if ($_FILES['img_url']['size'] > 10000000) {  // Allows files under 10 mbyte
				$message .= '
					<div class="">
						Image is to large. Max size is 10 MB.
					</div>
            	';
			}

			// $img_size = getimagesize($fileTempPath);
			// $img_aspect_ratio = $img_size[0] / $img_size[1];

			// if ($img_aspect_ratio != 1) {
			// 	$message .= "Image must have a 1:1 aspect ratio. (Same height and with)";
			// }
		}

		
		
		if (empty($message)) {
			move_uploaded_file($fileTempPath, $newFilePath);
			$imgUrl = $path . $fileName;
			
			$message .=$crudFunctions->addNewProduct($message, $title, $flavour, $description, $price, $stock, $imgUrl);
			/* $sql = "
				INSERT INTO products (
					title,
					flavour,
					description,
					price,
					stock,
					img_url)
				VALUES (
					:title,
					:flavour,
					:description,
					:price,
					:stock,
					:img_url)
			";
		 */
			/* $stmt = $pdo->prepare($sql);
			$stmt->bindParam(':title', $title);
			$stmt->bindParam(':flavour', $flavour);
			$stmt->bindParam(':description', $description);
			$stmt->bindParam(':price', $price);
			$stmt->bindParam(':stock', $stock);
			$stmt->bindParam(':img_url', $imgUrl);
			$stmt->execute();
			header('Location: index.php?added');
			exit; */
		}
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