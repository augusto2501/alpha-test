<?php

namespace App\Repositories;

use App\Models\Examen;

/**
 * Repositorio para el manejo de Exámenes en la base de datos.
 *
 * Esta clase extiende de ResourceRepository e implementa las operaciones
 * específicas para los exámenes.
 */
class ExamenRepository extends ResourceRepository
{
    /**
     * Nombre de la tabla en la base de datos.
     *
     * @var string
     */
    private string $table = 'examenes';

    /**
     * Busca exámenes por una palabra clave en su nombre.
     *
     * @param string $keyword Palabra clave a buscar (mínimo 3 caracteres)
     * @return array Array de objetos Examen
     * @throws \InvalidArgumentException Si la palabra clave tiene menos de 3 caracteres
     */
    public function searchByKeyword(string $keyword): array
    {
        $keyword = $this->validateKeyword($keyword);
        $searchTerm = "%{$keyword}%";

        $sql = "SELECT * FROM {$this->table} WHERE nombre LIKE :searchTerm ORDER BY nombre ASC";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':searchTerm', $searchTerm, \PDO::PARAM_STR);
        $stmt->execute();

        $results = [];

        while ($row = $stmt->fetch()) {
            $results[] = new Examen(
                (int) $row['id'],
                $row['nombre'],
                $row['tipo'],
                $row['created_at'],
                $row['updated_at']
            );
        }

        return $results;
    }

    /**
     * Obtiene un examen por su ID.
     *
     * @param int $id ID del examen
     * @return Examen|null El examen encontrado o null si no existe
     */
    public function findById(int $id): ?Examen
    {
        $sql = "SELECT * FROM {$this->table} WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id, \PDO::PARAM_INT);
        $stmt->execute();

        $row = $stmt->fetch();

        if (!$row) {
            return null;
        }

        return new Examen(
            (int) $row['id'],
            $row['nombre'],
            $row['tipo'],
            $row['created_at'],
            $row['updated_at']
        );
    }

    /**
     * Guarda un examen en la base de datos (nuevo o actualización).
     *
     * @param Examen $examen El examen a guardar
     * @return Examen El examen con ID actualizado si era nuevo
     */
    public function save(Examen $examen): Examen
    {
        if ($examen->getId() === 0) {
            return $this->insert($examen);
        }

        return $this->update($examen);
    }

    /**
     * Inserta un nuevo examen en la base de datos.
     *
     * @param Examen $examen El examen a insertar
     * @return Examen El examen con el ID asignado
     */
    private function insert(Examen $examen): Examen
    {
        $sql = "INSERT INTO {$this->table} (nombre, tipo) VALUES (:nombre, :tipo)";
        $stmt = $this->db->prepare($sql);

        $nombre = $examen->getName();
        $tipo = $examen->getTipo();

        $stmt->bindParam(':nombre', $nombre, \PDO::PARAM_STR);
        $stmt->bindParam(':tipo', $tipo, \PDO::PARAM_STR);
        $stmt->execute();

        $id = (int) $this->db->lastInsertId();

        return $this->findById($id);
    }

    /**
     * Actualiza un examen existente en la base de datos.
     *
     * @param Examen $examen El examen a actualizar
     * @return Examen El examen actualizado
     */
    private function update(Examen $examen): Examen
    {
        $sql = "UPDATE {$this->table} SET nombre = :nombre, tipo = :tipo WHERE id = :id";
        $stmt = $this->db->prepare($sql);

        $id = $examen->getId();
        $nombre = $examen->getName();
        $tipo = $examen->getTipo();

        $stmt->bindParam(':id', $id, \PDO::PARAM_INT);
        $stmt->bindParam(':nombre', $nombre, \PDO::PARAM_STR);
        $stmt->bindParam(':tipo', $tipo, \PDO::PARAM_STR);
        $stmt->execute();

        return $examen;
    }

    /**
     * Elimina un examen de la base de datos.
     *
     * @param int $id ID del examen a eliminar
     * @return bool true si se eliminó correctamente, false en caso contrario
     */
    public function delete(int $id): bool
    {
        $sql = "DELETE FROM {$this->table} WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id, \PDO::PARAM_INT);
        return $stmt->execute();
    }
}