<?php
require_once 'database.php';
require_once 'function.php';

session_start();

$erreur = '';
$validation = '';

define("URL", "http://localhost/KONEXIO/php/TP/");

define("RACINE_SITE", $_SERVER['DOCUMENT_ROOT'] . "/KONEXIO/php/TP/");
