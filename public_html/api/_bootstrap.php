<?php
declare(strict_types=1);

/**
 * Los endpoints de api/ incluyen este archivo en vez de escribir
 * "../../backend/bootstrap.php". Sube directorios desde acá hasta
 * encontrar backend/bootstrap.php, así no importa en qué subcarpeta
 * quede public_html ni cuántos niveles haya hasta la raíz del proyecto.
 */

$dir = __DIR__;
$root = null;

for ($i = 0; $i <= 12; $i++) {
    if (is_file($dir . '/backend/bootstrap.php')) {
        $root = $dir;
        break;
    }
    $parent = dirname($dir);
    if ($parent === $dir) {
        break; // llegamos a la raíz del filesystem
    }
    $dir = $parent;
}

if ($root === null) {
    http_response_code(500);
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode(['ok' => false, 'error' => 'No se encontró la configuración del servidor.']);
    exit;
}

require $root . '/backend/bootstrap.php';
