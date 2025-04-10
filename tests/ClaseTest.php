<?php

namespace Tests;

use PHPUnit\Framework\TestCase;
use App\Models\Clase;

/**
 * Pruebas unitarias para la clase Clase.
 */
class ClaseTest extends TestCase
{
    /**
     * Prueba la creación de una instancia de Clase.
     */
    public function testCreateClase(): void
    {
        $clase = new Clase(1, 'Clase de Prueba', 4);

        $this->assertEquals(1, $clase->getId());
        $this->assertEquals('Clase de Prueba', $clase->getName());
        $this->assertEquals(4, $clase->getPonderacion());
        $this->assertEquals('Clase', $clase->getResourceType());
    }

    /**
     * Prueba que se lance una excepción al establecer una ponderación inválida.
     */
    public function testInvalidPonderacion(): void
    {
        $this->expectException(\InvalidArgumentException::class);

        new Clase(1, 'Clase de Prueba', 6); // Ponderación > 5
    }

    /**
     * Prueba el formato de visualización del resultado de búsqueda.
     */
    public function testSearchResultDisplay(): void
    {
        $clase = new Clase(1, 'Clase de Prueba', 4);

        $expected = 'Clase de Prueba | 4/5';
        $this->assertEquals($expected, $clase->getSearchResultDisplay());
    }

    /**
     * Prueba la actualización de propiedades.
     */
    public function testUpdateProperties(): void
    {
        $clase = new Clase(1, 'Clase de Prueba', 4);

        $clase->setName('Clase Actualizada');
        $clase->setPonderacion(5);

        $this->assertEquals('Clase Actualizada', $clase->getName());
        $this->assertEquals(5, $clase->getPonderacion());
    }
}