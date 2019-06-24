<?php

require_once('inc/functions.php');

$content = renderTemplate('itemHistory.php');

echo renderTemplate('layout.php', ['title' => 'History', 'cssStyle' => '../css/history.css', 'content' => $content]);

//echo renderTemplate('layout.php', ['title' => 'History', 'cssStyle' => '../css/history.css', 'jsStyle' => '../js/history.js', 'content' => $content]);