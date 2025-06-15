<?php
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
            // error_log($error->getMessage()); // /xampp/apache/logs/error.log
            echo "Database connection failed: " . $error->getMessage(); // Vervang met error_log() voor actuele situatie

            setFlash("Er is een technisch probleem. Probeer het later opnieuw.", "error"); // optioneel, als sessie beschikbaar is
            redirect("Location: error.php");
            exit;
        }
    }
}
?>
