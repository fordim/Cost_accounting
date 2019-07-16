CREATE DATABASE accounting;

use accounting;

CREATE TABLE users
(
    id INT AUTO_INCREMENT,
    email VARCHAR(50) UNIQUE CHECK(Email !=''),
    name VARCHAR(30),
    password VARCHAR(100),
    created_at DATETIME,
    updated_at DATETIME,
    deleted_at DATETIME,
    PRIMARY KEY (Id)
);

CREATE TABLE categories
(
    id INT AUTO_INCREMENT,
    name VARCHAR(30),
    PRIMARY KEY (Id)
);

CREATE TABLE history
(
    id INT AUTO_INCREMENT,
    user_id INT,
    category_id INT,
    sum FLOAT CHECK(sum !=''),
    comment VARCHAR(100),
    created_at DATETIME,
    updated_at DATETIME,
    deleted_at DATETIME,
    PRIMARY KEY (Id),
    FOREIGN KEY (user_id)  REFERENCES users (id),
    FOREIGN KEY (category_id)  REFERENCES categories (id)
);


# Изменяем тип столбца
ALTER TABLE history MODIFY created_at DATETIME;

# Добавляем Primary Key в существующую таблицу
ALTER TABLE categories add PRIMARY KEY (id);

# Добавляем FOREIGN Key в существующую таблицу
ALTER TABLE history add FOREIGN KEY (user_id) REFERENCES users (id);

# Добавляем строки в таблицу user
INSERT users(email, name, password, created_at, updated_at)
VALUES ('test@mail.ru', 'Jack', '$2y$10$8cGDnK4bvKq0X65fC/m1duQtA6NuMBf5az3mvzaXARBqhNLJ21aoG', '2019-07-16 10:10:15', '2019-07-16 20:15:15');

# Добавляем строки в таблицу categories
INSERT users(name)
VALUES ('Строительные материалы');

# Добавляем строки в таблицу history
INSERT history(user_id, category_id, sum, comment, created_at, updated_at)
VALUES (1, 1, 500.48, 'Test comment, Test','2019-07-16 10:10:15', '2019-07-16 20:15:15');