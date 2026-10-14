<?php
declare(strict_types=1);

/**
 * Importador (re-ejecutable) de un export de productos de WooCommerce a
 * backend/data/catalogo.json, bajando las imágenes a
 * public_html/assets/img/catalogo/{slug}/01.ext, 02.ext, ...
 *
 * También genera backend/data/catalogo-en-draft.json con las filas en
 * inglés del mismo export (mismo esquema, mismas imágenes por slug vía
 * "Grupo de traducción"), pero ese archivo NO se usa en ningún template
 * ni ruta pública todavía: queda listo a propósito para cuando el sitio
 * se lance también en inglés.
 *
 * Uso: php backend/tools/import-woo-csv.php ruta/al/export.csv
 */

require __DIR__ . '/../JsonStore.php';

use SuperWalter\JsonStore;

$csvPath = $argv[1] ?? null;
if ($csvPath === null || !is_file($csvPath)) {
    fwrite(STDERR, "Uso: php import-woo-csv.php <archivo.csv>\n");
    exit(1);
}

$imgRoot = __DIR__ . '/../../public_html/assets/img/catalogo';

function sw_slugify(string $s): string
{
    $t = @iconv('UTF-8', 'ASCII//TRANSLIT//IGNORE', $s);
    if ($t === false) {
        $t = $s;
    }
    $t = strtolower($t);
    $t = preg_replace('/[^a-z0-9]+/', '-', $t) ?? '';
    $t = trim($t, '-');
    return $t !== '' ? $t : 'item';
}

/** "A, B, algo con 22\,5 cm" -> ["A", "B", "algo con 22,5 cm"] */
function sw_split_specs(string $raw): array
{
    $raw = trim($raw);
    if ($raw === '') {
        return [];
    }
    $placeholder = "\x01";
    $tmp = str_replace('\\,', $placeholder, $raw);
    $parts = array_map('trim', explode(',', $tmp));
    $parts = array_map(static fn (string $p): string => str_replace($placeholder, ',', $p), $parts);
    return array_values(array_filter($parts, static fn (string $p): bool => $p !== ''));
}

/** HTML mínimo (sin clases de Elementor ni estilos), párrafos reales a partir de los "\n" literales del export. */
function sw_sanitize_description(string $raw): string
{
    $text = str_replace('\\n', "\n", $raw);
    $text = strip_tags($text, '<h3><h4><p><ul><ol><li><strong><em><b><i><br>');
    $text = preg_replace('/<(\w+)[^>]*>/', '<$1>', $text) ?? $text;

    $blocks = preg_split('/\n{2,}/', $text) ?: [];
    $out = [];
    foreach ($blocks as $block) {
        $block = trim($block);
        if ($block === '') {
            continue;
        }
        if (preg_match('/^<(h3|h4|p|ul|ol)>/i', $block)) {
            $out[] = $block;
        } else {
            $out[] = '<p>' . nl2br($block, false) . '</p>';
        }
    }
    return implode("\n", $out);
}

/**
 * Descarga en paralelo (curl_multi, concurrencia limitada) las imágenes
 * de varios productos a la vez. $jobs: slug => [url, url, ...].
 * Devuelve ['results' => slug => [ruta_relativa|null, ...], 'failed' => [string, ...]].
 */
