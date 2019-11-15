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
}
