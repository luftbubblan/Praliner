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

                $_SESSION['id'] = $user['id'];

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

            $message = successMessage("Name has been updated.");
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

                $message = successMessage("E-mail has been updated.");
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
            
            $message = successMessage("Password has been updated.");
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

            $message = successMessage("Information has been updated.");
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

    function addNewProduct($message, $title, $flavour, $description, $price, $stock, $imgUrl) {
        if (empty($message)) {
            try {
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

            }  catch (\PDOException $e) {
                if ((int) $e->getCode() === 23000) {
                    $message = errorEmailtaken();
                    return $message;
                } else {
                    throw new \PDOException($e->getMessage(), (int) $e->getCode());
                }
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

                header('Location:users.php');
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
}

$crudFunctions = new CRUDFunctions($pdo);

?>