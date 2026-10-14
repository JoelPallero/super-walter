<?php
declare(strict_types=1);

require __DIR__ . '/_guard.php';
require __DIR__ . '/_upload.php';

use SuperWalter\JsonStore;

$origSlug = trim((string) ($_GET['slug'] ?? ''));
$editing = $origSlug !== '';
$existing = $editing ? JsonStore::find('novedades.json', $origSlug) : null;

if ($editing && $existing === null) {
    $_SESSION['flash'] = ['type' => 'error', 'msg' => 'No se encontró esa novedad.'];
    header('Location: index.php');
    exit;
}

$todas = JsonStore::all('novedades.json');
$errors = [];

$v = array_merge([
    'slug' => '', 'title' => '', 'seo_title' => '', 'seo_description' => '',
    'og_title' => '', 'og_description' => '', 'category' => 'institucional', 'category_label' => 'Institucional',
    'subcategory_label' => '', 'date' => date('Y-m-d'), 'hero_image' => '', 'hero_image_alt' => '',
    'lead' => '', 'body_paragraphs' => [], 'chips' => [], 'cta_text' => 'Solicitar asesoramiento',
    'cta_href' => 'contacto.php', 'related_slugs' => [], 'is_featured' => false,
    'featured_desc' => '', 'featured_link_text' => '', 'listing_link_text' => '',
], $existing ?? []);

$categoryLabels = ['institucional' => 'Institucional', 'ferias' => 'Ferias', 'comercial' => 'Comercial', 'comunidad' => 'Comunidad'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!sw_admin_csrf_check()) {
        $errors[] = 'Sesión expirada, volvé a intentar.';
    }

    $slug = strtolower(trim((string) ($_POST['slug'] ?? '')));
    $title = trim((string) ($_POST['title'] ?? ''));
    $date = trim((string) ($_POST['date'] ?? ''));

    if ($slug === '' || !preg_match('/^[a-z0-9]+(-[a-z0-9]+)*$/', $slug)) {
        $errors[] = 'El slug es obligatorio y solo puede tener minúsculas, números y guiones.';
    } elseif (JsonStore::slugExists('novedades.json', $slug, $origSlug)) {
        $errors[] = 'Ya existe otra novedad con ese slug.';
    }
    if ($title === '') {
        $errors[] = 'El título es obligatorio.';
    }
    if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $date)) {
        $errors[] = 'La fecha debe tener formato AAAA-MM-DD.';
    }

    $category = array_key_exists($_POST['category'] ?? '', $categoryLabels) ? $_POST['category'] : 'institucional';

    $bodyParagraphs = array_values(array_filter(array_map(
        'trim',
        preg_split('/\r?\n\r?\n+/', (string) ($_POST['body_paragraphs'] ?? '')) ?: []
    ), static fn (string $p): bool => $p !== ''));

    $chips = array_values(array_filter(array_map('trim', explode(',', (string) ($_POST['chips'] ?? '')))));
    $relatedSlugs = array_values(array_filter((array) ($_POST['related_slugs'] ?? [])));

    $heroImage = $v['hero_image'] ?? '';
    try {
        $uploaded = sw_admin_handle_image_upload('hero_image_file', $slug . '-hero');
        if ($uploaded !== null) {
            $heroImage = $uploaded;
        } elseif (trim((string) ($_POST['hero_image'] ?? '')) !== '') {
            $heroImage = trim((string) $_POST['hero_image']);
        }
    } catch (\RuntimeException $e) {
        $errors[] = $e->getMessage();
    }
    if ($heroImage === '') {
        $errors[] = 'La imagen es obligatoria (subí un archivo o indicá una ruta existente, ej: assets/img/trigo.webp).';
    }
    if (empty($bodyParagraphs)) {
        $errors[] = 'El cuerpo de la nota necesita al menos un párrafo.';
    }

    if (empty($errors)) {
        $data = [
            'slug' => $slug,
            'title' => $title,
            'seo_title' => trim((string) ($_POST['seo_title'] ?? '')),
            'seo_description' => trim((string) ($_POST['seo_description'] ?? '')),
            'og_title' => trim((string) ($_POST['og_title'] ?? '')),
            'og_description' => trim((string) ($_POST['og_description'] ?? '')),
            'category' => $category,
            'category_label' => $categoryLabels[$category],
            'subcategory_label' => trim((string) ($_POST['subcategory_label'] ?? '')),
            'date' => $date,
            'hero_image' => $heroImage,
            'hero_image_alt' => trim((string) ($_POST['hero_image_alt'] ?? '')),
            'lead' => trim((string) ($_POST['lead'] ?? '')),
            'body_paragraphs' => $bodyParagraphs,
            'chips' => $chips,
            'cta_text' => trim((string) ($_POST['cta_text'] ?? '')),
            'cta_href' => trim((string) ($_POST['cta_href'] ?? 'contacto.php')),
            'related_slugs' => $relatedSlugs,
            'is_featured' => !empty($_POST['is_featured']),
            'featured_desc' => trim((string) ($_POST['featured_desc'] ?? '')),
            'featured_link_text' => trim((string) ($_POST['featured_link_text'] ?? '')),
            'listing_link_text' => trim((string) ($_POST['listing_link_text'] ?? '')),
        ];

        if ($editing && $origSlug !== $slug) {
            JsonStore::delete('novedades.json', $origSlug);
        }
        JsonStore::upsert('novedades.json', $data);

        $_SESSION['flash'] = ['type' => 'ok', 'msg' => 'Novedad guardada correctamente.'];
        header('Location: index.php');
        exit;
    }

    $v = array_merge($v, $_POST, [
        'slug' => $slug, 'title' => $title, 'date' => $date, 'category' => $category,
        'body_paragraphs' => $bodyParagraphs, 'chips' => $chips, 'related_slugs' => $relatedSlugs,
    ]);
}

