DROP DATABASE IF EXISTS accounting;
CREATE DATABASE accounting;

use accounting;

CREATE TABLE users
(
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(255) UNIQUE NOT NULL,
    name VARCHAR(50) NOT NULL,
    password_hash CHAR(60) NOT NULL,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME NULL DEFAULT NULL,
    deleted_at DATETIME NULL DEFAULT NULL
);

CREATE TABLE categories
(
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) UNIQUE NOT NULL
);

CREATE TABLE history
(
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    category_id INT NOT NULL,
    amount FLOAT NOT NULL,
    comment TEXT,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME NULL DEFAULT NULL,
    deleted_at DATETIME NULL DEFAULT NULL,
    FOREIGN KEY (user_id)  REFERENCES users (id) ON DELETE RESTRICT ON UPDATE RESTRICT,
    FOREIGN KEY (category_id)  REFERENCES categories (id)
);

CREATE TABLE history_cashing
(
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    name VARCHAR(50) NOT NULL,
    amount FLOAT NOT NULL,
    card VARCHAR(50) NOT NULL,
    percent FLOAT NOT NULL,
    profit FLOAT NOT NULL,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME NULL DEFAULT NULL,
    deleted_at DATETIME NULL DEFAULT NULL,
    FOREIGN KEY (user_id)  REFERENCES users (id) ON DELETE RESTRICT ON UPDATE RESTRICT
);

CREATE TABLE history_operations
(
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    month TIMESTAMP NOT NULL,
    teor_sum  FLOAT NOT NULL,
    deposit FLOAT NOT NULL,
    expense FLOAT NOT NULL,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME NULL DEFAULT NULL,
    deleted_at DATETIME NULL DEFAULT NULL,
    FOREIGN KEY (user_id)  REFERENCES users (id) ON DELETE RESTRICT ON UPDATE RESTRICT
);