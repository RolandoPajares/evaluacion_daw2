<?php

require_once('Config/Config.php');
require_once('Helpers/Helpers.php');

// Front Controller: todas las solicitudes llegan primero aqui.
$url = $_GET['url'] ?? 'Home';
$arrUrl = explode('/', trim($url, '/'));

$controller = !empty($arrUrl[0]) ? ucfirst(strtolower($arrUrl[0])) : 'Home';
$method = $arrUrl[1] ?? 'index';
$params = [];

if (!empty($arrUrl[2])) {
    $params = array_slice($arrUrl, 2);
}

require_once('Libraries/Core/Autoload.php');
require_once('Libraries/Core/Load.php');

