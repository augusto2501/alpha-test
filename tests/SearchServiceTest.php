<?php

namespace Tests;

use PHPUnit\Framework\TestCase;
use App\Services\SearchService;
use App\Models\Clase;
use App\Models\Examen;
use App\Repositories\ClaseRepository;
use App\Repositories\ExamenRepository;

/**
 * Pruebas unitarias para el servicio de búsqueda.
 *
 * Utiliza mocks para simular los repositorios y evitar
 * dependencias de la base de datos.
 */
class SearchServiceTest extends TestCase
{
    /**
     * Prueba la búsqueda con resultado vacío.
     */
    public function testEmptySearch(): void
    {
        // Crear una subclase que sobrescriba los métodos de creación de repositorios
        $searchService = $this->getMockBuilder(SearchService::class)
            ->onlyMethods(['createClaseRepository', 'createExamenRepository'])
            ->getMock();

        // Configurar los mocks de los repositorios
        $claseRepositoryMock = $this->createMock(ClaseRepository::class);
        $claseRepositoryMock->method('searchByKeyword')
            ->willReturn([]);

        $examenRepositoryMock = $this->createMock(ExamenRepository::class);
        $examenRepositoryMock->method('searchByKeyword')
            ->willReturn([]);

        // Asignar los mocks a los métodos de creación de repositorios
        $searchService->method('createClaseRepository')
            ->willReturn($claseRepositoryMock);
        $searchService->method('createExamenRepository')
            ->willReturn($examenRepositoryMock);

        // Ejecutar la búsqueda
        $results = $searchService->search('keyword');

        // Verificar que no hay resultados
        $this->assertEmpty($results);
    }

    /**
     * Prueba la búsqueda con resultados mixtos.
     */
    public function testMixedSearch(): void
    {
        // Crear una subclase que sobrescriba los métodos de creación de repositorios
        $searchService = $this->getMockBuilder(SearchService::class)
            ->onlyMethods(['createClaseRepository', 'createExamenRepository'])
            ->getMock();

        // Crear objetos de prueba
        $clase = new Clase(1, 'Vocabulario sobre Trabajo', 5);
        $examen = new Examen(2, 'Examen de Trabajo', Examen::TIPO_SELECCION);

        // Configurar los mocks de los repositorios
        $claseRepositoryMock = $this->createMock(ClaseRepository::class);
        $claseRepositoryMock->method('searchByKeyword')
            ->willReturn([$clase]);

        $examenRepositoryMock = $this->createMock(ExamenRepository::class);
        $examenRepositoryMock->method('searchByKeyword')
            ->willReturn([$examen]);

        // Asignar los mocks a los métodos de creación de repositorios
        $searchService->method('createClaseRepository')
            ->willReturn($claseRepositoryMock);
        $searchService->method('createExamenRepository')
            ->willReturn($examenRepositoryMock);

        // Ejecutar la búsqueda
        $results = $searchService->search('trabajo');

        // Verificar que hay 2 resultados
        $this->assertCount(2, $results);
        $this->assertInstanceOf(Clase::class, $results[0]);
        $this->assertInstanceOf(Examen::class, $results[1]);
    }

    /**
     * Prueba el formateo de resultados.
     */
    public function testFormatResults(): void
    {
        $searchService = new SearchService();

        // Crear objetos de prueba
        $clase = new Clase(1, 'Vocabulario sobre Trabajo', 5);
        $examen = new Examen(2, 'Examen de Trabajo', Examen::TIPO_SELECCION);

        $results = [$clase, $examen];

        // Formatear resultados
        $formatted = $searchService->formatResults($results);

        // Verificar formato
        $this->assertEquals('Clase: Vocabulario sobre Trabajo | 5/5', $formatted[0]);
        $this->assertEquals('Examen: Examen de Trabajo | Selección', $formatted[1]);
    }

    /**
     * Prueba que se lance una excepción con una palabra clave demasiado corta.
     */
    public function testShortKeywordException(): void
    {
        $searchService = new SearchService();

        $this->expectException(\InvalidArgumentException::class);

        $searchService->search('ab'); // Solo 2 caracteres
    }

    public function testSearchCaseInsensitive(): void
    {
        $clase = new Clase(1, 'Vocabulario sobre Trabajo', 5);
        $examen = new Examen(2, 'Examen de Trabajo', Examen::TIPO_SELECCION);

        $claseRepositoryMock = $this->createMock(ClaseRepository::class);
        $claseRepositoryMock->method('searchByKeyword')
            ->willReturn([$clase]);

        $examenRepositoryMock = $this->createMock(ExamenRepository::class);
        $examenRepositoryMock->method('searchByKeyword')
            ->willReturn([$examen]);

        $searchService = $this->getMockBuilder(SearchService::class)
            ->onlyMethods(['createClaseRepository', 'createExamenRepository'])
            ->getMock();

        $searchService->method('createClaseRepository')
            ->willReturn($claseRepositoryMock);
        $searchService->method('createExamenRepository')
            ->willReturn($examenRepositoryMock);

        // Búsqueda con distintas capitalizaciones
        $resultsLower = $searchService->search('trabajo');
        $resultsUpper = $searchService->search('TRABAJO');

        $this->assertCount(2, $resultsLower);
        $this->assertEquals($resultsLower, $resultsUpper);
    }

}