<?php

class HomeController extends Controller
{
    public function index(): void
    {
        $this->views->render($this, 'index', [
            'title' => 'Gestión de Facultades y Docentes',
            'message' => 'Módulo desarrollado con PHP nativo, MVC, PDO y ORM propio.'
        ]);
    }
}