$h = static fn ($s): string => htmlspecialchars((string) ($s ?? ''), ENT_QUOTES, 'UTF-8');
$pageTitle = ($editing ? 'Editar' : 'Nueva') . ' novedad · Panel admin';
require __DIR__ . '/_layout-top.php';
?>
<h1><?= $editing ? 'Editar novedad' : 'Nueva novedad' ?></h1>

<?php foreach ($errors as $err): ?>
<p class="flash flash--error"><?= $h($err) ?></p>
<?php endforeach; ?>

<form method="post" enctype="multipart/form-data" novalidate>
  <?= sw_admin_csrf_field() ?>

  <fieldset>
    <legend>Datos básicos</legend>
    <div class="grid2">
      <div class="field"><label for="slug">Slug (URL)</label><input type="text" id="slug" name="slug" value="<?= $h($v['slug']) ?>" placeholder="mi-novedad-2026" required></div>
      <div class="field"><label for="date">Fecha</label><input type="date" id="date" name="date" value="<?= $h($v['date']) ?>" required></div>
    </div>
    <div class="field"><label for="title">Título</label><input type="text" id="title" name="title" value="<?= $h($v['title']) ?>" required></div>
    <div class="grid2">
      <div class="field"><label for="category">Categoría</label>
        <select id="category" name="category">
<?php foreach ($categoryLabels as $key => $label): ?>
          <option value="<?= $h($key) ?>" <?= ($v['category'] ?? '') === $key ? 'selected' : '' ?>><?= $h($label) ?></option>
