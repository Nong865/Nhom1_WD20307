-- Schema for tour_management (MySQL)
CREATE DATABASE IF NOT EXISTS tour_management CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE tour_management;

DROP TABLE IF EXISTS bookings;
DROP TABLE IF EXISTS tours;
DROP TABLE IF EXISTS users;
DROP TABLE IF EXISTS roles;

CREATE TABLE roles (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) NOT NULL
);

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role_id INT DEFAULT 2,
    full_name VARCHAR(200),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (role_id) REFERENCES roles(id)
);

CREATE TABLE tours (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    price DECIMAL(12,2) NOT NULL DEFAULT 0,
    description TEXT,
    start_date DATE DEFAULT NULL,
    end_date DATE DEFAULT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE bookings (
    id INT AUTO_INCREMENT PRIMARY KEY,
    tour_id INT NOT NULL,
    user_id INT NOT NULL,
    seats INT DEFAULT 1,
    total_price DECIMAL(12,2),
    status VARCHAR(50) DEFAULT 'booked',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (tour_id) REFERENCES tours(id),
    FOREIGN KEY (user_id) REFERENCES users(id)
);
