<?php
	$pageTitle = "Admin page";

	require('../../src/config.php');

	echo "<pre>";
	print_r($_POST);
	echo "</pre>";

	echo "<pre>";
	print_r($_FILES['img_url']);
	echo "</pre>";

	//CREATE
	$message = "";
	$title = "";
	$flavour = "";
	$description = "";
	$price = "";
	$stock = "";
	$img_url = "";

	if (isset($_POST['createProductBtn'])) {
		$title = trim($_POST['title']);
		$flavour = trim($_POST['flavour']);
		$description = trim($_POST['description']);
		$price = trim($_POST['price']);
		$stock = trim($_POST['stock']);
		// $img_url = trim($_POST['img_url']);

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

		if (empty($stock) && $stock != 0) {
			$message .= '
                <div class="">
                    Stock must not be empty.
                </div>
            ';
		}

		// if (empty($img_url)) {
		// 	$message .= '
        //         <div class="">
        //             Img must not be empty.
        //         </div>
        //     ';
		// }

		if(!is_uploaded_file($_FILES['img_url']['tmp_name'])) {
			$message .= '
                <div class="">
                    Picture must be chosen.
                </div>
            ';
		} else {
			$fileName 	    = $_FILES['img_url']['name'];
			$fileType 	    = $_FILES['img_url']['type'];
			$fileTempPath   = $_FILES['img_url']['tmp_name'];
			$path 		    = "img/";

			$newFilePath = $path . $fileName; 
		}

		if (empty($message)) {
			$isTheFileUploaded = move_uploaded_file($fileTempPath, $newFilePath);
	
			if ($isTheFileUploaded) {
				// Success the file is uploaded
				$imgUrl = $newFilePath;
			} else {
				// Could not upload the file
				$error = "Could not upload the file";
			}

			$sql = "
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
		
			$stmt = $pdo->prepare($sql);
			$stmt->bindParam(':title', $title);
			$stmt->bindParam(':flavour', $flavour);
			$stmt->bindParam(':description', $description);
			$stmt->bindParam(':price', $price);
			$stmt->bindParam(':stock', $stock);
			$stmt->bindParam(':img_url', $imgUrl);
			$stmt->execute();
			// header('Location: index.php?added');
			// exit;
		}
	}

	include('layout/header.php');
?>


<h1>Add new product</h1>

<?=$message?>

<form action="" method="POST" enctype="multipart/form-data">
    <input type="text" name="title" placeholder="Title" value="<?=$_POST['title']?>">
    <input type="text" name="flavour" placeholder="Flavour" value="<?=$_POST['flavour']?>">
    <textarea name="description" placeholder="Description"><?=$_POST['description']?></textarea>
    <input type="number" name="price" placeholder="Price" value="<?=$_POST['price']?>">
    <input type="number" name="stock" placeholder="Stock" value="<?=$_POST['stock']?>" min="0">
    <lable>Picture:</lable>
	<input type="file" name="img_url" placeholder="Image" value="<?=$_POST['img_url']?>">
    <input type="submit" name="createProductBtn" value="List Product">
</form>









<?php include('layout/footer.php') ?>