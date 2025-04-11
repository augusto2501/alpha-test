<?php

/**
 * Punto de entrada de la aplicación de búsqueda de cursos online.
 *
 * Este script se ejecuta desde la línea de comandos y permite buscar
 * clases y exámenes en la base de datos.
 *
 * Uso: php main.php search <keyword>
 *
 * @author Carlos Augusto Aranzazu
 */

// Cargamos el autoloader de Composer
require_once __DIR__ . '/vendor/autoload.php';

use Dotenv\Dotenv;
// Cargamos las variables de entorno
$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

// Importamos las clases necesarias
use App\Services\SearchService;


/**
 * Muestra la ayuda de uso de la aplicación.
 *
 * @return void
 */
function showHelp(): void
{
    echo "Uso: php main.php search <palabra_clave>\n";
    echo "  <palabra_clave>: Término a buscar (mínimo 3 caracteres)\n";
}

/**
 * Ejecuta la búsqueda y muestra los resultados.
 *
 * @param string $keyword Palabra clave a buscar
 * @return void
 */
function executeSearch(string $keyword): void
{
    try {
        $searchService = new SearchService();
        $results = $searchService->search($keyword);

        if (empty($results)) {
            echo "No se encontraron resultados para: \"$keyword\"\n";
            return;
        }

        $formattedResults = $searchService->formatResults($results);

        foreach ($formattedResults as $result) {
            echo $result . "\n";
        }
    } catch (\InvalidArgumentException $e) {
        echo "Error: " . $e->getMessage() . "\n";
        showHelp();
    } catch (\PDOException $e) {
        echo "Error de base de datos: " . $e->getMessage() . "\n";
    } catch (\Exception $e) {
        echo "Error inesperado: " . $e->getMessage() . "\n";
    }
}

/**
 * Punto de entrada principal.
 */
function main(): void
{
    global $argv;

    // Verificar argumentos
    if (!isset($argv) || count($argv) < 3) {
        showHelp();
        exit(1);
    }

    $command = $argv[1];
    $keyword = $argv[2];

    // Procesar comando
    switch ($command) {
        case 'search':
            executeSearch($keyword);
            break;

        default:
            echo "Comando desconocido: $command\n";
            showHelp();
            exit(1);
    }
}

// Ejecutar la aplicación
main();