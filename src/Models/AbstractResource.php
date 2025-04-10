<?php

namespace App\Models;

use App\Interfaces\SearchableInterface;

/**
 * Clase abstracta que representa un recurso de aprendizaje.
 *
 * Esta clase implementa la interfaz SearchableInterface y proporciona
 * la estructura común para todos los recursos de aprendizaje como
 * clases y exámenes.
 */
abstract class AbstractResource implements SearchableInterface
{
    /**
     * Identificador único del recurso.
     *
     * @var int
     */
    protected int $id;

    /**
     * Nombre del recurso.
     *
     * @var string
     */
    protected string $nombre;

    /**
     * Fecha de creación del recurso.
     *
     * @var string
     */
    protected string $createdAt;

    /**
     * Fecha de última actualización del recurso.
     *
     * @var string
     */
    protected string $updatedAt;

    /**
     * Constructor de la clase.
     *
     * @param int    $id        Identificador único
     * @param string $nombre    Nombre del recurso
     * @param string $createdAt Fecha de creación (opcional)
     * @param string $updatedAt Fecha de actualización (opcional)
     */
    public function __construct(
        int $id,
        string $nombre,
        string $createdAt = '',
        string $updatedAt = ''
    ) {
        $this->id = $id;
        $this->nombre = $nombre;
        $this->createdAt = $createdAt;
        $this->updatedAt = $updatedAt;
    }

    /**
     * Obtiene el ID del recurso.
     *
     * @return int El ID del recurso
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * Obtiene el nombre del recurso.
     *
     * @return string El nombre del recurso
     */
    public function getName(): string
    {
        return $this->nombre;
    }

    /**
     * Establece el nombre del recurso.
     *
     * @param string $nombre El nuevo nombre
     * @return self
     */
    public function setName(string $nombre): self
    {
        $this->nombre = $nombre;
        return $this;
    }

    /**
     * Obtiene la fecha de creación.
     *
     * @return string La fecha de creación
     */
    public function getCreatedAt(): string
    {
        return $this->createdAt;
    }

    /**
     * Obtiene la fecha de última actualización.
     *
     * @return string La fecha de última actualización
     */
    public function getUpdatedAt(): string
    {
        return $this->updatedAt;
    }

    /**
     * Método abstracto que debe ser implementado por las clases hijas para
     * obtener el tipo de recurso.
     *
     * @return string El tipo de recurso
     */
    abstract public function getResourceType(): string;

    /**
     * Método abstracto que debe ser implementado por las clases hijas para
     * obtener la representación del recurso para los resultados de búsqueda.
     *
     * @return string La representación del recurso
     */
    abstract public function getSearchResultDisplay(): string;
}