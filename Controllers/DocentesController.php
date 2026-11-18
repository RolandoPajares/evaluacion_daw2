<?php

class DocentesController extends Controller
{
    private array $categorias = ['AUXILIAR', 'ASOCIADO', 'PRINCIPAL'];
    private array $dedicaciones = [
        'DEDICACION EXCLUSIVA-DE',
        'TIEMPO COMPLETO-TC',
        'TIEMPO PARCIAL-TP'
    ];

    public function index(): void
    {
        $this->listar();
    }

    public function listar(): void
    {
        $this->views->render($this, 'listar', [
            'docentes' => $this->model->activos()
        ]);
    }

    public function crear(): void
    {
        $this->views->render($this, 'formulario', $this->datosVistaFormulario());
    }

    public function guardar(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            redirect('docentes');
        }

        $data = $this->datosFormulario();
        if ($data === null) {
            $vista = $this->datosVistaFormulario($_POST);
            $vista['error'] = 'Complete los campos y seleccione valores válidos.';
            $this->views->render($this, 'formulario', $vista);
            return;
        }

        $this->model->insert($data);
        redirect('docentes');
    }

    public function editar($id): void
    {
        $docente = $this->model->findDetalle((int) $id);
        if (!$docente) {
            require_once('Controllers/ErrorController.php');
            (new ErrorController())->error404();
            return;
        }

        $this->views->render($this, 'formulario', $this->datosVistaFormulario(
            $docente,
            'docentes/actualizar/' . (int) $id,
            'Editar docente'
        ));
    }

    public function actualizar($id): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            redirect('docentes');
        }

        $data = $this->datosFormulario();
        if ($data !== null) {
            $this->model->update((int) $id, $data);
        }
        redirect('docentes');
    }

    public function eliminar($id): void
    {
        // Eliminacion logica: estado 0 excluye al docente del listado activo.
        $this->model->update((int) $id, ['estado' => 0]);
        redirect('docentes');
    }

    private function datosVistaFormulario(array $data = [], string $action = 'docentes/guardar', string $title = 'Registrar docente'): array
    {
        require_once('Models/FacultadesModel.php');
        $facultadesModel = new FacultadesModel();
        return [
            'docente' => $data,
            'facultades' => $facultadesModel->activas(),
            'categorias' => $this->categorias,
            'dedicaciones' => $this->dedicaciones,
            'action' => $action,
            'title' => $title
        ];
    }

    private function datosFormulario(): ?array
    {
        $idFacultad = (int) ($_POST['id_facultad'] ?? 0);
        $categoria = $_POST['categoria'] ?? '';
        $dedicacion = $_POST['dedicacion'] ?? '';
        $data = [
            'id_facultad' => $idFacultad,
            'dni' => trim($_POST['dni'] ?? ''),
            'apellidos' => trim($_POST['apellidos'] ?? ''),
            'nombres' => trim($_POST['nombres'] ?? ''),
            'correo' => trim($_POST['correo'] ?? ''),
            'categoria' => $categoria,
            'dedicacion' => $dedicacion,
            'estado' => 1
        ];

        require_once('Models/FacultadesModel.php');
        $facultad = (new FacultadesModel())->findActiva($idFacultad);
        $valido = $facultad && $data['dni'] !== '' && strlen($data['dni']) === 8
            && $data['apellidos'] !== '' && $data['nombres'] !== ''
            && filter_var($data['correo'], FILTER_VALIDATE_EMAIL)
            && in_array($categoria, $this->categorias, true)
            && in_array($dedicacion, $this->dedicaciones, true);

        return $valido ? $data : null;
    }
}
