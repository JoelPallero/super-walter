<?php
declare(strict_types=1);

/**
 * Listado compartido por productos-nuevos.php y productos-usados.php.
 * El script que lo incluye debe definir $condicion ('nuevo'|'usado') antes.
 */

use SuperWalter\JsonStore;

$lang = $lang ?? 'es';
$base = $base ?? '';

$todos = JsonStore::allLocalized('catalogo.json', $lang);
$items = array_values(array_filter($todos, static fn (array $it): bool => $it['condicion'] === $condicion));

$esNuevo = $condicion === 'nuevo';
$pageKey = $esNuevo ? 'new' : 'used';
$tituloPagina = $esNuevo ? tr('Productos nuevos', 'New machinery') : tr('Productos usados', 'Used machinery');
$leadPagina = $esNuevo
    ? tr('Sembradoras, rastras y maquinaria general de fábrica, listas para cotizar.', 'Factory-built seeders, harrows and general machinery, ready to quote.')
    : tr('Equipos usados revisados y listos para volver al lote, de Super Walter y otras marcas.', 'Inspected used equipment ready to get back in the field, from Super Walter and other brands.');

$catLabels = sw_cat_labels();

$activeNav = 'lineup';
$h = static fn (?string $s): string => htmlspecialchars((string) $s, ENT_QUOTES, 'UTF-8');
?>
<!DOCTYPE html>
<html lang="<?= $lang === 'en' ? 'en' : 'es-AR' ?>">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="theme-color" content="#7f1810">

<!-- ============ SEO ============ -->
<title><?= $h($tituloPagina) ?> · Super Walter</title>
<meta name="description" content="<?= $h($leadPagina) ?>">
<link rel="canonical" href="<?= $h('https://superwalter.com.ar/' . sw_path($pageKey, $lang)) ?>">
<?= sw_hreflang_tags() ?>

<meta property="og:locale" content="<?= $lang === 'en' ? 'en_US' : 'es_AR' ?>">
<meta property="og:locale:alternate" content="<?= $lang === 'en' ? 'es_AR' : 'en_US' ?>">

<link rel="icon" href="<?= $base ?>assets/img/isotipo.svg" type="image/svg+xml">
<link rel="apple-touch-icon" href="<?= $base ?>assets/img/isotipo.svg">

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

<link rel="stylesheet" href="<?= $base ?>assets/css/styles.css">
</head>
<body>

<?php include __DIR__ . '/header.php'; ?>

<main id="main">
<span id="top"></span>

<!-- ============================ HERO ============================ -->
<section class="page-hero" aria-label="<?= $h($tituloPagina) ?>">
  <div class="container">
    <p class="eyebrow on-dark" data-reveal="fade"><img class="mk" src="<?= $base ?>assets/img/mark.svg" alt=""><?= $h(tr('Sembradoras', 'Seeders')) ?> · <?= $h($tituloPagina) ?></p>
    <h1 class="section-title" data-reveal style="color:#fff;max-width:20ch"><?= $h($tituloPagina) ?><span class="mark-x">.</span></h1>
    <p class="lead" data-reveal data-reveal-delay="1" style="color:rgba(255,255,255,.78);margin-top:1.1rem"><?= $h($leadPagina) ?></p>
  </div>
</section>

