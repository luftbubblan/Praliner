<?php
	$pageTitle = "Edit product";

	require('../../src/config.php');

	echo "<pre>";
    print_r($_POST);
    echo "</pre>";
    
	// UPDATE
    $message = "";
	$title = "";
	$flavour = "";
	$description = "";
	$price = "";
	$stock = "";
	$img_url = "";
	$empty = "not empty";
    if (isset($_POST['updateProductBtn'])) {
        $title = trim($_POST['title']);
        $flavour = trim($_POST['flavour']);
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
        if (empty($flavour)) {
			$message .= '
                <div class="">
                    Flavour must not be empty.
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
                UPDATE products
                SET
                    title = :title,
                    flavour = :flavour,
                    description = :description,
                    price = :price,
                    stock = :stock,
                    img_url = :img_url
                WHERE id = :id
            ";
            
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(":title", $_POST['title']);
            $stmt->bindParam(":flavour", $_POST['flavour']);
            $stmt->bindParam(":description", $_POST['description']);
            $stmt->bindParam(":price", $_POST['price']);
            $stmt->bindParam(":stock", $_POST['stock']);
            $stmt->bindParam(":img_url", $_POST['img_url']);
            $stmt->bindParam(":id", $_POST['id']);
            $stmt->execute();
            header('Location: index.php?updated');
            exit;
        }
    }



	include('layout/header.php');
?>


<h1>Edit product</h1>
<a href="index.php">Admin</a>

<?=$message?>

<div>
    <form action="" method="POST">
        <input type="text" name="title" placeholder="Title" value="<?=$_POST['title']?>">
        <input type="text" name="flavour" placeholder="Flavour" value="<?=$_POST['flavour']?>">
        <textarea name="description" placeholder="Description"><?=$_POST['description']?></textarea>
        <input type="number" name="price" placeholder="Price" value="<?=$_POST['price']?>">
        <input type="number" name="stock" placeholder="Stock" value="<?=$_POST['stock']?>">
        <input type="text" name="img_url" placeholder="Image" value="<?=$_POST['img_url']?>">
        <input type="hidden" name="id" value="<?=$_POST['id'] ?>">
        <input type="submit" name="updateProductBtn" value="Update Product">
    </form>
</div>

















<?php include('layouts/footer.php') ?>