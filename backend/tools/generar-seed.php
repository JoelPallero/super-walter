<?php
declare(strict_types=1);

/**
 * Genera backend/seed.sql (INSERTs con todo el contenido actual de backend/data/*.json)
 * para importar en phpMyAdmin después de schema.sql. No necesita conexión a la base.
 *
 * Uso: php backend/tools/generar-seed.php
 */

require __DIR__ . '/../bootstrap.php';

use SuperWalter\JsonStore;

function q(?string $s): string
{
    if ($s === null) {
        return 'NULL';
    }
    $s = str_replace(['\\', "'", "\0", "\r", "\n", "\x1a"], ['\\\\', "\\'", '\\0', '\\r', '\\n', '\\Z'], $s);
    return "'" . $s . "'";
}

$out = "-- Seed generado por backend/tools/generar-seed.php. Importar DESPUÉS de schema.sql.\n";
$out .= "SET NAMES utf8mb4;\nSET FOREIGN_KEY_CHECKS = 0;\n";
$out .= "DELETE FROM catalogo_specs;\nDELETE FROM catalogo_imagenes;\nDELETE FROM catalogo_productos;\nDELETE FROM contenido;\n";
$out .= "DELETE FROM usuarios;
";
$out .= "ALTER TABLE catalogo_specs AUTO_INCREMENT = 1;\nALTER TABLE catalogo_imagenes AUTO_INCREMENT = 1;\nALTER TABLE catalogo_productos AUTO_INCREMENT = 1;\n\n";

// Usuario admin: toma ADMIN_USER y ADMIN_PASSWORD_HASH del .env (solo el hash, nunca la clave).
if (sw_env('ADMIN_USER') !== '' && sw_env('ADMIN_PASSWORD_HASH') !== '') {
    $out .= 'INSERT INTO usuarios (usuario, password_hash, nombre) VALUES (' . q(sw_env('ADMIN_USER')) . ', ' . q(sw_env('ADMIN_PASSWORD_HASH')) . ", 'Administrador');

";
}

// Catálogo: ids explícitos (1..N) para poder referenciarlos desde imágenes y specs.
$catalogo = JsonStore::allFromFile('catalogo.json');
$cats = [];
foreach ($catalogo as $it) {
    $cats[$it['categoria'] ?: 'general'] = true;
}
foreach (array_keys($cats) as $c) {
    $out .= 'INSERT IGNORE INTO categorias (slug, nombre) VALUES (' . q($c) . ', ' . q($c) . ");\n";
}

foreach ($catalogo as $i => $it) {
    $id = $i + 1;
    $price = isset($it['price']) && $it['price'] !== null ? number_format((float) $it['price'], 2, '.', '') : 'NULL';
    $out .= "\n-- {$it['title']}\n";
    $out .= 'INSERT INTO catalogo_productos (id, slug, wc_id, titulo, condicion, categoria, precio, sku, descripcion_html, image_alt, orden) VALUES ('
        . implode(', ', [
            $id, q($it['slug']), q((string) ($it['wc_id'] ?? '')), q($it['title']),
            q($it['condicion'] === 'nuevo' ? 'nuevo' : 'usado'), q($it['categoria'] ?: 'general'), $price,
            q((string) ($it['sku'] ?? '')), q((string) ($it['description_html'] ?? '')), q((string) ($it['image_alt'] ?? '')), $id,
        ]) . ");\n";
    foreach (array_values($it['images'] ?? []) as $n => $ruta) {
        $out .= "INSERT INTO catalogo_imagenes (producto_id, ruta, orden) VALUES ($id, " . q($ruta) . ", $n);\n";
    }
    foreach (array_values($it['specs'] ?? []) as $n => $spec) {
        $spec = (string) $spec;
        [$label, $value] = str_contains($spec, '|') ? array_map('trim', explode('|', $spec, 2)) : ['', $spec];
        $out .= "INSERT INTO catalogo_specs (producto_id, etiqueta, valor, orden) VALUES ($id, " . q($label) . ', ' . q($value) . ", $n);\n";
    }
}

// Páginas de producto de línea y novedades (contenido completo en JSON).
foreach (['productos' => 'productos.json', 'novedades' => 'novedades.json', 'productos_en' => 'productos-en.json', 'novedades_en' => 'novedades-en.json', 'catalogo_en' => 'catalogo-en.json'] as $coleccion => $file) {
    $out .= "\n-- Colección: $coleccion\n";
    foreach (JsonStore::allFromFile($file) as $n => $item) {
        $json = json_encode($item, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        $out .= 'INSERT INTO contenido (coleccion, slug, titulo, orden, data) VALUES ('
            . implode(', ', [q($coleccion), q($item['slug']), q((string) ($item['title'] ?? '')), $n + 1, q($json)]) . ");\n";
    }
}

$out .= "\nSET FOREIGN_KEY_CHECKS = 1;\n";
file_put_contents(__DIR__ . '/../seed.sql', $out);
echo 'seed.sql generado: ' . count($catalogo) . " ítems de catálogo, "
    . count(JsonStore::allFromFile('productos.json')) . ' productos, '
    . count(JsonStore::allFromFile('novedades.json')) . " novedades.\n";
