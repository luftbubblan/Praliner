<?php

class CRUDFunctions {
    function __construct($pdo) {
        $this->pdo = $pdo;
    }

    function registerUser($message, $firstName, $lastName, $email, $password, $phone, $street, $postalCode, $city, $country) {
        if (empty($message)) {
            $encryptedPassword = encryptPassword($password);

            try {
                $sql = "
                    INSERT INTO users (
                        first_name,
                        last_name,
                        email,
                        password,
                        phone,
                        street,
                        postal_code,
                        city,
                        country)
                    VALUES (
                        :firstName,
                        :lastName,
                        :email,
                        :encryptedPassword,
                        :phone,
                        :street,
                        :postalCode,
                        :city,
                        :country)
                    ";
            
                $stmt = $this->pdo->prepare($sql);
                $stmt->bindParam(':firstName', $firstName);
                $stmt->bindParam(':lastName', $lastName);
                $stmt->bindParam(':email', $email);
                $stmt->bindParam(':encryptedPassword', $encryptedPassword);
                $stmt->bindParam(':phone', $phone);
                $stmt->bindParam(':street', $street);
                $stmt->bindParam(':postalCode', $postalCode);
                $stmt->bindParam(':city', $city);
                $stmt->bindParam(':country', $country);
                $stmt->execute();

                $sql = "
                    SELECT id FROM users
                    WHERE email = :email
                ";

                $stmt = $this->pdo->prepare($sql);
                $stmt->bindParam(':email', $email);
                $stmt->execute();
                $user = $stmt->fetch();

                setLoginSession($user['id']);

                header('Location: myPage.php');
                exit;
            } catch (\PDOException $e) {
                if ((int) $e->getCode() === 23000) {
                    $message = errorEmailtaken();
                    return $message;
                } else {
                    throw new \PDOException($e->getMessage(), (int) $e->getCode());
                }
            }
        }
    }

