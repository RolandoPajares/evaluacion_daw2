<?php

class Views
{
    public function render($controller, $view, $data = [])
    {
        $controllerName = str_replace('Controller', '', get_class($controller));
        $viewPath = "Views/{$controllerName}/{$view}.php";

        if (!file_exists($viewPath)) {
            require_once('Controllers/ErrorController.php');
            $error = new ErrorController();
            $error->error404();
            return;
        }

        if (!empty($data)) {
            extract($data);
        }
        require_once($viewPath);
    }
}

