#Получить всех пользователей с таблице users
SELECT id, email, name FROM users;

#Получить все данный по пользователю с таблицы users
SELECT id, email, name, password_hash, created_at, updated_at, deleted_at FROM users WHERE id = 1;

#Получить все категории с таблице categories;
SELECT id, name FROM categories;

#Получить определенную категорию с таблицы categories
SELECT id, name FROM categories WHERE id = 1;

#Записывае новых пользователей в таблицу users
INSERT INTO users (email, name, password_hash)
VALUES ('test@mail.ru', 'Admin', '$2y$10$EywimCX5CqbWtZd168f5GePKBWKTcG0a4WDVoIjNnNoiurF8IX9Ai'),
       ('testOne@mail.ru', 'One', '$2y$10$FYQ2ue9Fy1/VyrTVmUWi1u6Y6Jh9JdtsO8XxpujpSHhEI2BsgffTy'),
       ('testTwo@mail.ru', 'Two', '$2y$10$9XOYfaEfNMZF22X7wCo5nevC8CHv1WAU3bbUws.R2qwFAkJ0mlSnG'),
       ('testThree@mail.ru', 'Three', '$2y$10$HgYsmI48zfaPKM49K3/6n.0w.Sbz1/OeUF2L72hRzKJyxmjXvR/z6'),
       ('testFour@mail.ru', 'Four', '$2y$10$bD7vaTGecu0hVwM1Nk40H.cfqC1c1PvWtPLu.8eONmf.eO665jO4K'),
       ('testFive@mail.ru', 'Five', '$2y$10$fZVAzUTkx9t5yb3tdyaJ4.DZkjhmY78bfsxc.5lX1UNcUXf5He1yW'),
       ('testSix@mail.ru', 'Six', '$2y$10$T3VaBrBullgtAqQCF.wF7.s8Wu7t2A9alcdwkPcqUD/fuFHoTzyPi'),
       ('testSeven@mail.ru', 'Seven', '$2y$10$fq85qm4IswJ3Yh2Fh8Hqp.RjPCCuNLRXvMmMTlWbwlbDu5GKOhxDG'),
       ('testEight@mail.ru', 'Eight', '$2y$10$VCugsJoPlt9GaWrIq4jMYuRkPYo226OhOhbNKu5OFUuVH04zvInxK'),
       ('testNine@mail.ru', 'Nine', '$2y$10$G7JtXA3H44AO/EmgD2JUleVNIHcxyaBAksbHA9fZ553OzIf1hFkGC');

#Записываем новые категории в таблицу categories
INSERT INTO categories(name)
VALUE ('Продукты питания'),
      ('Товары для дома'),
      ('Отдых'),
      ('Развлечения'),
      ('Строительные материалы');

#Записываем новые данные в таблицу history
INSERT INTO history(user_id, category_id, amount, comment)
VALUES (1, 1, 600, 'Milk, meat, bread'),
       (1, 2, 200, 'Soap, bucket, broom'),
       (1, 3, 200, 'Movie'),
       (2, 1, 300, 'Milk, meat, bread: Two'),
       (2, 3, 500, 'Movie : Two'),
       (3, 4, 555, 'Football : Three'),
       (3, 4, 530, 'Basketball : Three'),
       (4, 4, 200.48, 'Football : Four'),
       (4, 5, 1500, 'Sand : Four'),
       (5, 5, 52000, 'Land : Five');

#Ищем пользользователя по email и заменяем ему email в БД
UPDATE users
SET email = 'testnew@mail.ru'
WHERE email = 'test@mail.ru';

#Запрос на изменение названии категории
UPDATE categories
SET name = 'Новая категория'
WHERE id = 1;

#Получить всю иторию (Join user and categories)
SELECT u.name, c.name, h.amount, h.comment, h.created_at, h.updated_at, h.deleted_at

FROM history AS h
JOIN users AS u ON h.user_id = u.id
JOIN categories AS c ON h.category_id = c.id
ORDER BY u.name;

