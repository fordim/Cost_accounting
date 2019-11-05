<?php

CONST DATE_FORMAT = 'Y-m-d';

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

function getCurrentDate(): string{
    return date(DATE_FORMAT);
}

function getDateOfLastMonth(): string {
    return date(DATE_FORMAT, strtotime("last Month"));
}
