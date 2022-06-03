<?php
	$pageTitle = "Edit product";

	require('../../src/config.php');

	echo "<pre>";
    print_r($_POST);
    echo "</pre>";
    
	// READ
    $sql = "
    SELECT * 
    FROM products 
    WHERE id = :id
    ";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(":id", $_POST['id']);
    $stmt->execute();
    $product = $stmt->fetch();
    
	// UPDATE
    if (isset($_POST['updateProductBtn'])) {
        // $content = trim($_POST['content']);

        $sql = "
            UPDATE products
            SET
                title = :title,
                description = :description,
                price = :price,
                stock = :stock,
                img_url = :img_url
            WHERE id = :id
        ";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(":title", $_POST['title']);
        $stmt->bindParam(":description", $_POST['description']);
        $stmt->bindParam(":price", $_POST['price']);
        $stmt->bindParam(":stock", $_POST['stock']);
        $stmt->bindParam(":img_url", $_POST['img_url']);
        $stmt->bindParam(":id", $_POST['id']);
        $stmt->execute();
        header('Location: index.php?updated');
        exit;
    }



	include('layout/header.php');
?>


<h1>Edit product</h1>
<a href="index.php">Admin</a>

<?=$message?>

<div>
    <form action="" method="POST">
        <input type="text" name="title" placeholder="Title" value="<?=$product['title']?>">
        <textarea name="description" placeholder="Description"><?=$product['description']?></textarea>
        <input type="number" name="price" placeholder="Price" value="<?=$product['price']?>">
        <input type="number" name="stock" placeholder="Stock" value="<?=$product['stock']?>">
        <input type="text" name="img_url" placeholder="Image" value="<?=$product['img_url']?>">
        <input type="hidden" name="id" value="<?=$product['id'] ?>">
        <input type="submit" name="updateProductBtn" value="Update Product">
    </form>
</div>

















<?php include('layouts/footer.php') ?>