# Aplicación de Búsqueda de Cursos de Idiomas

Esta aplicación de consola en PHP permite buscar clases y exámenes en una base de datos por coincidencia en sus nombres, mostrando información específica para cada tipo de recurso.

## Requisitos

- PHP 7.4 o superior
- MySQL/MariaDB
- Composer

## Instalación

1. Clonar el repositorio:
   ```
   git clone https://github.com/tu-usuario/curso-idiomas-app.git
   cd curso-idiomas-app
   ```

2. Instalar dependencias:
   ```
   composer install
   ```

3. Configurar la base de datos:
    - Crear una base de datos MySQL
    - Copiar el archivo `.env.example` a `.env` y configurar los datos de conexión
    - Ejecutar el script SQL para crear las tablas y cargar datos de ejemplo:
      ```
      mysql -u usuario -p < sql/create_tables.sql
      ```

## Uso

Para buscar clases y exámenes, ejecute el siguiente comando desde la terminal:

```
php main.php search <palabra_clave>
```

Donde `<palabra_clave>` es el término que desea buscar (debe tener al menos 3 caracteres).

### Ejemplo:

```
php main.php search trabajo
```

Resultado:
```
Clase: Vocabulario sobre Trabajo en Inglés | 5/5
Clase: Conversaciones de Trabajo en Inglés | 5/5
Examen: Trabajos y ocupaciones en Inglés | Selección
```

## Estructura del Proyecto

- `main.php`: Punto de entrada de la aplicación
- `src/`: Código fuente
    - `Config/`: Configuración (base de datos)
    - `Interfaces/`: Interfaces para los modelos
    - `Models/`: Modelos de datos (Clase, Examen)
    - `Repositories/`: Acceso a datos
    - `Services/`: Servicios de la aplicación
- `sql/`: Scripts SQL para crear la base de datos
- `tests/`: Pruebas unitarias (opcional)

## Patrones de Diseño Implementados

1. **Repository Pattern**: Separa la lógica de acceso a datos de los modelos de negocio.
    - `ResourceRepository.php`: Repositorio base
    - `ClaseRepository.php`: Repositorio para clases
    - `ExamenRepository.php`: Repositorio para exámenes

2. **Factory Method**: Utilizado en `SearchService` para crear los repositorios.

3. **Singleton**: Implementado en la clase `Database` para garantizar una única conexión a la base de datos.

4. **Facade**: El `SearchService` actúa como una fachada, simplificando la interacción con múltiples repositorios.

## Estándares Seguidos

- **PSR-4**: Autoloading mediante Composer
- **PSR-1/PSR-2**: Estilo de código
- **PHPDoc**: Documentación de código

## Pruebas Unitarias (Opcional)

Para ejecutar las pruebas unitarias:

```
composer test
```

## Licencia

Este proyecto es software libre y se distribuye bajo la Licencia MIT.