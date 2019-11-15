<?php

function downloadAllHistory($link, int $userId){
    $arrayForCSV = getUserExpensesAll($link, $userId);
    array_unshift($arrayForCSV, ["Created_at", "Amount", "Comment", "Category"]);
    createAndDownloadCSV($arrayForCSV);
}

function createAndDownloadCSV($arrayForCSV) {
    $tmpFile = tempnam('temp/', 'CSV');

    $file = fopen($tmpFile, 'w');
    foreach ($arrayForCSV as $fields){
        fputs($file, chr(0xEF) . chr(0xBB) . chr(0xBF)); // BOM (Byte Order Mark) - кодировка, что-бы понимало русский язык.
        fputcsv($file, array_values($fields), ';', ' ');
    }
    fclose($file);

    $fileNewFormat = basename($tmpFile, ".tmp").".csv";
    $newPathToFile = "temp/$fileNewFormat";
    rename($tmpFile, $newPathToFile);

    fileForceDownload($newPathToFile);
}

function fileForceDownload($file) {
    if (!file_exists($file)){
        return;
    } else {
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
        unlink($file);
        exit;
    }
}
