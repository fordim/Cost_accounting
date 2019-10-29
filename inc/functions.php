<?php
//Это модель
//Нет Обращения к $_ (глобальные $_GET, $_POST)
//Нет HTML code
//Нет echo, die, print
//Нет session_start(), глобальные $link
//require_once 'init.php'; - это нельзя

function renderTemplate(string $name, array $data = []): string
{
    $name = 'templates/' . $name;
    $result = '';
    if (!is_readable($name)) {
        return $result;
    }
    ob_start();
    extract($data);
    require $name;
    $result = ob_get_clean();
    return $result;
}

function processFormSignIn($link, string $email, string $password){
    $email = requestVerification($link, $email);
    $sql = "SELECT * FROM users AS u WHERE u.email = '$email'";

    $users = fetchData($link, $sql);
    if (count($users) === 1){
        $user = $users[0];
        $password_hash = $user['password_hash'];
        if (password_verify($password, $password_hash)){
            $_SESSION['user'] = [
                'id' => (int)$user['id'],
                'email' => $user['email']
            ];
            return;
        }
    }
    die ("Пользователя не существует в базе или введен не верный логин/пароль. </br>Повторите попытку.");
}

function insertData($link, string $sql): int {
    $result = mysqli_query($link, $sql) or die ("Ошибка, при попытке сделать запись в БД </br>" . mysqli_error($link));
    return mysqli_insert_id($link);
}

function requestVerification($link, $a){
    return htmlentities(mysqli_real_escape_string($link, $a));
}

function processFormSignUp($link, string $name, string $email, string $passwordUser){
    $name = requestVerification($link, $name);
    $email = requestVerification($link, $email);
    $passwordUser = requestVerification($link, $passwordUser);
    $passwordHash = password_hash($passwordUser, PASSWORD_DEFAULT);

    $sql =   "INSERT INTO users (email, name, password_hash)
                VALUES ('$email', '$name', '$passwordHash')";

    insertData($link, $sql);
    $user = findUserByEmail($link, $email);
    $_SESSION['user'] = [
        'id' => (int)$user['id'],
        'email' => $user['email']
    ];
}

function findUserByEmail($link, $email){
    $sql = "SELECT id FROM users WHERE users.email = '$email'";
    $users = fetchData($link, $sql);
    return count($users) === 1 ? (int)$users[0]['id'] : null;
}

function processFormAddExpense($link, float $sum, string $comment, int $categoryId, $userId){
    $sum = requestVerification($link, $sum);
    $comment = requestVerification($link, $comment);

    $sql =   "INSERT INTO history(user_id, category_id, amount, comment)
                VALUES ($userId, $categoryId, $sum, '$comment')";

    insertData($link, $sql);
}

function fetchData($link, string $sql): array {
    $result = mysqli_query($link, $sql) or die("Ошибка " . mysqli_error($link));
    return mysqli_fetch_all($result, MYSQLI_ASSOC);
}

function getActualTime(){
    return $actualMonth = date('Y-m-d');
}

function getPreviousMonth(){
    return $previousMonth = date('Y-m-d', strtotime("last Month"));
}

function getUserExpenses($link, int $userId, string $dateFrom, string $dateTo): array {
    $sql =    "SELECT h.created_at, h.amount,  h.comment, c.name as category
                FROM history AS h
                JOIN users AS u ON h.user_id = u.id
                JOIN categories AS c ON h.category_id = c.id
                WHERE u.id = $userId AND DATE(h.created_at) BETWEEN '$dateFrom' AND '$dateTo'
                ORDER BY h.created_at";

    return fetchData($link, $sql);
}

function getUserExpensesAll($link, int $userId) : array {
    $sql =    "SELECT h.created_at, h.amount,  h.comment, c.name as category
                FROM history AS h
                JOIN users AS u ON h.user_id = u.id
                JOIN categories AS c ON h.category_id = c.id
                WHERE u.id = $userId
                ORDER BY h.created_at";

    return fetchData($link, $sql);
}

