<?php
declare(strict_types=1);

require __DIR__ . '/_guard.php';

use SuperWalter\JsonStore;

$productos = JsonStore::all('productos.json');
$novedades = JsonStore::all('novedades.json');
$catalogo = JsonStore::all('catalogo.json');

$enSlugs = [];
foreach (['producto' => 'productos-en.json', 'novedad' => 'novedades-en.json', 'catalogo' => 'catalogo-en.json'] as $t => $f) {
    foreach (JsonStore::all($f) as $o) {
        if (!empty($o['slug'])) {
            $enSlugs[$t][$o['slug']] = true;
        }
    }
}
$enBtn = static function (string $t, string $slug) use ($enSlugs): string {
    $has = isset($enSlugs[$t][$slug]);
    return '<a class="btn btn--ghost" href="traduccion.php?type=' . $t . '&amp;slug=' . urlencode($slug) . '">EN</a> '
        . '<small title="' . ($has ? 'Tiene traducción al inglés' : 'Sin traducción al inglés') . '">' . ($has ? 'EN ✓' : 'EN —') . '</small>';
};

$flash = $_SESSION['flash'] ?? null;
unset($_SESSION['flash']);

$pageTitle = 'Panel admin · Super Walter';
require __DIR__ . '/_layout-top.php';
?>
<h1>Panel admin</h1>

<?php if ($flash): ?>
<p class="flash flash--<?= $flash['type'] === 'ok' ? 'ok' : 'error' ?>"><?= htmlspecialchars($flash['msg'], ENT_QUOTES, 'UTF-8') ?></p>
<?php endif; ?>

<h2>Productos <a class="btn" href="producto-form.php">+ Nuevo producto</a></h2>
<table>
  <thead><tr><th></th><th>Título</th><th>Slug</th><th>Home</th><th></th></tr></thead>
  <tbody>
<?php foreach ($productos as $p): ?>
  <tr>
    <td><img class="thumb" src="../<?= htmlspecialchars($p['hero_image'] ?? '', ENT_QUOTES, 'UTF-8') ?>" alt=""></td>
    <td><?= htmlspecialchars($p['title'] ?? '', ENT_QUOTES, 'UTF-8') ?></td>
    <td><code><?= htmlspecialchars($p['slug'] ?? '', ENT_QUOTES, 'UTF-8') ?></code></td>
    <td><?= !empty($p['is_homepage_featured']) ? '★' : '' ?></td>
    <td class="actions">
      <a class="btn btn--ghost" href="producto-form.php?slug=<?= urlencode($p['slug']) ?>">Editar</a>
      <?= $enBtn('producto', (string) $p['slug']) ?>
      <a class="btn btn--ghost" href="../productos/<?= urlencode($p['slug']) ?>" target="_blank">Ver</a>
      <form method="post" action="delete.php" onsubmit="return confirm('¿Borrar este producto?');" style="display:inline">
        <?= sw_admin_csrf_field() ?>
        <input type="hidden" name="type" value="producto">
        <input type="hidden" name="slug" value="<?= htmlspecialchars($p['slug'], ENT_QUOTES, 'UTF-8') ?>">
        <button class="btn btn--danger" type="submit">Borrar</button>
      </form>
    </td>
  </tr>
<?php endforeach; ?>
<?php if (!$productos): ?>
  <tr><td colspan="5">Todavía no hay productos cargados.</td></tr>
<?php endif; ?>
  </tbody>
</table>

<h2>Novedades <a class="btn" href="novedad-form.php">+ Nueva novedad</a></h2>
<table>
  <thead><tr><th></th><th>Título</th><th>Slug</th><th>Categoría</th><th>Fecha</th><th>Destacada</th><th></th></tr></thead>
  <tbody>
