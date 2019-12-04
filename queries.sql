#Записывае новых пользователей в таблицу users
INSERT INTO users (email, name, password_hash)
VALUES ('test@mail.ru', 'Admin', '$2y$10$EywimCX5CqbWtZd168f5GePKBWKTcG0a4WDVoIjNnNoiurF8IX9Ai'),
       ('testOne@mail.ru', 'One', '$2y$10$FYQ2ue9Fy1/VyrTVmUWi1u6Y6Jh9JdtsO8XxpujpSHhEI2BsgffTy'),
       ('testTwo@mail.ru', 'Two', '$2y$10$9XOYfaEfNMZF22X7wCo5nevC8CHv1WAU3bbUws.R2qwFAkJ0mlSnG'),
       ('testThree@mail.ru', 'Three', '$2y$10$HgYsmI48zfaPKM49K3/6n.0w.Sbz1/OeUF2L72hRzKJyxmjXvR/z6');

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
       (2, 1, 300, 'Milk, meat, bread: One'),
       (2, 3, 500, 'Movie : One'),
       (3, 4, 555, 'Football : Two'),
       (3, 4, 530, 'Basketball : Two'),
       (4, 4, 200.48, 'Football : Three');

#Записываем новые данные в таблицу history_cashing
INSERT INTO history_cashing(user_id, name, amount, card, percent, profit)
VALUE  (1, 'Настя', 50000, 'СберБанк : 4111 1111 1111 1111', 2, 1000),
       (1, 'Марго', 35000, 'СберБанк : 4111 1111 1111 1111', 2.5, 875),
       (1, 'Кристина', 95000, 'СберБанк : 4111 1111 1111 1111', 2, 1900),
       (1, 'Влад', 15000, 'СберБанк : 4111 1111 1111 1111', 2, 300),
       (1, 'Марина', 67500, 'СберБанк : 4111 1111 1111 1111', 2, 1350);

#Записываем новые данные в таблицу history_operations
INSERT INTO history_operations(user_id, month, balance, profit, deposit, expense, teor_sum, real_sum)
VALUE  (1, '2019-10-01 00:00:00', 350000, 25000, 30000, 10000, 395000, 395000),
       (1, '2019-11-01 00:00:00', 395000, 15000, 30000, 10000, 435000, 440000);

