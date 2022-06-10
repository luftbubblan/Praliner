<?php

class CRUDFunctions {
    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function registerUser($firstName, $lastName, $email, $encryptedPassword, $phone, $street, $postalCode, $city, $country) {
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

    public function updateName($firstName, $lastName, $sessionId) {
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

    public function updateEmail($email, $sessionId) {
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

    public function updatePassword($encryptedPassword, $sessionId) {
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

    public function updateInformation($phone, $street, $postalCode, $city, $country, $sessionId) {
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

    public function fetchUserById($sessionId) {
        $sql = "
            SELECT * FROM users
            WHERE id = :id
        ";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':id', $sessionId);
        $stmt->execute();
        return $stmt->fetch();
    }
}

$crudFunctions = new CRUDFunctions($pdo);

?>