<?php

if (isset($_POST)) {
    print("<br>Name: " . $_POST['name']);
    print("<br>Email: " . $_POST['email']);
    print("<br>Password: " . $_POST['password']);
}

if (isset($_POST)) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $passwordHash = password_hash('$password', PASSWORD_DEFAULT);

    $putDataToFile = fopen('temp.txt', 'a+'); // Открываем файл
    fwrite($putDataToFile, "\r\n" . "Name пользователя: " . $name . PHP_EOL); // Записываем данные
    fwrite($putDataToFile, "Email пользователя: " . $email . "\r\n"); // Записываем данные
    fwrite($putDataToFile, "Password пользователя: " . $passwordHash . PHP_EOL); // Записываем данные
    fclose($putDataToFile);
}

//echo "<br/>Имя: ". $_POST['name'];
//echo "<br/>Email: ". $_POST['email'];
//echo "<br/>Password: ". $_POST['password'];