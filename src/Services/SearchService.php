<?php

namespace App\Services;

use App\Repositories\ClaseRepository;
use App\Repositories\ExamenRepository;
use App\Interfaces\SearchableInterface;

/**
 * Servicio de búsqueda para recursos educativos.
 *
 * Esta clase implementa el patrón Factory Method para crear los repositorios
 * y el patrón Facade para simplificar el proceso de búsqueda.
 */
class SearchService
{
    /**
     * Repositorio de clases.
     *
     * @var ClaseRepository
     */
    private ClaseRepository $claseRepository;

    /**
     * Repositorio de exámenes.
     *
     * @var ExamenRepository
     */
    private ExamenRepository $examenRepository;

    /**
     * Constructor que inicializa los repositorios.
     *
     * Implementa el patrón Factory Method para crear las instancias
     * de los repositorios necesarios.
     */
    public function __construct()
    {
        // Factory Method: creamos los repositorios necesarios
        $this->claseRepository = $this->createClaseRepository();
        $this->examenRepository = $this->createExamenRepository();
    }

    /**
     * Crea una instancia del repositorio de clases.
     *
     * @return ClaseRepository La instancia del repositorio
     */
    protected function createClaseRepository(): ClaseRepository
    {
        return new ClaseRepository();
    }

    /**
     * Crea una instancia del repositorio de exámenes.
     *
     * @return ExamenRepository La instancia del repositorio
     */
    protected function createExamenRepository(): ExamenRepository
    {
        return new ExamenRepository();
    }

    /**
     * Busca recursos (clases y exámenes) que coincidan con la palabra clave.
     *
     * @param string $keyword Palabra clave a buscar (mínimo 3 caracteres)
     * @return array Array de objetos SearchableInterface
     * @throws \InvalidArgumentException Si la palabra clave tiene menos de 3 caracteres
     */
    public function search(string $keyword): array
    {
        // Validar longitud mínima
        if (mb_strlen(trim($keyword)) < 3) {
            throw new \InvalidArgumentException(
                'La palabra clave debe tener al menos 3 caracteres'
            );
        }

        // Buscar en clases
        $clases = $this->claseRepository->searchByKeyword($keyword);

        // Buscar en exámenes
        $examenes = $this->examenRepository->searchByKeyword($keyword);

        // Combinar resultados
        return array_merge($clases, $examenes);
    }

    /**
     * Formatea los resultados de la búsqueda para mostrarlos en la consola.
     *
     * @param array $results Array de objetos SearchableInterface
     * @return array Array de cadenas formateadas
     */
    public function formatResults(array $results): array
    {
        $formatted = [];

        /** @var SearchableInterface $result */
        foreach ($results as $result) {
            $formatted[] = $result->getResourceType() . ': ' . $result->getSearchResultDisplay();
        }

        return $formatted;
    }
}