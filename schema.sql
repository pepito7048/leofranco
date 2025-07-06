CREATE DATABASE IF NOT EXISTS leofranco;
USE leofranco;

CREATE TABLE users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  email VARCHAR(100) NOT NULL,
  password VARCHAR(100) NOT NULL,
  role ENUM('user','admin') DEFAULT 'user'
);

CREATE TABLE products (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100) NOT NULL,
  description TEXT,
  price DECIMAL(10,2),
  image VARCHAR(100)
);

CREATE TABLE orders (
  id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT,
  total DECIMAL(10,2),
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE order_items (
  id INT AUTO_INCREMENT PRIMARY KEY,
  order_id INT,
  product_id INT,
  quantity INT
);

INSERT INTO users (email, password, role) VALUES ('admin@leofranco.com', 'admin123', 'admin');