<?php foreach ($novedades as $n): ?>
  <tr>
    <td><img class="thumb" src="../<?= htmlspecialchars($n['hero_image'] ?? '', ENT_QUOTES, 'UTF-8') ?>" alt=""></td>
    <td><?= htmlspecialchars($n['title'] ?? '', ENT_QUOTES, 'UTF-8') ?></td>
    <td><code><?= htmlspecialchars($n['slug'] ?? '', ENT_QUOTES, 'UTF-8') ?></code></td>
    <td><?= htmlspecialchars($n['category_label'] ?? '', ENT_QUOTES, 'UTF-8') ?></td>
    <td><?= htmlspecialchars($n['date'] ?? '', ENT_QUOTES, 'UTF-8') ?></td>
    <td><?= !empty($n['is_featured']) ? '★' : '' ?></td>
    <td class="actions">
      <a class="btn btn--ghost" href="novedad-form.php?slug=<?= urlencode($n['slug']) ?>">Editar</a>
      <?= $enBtn('novedad', (string) $n['slug']) ?>
      <a class="btn btn--ghost" href="../novedades/<?= urlencode($n['slug']) ?>" target="_blank">Ver</a>
      <form method="post" action="delete.php" onsubmit="return confirm('¿Borrar esta novedad?');" style="display:inline">
        <?= sw_admin_csrf_field() ?>
        <input type="hidden" name="type" value="novedad">
        <input type="hidden" name="slug" value="<?= htmlspecialchars($n['slug'], ENT_QUOTES, 'UTF-8') ?>">
        <button class="btn btn--danger" type="submit">Borrar</button>
      </form>
    </td>
  </tr>
<?php endforeach; ?>
<?php if (!$novedades): ?>
  <tr><td colspan="7">Todavía no hay novedades cargadas.</td></tr>
<?php endif; ?>
  </tbody>
</table>

<h2>Catálogo (nuevos/usados) <a class="btn" href="catalogo-form.php">+ Nuevo ítem</a></h2>
<table>
  <thead><tr><th></th><th>Título</th><th>Slug</th><th>Condición</th><th>Categoría</th><th>Precio</th><th></th></tr></thead>
  <tbody>
<?php foreach ($catalogo as $it): ?>
  <tr>
    <td><img class="thumb" src="../<?= htmlspecialchars($it['images'][0] ?? '', ENT_QUOTES, 'UTF-8') ?>" alt=""></td>
    <td><?= htmlspecialchars($it['title'] ?? '', ENT_QUOTES, 'UTF-8') ?></td>
    <td><code><?= htmlspecialchars($it['slug'] ?? '', ENT_QUOTES, 'UTF-8') ?></code></td>
    <td><?= htmlspecialchars($it['condicion'] ?? '', ENT_QUOTES, 'UTF-8') ?></td>
    <td><?= htmlspecialchars($it['categoria'] ?? '', ENT_QUOTES, 'UTF-8') ?></td>
    <td><?= $it['price'] !== null ? '$' . number_format((float) $it['price'], 0, ',', '.') : '—' ?></td>
    <td class="actions">
      <a class="btn btn--ghost" href="catalogo-form.php?slug=<?= urlencode($it['slug']) ?>">Editar</a>
      <?= $enBtn('catalogo', (string) $it['slug']) ?>
      <a class="btn btn--ghost" href="../catalogo/<?= urlencode($it['slug']) ?>" target="_blank">Ver</a>
      <form method="post" action="delete.php" onsubmit="return confirm('¿Borrar este ítem del catálogo?');" style="display:inline">
        <?= sw_admin_csrf_field() ?>
        <input type="hidden" name="type" value="catalogo">
        <input type="hidden" name="slug" value="<?= htmlspecialchars($it['slug'], ENT_QUOTES, 'UTF-8') ?>">
        <button class="btn btn--danger" type="submit">Borrar</button>
      </form>
    </td>
  </tr>
<?php endforeach; ?>
<?php if (!$catalogo): ?>
  <tr><td colspan="7">Todavía no hay ítems de catálogo cargados.</td></tr>
<?php endif; ?>
  </tbody>
</table>

<?php require __DIR__ . '/_layout-bottom.php'; ?>
