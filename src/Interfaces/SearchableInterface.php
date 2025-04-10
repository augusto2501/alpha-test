<?php

namespace App\Interfaces;

/**
 * Interfaz para objetos que pueden ser buscados.
 *
 * Esta interfaz define el contrato que deben cumplir todas las clases
 * que deseen implementar funcionalidad de búsqueda.
 */
interface SearchableInterface
{
    /**
     * Devuelve una representación en cadena de texto del objeto para mostrar en los resultados de búsqueda.
     *
     * @return string La representación textual del objeto
     */
    public function getSearchResultDisplay(): string;

    /**
     * Obtiene el tipo de recurso (Clase, Examen, etc).
     *
     * @return string El tipo de recurso
     */
    public function getResourceType(): string;

    /**
     * Devuelve el nombre del recurso para búsquedas.
     *
     * @return string El nombre del recurso
     */
    public function getName(): string;
}