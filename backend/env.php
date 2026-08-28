<?php
declare(strict_types=1);

/**
 * Sube directorios desde $from hasta encontrar $marker, sin asumir
 * una profundidad fija (nada de "../.."). Así da igual si public_html
 * termina en una subcarpeta: mientras el marcador exista en algún
 * ancestro, se encuentra.
 */
function sw_find_root(string $from, string $marker, int $maxLevels = 12): string
{
    $dir = $from;
    for ($i = 0; $i <= $maxLevels; $i++) {
        if (file_exists($dir . DIRECTORY_SEPARATOR . $marker)) {
            return $dir;
        }
        $parent = dirname($dir);
        if ($parent === $dir) {
            break; // llegamos a la raíz del filesystem
        }
        $dir = $parent;
    }
    throw new \RuntimeException("No se encontró \"{$marker}\" subiendo desde {$from}");
}

/**
 * Lee el .env (fuera de public_html) sin depender de librerías externas.
 * Ignora líneas vacías y comentarios (con # o con /* al inicio de línea).
 */
function sw_load_env(string $path): array
{
    $env = [];
    if (!is_file($path)) {
        return $env;
    }

    foreach (file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) as $line) {
        $line = trim($line);
        if ($line === '' || $line[0] === '#' || str_starts_with($line, '/*') || str_starts_with($line, '*')) {
            continue;
        }
        if (!str_contains($line, '=')) {
            continue;
        }
        [$key, $value] = explode('=', $line, 2);
        $env[trim($key)] = trim($value);
    }

    return $env;
}
