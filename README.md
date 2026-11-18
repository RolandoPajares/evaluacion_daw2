# Evaluación de Desempeño - Facultades y Docentes

Aplicación PHP nativa desarrollada con arquitectura MVC, PDO y un ORM propio para resolver la práctica de Desarrollo de Aplicaciones Web II.

## Funcionalidades implementadas

### Facultades

- Listado de facultades activas (`estado = 1`).
- Registro de facultades.
- Edición de nombre y abreviatura.
- Eliminación lógica cambiando `estado` a `0`.

### Docentes

- Listado de docentes activos (`estado = 1`).
- Visualización de facultad, DNI, apellidos, nombres, correo, categoría y dedicación.
- Registro asociado a una facultad existente mediante un `<select>`.
- Validación de categorías y dedicaciones permitidas.
- Edición de docentes.
- Eliminación lógica cambiando `estado` a `0`.

## Arquitectura

- `index.php`: Front Controller; recibe la URL y separa controlador, método y parámetros.
- `Libraries/Core/Load.php`: localiza e invoca el controlador solicitado.
- `Controllers/`: coordinan las peticiones y no contienen consultas SQL.
- `Models/`: contienen la lógica de acceso a datos y heredan del ORM.
- `Libraries/Core/Model.php`: ORM y Query Builder propio.
- `Libraries/Core/Conexion.php`: conexión PDO diferida con excepciones.
- `Views/`: formularios y listados HTML; no contienen SQL.
- `database/evaluacion_daw2.sql`: crea la base de datos, tablas y datos de prueba indicados en la evaluación.

## ORM y Query Builder

Los modelos heredan de `Model` y solo declaran su tabla:

```php
class FacultadesModel extends Model
{
    protected string $table = 'facultad';
}
```

El ORM proporciona `all()`, `find()`, `insert()`, `update()` y `delete()`. El listado de docentes usa el Query Builder con `select()`, `join()`, `where()`, `orderBy()` y `get()`.

Los valores se enlazan mediante consultas preparadas PDO. Los nombres de tablas, columnas y condiciones del Query Builder son definidos por el código del desarrollador.

## Instalación en XAMPP

1. Mantener el proyecto dentro de `C:\xampp\htdocs\dwa2\evaluacion_daw2`.
2. Iniciar Apache y MySQL desde XAMPP.
3. Abrir `database/evaluacion_daw2.sql` en phpMyAdmin y ejecutarlo.
4. Revisar `Config/Config.php`. Actualmente usa la base `evaluacion_daw2`; conservar o ajustar usuario y contraseña de MySQL según la instalación local.
5. Abrir `http://localhost:18080/dwa2/evaluacion_daw2/`.

Rutas principales: `/facultades`, `/facultades/crear`, `/docentes` y `/docentes/crear`.

## Correspondencia con los requisitos

Los requisitos REQ-01 a REQ-12 están cubiertos por `FacultadesController`, `DocentesController`, `FacultadesModel`, `DocentesModel` y sus vistas. Las eliminaciones son lógicas y los listados solo consultan registros activos.

## Verificación

Se debe probar con MySQL activo el registro, edición y desactivación de ambas entidades. La portada no necesita conexión porque `Conexion` abre PDO de forma diferida; las operaciones de facultades y docentes sí requieren ejecutar primero el script SQL.

