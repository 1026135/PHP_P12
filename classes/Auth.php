<?php
require_once 'Database.php';

class Auth extends Database
{

    public function __construct()
    {
        parent::__construct();
    }
    
    // Login methods //
    public function login($email, $password)
    {
        $sql = "
            SELECT u.id, u.name, u.email, u.password, r.role_name 
            FROM users u 
            JOIN roles r ON u.role_id = r.id 
            WHERE email = :email
        ";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            ':email' => $email
        ]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
    
        if ($user && password_verify($password, $user['password'])) {
            session_regenerate_id(true);
            $_SESSION['user'] = [
                'id'        => $user['id'],
                'name'      => $user['name'],
                'email'     => $user['email'],
                'role'      => $user['role_name'],
            ];
            return true;
        }
        return false;
    }

    public function logout()
    {
        unset($_SESSION['user']);
        session_destroy();
        return true;
    }
    // Login methods //


    // Get data methods//
    public function getUser() 
    {
        if (!$this->isLoggedIn()) {
            return null;
        }

        $sql = "
            SELECT u.id, u.name, u.email, r.role_name 
            FROM users u 
            JOIN roles r ON u.role_id = r.id 
            WHERE u.id = :id
        ";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':id' => $_SESSION['user']['id']]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            $_SESSION['user'] = [
                'id'    => $user['id'],
                'name'  => $user['name'],
                'email' => $user['email'],
                'role'  => $user['role_name'],
            ];
        }

        return $_SESSION['user'];
    }
    // Get data methods//

    // Check data methods //
    public function isLoggedIn()
    {
        return isset($_SESSION['user']);
    }

    public function isAdmin()
    {
        return $this->isLoggedIn() && $_SESSION['user']['role'] === 'admin';
    }
    // Check data methods //
}

