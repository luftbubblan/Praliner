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
                    $message = '<div class="">E-mail is already taked, please use another e-mail.</div>';
                    return $message;
                } else {
                    throw new \PDOException($e->getMessage(), (int) $e->getCode());
                }
            }
        }
    }

    function updateName($message, $firstName, $lastName, $sessionId) {
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
            $stmt->bindParam(':id', $sessionId);
            $stmt->execute();

            $message = '<div class="">Name has been updated.</div>';
            return $message;
        }
    }

    function updateEmail($message, $email, $sessionId) {
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
                $stmt->bindParam(':id', $sessionId);
                $stmt->execute();

                $message = '<div class="">E-mail has been updated.</div>';
                return $message;
            } catch (\PDOException $e) {
                if ((int) $e->getCode() === 23000) {
                    $message = '<div class="">E-mail is already taked, please use another e-mail.</div>';
                    return $message;
                } else {
                    throw new \PDOException($e->getMessage(), (int) $e->getCode());
                }
            } 
        }
    }

    function updatePassword($message, $newpassword, $sessionId) {
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
            $stmt->bindParam(':id', $sessionId);
            $stmt->execute();
            
            $message = '<div class="">Password has been updated.</div>';
            return $message;
        }
    }

    function updateInformation($message, $phone, $street, $postalCode, $city, $country, $sessionId) {
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
            $stmt->bindParam(':id', $sessionId);
            $stmt->execute();

            $message = '<div class=""> Information has been updated.</div>';
            return $message;
        }
    }

    function fetchUserById($sessionId) {
        $sql = "
            SELECT * FROM users
            WHERE id = :id
        ";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':id', $sessionId);
        $stmt->execute();
        return $stmt->fetch();
    }

    function fetchPasswordById($sessionId) {
        $sql = "
            SELECT password FROM users
            WHERE id = :id
        ";

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':id', $sessionId);
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

    function addNewUser($firstName, $lastName, $email,$password, $phone, $street, $postalCode, $city, $country) {
        $sql = "
            INSERT INTO users (first_name, last_name, email, password, phone, street, postal_code, city, country)
            VALUES (:first_name, :last_name, :email, :password, :phone, :street, :postal_code, :city, :country)
        ";
        $encryptedPassword = password_hash($password, PASSWORD_BCRYPT, ['cost' => 12]);
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
    }
}




$crudFunctions = new CRUDFunctions($pdo);

?>