function sw_download_batch(array $jobs, string $imgRoot, int $concurrency = 8): array
{
    $results = [];
    $queue = [];
    foreach ($jobs as $slug => $urls) {
        @mkdir("$imgRoot/$slug", 0755, true);
        $results[$slug] = array_fill(0, count($urls), null);
        foreach ($urls as $i => $url) {
            $queue[] = [$slug, $i, $url];
        }
    }

    $failed = [];
    $mh = curl_multi_init();
    $active = [];
    $next = 0;
    $total = count($queue);
    $done = 0;

    $startOne = function () use (&$next, &$queue, &$active, $mh, $imgRoot): bool {
        if ($next >= count($queue)) {
            return false;
        }
        [$slug, $i, $url] = $queue[$next++];
        $ext = strtolower(pathinfo((string) parse_url($url, PHP_URL_PATH), PATHINFO_EXTENSION));
        if (!in_array($ext, ['jpg', 'jpeg', 'png', 'webp', 'gif'], true)) {
            $ext = 'jpg';
        }
        $name = sprintf('%02d.%s', $i + 1, $ext);
        $dest = "$imgRoot/$slug/$name";
        $fp = fopen($dest, 'w');
        if ($fp === false) {
            return true;
        }
        $ch = curl_init($url);
        curl_setopt_array($ch, [
            CURLOPT_FILE => $fp,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_USERAGENT => 'Mozilla/5.0 (compatible; SuperWalterImport/1.0)',
            // Este entorno de PHP local no trae un bundle de CAs configurado
            // (curl.cainfo vacío), lo que rompe la verificación TLS incluso
            // contra el propio dominio del cliente. Es un script de
            // migración de una sola vez bajando imágenes públicas de su
            // propio sitio viejo, así que no hay riesgo real en relajar
            // esto acá; en un hosting con CAs bien configuradas no hace falta.
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_SSL_VERIFYHOST => false,
        ]);
        curl_multi_add_handle($mh, $ch);
        $key = (int) $ch;
        $active[$key] = ['slug' => $slug, 'i' => $i, 'fp' => $fp, 'dest' => $dest,
            'rel' => "assets/img/catalogo/$slug/$name", 'url' => $url];
        return true;
    };

    for ($k = 0; $k < $concurrency; $k++) {
        $startOne();
    }

    do {
        do {
            $status = curl_multi_exec($mh, $running);
        } while ($status === CURLM_CALL_MULTI_PERFORM);
        curl_multi_select($mh, 1.0);

        while (($info = curl_multi_info_read($mh)) !== false) {
            $ch = $info['handle'];
            $key = (int) $ch;
            $meta = $active[$key];
            fclose($meta['fp']);
            $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            $size = is_file($meta['dest']) ? filesize($meta['dest']) : 0;
            if ($info['result'] !== CURLE_OK || $code >= 400 || $size < 300) {
                @unlink($meta['dest']);
                $failed[] = "{$meta['url']} (http={$code})";
            } else {
                $results[$meta['slug']][$meta['i']] = $meta['rel'];
            }
            curl_multi_remove_handle($mh, $ch);
            curl_close($ch);
            unset($active[$key]);
            $done++;
            echo "\r  descargando imágenes... {$done}/{$total}";
            $startOne();
        }
    } while ($running > 0 || count($active) > 0);
    echo "\n";

    curl_multi_close($mh);
    return ['results' => $results, 'failed' => $failed];
}

// ---------------------------------------------------------------------
// Parseo del CSV
// ---------------------------------------------------------------------

$fh = fopen($csvPath, 'r');
$header = fgetcsv($fh);
$header[0] = preg_replace('/^\xEF\xBB\xBF/', '', (string) $header[0]);
$idx = array_flip($header);
$get = static fn (array $r, string $col): string => trim((string) ($r[$idx[$col] ?? -1] ?? ''));

$esRows = [];
$enRows = [];
while (($row = fgetcsv($fh)) !== false) {
    if (count($row) < 5) {
        continue;
    }
    $lang = $get($row, 'Idioma (Polylang)');
    if ($lang === 'es') {
        $esRows[] = $row;
    } elseif ($lang === 'en') {
        $enRows[] = $row;
    }
}
fclose($fh);

echo "Filas ES: " . count($esRows) . " / EN: " . count($enRows) . "\n";

// ---------------------------------------------------------------------
// Ítems en español (los que se publican)
// ---------------------------------------------------------------------

$usedSlugs = [];
$items = [];
$downloadJobs = [];
$translationMap = []; // grupo de traducción -> slug ES

