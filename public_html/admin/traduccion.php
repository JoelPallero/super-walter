<?php
declare(strict_types=1);

require __DIR__ . '/_guard.php';

use SuperWalter\JsonStore;

$type = (string) ($_GET['type'] ?? '');
$slug = trim((string) ($_GET['slug'] ?? ''));

$maps = [
    'producto' => ['productos.json', 'productos-en.json', 'producto', 'products'],
    'novedad'  => ['novedades.json', 'novedades-en.json', 'novedad', 'news'],
    'catalogo' => ['catalogo.json', 'catalogo-en.json', 'ítem de catálogo', 'catalog'],
];

// kinds: text | textarea | json | lines (una por línea) | csv (separado por comas) | paras (separados por línea en blanco)
$specs = [
    'producto' => [
        ['title', 'Título', 'text'], ['seo_title', 'SEO title', 'text'], ['seo_description', 'Meta description', 'textarea'],
        ['og_title', 'og:title', 'text'], ['og_description', 'og:description', 'text'], ['hero_image_alt', 'Texto alternativo del hero', 'text'],
        ['hero_pills', 'Pills del hero (JSON)', 'json'], ['lead', 'Bajada (lead)', 'textarea'], ['cta_hero_text', 'Texto del botón del hero', 'text'],
        ['ficha_eyebrow', 'Ficha: eyebrow', 'text'], ['ficha_heading', 'Ficha: título', 'textarea'], ['ficha_image_alt', 'Ficha: texto alternativo de imagen', 'text'],
        ['ficha_badge', 'Ficha: badge', 'text'], ['features', 'Features (JSON)', 'json'], ['sub_models', 'Sub-modelos (JSON)', 'json'],
        ['benefits_heading', 'Beneficios: título', 'text'], ['benefits', 'Beneficios (JSON)', 'json'], ['cta_title_html', 'CTA: título (HTML)', 'text'],
        ['cta_lead', 'CTA: bajada', 'textarea'], ['form_message_placeholder', 'Placeholder del mensaje del formulario', 'text'],
        ['listing_badge_text', 'Texto del badge en el listado', 'text'], ['homepage_chips', 'Chips en la home (separados por coma)', 'csv'],
        ['homepage_link_text', 'Texto del link en la home', 'text'],
    ],
    'novedad' => [
        ['title', 'Título', 'text'], ['seo_title', 'SEO title', 'text'], ['seo_description', 'Meta description', 'textarea'],
        ['og_title', 'og:title', 'text'], ['og_description', 'og:description', 'text'], ['category_label', 'Etiqueta de categoría', 'text'],
        ['subcategory_label', 'Etiqueta de sub-categoría', 'text'], ['hero_image_alt', 'Texto alternativo de la imagen', 'text'],
        ['lead', 'Bajada (lead)', 'textarea'], ['body_paragraphs', 'Párrafos del cuerpo (línea en blanco entre párrafos)', 'paras'],
        ['chips', 'Chips al pie (separados por coma)', 'csv'], ['cta_text', 'Texto del botón', 'text'],
        ['featured_desc', 'Descripción larga (destacada)', 'textarea'], ['featured_link_text', 'Texto del link (destacada)', 'text'],
        ['listing_link_text', 'Texto del link en el listado', 'text'],
    ],
    'catalogo' => [
        ['title', 'Título', 'text'], ['image_alt', 'Texto alternativo de la imagen', 'text'],
        ['description_html', 'Descripción (HTML simple)', 'textarea'], ['specs', 'Especificaciones (una por línea, formato Etiqueta | Valor)', 'lines'],
    ],
];

$base = null;
if (isset($maps[$type]) && $slug !== '') {
    $base = JsonStore::find($maps[$type][0], $slug);
}
if ($base === null) {
    $_SESSION['flash'] = ['type' => 'error', 'msg' => 'No se encontró el contenido a traducir.'];
    header('Location: index.php');
    exit;
}
[$baseFile, $overFile, $typeLabel, $enPath] = $maps[$type];
$fields = $specs[$type];
$over = JsonStore::find($overFile, $slug) ?? [];

$h = static fn ($s): string => htmlspecialchars((string) ($s ?? ''), ENT_QUOTES, 'UTF-8');
$pretty = static fn ($v): string => (string) json_encode($v, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);

// Valor de un registro (base u overlay) -> texto editable.
$toStr = static function (string $key, string $kind, array $rec) use ($pretty): string {
    if ($key === 'listing_badge_text') {
        return (string) ($rec['listing_badge']['text'] ?? '');
    }
    $val = $rec[$key] ?? null;
    if ($val === null || $val === '' || $val === []) {
        return '';
    }
    switch ($kind) {
        case 'json':  return $pretty($val);
        case 'lines': return is_array($val) ? implode("\n", $val) : (string) $val;
        case 'csv':   return is_array($val) ? implode(', ', $val) : (string) $val;
        case 'paras': return is_array($val) ? implode("\n\n", $val) : (string) $val;
        default:      return is_array($val) ? $pretty($val) : (string) $val;
    }
};

