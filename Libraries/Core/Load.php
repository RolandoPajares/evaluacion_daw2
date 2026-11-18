<?php

// Localiza el controlador y ejecuta el metodo solicitado.
$controllerFile = 'Controllers/' . $controller . 'Controller.php';

if (file_exists($controllerFile)) {
    require_once($controllerFile);
    $controllerClass = $controller . 'Controller';
    $controllerObject = new $controllerClass();

    if (method_exists($controllerObject, $method)) {
        call_user_func_array([$controllerObject, $method], $params);
    } else {
        require_once('Controllers/ErrorController.php');
        $error = new ErrorController();
        $error->error404();
    }
} else {
    require_once('Controllers/ErrorController.php');
    $error = new ErrorController();
    $error->error404();
}

