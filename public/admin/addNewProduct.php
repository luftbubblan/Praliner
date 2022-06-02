<?php
	$pageTitle = "Admin page";

	require('../../src/config.php');

    echo "<pre>";
    print_r($_POST);
    echo "</pre>";

	if (isset($_POST['createProductBtn'])) {
		$sql = "
		  INSERT INTO products (title, description, price, stock, img_url)
		  VALUES (:title, :description, :price, :stock, :img_url)
		";
	
		$stmt = $pdo->prepare($sql);
		$stmt->bindParam(':title', $_POST['title']);
		$stmt->bindParam(':description', $_POST['description']);
		$stmt->bindParam(':price', $_POST['price']);
		$stmt->bindParam(':stock', $_POST['stock']);
		$stmt->bindParam(':img_url', $_POST['img_url']);
		$stmt->execute();
        // header('Location: index.php');
        // exit;
	  }

	include('layout/header.php');
?>


<h1>Add new product</h1>
<a href="index.php">Admin</a>


<form action="" method="POST">
    <input type="text" name="title" placeholder="Title" value="<?=$_POST['title']?>">
    <textarea name="description" placeholder="Description"><?=$_POST['description']?></textarea>
    <input type="text" name="price" placeholder="Price" value="<?=$_POST['price']?>">
    <input type="text" name="stock" placeholder="Stock" value="<?=$_POST['stock']?>">
    <input type="text" name="img_url" placeholder="Image" value="<?=$_POST['img_url']?>">
    <input type="submit" name="createProductBtn" value="List Product">
</form>









<?php include('layouts/footer.php') ?>