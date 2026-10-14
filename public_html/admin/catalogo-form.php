<?php
declare(strict_types=1);

require __DIR__ . '/_guard.php';
require __DIR__ . '/_upload.php';

use SuperWalter\JsonStore;

$origSlug = trim((string) ($_GET['slug'] ?? ''));
$editing = $origSlug !== '';
$existing = $editing ? JsonStore::find('catalogo.json', $origSlug) : null;

if ($editing && $existing === null) {
    $_SESSION['flash'] = ['type' => 'error', 'msg' => 'No se encontró ese ítem de catálogo.'];
    header('Location: index.php');
    exit;
}

$errors = [];

$v = array_merge([
    'slug' => '', 'wc_id' => '', 'title' => '', 'condicion' => 'usado', 'categoria' => 'general',
    'price' => null, 'sku' => '', 'description_html' => '', 'specs' => [], 'images' => [], 'image_alt' => '',
], $existing ?? []);

$catLabels = ['granos-finos' => 'Grano fino', 'granos-gruesos' => 'Grano grueso', 'general' => 'Maquinaria general'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!sw_admin_csrf_check()) {
        $errors[] = 'Sesión expirada, volvé a intentar.';
    }

    $slug = strtolower(trim((string) ($_POST['slug'] ?? '')));
    $title = trim((string) ($_POST['title'] ?? ''));
    $condicion = ($_POST['condicion'] ?? '') === 'nuevo' ? 'nuevo' : 'usado';
    $categoria = array_key_exists($_POST['categoria'] ?? '', $catLabels) ? $_POST['categoria'] : 'general';
    $priceRaw = trim((string) ($_POST['price'] ?? ''));
    $price = $priceRaw === '' ? null : (float) str_replace(',', '.', $priceRaw);

    if ($slug === '' || !preg_match('/^[a-z0-9]+(-[a-z0-9]+)*$/', $slug)) {
        $errors[] = 'El slug es obligatorio y solo puede tener minúsculas, números y guiones.';
    } elseif (JsonStore::slugExists('catalogo.json', $slug, $origSlug)) {
        $errors[] = 'Ya existe otro ítem con ese slug.';
    }
    if ($title === '') {
        $errors[] = 'El título es obligatorio.';
    }

    $specs = array_values(array_filter(array_map('trim', preg_split('/\r?\n/', (string) ($_POST['specs'] ?? '')) ?: [])));
    $imagesFromText = array_values(array_filter(array_map('trim', preg_split('/\r?\n/', (string) ($_POST['images'] ?? '')) ?: [])));

    try {
        $files = $_FILES['image_file'] ?? null;
        $count = $files && is_array($files['name']) ? count($files['name']) : 0;
        for ($i = 0; $i < $count; $i++) {
            $_FILES['image_file_' . $i] = [
                'name' => $files['name'][$i], 'type' => $files['type'][$i], 'tmp_name' => $files['tmp_name'][$i],
                'error' => $files['error'][$i], 'size' => $files['size'][$i],
            ];
            $uploaded = sw_admin_handle_image_upload('image_file_' . $i, $slug);
            if ($uploaded !== null) {
                $imagesFromText[] = $uploaded;
            }
        }
    } catch (\RuntimeException $e) {
        $errors[] = $e->getMessage();
    }

    if (empty($imagesFromText)) {
        $errors[] = 'Necesita al menos una imagen (una ruta existente o subir un archivo).';
    }

    if (empty($errors)) {
        $data = [
            'slug' => $slug,
            'wc_id' => trim((string) ($_POST['wc_id'] ?? '')),
            'title' => $title,
            'condicion' => $condicion,
            'categoria' => $categoria,
            'price' => $price,
            'sku' => trim((string) ($_POST['sku'] ?? '')),
            'description_html' => trim((string) ($_POST['description_html'] ?? '')),
            'specs' => $specs,
            'images' => $imagesFromText,
            'image_alt' => trim((string) ($_POST['image_alt'] ?? '')) ?: $title,
        ];

        if ($editing && $origSlug !== $slug) {
            JsonStore::delete('catalogo.json', $origSlug);
        }
        JsonStore::upsert('catalogo.json', $data);

        $_SESSION['flash'] = ['type' => 'ok', 'msg' => 'Ítem de catálogo guardado correctamente.'];
        header('Location: index.php');
        exit;
    }

    $v = array_merge($v, $_POST, [
        'slug' => $slug, 'title' => $title, 'condicion' => $condicion, 'categoria' => $categoria,
        'price' => $price, 'specs' => $specs, 'images' => $imagesFromText,
    ]);
}

