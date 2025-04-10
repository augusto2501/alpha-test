<?php

namespace App\Repositories;

use App\Models\Clase;

/**
 * Repositorio para el manejo de Clases en la base de datos.
 *
 * Esta clase extiende de ResourceRepository e implementa las operaciones
 * específicas para las clases de aprendizaje.
 */
class ClaseRepository extends ResourceRepository
{
    /**
     * Nombre de la tabla en la base de datos.
     *
     * @var string
     */
    private string $table = 'clases';

    /**
     * Busca clases por una palabra clave en su nombre.
     *
     * @param string $keyword Palabra clave a buscar (mínimo 3 caracteres)
     * @return array Array de objetos Clase
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
            $results[] = new Clase(
                (int) $row['id'],
                $row['nombre'],
                (int) $row['ponderacion'],
                $row['created_at'],
                $row['updated_at']
            );
        }

        return $results;
    }

    /**
     * Obtiene una clase por su ID.
     *
     * @param int $id ID de la clase
     * @return Clase|null La clase encontrada o null si no existe
     */
    public function findById(int $id): ?Clase
    {
        $sql = "SELECT * FROM {$this->table} WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id, \PDO::PARAM_INT);
        $stmt->execute();

        $row = $stmt->fetch();

        if (!$row) {
            return null;
        }

        return new Clase(
            (int) $row['id'],
            $row['nombre'],
            (int) $row['ponderacion'],
            $row['created_at'],
            $row['updated_at']
        );
    }

    /**
     * Guarda una clase en la base de datos (nueva o actualización).
     *
     * @param Clase $clase La clase a guardar
     * @return Clase La clase con ID actualizado si era nueva
     */
    public function save(Clase $clase): Clase
    {
        if ($clase->getId() === 0) {
            return $this->insert($clase);
        }

        return $this->update($clase);
    }

    /**
     * Inserta una nueva clase en la base de datos.
     *
     * @param Clase $clase La clase a insertar
     * @return Clase La clase con el ID asignado
     */
    private function insert(Clase $clase): Clase
    {
        $sql = "INSERT INTO {$this->table} (nombre, ponderacion) VALUES (:nombre, :ponderacion)";
        $stmt = $this->db->prepare($sql);

        $nombre = $clase->getName();
        $ponderacion = $clase->getPonderacion();

        $stmt->bindParam(':nombre', $nombre, \PDO::PARAM_STR);
        $stmt->bindParam(':ponderacion', $ponderacion, \PDO::PARAM_INT);
        $stmt->execute();

        $id = (int) $this->db->lastInsertId();

        return $this->findById($id);
    }

    /**
     * Actualiza una clase existente en la base de datos.
     *
     * @param Clase $clase La clase a actualizar
     * @return Clase La clase actualizada
     */
    private function update(Clase $clase): Clase
    {
        $sql = "UPDATE {$this->table} SET nombre = :nombre, ponderacion = :ponderacion WHERE id = :id";
        $stmt = $this->db->prepare($sql);

        $id = $clase->getId();
        $nombre = $clase->getName();
        $ponderacion = $clase->getPonderacion();

        $stmt->bindParam(':id', $id, \PDO::PARAM_INT);
        $stmt->bindParam(':nombre', $nombre, \PDO::PARAM_STR);
        $stmt->bindParam(':ponderacion', $ponderacion, \PDO::PARAM_INT);
        $stmt->execute();

        return $clase;
    }

    /**
     * Elimina una clase de la base de datos.
     *
     * @param int $id ID de la clase a eliminar
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