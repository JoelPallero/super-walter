<?php
declare(strict_types=1);

require __DIR__ . '/_guard.php';
require __DIR__ . '/_upload.php';

use SuperWalter\JsonStore;

$origSlug = trim((string) ($_GET['slug'] ?? ''));
$editing = $origSlug !== '';
$existing = $editing ? JsonStore::find('productos.json', $origSlug) : null;

if ($editing && $existing === null) {
    $_SESSION['flash'] = ['type' => 'error', 'msg' => 'No se encontró ese producto.'];
    header('Location: index.php');
    exit;
}

$errors = [];
$jsonField = static function (string $raw, string $label, array &$errors) {
    $raw = trim($raw);
    if ($raw === '') {
        return [];
    }
    $decoded = json_decode($raw, true);
    if (!is_array($decoded)) {
        $errors[] = "El campo \"$label\" no es un JSON válido.";
        return [];
    }
    return $decoded;
};

// Valores por defecto: se completan con los del producto existente si los hay,
// así ningún campo queda como índice inexistente al renderizar el form.
$v = array_merge([
    'slug' => '', 'title' => '', 'seo_title' => '', 'seo_description' => '',
    'og_title' => '', 'og_description' => '', 'hero_image' => '', 'hero_image_alt' => '',
    'hero_pills' => [], 'lead' => '', 'cta_hero_text' => 'Consultar', 'ficha_eyebrow' => 'Ficha del modelo',
    'ficha_heading' => '', 'ficha_layout' => 'single_image', 'ficha_image' => '', 'ficha_image_alt' => '',
    'ficha_badge' => '', 'features' => [], 'sub_models' => [], 'benefits_heading' => '', 'benefits' => [],
    'cta_title_html' => '', 'cta_lead' => 'Completá el formulario y un asesor de Super Walter se comunica con vos para avanzar con la cotización.',
    'form_message_placeholder' => 'Hectáreas, cultivo, forma de pago...',
    'listing_badge' => ['text' => '', 'variant' => 'plain'], 'is_homepage_featured' => false,
    'homepage_chips' => [], 'homepage_link_text' => '',
], $existing ?? []);