    function updateName($message, $firstName, $lastName, $id) {
        if (empty($message)) {
            $sql = "
                UPDATE users
                SET
                    first_name = :firstName,
                    last_name = :lastName
                WHERE id = :id
            ";
            
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':firstName', $firstName);
            $stmt->bindParam(':lastName', $lastName);
            $stmt->bindParam(':id', $id);
            $stmt->execute();

            $message = successMessage("Namnet har uppdaterats.");
            return $message;
        }
    }

    function updateEmail($message, $email, $id) {
        if (empty($message)) {
            try {
                $sql = "
                    UPDATE users
                    SET
                        email = :email
                    WHERE id = :id
                ";
            
                $stmt = $this->pdo->prepare($sql);
                $stmt->bindParam(':email', $email);
                $stmt->bindParam(':id', $id);
                $stmt->execute();

                $message = successMessage("Emailadressen har uppdaterats.");
                return $message;
            } catch (\PDOException $e) {
                if ((int) $e->getCode() === 23000) {
                    $message = errorEmailtaken();
                    return $message;
                } else {
                    throw new \PDOException($e->getMessage(), (int) $e->getCode());
                }
            } 
        }
    }

    function updatePassword($message, $newpassword, $id) {
        if (empty($message)) {
            $encryptedPassword = encryptPassword($newpassword);

            $sql = "
                UPDATE users
                SET
                    password = :password
                WHERE id = :id
            ";
        
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(":password", $encryptedPassword);
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            
            $message = successMessage("Lösenordet har uppdaterats.");
            return $message;
        }
    }

    function updateInformation($message, $phone, $street, $postalCode, $city, $country, $id) {
        if (empty($message)) {
            $sql = "
                UPDATE users
                SET
                    phone = :phone,
                    street = :street,
                    postal_code = :postal_code,
                    city = :city,
                    country = :country
                WHERE id = :id
            ";
            
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':phone', $phone);
            $stmt->bindParam(':street', $street);
            $stmt->bindParam(':postal_code', $postalCode);
            $stmt->bindParam(':city', $city);
            $stmt->bindParam(':country', $country);
            $stmt->bindParam(':id', $id);
            $stmt->execute();

            $message = successMessage("Informationen har uppdaterats.");
            return $message;
        }
    }

    function fetchUserById($id) {        
        $sql = "
            SELECT * FROM users
            WHERE id = :id
        ";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch();
    }

    function deleteUserById($id) {
        $sql = "
            DELETE FROM users 
            WHERE id = :id;
        ";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
    }

    function fetchPasswordById($id) {
        $sql = "
            SELECT password FROM users
            WHERE id = :id
        ";

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch();
    }

    function fetchPasswordAndIdByEmail($email) {
        $sql = "
            SELECT id, password FROM users
            WHERE email = :email
        ";

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        return $stmt->fetch();
    }

    function fetchAllProductsDESC() {
		$stmt = $this->pdo->query("
            SELECT * 
            FROM products 
            ORDER BY id DESC
        ");
        return $stmt->fetchAll();
	}

    function fetchProductById($id) {
        $sql = "
            SELECT * 
            FROM products 
            WHERE id = :id
        ";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(":id", $id);
        $stmt->execute();
        return $stmt->fetch();
    }

    function addNewProduct($message, $title, $flavour, $description, $price, $stock) {
        if(!is_uploaded_file($_FILES['img_url']['tmp_name'])) {
			$message .= errorMessage("Must choose an image.");
            return $message;
		} else {
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
                $message .= errorMessage("Filtyp ej tillåten. Välj JPEG, PNG eller GIF.");
                return $message;
            } 
            
            if ($_FILES['img_url']['size'] > 10000000) {  // Allows files under 10 mbyte
                $message .= errorMessage("Bilden är för stor. Högst 10 MB.");
                return $message;
            }

            if (empty($message)) {
                move_uploaded_file($fileTempPath, $newFilePath);
                $imgUrl = $path . $fileName;

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
            
                $stmt = $this->pdo->prepare($sql);
                $stmt->bindParam(':title', $title);
                $stmt->bindParam(':flavour', $flavour);
                $stmt->bindParam(':description', $description);
                $stmt->bindParam(':price', $price);
                $stmt->bindParam(':stock', $stock);
                $stmt->bindParam(':img_url', $imgUrl);
                $stmt->execute();
                header('Location: index.php?added');
                exit;
            }
        }
    }

    function fetchAllUsers() {
		$stmt = $this->pdo->query("
            SELECT * FROM users;
        ");
        return $stmt->fetchAll();
	}
 
    function addNewUser($firstName, $lastName, $email,$password, $phone, $street, $postalCode, $city, $country, $message) {
        if (empty($message)) {
            try {
                $sql = "
                    INSERT INTO users (
                        first_name,
                        last_name,
                        email, password,
                        phone, street,
                        postal_code,
                        city,
                        country)
                    VALUES (
                        :first_name,
                        :last_name,
                        :email,
                        :password,
                        :phone,
                        :street,
                        :postal_code,
                        :city,
                        :country)
                ";

                $encryptedPassword = encryptPassword($password);
                $stmt = $this->pdo->prepare($sql);
                $stmt->bindParam(':first_name', $firstName);
                $stmt->bindParam(':last_name', $lastName);
                $stmt->bindParam(':email', $email);
                $stmt->bindParam(':password', $encryptedPassword);
                $stmt->bindParam(':phone', $phone);
                $stmt->bindParam(':street', $street);
                $stmt->bindParam(':postal_code', $postalCode);
                $stmt->bindParam(':city', $city);
                $stmt->bindParam(':country', $country);
                $stmt->execute();

                header('Location:users.php?created');
                exit;

            } catch (\PDOException $e) {
                if ((int) $e->getCode() === 23000) {
                    $message = errorEmailtaken();
                    return $message;
                } else {
                    throw new \PDOException($e->getMessage(), (int) $e->getCode());
                }
            } 
        }    
    }

    function updateUser($firstName, $lastName, $email, $password, $phone, $street, $postalCode, $city, $country, $message, $id) {
        if (empty($message)) {
            try {
                $sql = "
                    UPDATE users
                    SET 
                        first_name = :first_name,
                        last_name = :last_name,
                        email = :email,
                        password = :password,
                        phone = :phone,
                        street = :street,
                        postal_code = :postal_code,
                        city = :city,
                        country = :country
                    WHERE id = :id
                ";

                $stmt = $this->pdo->prepare($sql);

                if(strlen($password) == 60 && str_starts_with($password, '$2y$12$')) {
                    $stmt->bindParam(':password', $password);
                } else {
                    $encryptedPassword = encryptPassword($password);
                    $stmt->bindParam(':password', $encryptedPassword);
                }

                $stmt->bindParam(':id', $id);
                $stmt->bindParam(':first_name', $firstName);
                $stmt->bindParam(':last_name', $lastName);
                $stmt->bindParam(':email', $email);
                $stmt->bindParam(':phone', $phone);
                $stmt->bindParam(':street', $street);
                $stmt->bindParam(':postal_code', $postalCode);
                $stmt->bindParam(':city', $city);
                $stmt->bindParam(':country', $country);
                $stmt->execute(); 

                header('Location:users.php?updated');
                exit;

            } catch (\PDOException $e) {
                if ((int) $e->getCode() === 23000) {
                    $message = errorEmailtaken();
                    return $message;
                
                } else {
                    throw new \PDOException($e->getMessage(), (int) $e->getCode());
                }
            } 
        }
    }

    function updateProduct($message, $title, $flavour, $description, $price, $stock, $id) {
        if (empty($message)) {
            $sql = "
                UPDATE products
                SET
                    title = :title,
                    flavour = :flavour,
                    description = :description,
                    price = :price,
                    stock = :stock
                WHERE id = :id
            ";
            
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(":title", $title);
            $stmt->bindParam(":flavour", $flavour);
            $stmt->bindParam(":description", $description);
            $stmt->bindParam(":price", $price);
            $stmt->bindParam(":stock", $stock);
            $stmt->bindParam(":id", $id);
            $stmt->execute();
            header('Location: index.php?updated');
            exit;
        }
    }

    function deleteProduct($id) {
        $sql = "
            DELETE FROM products
            WHERE id = :id
        ";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(":id", $id);
        $stmt->execute();
        header('Location: index.php?deleted');
        exit;
    }

    function createOrder($message, $userId, $guest, $fullName, $email, $phone, $street, $postalCode, $city, $country) {
        if(empty($message)) {
            $sql = "
                INSERT INTO orders (
                    user_id,
                    total_price,
                    guest,
                    billing_full_name,
                    email,
                    phone,
                    billing_street,
                    billing_postal_code,
                    billing_city,
                    billing_country)
                VALUES (
                    :user_id,
                    :total_price,
                    :guest,
                    :billing_full_name,
                    :email,
                    :phone,
                    :billing_street,
                    :billing_postal_code,
                    :billing_city,
                    :billing_country)
            ";
                
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':user_id', $userId);
            $stmt->bindParam(':total_price', $_POST['totalSum']);
            $stmt->bindParam(':guest', $guest);
            $stmt->bindParam(':billing_full_name', $fullName);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':phone', $phone);
            $stmt->bindParam(':billing_street', $street);
            $stmt->bindParam(':billing_postal_code', $postalCode);
            $stmt->bindParam(':billing_city', $city);
            $stmt->bindParam(':billing_country', $country);
            $stmt->execute();
            $orderId = $this->pdo->lastInsertId();

            foreach($_SESSION['cartItems'] as $item) {
                $sql = "
                    INSERT INTO order_items (
                        order_id,
                        product_id,
                        product_title,
                        quantity,
                        unit_price)
                    VALUES (
                        :order_id,
                        :product_id,
                        :product_title,
                        :quantity,
                        :unit_price)
                "; 
                $stmt = $this->pdo->prepare($sql);
                $stmt->bindParam(':order_id', $orderId);
                $stmt->bindParam(':product_id', $item['id']);
                $stmt->bindParam(':product_title', $item['title']);
                $stmt->bindParam(':quantity', $item['quantity']);
                $stmt->bindParam(':unit_price', $item['price']);
                $stmt->execute();
            }

            $_SESSION['orderId'] = $orderId;
            header('Location: order-confirmation.php');
            exit;
        } else {
            header('Location: checkout.php?message=' . $message);
            exit;
        }
    }
}

$crudFunctions = new CRUDFunctions($pdo);

?>