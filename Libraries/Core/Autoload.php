<?php

/**
 * Carga automaticamente las clases del nucleo, igual que en el proyecto de clase.
 */
spl_autoload_register(function ($className) {
    $filePath = __DIR__ . '/' . $className . '.php';
    if (file_exists($filePath)) {
        require_once($filePath);
    }
});

