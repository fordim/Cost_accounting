<?php

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
