-- Create the database (if not exists)
CREATE DATABASE IF NOT EXISTS user_crud CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

-- Use the database
USE user_crud;



-- Create roles table
CREATE TABLE IF NOT EXISTS roles (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    role_name VARCHAR(50) NOT NULL UNIQUE
);

-- Create users table
CREATE TABLE IF NOT EXISTS users (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role_id INT UNSIGNED NOT NULL DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (role_id) REFERENCES roles(id) ON DELETE RESTRICT ON UPDATE CASCADE
);

-- Create products table
CREATE TABLE IF NOT EXISTS products (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    user_id INT UNSIGNED NOT NULL,
    description TEXT,
    price DECIMAL(10, 2) NOT NULL,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE RESTRICT ON UPDATE CASCADE
);


-- Insert some default roles
INSERT IGNORE INTO roles (role_name) VALUES ('user'), ('admin');


-- Insert dummy users
INSERT INTO users (name, email, password, role_id) VALUES
('Alice Admin', 'alice.admin@example.com', '$2y$10$OQZ0NV1DEUSFw.CZr7O/1OwLW0mXoZRGGJ1vV7xN2X9cOMtQbINxO', 2),  -- password123, role: admin
('Bob User', 'bob.user@example.com', '$2y$10$OQZ0NV1DEUSFw.CZr7O/1OwLW0mXoZRGGJ1vV7xN2X9cOMtQbINxO', 1),    -- password123, role: user
('Carol User', 'carol.user@example.com', '$2y$10$OQZ0NV1DEUSFw.CZr7O/1OwLW0mXoZRGGJ1vV7xN2X9cOMtQbINxO', 1);   -- password123, role: user


-- Insert dummy products
INSERT INTO products (name, user_id, description, price) VALUES 
('Wireless Mouse', 1, 'A smooth and responsive wireless mouse', 19.99),
('Gaming Keyboard', 2, 'Mechanical RGB backlit gaming keyboard', 49.95),
('USB-C Hub', 1, 'Multi-port USB-C hub with HDMI and USB 3.0', 29.50),
('Noise Cancelling Headphones', 3, 'Over-ear headphones with ANC technology', 89.99),
('4K Monitor', 2, '27-inch 4K UHD monitor with HDR support', 239.00);
