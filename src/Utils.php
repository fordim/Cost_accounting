<?php

namespace App;

use Psr\Http\Message\ResponseInterface as Response;

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

    public static function renderNavBarCabinet(): string
    {
        return Utils::renderTemplate(
            'navbarCabinet.php',
            [
                'mainRoute' => Settings::ROUTE_MAIN_PAGE,
                'cabinetRoute' => Settings::ROUTE_CABINET,
                'historyRoute' => Settings::ROUTE_HISTORY,
                'categoryRoute' => Settings::ROUTE_CATEGORY,
                'userName' => Database::getInstance()->getUserName(Session::getInstance()->getUserId()),
                'logoutRoute' => Settings::ROUTE_LOGOUT
            ]
        );
    }

    public static function renderNavBarMain(): string
    {
        return Utils::renderTemplate(
            'navbarMain.php',
            [
                'mainRoute' => Settings::ROUTE_MAIN_PAGE,
                'signUpPageRoute' => Settings::ROUTE_SIGN_UP,
                'signInRoute' => Settings::ROUTE_SIGN_IN
            ]
        );
    }

    public static function redirect(Response $response, string $url): Response
    {
        return $response
            ->withHeader('Location', $url)
            ->withStatus(302);
    }
}
