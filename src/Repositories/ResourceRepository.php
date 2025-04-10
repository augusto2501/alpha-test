<?php

namespace App\Repositories;

use App\Config\Database;

/**
 * Clase base abstracta para los repositorios.
 *
 * Esta clase implementa la funcionalidad común para todos los repositorios
 * y proporciona una conexión a la base de datos.
 */
abstract class ResourceRepository
{
    /**
     * Conexión a la base de datos.
     *
     * @var \PDO
     */
    protected \PDO $db;

    /**
     * Constructor que inicializa la conexión a la base de datos.
     */
    public function __construct()
    {
        $this->db = Database::getInstance()->getConnection();
    }

    /**
     * Busca recursos por una palabra clave en su nombre.
     *
     * @param string $keyword Palabra clave a buscar (mínimo 3 caracteres)
     * @return array Array de resultados
     */
    abstract public function searchByKeyword(string $keyword): array;

    /**
     * Valida que la palabra clave tenga al menos 3 caracteres.
     *
     * @param string $keyword Palabra clave a validar
     * @return string La palabra clave validada
     * @throws \InvalidArgumentException Si la palabra clave tiene menos de 3 caracteres
     */
    protected function validateKeyword(string $keyword): string
    {
        $keyword = trim($keyword);

        if (mb_strlen($keyword) < 3) {
            throw new \InvalidArgumentException(
                'La palabra clave debe tener al menos 3 caracteres'
            );
        }

        return $keyword;
    }
}