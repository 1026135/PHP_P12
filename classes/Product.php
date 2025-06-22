<?php
require_once 'Database.php';

class Product extends Database
{

    // Get data methods //
    public function getAllProducts()
    {
        $sql = "
            SELECT * 
            FROM products
        ";
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getProductByUserId($user_id)
    {
        $sql = "
            SELECT * 
            FROM products 
            WHERE user_id = :user_id
        ";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            'user_id' => $user_id
        ]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getProductById($id)
    {
        $sql = "
            SELECT * 
            FROM products 
            WHERE id = :id
        ";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            'id' => $id
        ]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    // Get data methods //

    // Change data methods //
    public function addProduct($data)
    {
        $sql = "
            INSERT INTO products (name, user_id, description, price)
            VALUES (:name, :user_id, :description, :price)
        ";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            'name'          => $data['name'],
            'user_id'       => $data['user_id'],
            'description'   => $data['description'],
            'price'         => $data['price']
        ]);

        return $this->pdo->lastInsertId();
    }

    public function updateProduct($id, $data)
    {
        $sql = "
            UPDATE products
            SET name = :name,
                user_id = :user_id,
                description = :description,
                price = :price
            WHERE id = :id
        ";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            'id'            => $id,
            'name'          => $data['name'],
            'user_id'       => $data['user_id'],
            'description'   => $data['description'],
            'price'         => $data['price']
        ]);
    }

    public function deleteProduct($id)
    {
        $sql = "
            DELETE FROM products 
            WHERE id = :id
        ";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            'id' => $id
        ]);
    }
    // Change data methods //
}
?>
