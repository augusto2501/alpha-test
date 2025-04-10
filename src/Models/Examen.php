<?php

namespace App\Models;

/**
 * Clase que representa un examen.
 *
 * Esta clase extiende de AbstractResource y representa un examen
 * en el sistema con sus atributos específicos.
 */
class Examen extends AbstractResource
{
    /**
     * Constantes para los tipos de examen.
     */
    public const TIPO_SELECCION = 'seleccion';
    public const TIPO_PREGUNTA_RESPUESTA = 'pregunta_respuesta';
    public const TIPO_COMPLETACION = 'completacion';

    /**
     * Array de tipos de examen válidos.
     *
     * @var array
     */
    private static array $tiposValidos = [
        self::TIPO_SELECCION,
        self::TIPO_PREGUNTA_RESPUESTA,
        self::TIPO_COMPLETACION
    ];

    /**
     * Tipo de examen.
     *
     * @var string
     */
    private string $tipo;

    /**
     * Constructor de la clase.
     *
     * @param int    $id        Identificador único
     * @param string $nombre    Nombre del examen
     * @param string $tipo      Tipo de examen (seleccion, pregunta_respuesta, completacion)
     * @param string $createdAt Fecha de creación (opcional)
     * @param string $updatedAt Fecha de actualización (opcional)
     */
    public function __construct(
        int $id,
        string $nombre,
        string $tipo,
        string $createdAt = '',
        string $updatedAt = ''
    ) {
        parent::__construct($id, $nombre, $createdAt, $updatedAt);
        $this->setTipo($tipo);
    }

    /**
     * Obtiene el tipo de examen.
     *
     * @return string El tipo de examen
     */
    public function getTipo(): string
    {
        return $this->tipo;
    }

    /**
     * Establece el tipo de examen, validando que sea uno válido.
     *
     * @param string $tipo El nuevo tipo
     * @return self
     * @throws \InvalidArgumentException Si el tipo no es válido
     */
    public function setTipo(string $tipo): self
    {
        if (!in_array($tipo, self::$tiposValidos)) {
            throw new \InvalidArgumentException(
                'El tipo debe ser uno de los siguientes: ' . implode(', ', self::$tiposValidos)
            );
        }

        $this->tipo = $tipo;
        return $this;
    }

    /**
     * Obtiene el tipo de examen formateado para mostrar.
     *
     * @return string El tipo de examen en formato legible
     */
    public function getTipoFormateado(): string
    {
        $tipos = [
            self::TIPO_SELECCION => 'Selección',
            self::TIPO_PREGUNTA_RESPUESTA => 'Pregunta y Respuesta',
            self::TIPO_COMPLETACION => 'Completación'
        ];

        return $tipos[$this->tipo] ?? 'Desconocido';
    }

    /**
     * Obtiene el tipo de recurso.
     *
     * @return string El tipo de recurso (siempre "Examen")
     */
    public function getResourceType(): string
    {
        return 'Examen';
    }

    /**
     * Devuelve la representación en cadena del examen para resultados de búsqueda.
     *
     * @return string La representación del examen en el formato: "Nombre | Tipo"
     */
    public function getSearchResultDisplay(): string
    {
        return sprintf(
            '%s | %s',
            $this->nombre,
            $this->getTipoFormateado()
        );
    }
}