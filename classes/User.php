<?php
require_once 'Database.php';

class User extends Database
{

    public function __construct()
    {
        parent::__construct();
    }

    public function addUser($name, $email, $password, $role_id = 1)
{
    $sql = "
        INSERT INTO users (name, email, password, role_id) 
        VALUES (:name, :email, :password, :role_id)
        ";
    $stmt = $this->pdo->prepare($sql);
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    $stmt->execute([
        ':name' => $name,
        ':email' => $email,
        ':password' => $hashedPassword,
        ':role_id' => $role_id
    ]);
    return $this->pdo->lastInsertId();
}


    public function getAllUsers()
    {
        $sql = "
            SELECT u.id, u.name, u.email, r.role_name 
            FROM users u 
            JOIN roles r ON u.role_id = r.id
            ";
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getUserById($id)
    {
        $sql = "
            SELECT u.id, u.name, u.email, r.role_name 
            FROM users u 
            JOIN roles r ON u.role_id = r.id 
            WHERE u.id = :id
            ";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function updateUser($id, $name, $email)
    {
        $sql = "
            UPDATE users 
            SET name = :name, email = :email WHERE id = :id
            ";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            ':name' => $name,
            ':email' => $email,
            ':id' => $id
        ]);
    }

    public function deleteUser($id)
    {
        $sql = "DELETE FROM users WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([':id' => $id]);
    }

    public function emailExists($email)
    {
        $sql = "
            SELECT COUNT(*) 
            FROM users WHERE email = :email
            ";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':email' => $email]);
        return $stmt->fetchColumn() > 0;
    }
}
?>