$rawFeatures = json_encode($v['features'] ?? [], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
$rawSubModels = json_encode($v['sub_models'] ?? [], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
$rawBenefits = json_encode($v['benefits'] ?? [], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
$rawHeroPills = json_encode($v['hero_pills'] ?? [], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!sw_admin_csrf_check()) {
        $errors[] = 'Sesión expirada, volvé a intentar.';
    }

    $slug = strtolower(trim((string) ($_POST['slug'] ?? '')));
    $title = trim((string) ($_POST['title'] ?? ''));
    $rawFeatures = (string) ($_POST['features'] ?? $rawFeatures);
    $rawSubModels = (string) ($_POST['sub_models'] ?? $rawSubModels);
    $rawBenefits = (string) ($_POST['benefits'] ?? $rawBenefits);
    $rawHeroPills = (string) ($_POST['hero_pills'] ?? $rawHeroPills);

    if ($slug === '' || !preg_match('/^[a-z0-9]+(-[a-z0-9]+)*$/', $slug)) {
        $errors[] = 'El slug es obligatorio y solo puede tener minúsculas, números y guiones.';
    } elseif (JsonStore::slugExists('productos.json', $slug, $origSlug)) {
        $errors[] = 'Ya existe otro producto con ese slug.';
    }
    if ($title === '') {
        $errors[] = 'El título es obligatorio.';
    }

    $features = $jsonField($rawFeatures, 'Features', $errors);
    $subModels = $jsonField($rawSubModels, 'Sub-modelos', $errors);
    $benefits = $jsonField($rawBenefits, 'Beneficios', $errors);
    $heroPills = $jsonField($rawHeroPills, 'Pills del hero', $errors);

    $heroImage = $v['hero_image'] ?? '';
    $fichaImage = $v['ficha_image'] ?? '';
    try {
        $uploaded = sw_admin_handle_image_upload('hero_image_file', $slug . '-hero');
        if ($uploaded !== null) {
            $heroImage = $uploaded;
        } elseif (trim((string) ($_POST['hero_image'] ?? '')) !== '') {
            $heroImage = trim((string) $_POST['hero_image']);
        }
        $uploadedFicha = sw_admin_handle_image_upload('ficha_image_file', $slug . '-ficha');
        if ($uploadedFicha !== null) {
            $fichaImage = $uploadedFicha;
        } elseif (trim((string) ($_POST['ficha_image'] ?? '')) !== '') {
            $fichaImage = trim((string) $_POST['ficha_image']);
        }
    } catch (\RuntimeException $e) {
        $errors[] = $e->getMessage();
    }

    if ($heroImage === '') {
        $errors[] = 'La imagen del hero es obligatoria (subí un archivo o indicá una ruta existente, ej: assets/img/w660.webp).';
    }

    $homepageChips = array_values(array_filter(array_map('trim', explode(',', (string) ($_POST['homepage_chips'] ?? '')))));

    if (empty($errors)) {
        $data = [
            'slug' => $slug,
            'title' => $title,
            'seo_title' => trim((string) ($_POST['seo_title'] ?? '')),
            'seo_description' => trim((string) ($_POST['seo_description'] ?? '')),
            'og_title' => trim((string) ($_POST['og_title'] ?? '')),
            'og_description' => trim((string) ($_POST['og_description'] ?? '')),
            'hero_image' => $heroImage,
            'hero_image_alt' => trim((string) ($_POST['hero_image_alt'] ?? '')),
            'hero_pills' => $heroPills,
            'lead' => trim((string) ($_POST['lead'] ?? '')),
            'cta_hero_text' => trim((string) ($_POST['cta_hero_text'] ?? '')),
            'ficha_eyebrow' => trim((string) ($_POST['ficha_eyebrow'] ?? '')),
            'ficha_heading' => trim((string) ($_POST['ficha_heading'] ?? '')),
            'ficha_layout' => in_array($_POST['ficha_layout'] ?? '', ['single_image', 'side_image', 'no_image_multi_model'], true)
                ? $_POST['ficha_layout'] : 'single_image',
            'ficha_image' => $fichaImage,
            'ficha_image_alt' => trim((string) ($_POST['ficha_image_alt'] ?? '')),
            'ficha_badge' => trim((string) ($_POST['ficha_badge'] ?? '')),
            'features' => $features,
            'sub_models' => $subModels,
            'benefits_heading' => trim((string) ($_POST['benefits_heading'] ?? '')),
            'benefits' => $benefits,
            'cta_title_html' => trim((string) ($_POST['cta_title_html'] ?? '')),
            'cta_lead' => trim((string) ($_POST['cta_lead'] ?? '')),
            'form_message_placeholder' => trim((string) ($_POST['form_message_placeholder'] ?? '')),
            'listing_badge' => [
                'text' => trim((string) ($_POST['listing_badge_text'] ?? '')),
                'variant' => in_array($_POST['listing_badge_variant'] ?? '', ['plain', 'outline', 'amarillo'], true)
                    ? $_POST['listing_badge_variant'] : 'plain',
            ],
            'is_homepage_featured' => !empty($_POST['is_homepage_featured']),
            'homepage_chips' => $homepageChips,
            'homepage_link_text' => trim((string) ($_POST['homepage_link_text'] ?? '')),
        ];

        if ($editing && $origSlug !== $slug) {
            JsonStore::delete('productos.json', $origSlug);
        }
        JsonStore::upsert('productos.json', $data);

        $_SESSION['flash'] = ['type' => 'ok', 'msg' => 'Producto guardado correctamente.'];
        header('Location: index.php');
        exit;
    }

    // Si hay errores, mantenemos en pantalla lo que el usuario tipeó.
    $v = array_merge($v, $_POST, ['slug' => $slug, 'title' => $title]);
}

$h = static fn ($s): string => htmlspecialchars((string) ($s ?? ''), ENT_QUOTES, 'UTF-8');
$pageTitle = ($editing ? 'Editar' : 'Nuevo') . ' producto · Panel admin';
require __DIR__ . '/_layout-top.php';
?>
<h1><?= $editing ? 'Editar producto' : 'Nuevo producto' ?></h1>

<?php foreach ($errors as $err): ?>
<p class="flash flash--error"><?= $h($err) ?></p>
<?php endforeach; ?>

<form method="post" enctype="multipart/form-data" novalidate>
  <?= sw_admin_csrf_field() ?>

  <fieldset>
    <legend>Datos básicos</legend>
    <div class="grid2">
      <div class="field"><label for="slug">Slug (URL)</label><input type="text" id="slug" name="slug" value="<?= $h($v['slug']) ?>" placeholder="w660" required></div>
      <div class="field"><label for="title">Título</label><input type="text" id="title" name="title" value="<?= $h($v['title']) ?>" placeholder="W660" required></div>
    </div>
    <div class="field"><label for="lead">Bajada (lead)</label><textarea class="prose" id="lead" name="lead"><?= $h($v['lead']) ?></textarea></div>
    <div class="field"><label for="cta_hero_text">Texto botón del hero</label><input type="text" id="cta_hero_text" name="cta_hero_text" value="<?= $h($v['cta_hero_text']) ?>"></div>
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
    <legend>Imagen del hero</legend>
    <div class="grid2">
      <div class="field"><label for="hero_image">Ruta (existente en assets/img/…)</label><input type="text" id="hero_image" name="hero_image" value="<?= $h($v['hero_image']) ?>" placeholder="assets/img/w660.webp"></div>
      <div class="field"><label for="hero_image_file">…o subir una nueva (jpg/png/webp, máx 5MB)</label><input type="file" id="hero_image_file" name="hero_image_file" accept=".jpg,.jpeg,.png,.webp"></div>
    </div>
    <div class="field"><label for="hero_image_alt">Texto alternativo</label><input type="text" id="hero_image_alt" name="hero_image_alt" value="<?= $h($v['hero_image_alt']) ?>"></div>
    <div class="field"><label for="hero_pills">Pills del hero (JSON avanzado)</label>
      <textarea id="hero_pills" name="hero_pills"><?= $h($rawHeroPills) ?></textarea>
      <p class="hint">Array de objetos: [{"text":"Grano fino","variant":"outline"}]. Variant: plain | outline | amarillo.</p>
    </div>
  </fieldset>

  <fieldset>
    <legend>Ficha del modelo</legend>
    <div class="grid2">
      <div class="field"><label for="ficha_eyebrow">Eyebrow</label><input type="text" id="ficha_eyebrow" name="ficha_eyebrow" value="<?= $h($v['ficha_eyebrow']) ?>"></div>
      <div class="field"><label for="ficha_layout">Layout</label>
        <select id="ficha_layout" name="ficha_layout">
          <option value="single_image" <?= ($v['ficha_layout'] ?? '') === 'single_image' ? 'selected' : '' ?>>Imagen única (ej: W660)</option>
          <option value="side_image" <?= ($v['ficha_layout'] ?? '') === 'side_image' ? 'selected' : '' ?>>Imagen lateral + badge (ej: W1770, W650)</option>
          <option value="no_image_multi_model" <?= ($v['ficha_layout'] ?? '') === 'no_image_multi_model' ? 'selected' : '' ?>>Sin imagen, varios sub-modelos (ej: Familia)</option>
        </select>
      </div>
    </div>
    <div class="field"><label for="ficha_heading">Título de la ficha</label><textarea class="prose" id="ficha_heading" name="ficha_heading"><?= $h($v['ficha_heading']) ?></textarea></div>
    <div class="grid2">
      <div class="field"><label for="ficha_image">Imagen de ficha (ruta existente, opcional)</label><input type="text" id="ficha_image" name="ficha_image" value="<?= $h($v['ficha_image']) ?>"></div>
      <div class="field"><label for="ficha_image_file">…o subir una nueva</label><input type="file" id="ficha_image_file" name="ficha_image_file" accept=".jpg,.jpeg,.png,.webp"></div>
    </div>
    <div class="grid2">
      <div class="field"><label for="ficha_image_alt">Alt de imagen de ficha</label><input type="text" id="ficha_image_alt" name="ficha_image_alt" value="<?= $h($v['ficha_image_alt']) ?>"></div>
      <div class="field"><label for="ficha_badge">Badge sobre la imagen (solo layout "lateral")</label><input type="text" id="ficha_badge" name="ficha_badge" value="<?= $h($v['ficha_badge']) ?>"></div>
    </div>
    <div class="field"><label for="features">Features (JSON avanzado, layouts "imagen única"/"lateral")</label>
      <textarea id="features" name="features"><?= $h($rawFeatures) ?></textarea>
      <p class="hint">Array: [{"icon":"clock","title":"...","text":"..."}]. Iconos disponibles: bars, clock, cube, monitor.</p>
    </div>
    <div class="field"><label for="sub_models">Sub-modelos (JSON avanzado, solo layout "sin imagen")</label>
      <textarea id="sub_models" name="sub_models"><?= $h($rawSubModels) ?></textarea>
      <p class="hint">Mismo formato que Features: [{"icon":"bars","title":"...","text":"..."}]</p>
    </div>
  </fieldset>

  <fieldset>
    <legend>Beneficios</legend>
    <div class="field"><label for="benefits_heading">Título de la sección</label><input type="text" id="benefits_heading" name="benefits_heading" value="<?= $h($v['benefits_heading']) ?>"></div>
    <div class="field"><label for="benefits">Beneficios (JSON avanzado, 4 ítems)</label>
      <textarea id="benefits" name="benefits"><?= $h($rawBenefits) ?></textarea>
      <p class="hint">Array: [{"number":"01","title":"...","text":"..."}]</p>
    </div>
  </fieldset>

  <fieldset>
    <legend>Formulario de cotización</legend>
    <div class="field"><label for="cta_title_html">Título del CTA (admite &lt;em&gt;)</label><input type="text" id="cta_title_html" name="cta_title_html" value="<?= $h($v['cta_title_html']) ?>"></div>
    <div class="field"><label for="cta_lead">Texto del CTA</label><textarea class="prose" id="cta_lead" name="cta_lead"><?= $h($v['cta_lead']) ?></textarea></div>
    <div class="field"><label for="form_message_placeholder">Placeholder del campo "mensaje"</label><input type="text" id="form_message_placeholder" name="form_message_placeholder" value="<?= $h($v['form_message_placeholder']) ?>"></div>
  </fieldset>

  <fieldset>
    <legend>Cómo aparece listado en otras páginas</legend>
    <div class="grid2">
      <div class="field"><label for="listing_badge_text">Badge (ej: "Grano fino")</label><input type="text" id="listing_badge_text" name="listing_badge_text" value="<?= $h($v['listing_badge']['text'] ?? '') ?>"></div>
      <div class="field"><label for="listing_badge_variant">Variante del badge</label>
        <select id="listing_badge_variant" name="listing_badge_variant">
          <option value="plain" <?= ($v['listing_badge']['variant'] ?? '') === 'plain' ? 'selected' : '' ?>>Normal</option>
          <option value="outline" <?= ($v['listing_badge']['variant'] ?? '') === 'outline' ? 'selected' : '' ?>>Outline</option>
          <option value="amarillo" <?= ($v['listing_badge']['variant'] ?? '') === 'amarillo' ? 'selected' : '' ?>>Amarillo (destacado)</option>
        </select>
      </div>
    </div>
    <div class="field checks"><label><input type="checkbox" name="is_homepage_featured" value="1" <?= !empty($v['is_homepage_featured']) ? 'checked' : '' ?>> Mostrar como tarjeta grande destacada en el home</label></div>
    <div class="grid2">
      <div class="field"><label for="homepage_chips">Chips del home (separados por coma, solo si está destacado)</label><input type="text" id="homepage_chips" name="homepage_chips" value="<?= $h(implode(', ', $v['homepage_chips'] ?? [])) ?>"></div>
      <div class="field"><label for="homepage_link_text">Texto del link en el home (opcional)</label><input type="text" id="homepage_link_text" name="homepage_link_text" value="<?= $h($v['homepage_link_text'] ?? '') ?>"></div>
    </div>
  </fieldset>

  <button class="btn" type="submit">Guardar producto</button>
  <a class="btn btn--ghost" href="index.php">Cancelar</a>
</form>

<?php require __DIR__ . '/_layout-bottom.php'; ?>
