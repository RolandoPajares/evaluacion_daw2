<?php

/**
 * ORM basico propio de la aplicacion.
 *
 * Las clases de Models heredan de esta clase para consultar su tabla sin
 * repetir las operaciones CRUD. Los nombres de tabla y columna deben ser
 * definidos por el desarrollador; los valores se envian mediante parametros
 * PDO para evitar inyecciones SQL.
 */
class Model extends Conexion
{
    protected string $table = '';
    protected string $primaryKey = 'id';

    // Estado temporal del Query Builder.
    protected string $select = '*';
    protected array $joins = [];
    protected array $whereBuilder = [];
    protected array $bindings = [];
    protected string $orderBy = '';
    protected string $limit = '';

    /** ORM: devuelve todos los registros de la tabla del modelo. */
    public function all(): array
    {
        $sql = "SELECT * FROM {$this->table}";
        return $this->execute($sql)->fetchAll();
    }

    /** ORM: devuelve un registro por su clave primaria. */
    public function find(int $id): ?array
    {
        $sql = "SELECT * FROM {$this->table} WHERE {$this->primaryKey} = :id";
        $statement = $this->execute($sql, ['id' => $id]);
        $result = $statement->fetch();
        return $result ?: null;
    }

    /** ORM: crea un registro a partir de un arreglo columna => valor. */
    public function insert(array $data): string|false
    {
        $columns = implode(', ', array_keys($data));
        $placeholders = ':' . implode(', :', array_keys($data));
        $sql = "INSERT INTO {$this->table} ({$columns}) VALUES ({$placeholders})";

        if ($this->execute($sql, $data)->rowCount() > 0) {
            return (string) $this->connect()->lastInsertId();
        }

        return false;
    }

    /** ORM: actualiza un registro por su clave primaria. */
    public function update(int $id, array $data): bool
    {
        $setClause = [];
        foreach (array_keys($data) as $column) {
            $setClause[] = "{$column} = :{$column}";
        }

        $data['__primary_key'] = $id;
        $sql = "UPDATE {$this->table} SET " . implode(', ', $setClause);
        $sql .= " WHERE {$this->primaryKey} = :__primary_key";
        $this->execute($sql, $data);
        return true;
    }

    /** ORM: elimina un registro por su clave primaria. */
    public function delete(int $id): bool
    {
        $sql = "DELETE FROM {$this->table} WHERE {$this->primaryKey} = :id";
        $this->execute($sql, ['id' => $id]);
        return true;
    }

    /** Query Builder: define las columnas del SELECT. */
    public function select(string $fields): self
    {
        $this->select = $fields;
        return $this;
    }

    /**
     * Query Builder: agrega condiciones SQL y sus valores enlazados.
     * Ejemplo: ->where(['estado = :estado'], ['estado' => 1]).
     */
    public function where(array|string $conditions, array $bindings = []): self
    {
        $this->whereBuilder = array_merge($this->whereBuilder, (array) $conditions);
        $this->bindings = array_merge($this->bindings, $bindings);
        return $this;
    }

    /** Query Builder: agrega un JOIN definido por el desarrollador. */
    public function join(string $table, string $condition, string $type = 'INNER'): self
    {
        $type = strtoupper($type);
        $type = in_array($type, ['INNER', 'LEFT', 'RIGHT'], true) ? $type : 'INNER';
        $this->joins[] = "{$type} JOIN {$table} ON {$condition}";
        return $this;
    }

    /** Query Builder: agrega el ordenamiento. El campo debe ser definido por el desarrollador. */
    public function orderBy(string $field, string $direction = 'ASC'): self
    {
        $direction = strtoupper($direction) === 'DESC' ? 'DESC' : 'ASC';
        $this->orderBy = "ORDER BY {$field} {$direction}";
        return $this;
    }

    /** Query Builder: limita la cantidad de resultados. */
    public function limit(int $limit): self
    {
        $this->limit = 'LIMIT ' . max(0, $limit);
        return $this;
    }

    /** Query Builder: arma y ejecuta la consulta configurada. */
    public function get(): array
    {
        $sql = "SELECT {$this->select} FROM {$this->table}";

        if ($this->joins) {
            $sql .= ' ' . implode(' ', $this->joins);
        }
        if ($this->whereBuilder) {
            $sql .= ' WHERE ' . implode(' AND ', $this->whereBuilder);
        }
        if ($this->orderBy) {
            $sql .= ' ' . $this->orderBy;
        }
        if ($this->limit) {
            $sql .= ' ' . $this->limit;
        }

        $result = $this->execute($sql, $this->bindings)->fetchAll();
        $this->resetQuery();
        return $result;
    }

    /** Query Builder: devuelve el primer registro o null. */
    public function first(): ?array
    {
        $this->limit(1);
        $result = $this->get();
        return $result[0] ?? null;
    }

    /** Limpia el estado del Query Builder para la siguiente consulta. */
    public function resetQuery(): void
    {
        $this->select = '*';
        $this->joins = [];
        $this->whereBuilder = [];
        $this->bindings = [];
        $this->orderBy = '';
        $this->limit = '';
    }

    /** Ejecuta SQL con parametros preparados por PDO. */
    private function execute(string $sql, array $bindings = []): PDOStatement
    {
        $statement = $this->connect()->prepare($sql);
        foreach ($bindings as $key => $value) {
            $parameter = is_string($key) && $key[0] === ':' ? $key : ':' . $key;
            $statement->bindValue($parameter, $value);
        }
        $statement->execute();
        return $statement;
    }
}