<?php endforeach; ?>
        </select>
      </div>
      <div class="field"><label for="subcategory_label">Sub-categoría (texto libre, ej: "Aapresid")</label><input type="text" id="subcategory_label" name="subcategory_label" value="<?= $h($v['subcategory_label']) ?>"></div>
    </div>
    <div class="field"><label for="lead">Bajada (lead, se muestra en el hero y en los listados)</label><textarea class="prose" id="lead" name="lead"><?= $h($v['lead']) ?></textarea></div>
  </fieldset>

  <fieldset>
    <legend>SEO</legend>
    <div class="field"><label for="seo_title">Title (pestaña del navegador)</label><input type="text" id="seo_title" name="seo_title" value="<?= $h($v['seo_title']) ?>"></div>
    <div class="field"><label for="seo_description">Meta description</label><textarea id="seo_description" name="seo_description" class="prose"><?= $h($v['seo_description']) ?></textarea></div>
    <div class="grid2">
      <div class="field"><label for="og_title">og:title</label><input type="text" id="og_title" name="og_title" value="<?= $h($v['og_title']) ?>"></div>
      <div class="field"><label for="og_description">og:description</label><input type="text" id="og_description" name="og_description" value="<?= $h($v['og_description']) ?>"></div>
    </div>
  </fieldset>

  <fieldset>
    <legend>Imagen</legend>
    <div class="grid2">
      <div class="field"><label for="hero_image">Ruta (existente en assets/img/…)</label><input type="text" id="hero_image" name="hero_image" value="<?= $h($v['hero_image']) ?>" placeholder="assets/img/trigo.webp"></div>
      <div class="field"><label for="hero_image_file">…o subir una nueva (jpg/png/webp, máx 5MB)</label><input type="file" id="hero_image_file" name="hero_image_file" accept=".jpg,.jpeg,.png,.webp"></div>
    </div>
    <div class="field"><label for="hero_image_alt">Texto alternativo</label><input type="text" id="hero_image_alt" name="hero_image_alt" value="<?= $h($v['hero_image_alt']) ?>"></div>
  </fieldset>

  <fieldset>
    <legend>Cuerpo de la nota</legend>
    <div class="field"><label for="body_paragraphs">Párrafos (dejá una línea en blanco entre párrafo y párrafo)</label>
      <textarea class="prose" id="body_paragraphs" name="body_paragraphs" style="min-height:12rem"><?= $h(is_array($v['body_paragraphs']) ? implode("\n\n", $v['body_paragraphs']) : $v['body_paragraphs']) ?></textarea>
    </div>
    <div class="field"><label for="chips">Chips al pie de la nota (separados por coma, opcional)</label><input type="text" id="chips" name="chips" value="<?= $h(is_array($v['chips']) ? implode(', ', $v['chips']) : $v['chips']) ?>"></div>
    <div class="grid2">
      <div class="field"><label for="cta_text">Texto del botón</label><input type="text" id="cta_text" name="cta_text" value="<?= $h($v['cta_text']) ?>"></div>
      <div class="field"><label for="cta_href">Destino del botón</label><input type="text" id="cta_href" name="cta_href" value="<?= $h($v['cta_href']) ?>" placeholder="contacto.php">
        <p class="hint">Relativo a la raíz del sitio: contacto.php, empresa.php, index.php#lineup...</p>
      </div>
    </div>
  </fieldset>

  <fieldset>
    <legend>Más novedades relacionadas</legend>
    <div class="field checks">
<?php foreach ($todas as $n): if ($n['slug'] === $origSlug) continue; ?>
      <label><input type="checkbox" name="related_slugs[]" value="<?= $h($n['slug']) ?>" <?= in_array($n['slug'], (array) ($v['related_slugs'] ?? []), true) ? 'checked' : '' ?>> <?= $h($n['title']) ?></label><br>
<?php endforeach; ?>
    </div>
    <p class="hint">Si no elegís ninguna, se muestran automáticamente las más recientes de la misma categoría.</p>
  </fieldset>

  <fieldset>
    <legend>Destacada en /novedades</legend>
    <div class="field checks"><label><input type="checkbox" name="is_featured" value="1" <?= !empty($v['is_featured']) ? 'checked' : '' ?>> Mostrar como novedad destacada</label></div>
    <div class="field"><label for="featured_desc">Descripción larga (solo si está destacada)</label><textarea class="prose" id="featured_desc" name="featured_desc"><?= $h($v['featured_desc']) ?></textarea></div>
    <div class="grid2">
      <div class="field"><label for="featured_link_text">Texto del link (destacada)</label><input type="text" id="featured_link_text" name="featured_link_text" value="<?= $h($v['featured_link_text']) ?>" placeholder="Leer la nota completa"></div>
      <div class="field"><label for="listing_link_text">Texto del link en el listado general (opcional)</label><input type="text" id="listing_link_text" name="listing_link_text" value="<?= $h($v['listing_link_text']) ?>" placeholder="Leer más"></div>
    </div>
  </fieldset>

  <button class="btn" type="submit">Guardar novedad</button>
  <a class="btn btn--ghost" href="index.php">Cancelar</a>
</form>

<?php require __DIR__ . '/_layout-bottom.php'; ?>
