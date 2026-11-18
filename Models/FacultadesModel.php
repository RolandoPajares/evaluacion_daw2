<?php

class FacultadesModel extends Model
{
    protected string $table = 'facultad';

    public function activas(): array
    {
        return $this->select('id, nombre, abreviatura')
            ->where(['estado = :estado'], ['estado' => 1])
            ->orderBy('nombre')
            ->get();
    }

    public function findActiva(int $id): ?array
    {
        return $this->select('id, nombre, abreviatura')
            ->where(['id = :id', 'estado = :estado'], ['id' => $id, 'estado' => 1])
            ->first();
    }
}