$h = static fn ($s): string => htmlspecialchars((string) ($s ?? ''), ENT_QUOTES, 'UTF-8');
$pageTitle = ($editing ? 'Editar' : 'Nuevo') . ' ítem de catálogo · Panel admin';
require __DIR__ . '/_layout-top.php';
?>
<h1><?= $editing ? 'Editar ítem de catálogo' : 'Nuevo ítem de catálogo' ?></h1>

<?php foreach ($errors as $err): ?>
<p class="flash flash--error"><?= $h($err) ?></p>
<?php endforeach; ?>

<form method="post" enctype="multipart/form-data" novalidate>
  <?= sw_admin_csrf_field() ?>

  <fieldset>
    <legend>Datos básicos</legend>
    <div class="grid2">
      <div class="field"><label for="slug">Slug (URL)</label><input type="text" id="slug" name="slug" value="<?= $h($v['slug']) ?>" required></div>
      <div class="field"><label for="title">Título</label><input type="text" id="title" name="title" value="<?= $h($v['title']) ?>" required></div>
    </div>
    <div class="grid2">
      <div class="field"><label for="condicion">Condición</label>
        <select id="condicion" name="condicion">
          <option value="nuevo" <?= $v['condicion'] === 'nuevo' ? 'selected' : '' ?>>Nuevo</option>
          <option value="usado" <?= $v['condicion'] === 'usado' ? 'selected' : '' ?>>Usado</option>
        </select>
      </div>
      <div class="field"><label for="categoria">Categoría</label>
        <select id="categoria" name="categoria">
<?php foreach ($catLabels as $key => $label): ?>
          <option value="<?= $h($key) ?>" <?= $v['categoria'] === $key ? 'selected' : '' ?>><?= $h($label) ?></option>
<?php endforeach; ?>
        </select>
      </div>
    </div>
    <div class="grid2">
      <div class="field"><label for="price">Precio (vacío si se cotiza)</label><input type="text" id="price" name="price" value="<?= $v['price'] !== null ? $h((string) $v['price']) : '' ?>" placeholder="100000"></div>
      <div class="field"><label for="sku">SKU (opcional)</label><input type="text" id="sku" name="sku" value="<?= $h($v['sku']) ?>"></div>
    </div>
  </fieldset>

  <fieldset>
    <legend>Descripción y características</legend>
    <div class="field"><label for="description_html">Descripción (HTML simple: p, ul, li, h3, strong)</label>
      <textarea id="description_html" name="description_html" style="min-height:10rem"><?= $h($v['description_html']) ?></textarea>
    </div>
    <div class="field"><label for="specs">Tabla de especificaciones (una fila por línea, formato <code>Etiqueta | Valor</code>; sin "|" ocupa toda la fila)</label>
      <textarea id="specs" name="specs" placeholder="Año | 2010&#10;Surcos | 63 a 17,5 cm&#10;Estado de cubiertas | Muy bueno"><?= $h(is_array($v['specs']) ? implode("\n", $v['specs']) : $v['specs']) ?></textarea>
    </div>
  </fieldset>

  <fieldset>
    <legend>Imágenes</legend>
    <div class="field"><label for="images">Rutas existentes (una por línea, la primera es la principal)</label>
      <textarea id="images" name="images" placeholder="assets/img/catalogo/mi-producto/01.jpg"><?= $h(is_array($v['images']) ? implode("\n", $v['images']) : $v['images']) ?></textarea>
    </div>
    <div class="field"><label for="image_file">Agregar imágenes nuevas (jpg/png/webp, máx 5MB c/u; se pueden elegir varias)</label><input type="file" id="image_file" name="image_file[]" multiple accept=".jpg,.jpeg,.png,.webp"></div>
    <div class="field"><label for="image_alt">Texto alternativo</label><input type="text" id="image_alt" name="image_alt" value="<?= $h($v['image_alt']) ?>"></div>
  </fieldset>

  <button class="btn" type="submit">Guardar ítem</button>
  <a class="btn btn--ghost" href="index.php">Cancelar</a>
</form>

<?php require __DIR__ . '/_layout-bottom.php'; ?>
