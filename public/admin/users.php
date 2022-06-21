<?php
	$pageTitle = "users";

	require('../../src/config.php');
	require('../../src/app/common_functions.php');
	require('../../src/app/CRUD_functions.php');

	// echo "<pre>";
    // print_r($_GET);
    // echo "</pre>";

    if (isset($_GET['updated'])) {
        $message .= successMessage("User successfully updated.");
    }

    if (isset($_GET['created'])) {
        $message .= successMessage("User successfully created.");
    }

    if (isset($_GET['deleted'])) {
        $message .= successMessage("User successfully deleted.");
    }

    if (isset($_POST['deleteUserBtn'])) {
        $crudFunctions->deleteUserById($_POST['userId']);
        header('Location: users.php?deleted');
    } 
  
    $users = $crudFunctions->fetchAllUsers();
    
    include('layout/header.php'); 
?>

   
<div id="content">
    <article class="border">
        <h1>Hantera användare</h1>

         <?=$message ?> 

        <form action="addNewUser.php">
            <input type="submit" value="Ny användare">
        </form>
        <br>

        <?php if($users) { ?>
        <table id="users-tbl">
            <thead>
                <tr>
                    <th>id</th>
                    <th>First_name</th>
                    <th>Last_name</th>
                    <th>email</th>
                    <th>Phone</th>
                    <th>Street</th>
                    <th>Postal_code</th>
                    <th>City</th>
                    <th>Country</th>
                    <th>Date</th>

                </tr>
            </thead>
            <tbody>
                <?php foreach($users as $user) { ?>
                <tr>
                    <td><?=htmlentities($user['id']) ?></td>
                    <td><?=htmlentities($user['first_name']) ?></td>
                    <td><?=htmlentities($user['last_name']) ?></td>
                    <td><?=htmlentities($user['email']) ?></td>
                    <td><?=htmlentities($user['phone']) ?></td>
                    <td><?=htmlentities($user['street']) ?></td>
                    <td><?=htmlentities($user['postal_code']) ?></td>
                    <td><?=htmlentities($user['city']) ?></td>
                    <td><?=htmlentities($user['country']) ?></td>
                    <td><?=htmlentities($user['create_date']) ?></td>

                    <td>           
                        <form action="updateUser.php" method="GET">
                            <input type="hidden" name="userId" value="<?=htmlentities($user['id']) ?>">
                            <input type="submit" value="Uppdatera">
                        </form>

                        <form action="" method="POST">
                            <input type="hidden" name="userId" value="<?=htmlentities($user['id']) ?>">
                            <input type="submit" name="deleteUserBtn" value="Radera">
                        </form>
                    </td>                  
                </tr>
                <?php } ?>
            </tbody>
        </table>
        <?php } ?>
    </article>
</div>

<?php include('layout/footer.php') ?>