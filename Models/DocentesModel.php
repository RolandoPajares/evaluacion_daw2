<?php

class DocentesModel extends Model
{
    protected string $table = 'docente';

    public function activos(): array
    {
        return $this->select(
                'docente.id, docente.id_facultad, facultad.nombre AS facultad, '
                . 'docente.dni, docente.apellidos, docente.nombres, docente.correo, '
                . 'docente.categoria, docente.dedicacion'
            )
            ->join('facultad', 'facultad.id = docente.id_facultad')
            ->where(['docente.estado = :estado'], ['estado' => 1])
            ->orderBy('docente.apellidos')
            ->get();
    }
    

    public function findDetalle(int $id): ?array
    {
        return $this->select(
                'docente.id, docente.id_facultad, facultad.nombre AS facultad, '
                . 'docente.dni, docente.apellidos, docente.nombres, docente.correo, '
                . 'docente.categoria, docente.dedicacion'
            )
            ->join('facultad', 'facultad.id = docente.id_facultad')
            ->where(['docente.id = :id'], ['id' => $id])
            ->first();
    }
}

