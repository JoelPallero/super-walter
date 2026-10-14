<?php
declare(strict_types=1);

/**
 * Igual que public_html/api/_bootstrap.php: sube directorios desde acá
 * hasta encontrar backend/bootstrap.php, así no importa la profundidad
 * del archivo que lo incluye (raíz, productos/, novedades/, admin/).
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
        break;
    }
    $dir = $parent;
}

if ($root === null) {
    http_response_code(500);
    echo 'No se encontró la configuración del servidor.';
    exit;
}

require $root . '/backend/bootstrap.php';

require_once __DIR__ . '/i18n.php';
