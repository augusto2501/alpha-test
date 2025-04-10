<?php

namespace Tests;

use PHPUnit\Framework\TestCase;
use App\Models\Examen;

/**
 * Pruebas unitarias para la clase Examen.
 */
class ExamenTest extends TestCase
{
    /**
     * Prueba la creación de una instancia de Examen.
     */
    public function testCreateExamen(): void
    {
        $examen = new Examen(1, 'Examen de Prueba', Examen::TIPO_SELECCION);

        $this->assertEquals(1, $examen->getId());
        $this->assertEquals('Examen de Prueba', $examen->getName());
        $this->assertEquals(Examen::TIPO_SELECCION, $examen->getTipo());
        $this->assertEquals('Examen', $examen->getResourceType());
    }

    /**
     * Prueba que se lance una excepción al establecer un tipo inválido.
     */
    public function testInvalidTipo(): void
    {
        $this->expectException(\InvalidArgumentException::class);

        new Examen(1, 'Examen de Prueba', 'tipo_invalido');
    }

    /**
     * Prueba el formato de visualización del resultado de búsqueda.
     */
    public function testSearchResultDisplay(): void
    {
        $examen = new Examen(1, 'Examen de Prueba', Examen::TIPO_SELECCION);

        $expected = 'Examen de Prueba | Selección';
        $this->assertEquals($expected, $examen->getSearchResultDisplay());
    }

    /**
     * Prueba la actualización de propiedades.
     */
    public function testUpdateProperties(): void
    {
        $examen = new Examen(1, 'Examen de Prueba', Examen::TIPO_SELECCION);

        $examen->setName('Examen Actualizado');
        $examen->setTipo(Examen::TIPO_COMPLETACION);

        $this->assertEquals('Examen Actualizado', $examen->getName());
        $this->assertEquals(Examen::TIPO_COMPLETACION, $examen->getTipo());
    }

    /**
     * Prueba que el formato del tipo sea correcto.
     */
    public function testTipoFormateado(): void
    {
        $examen = new Examen(1, 'Examen', Examen::TIPO_PREGUNTA_RESPUESTA);

        $this->assertEquals('Pregunta y Respuesta', $examen->getTipoFormateado());
    }
}