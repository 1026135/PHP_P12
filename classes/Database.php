<?php
require_once 'config/config.php';

abstract class Database 
{
    protected $pdo;

    public function __construct() 
    {
        try 
        {
            $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8mb4";
            $this->pdo = new PDO($dsn, DB_USER, DB_PASS);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } 
        catch (PDOException $error) 
        {
            echo "Database connection failed: " . $error->getMessage();
            exit;
        }
    }
}
?>
