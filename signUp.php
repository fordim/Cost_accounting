<?php

require_once('inc/functions.php');

$content = renderTemplate('itemSignUp.php');

echo renderTemplate('layout.php', ['title' => 'Sign Up', 'cssStyle' => '../css/signUp.css', 'jsStyle' => '../js/signUp.js', 'content' => $content]);