//function formatDateTime(DateTime $dateTime): string {
//    return $dateTime->format('Y-m-d');
//}

function getAllCategories($link): array {
    $sql = "SELECT id, name FROM categories ORDER BY id";
    return fetchData($link, $sql);
}

function processFormAddCategory($link, string $newCategory){
    $newCategory = requestVerification($link, $newCategory);

    $sql =   "INSERT INTO categories(name)
                VALUES ('$newCategory')";

    insertData($link, $sql);
}

function processFormChangeCategory($link, int $categoryId, string $newCategory){
    $newCategory = requestVerification($link, $newCategory);

    $sql = "UPDATE categories
            SET name = '$newCategory'
            WHERE id = $categoryId";

    insertData($link, $sql);
}

function processFormDeleteCategory($link, int $categoryId){
    $sql = "DELETE FROM categories
            WHERE id = $categoryId";

    insertData($link, $sql);
}

function downloadAllHistory($link, int $userId){
    $arrayForCSV = getUserExpensesAll($link, $userId);
    array_unshift($arrayForCSV, ["Created_at", "Amount", "Comment", "Category"]);
    create_csv_file($arrayForCSV);
    file_force_download('temp/test.csv');
}

//function create_csv_file(array $arrayForCSV, $file = 'temp/test.csv', string $col_delimiter = ';', string $row_delimiter = "\r\n"){
//    if( ! is_array($arrayForCSV))
//        return false;
//
//    if($file && ! is_dir(dirname($file)))
//        return false;
//
//    $CSV_str = '';
//
//    foreach($arrayForCSV as $row ){
//        $cols = array();
//
//        foreach($row as $col_val){
//            // строки должны быть в кавычках ""
//            // кавычки " внутри строк нужно предварить такой же кавычкой "
//            if( $col_val && preg_match('/[",;\r\n]/', $col_val) ){
//                // поправим перенос строки
//                if( $row_delimiter === "\r\n" ){
//                    $col_val = str_replace( "\r\n", '\n', $col_val );
//                    $col_val = str_replace( "\r", '', $col_val );
//                }
//                elseif( $row_delimiter === "\n" ){
//                    $col_val = str_replace( "\n", '\r', $col_val );
//                    $col_val = str_replace( "\r\r", '\r', $col_val );
//                }
//                $col_val = str_replace( '"', '""', $col_val ); // предваряем "
//                $col_val = '"'. $col_val .'"'; // обрамляем в "
//            }
//            $cols[] = $col_val; // добавляем колонку в данные
//        }
//        $CSV_str .= implode( $col_delimiter, $cols ) . $row_delimiter; // добавляем строку в данные
//    }
//    $CSV_str = rtrim( $CSV_str, $row_delimiter );
//    // задаем кодировку windows-1251 для строки
//    if( $file ){
//        $CSV_str = iconv( "UTF-8", "cp1251",  $CSV_str );
//        // создаем csv файл и записываем в него строку
//        $done = file_put_contents( $file, $CSV_str );
//
//        return $done ? $CSV_str : false;
//    }
//    return $CSV_str;
//}

function create_csv_file($arrayForCSV) {
    $file = fopen('temp/test.csv', 'w');

    foreach ($arrayForCSV as $fields){
        fputs($file, chr(0xEF) . chr(0xBB) . chr(0xBF)); // BOM (Byte Order Mark) - кодировка, что-бы понимало русский язык.
        fputcsv($file, array_values($fields), ';', ' ');
    }

    fclose($file);
}

function file_force_download($file) {
    if (file_exists($file)) {
        if (ob_get_level()) {
            ob_end_clean();
        }
        // заставляем браузер показать окно сохранения файла
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename=' . basename($file));
        header('Content-Transfer-Encoding: binary');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($file));
        // читаем файл и отправляем его пользователю
        readfile($file);
        exit;
    }
}
