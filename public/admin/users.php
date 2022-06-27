<?php
	$pageTitle = "Användare admin";

	require('../../src/config.php');
	require('../../src/app/common_functions.php');
	require('../../src/app/CRUD_functions.php');

	$message = "";

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

   
<div class="content-products">
    <h2>Admin</h2>
    <h4>Hantera användare</h4>

         <?=$message ?> 

        <form action="addNewUser.php">
            <input class="add-new-btn btn btn-success" id="addNewUserBtn" type="submit" value="Lägg till ny användare">
        </form>
        <br>

        <?php if($users) { ?>
        <table id="admin-tbl">
            <thead>
                <tr id="lista">
                    <th>Förnamn</th>
                    <th>Efternamn</th>
                    <th>Email</th>
                    <th>Telefon</th>
                    <th>Adress</th>
                    <th>Postnummer</th>
                    <th>Ort</th>
                    <th>Land</th>
                    <th>Datum</th>
                    <th></th>

                </tr>
            </thead>
   
            <tbody>
            
                <?php foreach($users as $user) { ?>
                <tr>
                    <td><?=htmlentities($user['first_name']) ?></td>
                    <td><?=htmlentities($user['last_name']) ?></td>
                    <td><?=htmlentities($user['email']) ?></td>
                    <td><?=htmlentities($user['phone']) ?></td>
                    <td><?=htmlentities($user['street']) ?></td>
                    <td><?=htmlentities($user['postal_code']) ?></td>
                    <td><?=htmlentities($user['city']) ?></td>
                    <td><?=htmlentities($user['country']) ?></td>
                    <td><?=htmlentities($user['create_date']) ?></td>

                    <td class="table-btns">           
                        <form action="updateUser.php" method="GET">
                            <input type="hidden" name="userId" value="<?=htmlentities($user['id']) ?>">
                            <input class="btn btn-success" id="update-btn" type="submit" value="Uppdatera">
                        </form>

                        <form action="" method="POST">
                            <input type="hidden" name="userId" value="<?=htmlentities($user['id']) ?>">
                            <input class="btn btn-danger" type="submit" name="deleteUserBtn" value="Radera">
                        </form>
                    </td>                 
                </tr>
                <?php } ?>
            </tbody>
        </table>
        <?php } ?>
</div>

<?php include('layout/footer.php') ?>