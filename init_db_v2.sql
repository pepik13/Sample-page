-- init_db_v2.sql - full schema with categories and sample data
DROP DATABASE IF EXISTS electro_shop;
CREATE DATABASE electro_shop CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE electro_shop;

CREATE TABLE users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100) NOT NULL,
  email VARCHAR(255) NOT NULL UNIQUE,
  password_hash VARCHAR(255) NOT NULL,
  is_admin TINYINT(1) NOT NULL DEFAULT 0,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE products (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(200) NOT NULL,
  description TEXT,
  price DECIMAL(10,2) NOT NULL DEFAULT 0,
  image VARCHAR(255) NOT NULL,
  category VARCHAR(60) NOT NULL DEFAULT 'Accessories',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE orders (
  id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT NULL,
  total_amount DECIMAL(10,2) NOT NULL DEFAULT 0,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL
);

CREATE TABLE order_items (
  id INT AUTO_INCREMENT PRIMARY KEY,
  order_id INT NOT NULL,
  product_id INT NOT NULL,
  quantity INT NOT NULL,
  unit_price DECIMAL(10,2) NOT NULL,
  FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE CASCADE,
  FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE
);

-- Admin user: admin@shop.test / admin123 (hash poniżej)
INSERT INTO users (name, email, password_hash, is_admin) VALUES
('Admin', 'admin@shop.test', '$2y$10$wS2wK00VsH0cEsyq4YbTQOXPpFKg1RThb4bFQd1P1z1w9QJw6gZpG', 1);

INSERT INTO products (name, description, price, image, category) VALUES
('Smartphone X', 'Fast, bright, and reliable smartphone.', 499.00, 'phone.jpg', 'Accessories'),
('Laptop Pro 14', 'Slim laptop for work and study.', 999.00, 'laptop.jpg', 'Laptops'),
('Wireless Headphones', 'Over-ear headphones with noise cancellation.', 149.00, 'headphones.jpg', 'Accessories'),
('Smartwatch Active', 'Track your health and notifications.', 199.00, 'watch.jpg', 'Watches'),
('Tablet Air 11', 'Lightweight tablet for everyday use.', 329.00, 'tablet.jpg', 'Tablets');

-- upgrade_v2.sql - upgrade existing v1 DB to add category column
USE electro_shop;
ALTER TABLE products ADD COLUMN IF NOT EXISTS category VARCHAR(60) NOT NULL DEFAULT 'Accessories';
UPDATE products SET category='Accessories' WHERE category IS NULL OR category='';
INSERT INTO products (name, description, price, image, category)
SELECT 'Tablet Air 11','Lightweight tablet for everyday use.',329.00,'tablet.jpg','Tablets'
WHERE NOT EXISTS (SELECT 1 FROM products WHERE name='Tablet Air 11');
INSERT INTO users (name, email, password_hash, is_admin)
SELECT 'Admin','admin@shop.test','$2y$10$wS2wK00VsH0cEsyq4YbTQOXPpFKg1RThb4bFQd1P1z1w9QJw6gZpG',1
WHERE NOT EXISTS (SELECT 1 FROM users WHERE email='admin@shop.test');
