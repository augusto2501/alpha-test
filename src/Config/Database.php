<?php

namespace App\Config;

/**
 * Clase de configuración para la conexión a la base de datos.
 *
 * Esta clase implementa el patrón Singleton para asegurar que solo
 * exista una instancia de la conexión a la base de datos en toda la aplicación.
 */
class Database
{
    /**
     * Instancia única de la clase (Singleton).
     *
     * @var self|null
     */
    private static ?self $instance = null;

    /**
     * Instancia PDO para la conexión a la base de datos.
     *
     * @var \PDO|null
     */
    private ?\PDO $connection = null;

    /**
     * Constructor privado para prevenir instanciación directa (Singleton).
     */
    private function __construct()
    {
        // El constructor es privado para implementar el patrón Singleton
    }

    /**
     * Previene la clonación del objeto (parte del patrón Singleton).
     *
     * @return void
     */
    private function __clone()
    {
        // Este método está vacío para prevenir la clonación del objeto
    }

    /**
     * Obtiene la instancia única de la clase (método estático del patrón Singleton).
     *
     * @return self La instancia única de la clase
     */
    public static function getInstance(): self
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    /**
     * Obtiene la conexión a la base de datos, creándola si no existe.
     *
     * @return \PDO La conexión a la base de datos
     * @throws \PDOException Si ocurre un error al conectar
     */
    public function getConnection(): \PDO
    {
        if ($this->connection === null) {
            $host = $_ENV['DB_HOST'];
            $dbname = $_ENV['DB_NAME'];
            $username = $_ENV['DB_USER'];
            $password = $_ENV['DB_PASS'];
            $charset = $_ENV['DB_CHARSET'];

            $dsn = "mysql:host=$host;dbname=$dbname;charset=$charset";

            $options = [
                \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
                \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
                \PDO::ATTR_EMULATE_PREPARES => false,
            ];

            try {
                $this->connection = new \PDO($dsn, $username, $password, $options);
            } catch (\PDOException $e) {
                // En producción, esto debería ser manejado de forma más elegante
                throw new \PDOException("Error de conexión a la base de datos: " . $e->getMessage());
            }
        }

        return $this->connection;
    }
}