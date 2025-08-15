-- --------------------------------------------------------
-- Database: electro_shop
-- --------------------------------------------------------

DROP DATABASE IF EXISTS electro_shop;
CREATE DATABASE electro_shop CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE electro_shop;

-- --------------------------------------------------------
-- Table: users
-- --------------------------------------------------------
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role ENUM('customer','admin') DEFAULT 'customer',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- Admin account (password: admin123)
INSERT INTO users (name, email, password, role) VALUES
('Admin User', 'admin@shop.test', MD5('admin123'), 'admin');

-- --------------------------------------------------------
-- Table: products
-- --------------------------------------------------------
CREATE TABLE products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    description TEXT,
    price DECIMAL(10,2) NOT NULL,
    category ENUM('Laptops','Tablets','Watches','Accessories') NOT NULL,
    image VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- Example products
INSERT INTO products (name, description, price, category, image) VALUES
('HP Pavilion Laptop', 'Powerful laptop for work and play.', 699.99, 'Laptops', 'laptop.jpg'),
('Apple iPad 10th Gen', 'Latest iPad with 10.9-inch display.', 499.99, 'Tablets', 'tablet.jpg'),
('Samsung Galaxy Watch 5', 'Smartwatch with fitness tracking.', 199.99, 'Watches', 'watch.jpg'),
('Sony WH-1000XM4 Headphones', 'Noise cancelling headphones.', 299.99, 'Accessories', 'headphones.jpg');

-- --------------------------------------------------------
-- Table: orders
-- --------------------------------------------------------
CREATE TABLE orders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    total DECIMAL(10,2) NOT NULL,
    status ENUM('Pending','Processing','Shipped','Completed','Cancelled') DEFAULT 'Pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB;

-- --------------------------------------------------------
-- Table: order_items
-- --------------------------------------------------------
CREATE TABLE order_items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    order_id INT NOT NULL,
    product_id INT NOT NULL,
    quantity INT NOT NULL,
    price DECIMAL(10,2) NOT NULL,
    FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE CASCADE,
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE
) ENGINE=InnoDB;
