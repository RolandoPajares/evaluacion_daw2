<?php

class FacultadesController extends Controller
{
    public function index(): void
    {
        $this->listar();
    }

    public function listar(): void
    {
        $this->views->render($this, 'listar', [
            'facultades' => $this->model->activas()
        ]);
    }

    public function crear(): void
    {
        $this->views->render($this, 'formulario', [
            'facultad' => ['nombre' => '', 'abreviatura' => ''],
            'action' => 'facultades/guardar',
            'title' => 'Registrar facultad'
        ]);
    }

    public function guardar(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            redirect('facultades');
        }

        $data = $this->datosFormulario();
        if ($data === null) {
            $this->views->render($this, 'formulario', [
                'facultad' => $_POST,
                'action' => 'facultades/guardar',
                'title' => 'Registrar facultad',
                'error' => 'El nombre y la abreviatura son obligatorios.'
            ]);
            return;
        }

        $this->model->insert($data);
        redirect('facultades');
    }

    public function editar($id): void
    {
        $facultad = $this->model->find((int) $id);
        if (!$facultad) {
            require_once('Controllers/ErrorController.php');
            (new ErrorController())->error404();
            return;
        }

        $this->views->render($this, 'formulario', [
            'facultad' => $facultad,
            'action' => 'facultades/actualizar/' . (int) $id,
            'title' => 'Editar facultad'
        ]);
    }

    public function actualizar($id): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            redirect('facultades');
        }

        $data = $this->datosFormulario();
        if ($data !== null) {
            $this->model->update((int) $id, $data);
        }
        redirect('facultades');
    }

    public function eliminar($id): void
    {
        // Eliminacion logica: el registro permanece, pero deja de estar activo.
        $this->model->update((int) $id, ['estado' => 0]);
        redirect('facultades');
    }

    private function datosFormulario(): ?array
    {
        $nombre = trim($_POST['nombre'] ?? '');
        $abreviatura = trim($_POST['abreviatura'] ?? '');

        if ($nombre === '' || $abreviatura === '') {
            return null;
        }

        return [
            'nombre' => $nombre,
            'abreviatura' => $abreviatura,
            'estado' => 1
        ];
    }
}

