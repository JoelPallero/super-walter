<?php
declare(strict_types=1);

/**
 * Crea las tablas de backend/schema.sql en MySQL y carga el contenido actual
 * (catalogo.json -- generado desde el export de WooCommerce --, productos.json y
 * novedades.json). Re-ejecutable: reemplaza el contenido de esas tablas.
 *
 * Requiere DB_HOST / DB_NAME / DB_USER / DB_PASS en el .env.
 * Uso: php backend/tools/migrar-a-mysql.php
 */

require __DIR__ . '/../bootstrap.php';

use SuperWalter\Database;
use SuperWalter\DbStore;
use SuperWalter\JsonStore;

if (!Database::enabled()) {
    fwrite(STDERR, "Falta DB_NAME (y DB_USER / DB_PASS) en el .env.\n");
    exit(1);
}

$pdo = Database::pdo();
$sql = preg_replace('/^--.*$/m', '', (string) file_get_contents(__DIR__ . '/../schema.sql'));
foreach (array_filter(array_map('trim', explode(';', (string) $sql))) as $stmt) {
    $pdo->exec($stmt);
}
echo "Tablas creadas/verificadas.\n";

$soloEn = in_array('--solo-en', $argv, true);
$files = $soloEn
    ? ['productos-en.json', 'novedades-en.json', 'catalogo-en.json']
    : ['catalogo.json', 'productos.json', 'novedades.json', 'productos-en.json', 'novedades-en.json', 'catalogo-en.json'];

foreach ($files as $file) {
    $items = JsonStore::allFromFile($file);
    DbStore::replaceAll($file, $items);
    echo str_pad($file, 16) . count($items) . " registros cargados.\n";
}

// Usuario admin inicial desde el .env (si todavía no existe en la tabla).
if (!$soloEn && sw_env('ADMIN_USER') !== '' && sw_env('ADMIN_PASSWORD_HASH') !== '') {
    $pdo->prepare('INSERT IGNORE INTO usuarios (usuario, password_hash, nombre) VALUES (?, ?, ?)')
        ->execute([sw_env('ADMIN_USER'), sw_env('ADMIN_PASSWORD_HASH'), 'Administrador']);
    echo "Usuario admin '" . sw_env('ADMIN_USER') . "' verificado en la tabla usuarios.
";
}