<!-- ============================ LISTADO ============================ -->
<section class="news section-pad" id="listado" aria-labelledby="listado-title">
  <div class="container">
    <p class="eyebrow" data-reveal="fade"><img class="mk" src="<?= $base ?>assets/img/mark.svg" alt=""><?= count($items) ?> <?= $h(tr('equipo' . (count($items) === 1 ? '' : 's'), 'machine' . (count($items) === 1 ? '' : 's'))) ?></p>
    <h2 class="section-title" id="listado-title" data-reveal><?= $h(tr('Filtrá por tipo de grano o máquina.', 'Filter by grain type or machine.')) ?></h2>

    <div class="filters" id="catalogFilters" role="group" aria-label="<?= $h(tr('Filtrar por categoría', 'Filter by category')) ?>" data-reveal="fade">
      <button type="button" class="filter is-active" data-cat="todas" aria-pressed="true"><?= $h(tr('Todas', 'All')) ?></button>
      <button type="button" class="filter" data-cat="granos-finos" aria-pressed="false"><?= $h($catLabels['granos-finos']) ?></button>
      <button type="button" class="filter" data-cat="granos-gruesos" aria-pressed="false"><?= $h($catLabels['granos-gruesos']) ?></button>
      <button type="button" class="filter" data-cat="general" aria-pressed="false"><?= $h($catLabels['general']) ?></button>
    </div>

    <div class="news__grid" id="catalogGrid">
<?php foreach ($items as $i => $it): ?>
      <article class="news-card" data-cat="<?= $h($it['categoria']) ?>" data-reveal<?= $i > 0 ? ' data-reveal-delay="' . min($i % 3, 2) . '"' : '' ?>>
        <div class="news-card__img">
          <span class="news-card__pill pill <?= $esNuevo ? 'pill--amarillo' : '' ?>"><?= $h($esNuevo ? tr('Nuevo', 'New') : tr('Usado', 'Used')) ?></span>
<?php if (!empty($it['images'][0])): ?>
          <img src="<?= $base ?><?= $h($it['images'][0]) ?>" alt="<?= $h($it['image_alt'] ?? $it['title']) ?>" loading="lazy" width="1800" height="1350">
<?php endif; ?>
        </div>
        <div class="news-card__body">
          <p class="news-card__meta"><?= $h($catLabels[$it['categoria']] ?? tr('General', 'General')) ?></p>
          <h3><?= $h($it['title']) ?></h3>
<?php if ($it['price'] !== null): ?>
          <p style="color:var(--texto);font-weight:700">$<?= number_format((float) $it['price'], 0, sw_is_en() ? '.' : ',', sw_is_en() ? ',' : '.') ?></p>
<?php endif; ?>
          <a class="news-card__link" href="<?= $h(sw_url('catalog', $it['slug'])) ?>"><?= $h(tr('Ver ficha', 'View details')) ?></a>
        </div>
      </article>
<?php endforeach; ?>
      <p class="news-empty" id="catalogEmpty" hidden><?= $h(tr('No hay equipos en esta categoría por ahora.', 'There are no machines in this category yet.')) ?> <a href="<?= $h(sw_url($pageKey)) ?>"><?= $h(tr('Ver todos', 'See all')) ?></a>.</p>
    </div>
  </div>
</section>

<!-- ============================ CTA breve ============================ -->
<section class="cta section-pad" style="padding-block:0 clamp(3rem,6vw,5rem)">
  <div class="container">
    <div class="cta__panel" data-reveal style="text-align:center">
      <p class="eyebrow on-dark" style="justify-content:center;margin-bottom:1rem"><img class="mk" src="<?= $base ?>assets/img/mark.svg" alt=""><?= $h(tr('Hablemos', "Let's talk")) ?></p>
      <h2 class="cta__title" style="max-width:none;margin-inline:auto"><?= $h(tr('¿No encontrás lo que ', "Can't find what you ")) ?><em><?= $h(tr('necesitás', 'need')) ?></em>?</h2>
      <p class="cta__lead" style="margin-inline:auto"><?= $h(tr('Contanos qué estás buscando y te ayudamos a encontrar el equipo justo.', 'Tell us what you are looking for and we will help you find the right machine.')) ?></p>
      <a class="btn btn--amarillo" href="<?= $h(sw_url('contact')) ?>" style="margin-top:1.6rem"><?= $h(tr('Consultar', 'Inquire')) ?></a>
    </div>
  </div>
</section>
</main>

<?php
$footerLineupHref = sw_url('home') . '#lineup';
include __DIR__ . '/footer.php';
