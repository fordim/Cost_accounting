<?php

require_once ('inc/functions.php');

$content = renderTemplate('itemMain.php');

echo renderTemplate('layout.php', ['title' => 'Cost accounting', 'cssStyle' => "../css/main.css", 'content' => $content]);


