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



-- Insert some default roles
INSERT IGNORE INTO roles (role_name) VALUES ('user'), ('admin');


-- Insert dummy users
INSERT INTO users (name, email, password, role_id) VALUES
('Alice Admin', 'alice.admin@example.com', '$2y$10$OQZ0NV1DEUSFw.CZr7O/1OwLW0mXoZRGGJ1vV7xN2X9cOMtQbINxO', 2),  -- password123, role: admin
('Bob User', 'bob.user@example.com', '$2y$10$OQZ0NV1DEUSFw.CZr7O/1OwLW0mXoZRGGJ1vV7xN2X9cOMtQbINxO', 1),    -- password123, role: user
('Carol User', 'carol.user@example.com', '$2y$10$OQZ0NV1DEUSFw.CZr7O/1OwLW0mXoZRGGJ1vV7xN2X9cOMtQbINxO', 1);   -- password123, role: user
