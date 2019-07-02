<?php

require_once('inc/functions.php');

$content = renderTemplate('itemCabinet.php');

echo renderTemplate('layout.php', ['title' => 'Cabinet', 'cssStyle' => '../css/cabinet.css', 'jsStyle' => '../js/cabinet.js', 'content' => $content]);
