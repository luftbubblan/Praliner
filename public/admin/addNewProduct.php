<?php
	$pageTitle = "Admin page";

	require('../../src/config.php');

    echo "<pre>";
    print_r($_POST);
    echo "</pre>";

	//CREATE
	$message = "";
	$title = "";
	$description = "";
	$price = "";
	$stock = "";
	$img_url = "";
	$empty = "not empty";
	if (isset($_POST['createProductBtn'])) {
		$title = trim($_POST['title']);
		$description = trim($_POST['description']);
		$price = trim($_POST['price']);
		$stock = trim($_POST['stock']);
		$img_url = trim($_POST['img_url']);

		if (empty($title)) {
			$message .= '
                <div class="">
                    Title must not be empty.
                </div>
            ';
			$empty = "empty";
		}

		if (empty($description)) {
			$message .= '
                <div class="">
                    Description must not be empty.
                </div>
            ';
			$empty = "empty";
		}

		if (empty($price)) {
			$message .= '
                <div class="">
                    Price must not be empty.
                </div>
            ';
			$empty = "empty";
		}

		if (empty($stock)) {
			$message .= '
                <div class="">
                    Stock must not be empty.
                </div>
            ';
			$empty = "empty";
		}

		if (empty($img_url)) {
			$message .= '
                <div class="">
                    Img must not be empty.
                </div>
            ';
			$empty = "empty";
		}

		if ($empty == "not empty") {
			$sql = "
				INSERT INTO products (
					title,
					description,
					price,
					stock,
					img_url)
				VALUES (
					:title,
					:description,
					:price,
					:stock,
					:img_url)
			";
		
			$stmt = $pdo->prepare($sql);
			$stmt->bindParam(':title', $title);
			$stmt->bindParam(':description', $description);
			$stmt->bindParam(':price', $price);
			$stmt->bindParam(':stock', $stock);
			$stmt->bindParam(':img_url', $img_url);
			$stmt->execute();
			header('Location: index.php');
			exit;
		}
	}

	include('layout/header.php');
?>


<h1>Add new product</h1>
<a href="index.php">Admin</a>

<?=$message?>

<form action="" method="POST">
    <input type="text" name="title" placeholder="Title" value="<?=$_POST['title']?>">
    <textarea name="description" placeholder="Description"><?=$_POST['description']?></textarea>
    <input type="number" name="price" placeholder="Price" value="<?=$_POST['price']?>">
    <input type="number" name="stock" placeholder="Stock" value="<?=$_POST['stock']?>">
    <input type="text" name="img_url" placeholder="Image" value="<?=$_POST['img_url']?>">
    <input type="submit" name="createProductBtn" value="List Product">
</form>









<?php include('layouts/footer.php') ?>