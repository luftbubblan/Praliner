<?php
	$pageTitle = "users";

	require('../../src/config.php');

	echo "<pre>";
    print_r($_GET);
    echo "</pre>";

  /*   $message = "";
    if (isset($_GET['invalidUser'])) {
        $message = '
            <div class="error_msg">
                Du försöker redigera en ogiltig användare
            </div>
        ';
    } */

    /**
     * DELETE user
     */

    if (isset($_POST['deleteUserBtn'])) {
        $sql = "
            DELETE FROM users 
            WHERE id = :id;
        ";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':id', $_POST['userId']);
        $stmt->execute();
    }

    /**
     * READ all users
     */
    $sql = "SELECT * FROM users;";
    $stmt = $pdo->query($sql);
    $users = $stmt->fetchAll();

?>
<?php include('layout/header.php'); ?>

   
<div id="content">
    <article class="border">
        <h1>Hantera användare</h1>

       <!--  <?=$message ?> -->

    <form action="addNewUser.php" method="GET">
        <input type="submit" value="Ny användare">
    </form>

<br>
    <table id="users-tbl">
        <thead>
	        <tr>
	            <th>id</th>
	            <th>First_name</th>
                <th>Last_name</th>
	            <th>email</th>
                <th>Password</th>
	            <th>Phone</th>
	            <th>Street</th>
                <th>Postal_code</th>
                <th>City</th>
                <th>Country</th>
                <th>Date</th>

	        </tr>
        </thead>
<tbody>
    <?php foreach($users as $user) : ?>
        <tr>
            <td><?=htmlentities($user['id']) ?></td>
            <td><?=htmlentities($user['first_name']) ?></td>
            <td><?=htmlentities($user['last_name']) ?></td>
            <td><?=htmlentities($user['email']) ?></td>
            <td><?=htmlentities($user['password']) ?></td>
            <td><?=htmlentities($user['phone']) ?></td>
            <td><?=htmlentities($user['street']) ?></td>
            <td><?=htmlentities($user['postal_code']) ?></td>
            <td><?=htmlentities($user['city']) ?></td>
            <td><?=htmlentities($user['country']) ?></td>
            <td><?=htmlentities($user['create_date']) ?></td>
            <td>
                    
<form action="updateNewUser.php" method="GET">
        <input type="hidden" name="userId" value="<?=htmlentities($user['id']) ?>">
        <input type="submit" value="Uppdatera">
</form>

<form action="" method="POST">
    <input type="hidden" name="userId" value="<?=htmlentities($user['id']) ?>">
    <input type="submit" name="deleteUserBtn" value="Radera">
</form>
</td>
                        
</tr>
    <?php endforeach; ?>
</tbody>
</table>

<!--     <?php include('layout/byline.html'); ?>   -->          

        <hr>
    </article>
</div>



<?php include('layout/footer.php') ?>