$errors = [];
$values = [];
foreach ($fields as [$key, $label, $kind]) {
    $values[$key] = $toStr($key, $kind, $over);
    if ($kind === 'json' && $values[$key] === '') {
        $values[$key] = $toStr($key, $kind, $base); // plantilla con la estructura en español
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!sw_admin_csrf_check()) {
        $errors[] = 'Sesión expirada, volvé a intentar.';
    }
    $nonEmpty = static fn ($l): bool => $l !== '';
    $record = ['slug' => $slug];
    foreach ($fields as [$key, $label, $kind]) {
        $raw = trim(str_replace("\r\n", "\n", (string) ($_POST[$key] ?? '')));
        $values[$key] = $raw;
        if ($raw === '') {
            continue;
        }
        switch ($kind) {
            case 'json':
                $dec = json_decode($raw, true);
                if (!is_array($dec)) {
                    $errors[] = "El campo \"$label\" no es un JSON válido.";
                } elseif ($dec) {
                    $record[$key] = $dec;
                }
                break;
            case 'lines':
                $record[$key] = array_values(array_filter(array_map('trim', explode("\n", $raw)), $nonEmpty));
                break;
            case 'csv':
                $record[$key] = array_values(array_filter(array_map('trim', explode(',', $raw)), $nonEmpty));
                break;
            case 'paras':
                $record[$key] = array_values(array_filter(array_map('trim', preg_split('/\n\n+/', $raw) ?: []), $nonEmpty));
                break;
            default:
                if ($key === 'listing_badge_text') {
                    $record['listing_badge'] = ['text' => $raw, 'variant' => (string) ($base['listing_badge']['variant'] ?? 'plain')];
                } else {
                    $record[$key] = $raw;
                }
        }
    }

    if (!$errors) {
        if (count($record) > 1) {
            JsonStore::upsert($overFile, $record);
        } else {
            JsonStore::delete($overFile, $slug);
        }
        $_SESSION['flash'] = ['type' => 'ok', 'msg' => 'Traducción guardada.'];
        header('Location: index.php');
        exit;
    }
}

$pageTitle = 'Traducción al inglés · Panel admin';
require __DIR__ . '/_layout-top.php';
?>
<h1>Traducción al inglés: <?= $h($typeLabel) ?> <code><?= $h($slug) ?></code></h1>
<p class="hint">Los campos vacíos usan el texto en español como respaldo. Debajo de cada campo se muestra el original.</p>
<p><a class="btn btn--ghost" href="index.php">&larr; Volver al listado</a>
   <a class="btn btn--ghost" href="../en/<?= $h($enPath) ?>/<?= $h(urlencode($slug)) ?>" target="_blank">Ver página en inglés</a></p>

<?php foreach ($errors as $err): ?>
<p class="flash flash--error"><?= $h($err) ?></p>
<?php endforeach; ?>

<form method="post" novalidate>
  <?= sw_admin_csrf_field() ?>
  <fieldset>
    <legend>Textos en inglés</legend>
<?php foreach ($fields as [$key, $label, $kind]):
    $orig = $toStr($key, $kind, $base);
    $isBig = in_array($kind, ['textarea', 'json', 'lines', 'paras'], true);
    $rows = $kind === 'json' ? 14 : ($kind === 'paras' ? 10 : 4);
?>
    <div class="field">
      <label for="f_<?= $h($key) ?>"><?= $h($label) ?></label>
<?php if ($isBig): ?>
      <textarea id="f_<?= $h($key) ?>" name="<?= $h($key) ?>" rows="<?= $rows ?>"<?= $kind === 'json' ? ' spellcheck="false" style="font-family:monospace"' : '' ?>><?= $h($values[$key]) ?></textarea>
<?php else: ?>
      <input type="text" id="f_<?= $h($key) ?>" name="<?= $h($key) ?>" value="<?= $h($values[$key]) ?>">
<?php endif; ?>
<?php if ($kind === 'json'): ?>
      <p class="hint">Prellenado con la estructura en español si aún no hay traducción; traducí solo los textos y conservá claves y variantes.</p>
<?php elseif ($orig !== ''): ?>
      <p class="hint"><strong>ES:</strong> <span style="white-space:pre-wrap"><?= $h($orig) ?></span></p>
<?php endif; ?>
    </div>
<?php endforeach; ?>
  </fieldset>

  <button class="btn" type="submit">Guardar traducción</button>
  <a class="btn btn--ghost" href="index.php">Cancelar</a>
</form>

<?php require __DIR__ . '/_layout-bottom.php'; ?>
