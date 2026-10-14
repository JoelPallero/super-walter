<?php
declare(strict_types=1);

$lang = $lang ?? 'es';
$base = $base ?? '';

require __DIR__ . '/partials/bootstrap.php';
require __DIR__ . '/partials/format.php';

use SuperWalter\JsonStore;

$novedades = JsonStore::allLocalized('novedades.json', $lang);
$destacada = null;
foreach ($novedades as $n) {
    if (!empty($n['is_featured'])) {
        $destacada = $n;
        break;
    }
}

$pageKey = 'news';
$activeNav = 'novedades';
$footerLineupHref = sw_url('home') . '#lineup';
$h = static fn (?string $s): string => htmlspecialchars((string) $s, ENT_QUOTES, 'UTF-8');
$pillClass = static fn (string $cat): string => $cat === 'institucional' ? 'pill pill--amarillo' : 'pill';
?>
<!DOCTYPE html>
<html lang="<?= $lang === 'en' ? 'en' : 'es-AR' ?>">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="theme-color" content="#7f1810">

<!-- ============ SEO ============ -->
<title><?= $h(tr('Novedades · Super Walter — Lo que está pasando en la fábrica', 'News · Super Walter — What is happening at the factory')) ?></title>
<meta name="description" content="<?= $h(tr('Certificación CE, ferias internacionales, Expoagro, AgroActiva, La Rural, Aapresid, financiación directa y compromiso con la comunidad. Todas las novedades de Super Walter.', 'CE certification, international trade shows, Expoagro, AgroActiva, La Rural, Aapresid, direct financing and community commitment. All the latest news from Super Walter.')) ?>">
<link rel="canonical" href="<?= $h('https://superwalter.com.ar/' . sw_path($pageKey, $lang)) ?>">
<?= sw_hreflang_tags() ?>

<meta property="og:type" content="website">
<meta property="og:locale" content="<?= $lang === 'en' ? 'en_US' : 'es_AR' ?>">
<meta property="og:locale:alternate" content="<?= $lang === 'en' ? 'es_AR' : 'en_US' ?>">
<meta property="og:site_name" content="Super Walter">
<meta property="og:title" content="<?= $h(tr('Novedades · Super Walter', 'News · Super Walter')) ?>">
<meta property="og:description" content="<?= $h(tr('Ferias, certificaciones, lanzamientos y comunidad. Todo lo que pasa en Super Walter.', 'Trade shows, certifications, launches and community. Everything happening at Super Walter.')) ?>">
<meta property="og:url" content="<?= $h('https://superwalter.com.ar/' . sw_path($pageKey, $lang)) ?>">
<meta property="og:image" content="https://superwalter.com.ar/assets/img/og-image.jpg">

<link rel="icon" href="<?= $base ?>assets/img/isotipo.svg" type="image/svg+xml">
<link rel="apple-touch-icon" href="<?= $base ?>assets/img/isotipo.svg">

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

<link rel="stylesheet" href="<?= $base ?>assets/css/styles.css">
</head>
<body>

<?php include __DIR__ . '/partials/header.php'; ?>

<main id="main">
<span id="top"></span>

<!-- ============================ HERO DE PÁGINA ============================ -->
<section class="page-hero" aria-label="<?= $h(tr('Novedades', 'News')) ?>">
  <div class="container">
    <p class="eyebrow on-dark" data-reveal="fade"><img class="mk" src="<?= $base ?>assets/img/mark.svg" alt=""><?= $h(tr('Novedades y contenido técnico', 'News and technical content')) ?></p>
    <h1 class="section-title" data-reveal style="color:#fff;max-width:16ch"><?= $h(tr('Lo que está pasando en Super Walter', 'What is happening at Super Walter')) ?><span class="mark-x">.</span></h1>
    <p class="lead" data-reveal data-reveal-delay="1" style="color:rgba(255,255,255,.78);margin-top:1.1rem"><?= $h(tr('Ferias, certificaciones, lanzamientos y compromiso con la comunidad. Todo lo que sale de la fábrica y llega al lote.', 'Trade shows, certifications, launches and community commitment. Everything that leaves the factory and reaches the field.')) ?></p>
  </div>
</section>

<?php if ($destacada !== null): ?>
<!-- ============================ DESTACADA ============================ -->
<section class="news section-pad" style="padding-block:clamp(2.4rem,5vw,4rem) 0" aria-label="<?= $h(tr('Novedad destacada', 'Featured news')) ?>">
  <div class="container">
    <article class="card-model card-model--feature" data-reveal style="background:var(--carbon);color:#fff">
      <div class="card-model__media img-reveal" data-reveal>
        <div class="card-model__tags">
          <span class="pill pill--amarillo">★ <?= $h(tr('Destacado', 'Featured')) ?></span>
          <span class="pill"><?= $h(sw_date_long($destacada['date'] ?? '')) ?></span>
        </div>
        <img src="<?= $base ?><?= $h($destacada['hero_image']) ?>" alt="<?= $h($destacada['hero_image_alt'] ?? '') ?>" loading="lazy" width="2000" height="1334">
      </div>
      <div class="card-model__body">
        <h2 class="card-model__name"><?= $h($destacada['title']) ?></h2>
        <p class="card-model__desc"><?= $h($destacada['featured_desc'] ?? $destacada['lead'] ?? '') ?></p>
        <div class="card-model__chips">
