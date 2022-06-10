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
                $message .= '
                    <div class="">
                        E-mail is already taked, please use another e-mail.
                    </div>
                ';
            } else {
                throw new \PDOException($e->getMessage(), (int) $e->getCode());
            }
        }
    }
}

$crudFunctions = new CRUDFunctions($pdo);

?>