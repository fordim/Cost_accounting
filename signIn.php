<?php

require_once('inc/functions.php');

$content = renderTemplate('itemSignIn.php');

echo renderTemplate('layout.php', ['title' => 'Sign In', 'cssStyle' => '../css/signIn.css', 'content' => $content]);