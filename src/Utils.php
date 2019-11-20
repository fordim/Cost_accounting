<?php

namespace App;

final class Utils
{
    private const DATE_FORMAT = 'Y-m-d';

    public static function renderTemplate(string $name, array $data = []): string
    {
        $name = '../src/templates/' . $name;
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

    public static function getCurrentDate(): string
    {
        return date(self::DATE_FORMAT);
    }

    public static function getDateOfLastMonth(): string
    {
        return date(self::DATE_FORMAT, strtotime("last Month"));
    }

    public static function getFirstDateOfThisMonth(): string
    {
        return date(self::DATE_FORMAT, strtotime("first day of this month"));
    }

    public static function getFirstDateOfLastMonth(): string
    {
        return date(self::DATE_FORMAT, strtotime("first day of last month"));
    }

    public static function getLastDateOfLastMonth(): string
    {
        return date(self::DATE_FORMAT, strtotime("last day of last month"));
    }

    public static function downloadAllHistory(int $userId){
        $arrayForCSV = Database::getInstance()->getUserExpensesAll($userId);
        array_unshift($arrayForCSV, ["Created_at", "Amount", "Comment", "Category"]);
        self::createAndDownloadCSV($arrayForCSV);
    }

    public static function createAndDownloadCSV($arrayForCSV) {
        $tmpFile = tempnam('../temp/', 'CSV');

        $file = fopen($tmpFile, 'w');
        foreach ($arrayForCSV as $fields){
            fputs($file, chr(0xEF) . chr(0xBB) . chr(0xBF)); // BOM (Byte Order Mark) - кодировка, что-бы понимало русский язык.
            fputcsv($file, array_values($fields), ';', ' ');
        }
        fclose($file);

        $fileNewFormat = basename($tmpFile, ".tmp").".csv";
        $newPathToFile = "../temp/$fileNewFormat";
        rename($tmpFile, $newPathToFile);

        self::fileForceDownload($newPathToFile);
    }

    public static function fileForceDownload($file) {
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
}
