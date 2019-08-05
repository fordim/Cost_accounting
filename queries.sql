#Получить всех пользователей с таблице users
SELECT id, email, name FROM users;

#Получить все данный по пользователю с таблицы users
SELECT * FROM users WHERE id = 1;

#Получить все категории с таблице categories;
SELECT id, name FROM categories;

#Получить определенную категорию с таблицы categories
SELECT * FROM categories WHERE id = 1;

#Записывае данные по одному пользоваетлю в таблицу users
INSERT INTO users (email, name, password_hash)
VALUES ('test@mail.ru', 'Jack', '$2y$10$8cGDnK4bvKq0X65fC/m1duQtA6NuMBf5az3mvzaXARBqhNLJ21aoG');

#Записываем новую категорию в таблицу categories
INSERT INTO categories(name)
VALUE ('Строительные материалы');

#Записываем новую строку в таблицу history
INSERT INTO history(user_id, category_id, amount, comment)
VALUES (1, 1, 500.48, 'Test comment, Test');

#Ищем пользользователя по email и заменяем ему email в БД
UPDATE users
SET email = 'testnew@mail.ru'
WHERE  email = 'test@mail.ru';

#Запрос на изменение названии категории
UPDATE categories
SET name = 'New name'
WHERE name = 'Строительные материалы';

#Получить всю иторию (Join user and categories)
SELECT u.name, c.name, h.ammount, h.created_at, h.updated_at, h.deleted_at
FROM history AS h
JOIN users AS u ON h.user_id = u.id
JOIN categories AS c ON h.category_id = c.id
ORDER BY u.name;

