<?php

abstract class Database 
{
    protected $pdo;

    public function __construct($host, $dbname, $username, $password) 
    {
        try 
        {
            $this->pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } 
        catch (PDOException $e) 
        {
            echo "Database connection failed: " . $e->getMessage();
            exit;
        }
    }
}

?>

<?php
$servername =   "localhost";
$username   =   "root";
$password   =   "";
$dbname     =   "???";

try{
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    //echo "Connected succesfully ";
}
catch (PDOException $e){
    echo "conection failed: " . $e->getMessage();
}
?>
