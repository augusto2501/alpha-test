<?php

namespace App\Models;

/**
 * Clase que representa una clase de aprendizaje.
 *
 * Esta clase extiende de AbstractResource y representa una clase
 * de aprendizaje en el sistema con sus atributos específicos.
 */
class Clase extends AbstractResource
{
    /**
     * Ponderación de la clase (1-5).
     *
     * @var int
     */
    private int $ponderacion;

    /**
     * Constructor de la clase.
     *
     * @param int    $id          Identificador único
     * @param string $nombre      Nombre de la clase
     * @param int    $ponderacion Ponderación de la clase (1-5)
     * @param string $createdAt   Fecha de creación (opcional)
     * @param string $updatedAt   Fecha de actualización (opcional)
     */
    public function __construct(
        int $id,
        string $nombre,
        int $ponderacion,
        string $createdAt = '',
        string $updatedAt = ''
    ) {
        parent::__construct($id, $nombre, $createdAt, $updatedAt);
        $this->setPonderacion($ponderacion);
    }

    /**
     * Obtiene la ponderación de la clase.
     *
     * @return int La ponderación
     */
    public function getPonderacion(): int
    {
        return $this->ponderacion;
    }

    /**
     * Establece la ponderación de la clase validando que esté entre 1 y 5.
     *
     * @param int $ponderacion La nueva ponderación
     * @return self
     * @throws \InvalidArgumentException Si la ponderación no está entre 1 y 5
     */
    public function setPonderacion(int $ponderacion): self
    {
        if ($ponderacion < 1 || $ponderacion > 5) {
            throw new \InvalidArgumentException('La ponderación debe estar entre 1 y 5');
        }

        $this->ponderacion = $ponderacion;
        return $this;
    }

    /**
     * Obtiene el tipo de recurso.
     *
     * @return string El tipo de recurso (siempre "Clase")
     */
    public function getResourceType(): string
    {
        return 'Clase';
    }

    /**
     * Devuelve la representación en cadena de la clase para resultados de búsqueda.
     *
     * @return string La representación de la clase en el formato: "Nombre | Ponderación/5"
     */
    public function getSearchResultDisplay(): string
    {
        return sprintf(
            '%s | %d/5',
            $this->nombre,
            $this->ponderacion
        );
    }
}