<?php foreach ($destacada['chips'] ?? [] as $chip): ?>
          <span class="pill pill--outline-dark" style="color:#e8dccb"><?= $h($chip) ?></span>
<?php endforeach; ?>
        </div>
        <a class="card-model__link" href="<?= $h(sw_url('article', $destacada['slug'])) ?>"><?= $h($destacada['featured_link_text'] ?? tr('Leer la nota completa', 'Read the full story')) ?></a>
      </div>
    </article>
  </div>
</section>
<?php endif; ?>

<!-- ============================ LISTADO ============================ -->
<section class="news section-pad" id="listado" aria-labelledby="listado-title">
  <div class="container">
    <p class="eyebrow" data-reveal="fade"><img class="mk" src="<?= $base ?>assets/img/mark.svg" alt=""><?= $h(tr('Todas las novedades', 'All news')) ?></p>
    <h2 class="section-title" id="listado-title" data-reveal><?= $h(tr('Campaña tras campaña, siempre pasa algo.', 'Season after season, something is always happening.')) ?></h2>

    <div class="filters" id="newsFilters" role="group" aria-label="<?= $h(tr('Filtrar novedades por categoría', 'Filter news by category')) ?>" data-reveal="fade">
      <button type="button" class="filter is-active" data-cat="todas" aria-pressed="true"><?= $h(tr('Todas', 'All')) ?></button>
      <button type="button" class="filter" data-cat="institucional" aria-pressed="false"><?= $h(tr('Institucional', 'Corporate')) ?></button>
      <button type="button" class="filter" data-cat="ferias" aria-pressed="false"><?= $h(tr('Ferias', 'Trade shows')) ?></button>
      <button type="button" class="filter" data-cat="comercial" aria-pressed="false"><?= $h(tr('Comercial', 'Commercial')) ?></button>
      <button type="button" class="filter" data-cat="comunidad" aria-pressed="false"><?= $h(tr('Comunidad', 'Community')) ?></button>
    </div>

    <div class="news__grid" id="newsGrid">
<?php foreach ($novedades as $i => $n): ?>
      <article class="news-card" data-cat="<?= $h($n['category'] ?? '') ?>" data-reveal<?= $i > 0 ? ' data-reveal-delay="' . min($i % 3, 2) . '"' : '' ?>>
        <div class="news-card__img"><span class="news-card__pill <?= $h($pillClass($n['category'] ?? '')) ?>"><?= $h($n['category_label'] ?? '') ?></span><img src="<?= $base ?><?= $h($n['hero_image']) ?>" alt="<?= $h($n['hero_image_alt'] ?? '') ?>" loading="lazy" width="1800" height="2250"></div>
        <div class="news-card__body">
          <p class="news-card__meta"><?= $h(sw_date_short($n['date'] ?? '')) ?> · <?= $h($n['subcategory_label'] ?? '') ?></p>
          <h3><?= $h($n['title']) ?></h3>
          <p style="color:var(--texto-mute)"><?= $h($n['lead'] ?? '') ?></p>
          <a class="news-card__link" href="<?= $h(sw_url('article', $n['slug'])) ?>"><?= $h($n['listing_link_text'] ?? tr('Leer más', 'Read more')) ?></a>
        </div>
      </article>
<?php endforeach; ?>
      <p class="news-empty" id="newsEmpty" hidden><?= $h(tr('No hay novedades en esta categoría por ahora.', 'There is no news in this category yet.')) ?> <a href="<?= $h(sw_url('news')) ?>"><?= $h(tr('Ver todas', 'See all')) ?></a>.</p>
    </div>
  </div>
</section>

<!-- ============================ CTA breve ============================ -->
<section class="cta section-pad" style="padding-block:0 clamp(3rem,6vw,5rem)">
  <div class="container">
    <div class="cta__panel" data-reveal style="text-align:center">
      <p class="eyebrow on-dark" style="justify-content:center;margin-bottom:1rem"><img class="mk" src="<?= $base ?>assets/img/mark.svg" alt=""><?= $h(tr('No te pierdas nada', "Don't miss a thing")) ?></p>
      <h2 class="cta__title" style="max-width:none;margin-inline:auto"><?= $h(tr('Enterate de las ', 'Get the ')) ?><em><?= $h(tr('novedades', 'news')) ?></em><?= $h(tr(' antes que nadie.', ' before anyone else.')) ?></h2>
      <p class="cta__lead" style="margin-inline:auto"><?= $h(tr('Seguinos en redes o escribinos y te mantenemos al tanto de ferias, lanzamientos y planes de financiación.', 'Follow us on social media or write to us and we will keep you posted on trade shows, launches and financing plans.')) ?></p>
      <a class="btn btn--amarillo" href="<?= $h(sw_url('contact')) ?>" style="margin-top:1.6rem"><?= $h(tr('Suscribirme al Newsletter', 'Subscribe to the newsletter')) ?></a>
    </div>
  </div>
</section>
</main>

<?php include __DIR__ . '/partials/footer.php'; ?>