foreach ($esRows as $row) {
    $name = $get($row, 'Nombre');
    if ($name === '') {
        continue;
    }
    $slug = sw_slugify($name);
    $base = $slug;
    $n = 2;
    while (isset($usedSlugs[$slug])) {
        $slug = $base . '-' . $n++;
    }
    $usedSlugs[$slug] = true;

    $cats = array_map('trim', explode(',', $get($row, 'Categorías')));
    $condicion = in_array('Nuevos', $cats, true) ? 'nuevo' : 'usado';
    $categoria = 'general';
    foreach ($cats as $c) {
        if ($c === 'Granos finos') {
            $categoria = 'granos-finos';
            break;
        }
        if ($c === 'Granos gruesos') {
            $categoria = 'granos-gruesos';
            break;
        }
    }

    $priceRaw = $get($row, 'Precio normal');
    $price = $priceRaw === '' ? null : (float) $priceRaw;

    $imgs = array_values(array_filter(array_map('trim', explode(',', $get($row, 'Imágenes')))));

    $items[] = [
        'slug' => $slug,
        'wc_id' => $get($row, 'ID'),
        'title' => $name,
        'condicion' => $condicion,
        'categoria' => $categoria,
        'price' => $price,
        'sku' => $get($row, 'SKU'),
        'description_html' => sw_sanitize_description($get($row, 'Descripción')),
        'specs' => sw_split_specs($get($row, 'Valor(es) del atributo 1')),
        'images' => [],
        'image_alt' => $name,
    ];
    $downloadJobs[$slug] = $imgs;

    $grupo = $get($row, 'Grupo de traducción');
    if ($grupo !== '') {
        $translationMap[$grupo] = $slug;
    }
}

echo "Ítems ES a crear: " . count($items) . "\n";

$batch = sw_download_batch($downloadJobs, $imgRoot);
$downloaded = $batch['results'];
$failed = $batch['failed'];

$okCount = 0;
foreach ($items as &$item) {
    $paths = array_values(array_filter($downloaded[$item['slug']] ?? []));
    $item['images'] = $paths;
    $okCount += count($paths);
}
unset($item);

JsonStore::save('catalogo.json', $items);
echo "backend/data/catalogo.json escrito con " . count($items) . " ítems.\n";
echo "Imágenes OK: $okCount / fallidas: " . count($failed) . "\n";
if ($failed) {
    echo "Fallidas:\n  - " . implode("\n  - ", $failed) . "\n";
}

// ---------------------------------------------------------------------
// Borrador en inglés (NO se referencia desde ninguna página todavía)
// ---------------------------------------------------------------------

$imagesBySlug = [];
foreach ($items as $it) {
    $imagesBySlug[$it['slug']] = $it['images'];
}

$enItems = [];
foreach ($enRows as $row) {
    $name = $get($row, 'Nombre');
    if ($name === '') {
        continue;
    }
    $grupo = $get($row, 'Grupo de traducción');
    $slugEs = $translationMap[$grupo] ?? null;
    $slug = $slugEs ?? sw_slugify($name);

    $cats = array_map('trim', explode(',', $get($row, 'Categorías')));
    $condicion = in_array('New', $cats, true) ? 'nuevo' : 'usado';
    $categoria = 'general';
    foreach ($cats as $c) {
        if ($c === 'Fine grains') {
            $categoria = 'granos-finos';
            break;
        }
        if ($c === 'Coarse grains') {
            $categoria = 'granos-gruesos';
            break;
        }
    }

    $priceRaw = $get($row, 'Precio normal');
    $price = $priceRaw === '' ? null : (float) $priceRaw;

    $enItems[] = [
        'slug' => $slug,
        'wc_id' => $get($row, 'ID'),
        'title' => $name,
        'condicion' => $condicion,
        'categoria' => $categoria,
        'price' => $price,
        'sku' => $get($row, 'SKU'),
        'description_html' => sw_sanitize_description($get($row, 'Descripción')),
        'specs' => sw_split_specs($get($row, 'Valor(es) del atributo 1')),
        'images' => $slugEs !== null ? ($imagesBySlug[$slugEs] ?? []) : [],
        'image_alt' => $name,
    ];
}

JsonStore::save('catalogo-en-draft.json', $enItems);
echo "backend/data/catalogo-en-draft.json escrito con " . count($enItems) . " ítems (borrador, sin publicar).\n";
