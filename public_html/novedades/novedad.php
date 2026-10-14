<?php
declare(strict_types=1);

$lang = $lang ?? 'es';
$base = $base ?? '../';
$pageKey = 'article';

require __DIR__ . '/../partials/bootstrap.php';
require __DIR__ . '/../partials/format.php';

use SuperWalter\JsonStore;

$slug = isset($_GET['slug']) ? (string) $_GET['slug'] : '';
$novedad = $slug !== '' ? JsonStore::findLocalized('novedades.json', $slug, $lang) : null;

if ($novedad !== null) {
    $pageSlug = $slug;
}
$activeNav = 'novedades';
$h = static fn (?string $s): string => htmlspecialchars((string) $s, ENT_QUOTES, 'UTF-8');

if ($novedad === null) {
    http_response_code(404);
    ?>
<!DOCTYPE html>
<html lang="<?= $lang === 'en' ? 'en' : 'es-AR' ?>">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?= tr('Novedad no encontrada', 'News article not found') ?> · Super Walter</title>
  <link rel="stylesheet" href="<?= $base ?>assets/css/styles.css">
</head>
<body>
<?php include __DIR__ . '/../partials/header.php'; ?>
  <main id="main" class="section-pad">
    <div class="container" style="text-align:center;padding-block:6rem">
      <h1 class="section-title"><?= tr('No encontramos esa novedad.', 'We could not find that news article.') ?></h1>
      <p class="lead" style="margin-top:1rem"><a href="<?= sw_url('news') ?>" style="color:var(--bordo);font-weight:600"><?= tr('Ver todas las novedades →', 'See all news →') ?></a></p>
    </div>
  </main>
<?php include __DIR__ . '/../partials/footer.php'; ?>
<?php
    exit;
}

$todos = JsonStore::allLocalized('novedades.json', $lang);
$porSlug = [];
foreach ($todos as $item) {
    $porSlug[$item['slug']] = $item;
}

$relacionadas = [];
foreach ($novedad['related_slugs'] ?? [] as $rs) {
    if (isset($porSlug[$rs]) && $rs !== $slug) {
        $relacionadas[] = $porSlug[$rs];
    }
}
if (count($relacionadas) < 3) {
    // Respaldo: misma categoría, más recientes, si no hay suficientes relacionadas curadas.
    $mismaCat = array_values(array_filter(
        $todos,
        static fn (array $n): bool => $n['slug'] !== $slug
            && $n['category'] === $novedad['category']
            && !in_array($n['slug'], array_column($relacionadas, 'slug'), true)
    ));
    usort($mismaCat, static fn (array $a, array $b): int => strcmp($b['date'], $a['date']));
    foreach ($mismaCat as $n) {
        if (count($relacionadas) >= 3) {
            break;
        }
        $relacionadas[] = $n;
    }
}
$relacionadas = array_slice($relacionadas, 0, 3);

$pillClass = static fn (string $cat): string => $cat === 'institucional' ? 'pill pill--amarillo' : 'pill';

// cta_href en los datos usa nombres de archivo del sitio en español.
$ctaRoutes = [
    'contacto.php' => 'contact',
    'empresa.php' => 'company',
    'novedades.php' => 'news',
    'sucursales.php' => 'branches',
    'trabaja-con-nosotros.php' => 'careers',
    'productos-nuevos.php' => 'new',
    'productos-usados.php' => 'used',
    'index.php' => 'home',
];
$ctaRaw = (string) ($novedad['cta_href'] ?? 'contacto.php');
$ctaParts = explode('#', $ctaRaw, 2);
$ctaUrl = isset($ctaRoutes[$ctaParts[0]])
    ? sw_url($ctaRoutes[$ctaParts[0]]) . (isset($ctaParts[1]) ? '#' . $ctaParts[1] : '')
    : $base . $ctaRaw;
?>
<!DOCTYPE html>
<html lang="<?= $lang === 'en' ? 'en' : 'es-AR' ?>">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="theme-color" content="#7f1810">

  <!-- ============ SEO ============ -->
  <title><?= $h($novedad['seo_title'] ?? $novedad['title']) ?></title>
  <meta name="description" content="<?= $h($novedad['seo_description'] ?? '') ?>">
  <link rel="canonical" href="https://superwalter.com.ar/<?= $h(sw_path($pageKey, $lang, $slug)) ?>">
  <?= sw_hreflang_tags() ?>


  <meta property="og:type" content="article">
  <meta property="og:locale" content="<?= $lang === 'en' ? 'en_US' : 'es_AR' ?>">
  <meta property="og:locale:alternate" content="<?= $lang === 'en' ? 'es_AR' : 'en_US' ?>">
  <meta property="og:site_name" content="Super Walter">
  <meta property="og:title" content="<?= $h($novedad['og_title'] ?? $novedad['title']) ?>">
  <meta property="og:description" content="<?= $h($novedad['og_description'] ?? '') ?>">
  <meta property="og:url" content="https://superwalter.com.ar/<?= $h(sw_path($pageKey, $lang, $slug)) ?>">
  <meta property="og:image" content="https://superwalter.com.ar/assets/img/og-image.jpg">

  <link rel="icon" href="<?= $base ?>assets/img/isotipo.svg" type="image/svg+xml">
  <link rel="apple-touch-icon" href="<?= $base ?>assets/img/isotipo.svg">

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap"
    rel="stylesheet">

  <link rel="stylesheet" href="<?= $base ?>assets/css/styles.css">
</head>

<body>

<?php include __DIR__ . '/../partials/header.php'; ?>

  <main id="main">
    <span id="top"></span>

    <!-- ============================ HERO DE NOVEDAD ============================ -->
    <section class="page-hero page-hero--photo" aria-label="<?= $h($novedad['title']) ?>">
      <div class="ph-bg" aria-hidden="true"><img src="<?= $base ?><?= $h($novedad['hero_image']) ?>"
          alt="<?= $h($novedad['hero_image_alt'] ?? '') ?>" width="1800" height="2250"></div>
      <div class="container">
        <p class="page-hero__crumb"><a href="<?= sw_url('home') ?>"><?= tr('Inicio', 'Home') ?></a> · <a href="<?= sw_url('news') ?>"><?= tr('Novedades', 'News') ?></a> ·
          <span><?= $h($novedad['title']) ?></span></p>
        <div style="display:flex;flex-wrap:wrap;gap:.6rem;margin-bottom:1.2rem">
          <span class="<?= $h($pillClass($novedad['category'] ?? '')) ?>"><?= $h($novedad['category_label'] ?? '') ?></span>
          <span class="pill pill--outline"><?= $h(sw_date_long($novedad['date'] ?? '')) ?></span>
        </div>
        <h1 class="section-title" data-reveal style="color:#fff;max-width:24ch"><?= $h($novedad['title']) ?><span class="mark-x"></span></h1>
        <p class="lead" data-reveal data-reveal-delay="1" style="color:rgba(255,255,255,.78);margin-top:1.1rem"><?= $h($novedad['lead'] ?? '') ?></p>
      </div>
    </section>

    <!-- ============================ ARTÍCULO ============================ -->
    <section class="intro section-pad" aria-labelledby="art-title">
      <div class="container">
        <div class="legacy__media img-reveal" data-reveal style="margin-bottom:clamp(1.6rem,3vw,2.4rem)">
          <img src="<?= $base ?><?= $h($novedad['hero_image']) ?>" alt="<?= $h($novedad['hero_image_alt'] ?? '') ?>" loading="lazy" width="1800"
            height="2250">
        </div>
        <h2 class="visually-hidden" id="art-title"><?= $h($novedad['title']) ?></h2>
        <div class="intro__body" data-reveal style="max-width:none">
<?php foreach ($novedad['body_paragraphs'] ?? [] as $p): ?>
          <p><?= $h($p) ?></p>
<?php endforeach; ?>
        </div>
<?php if (!empty($novedad['chips'])): ?>
        <div class="card-model__chips" style="margin-top:1.6rem">
<?php foreach ($novedad['chips'] as $chip): ?>
          <span class="pill pill--outline-dark"><?= $h($chip) ?></span>
<?php endforeach; ?>
        </div>
<?php endif; ?>
        <a class="btn btn--amarillo" href="<?= $h($ctaUrl) ?>" style="margin-top:2rem"><?= $h($novedad['cta_text'] ?? tr('Solicitar asesoramiento', 'Request advice')) ?></a>
      </div>
    </section>

    <!-- ============================ MÁS NOVEDADES ============================ -->
<?php if (!empty($relacionadas)): ?>
    <section class="news section-pad" id="mas" aria-labelledby="mas-title">
      <div class="container">
        <p class="eyebrow" data-reveal="fade"><img class="mk" src="<?= $base ?>assets/img/mark.svg" alt=""><?= tr('Seguí leyendo', 'Keep reading') ?></p>
        <h2 class="section-title" id="mas-title" data-reveal><?= tr('Más novedades de Super Walter.', 'More news from Super Walter.') ?></h2>
        <div class="news__grid">
<?php foreach ($relacionadas as $i => $n): ?>
          <article class="news-card" data-reveal<?= $i > 0 ? ' data-reveal-delay="' . min($i, 2) . '"' : '' ?>>
            <div class="news-card__img"><span class="news-card__pill <?= $h($pillClass($n['category'] ?? '')) ?>"><?= $h($n['category_label'] ?? '') ?></span><img
                src="<?= $base ?><?= $h($n['hero_image']) ?>" alt="<?= $h($n['hero_image_alt'] ?? '') ?>" loading="lazy" width="1800"
                height="2250"></div>
            <div class="news-card__body">
              <p class="news-card__meta"><?= $h(sw_date_short($n['date'] ?? '')) ?> · <?= $h($n['subcategory_label'] ?? '') ?></p>
              <h3><?= $h($n['title']) ?></h3>
              <a class="news-card__link" href="<?= $h(sw_url('article', $n['slug'])) ?>"><?= tr('Leer más', 'Read more') ?></a>
            </div>
          </article>
<?php endforeach; ?>
        </div>
        <p class="form__note" data-reveal style="color:var(--texto-mute);margin-top:1.3rem"><a href="<?= sw_url('news') ?>"
            style="color:var(--bordo);font-weight:600"><?= tr('Ver todas las novedades →', 'See all news →') ?></a></p>
      </div>
    </section>
<?php endif; ?>

    <!-- ============================ CTA breve ============================ -->
    <section class="cta section-pad" style="padding-block:0 clamp(3rem,6vw,5rem)">
      <div class="container">
        <div class="cta__panel" data-reveal style="text-align:center">
          <p class="eyebrow on-dark" style="justify-content:center;margin-bottom:1rem"><img class="mk"
              src="<?= $base ?>assets/img/mark.svg" alt=""><?= tr('No te pierdas nada', "Don't miss a thing") ?></p>
          <h2 class="cta__title" style="max-width:none;margin-inline:auto"><?php if ($lang === 'en'): ?>Be the first to hear the <em>news</em>.<?php else: ?>Enterate de las <em>novedades</em> antes
            que nadie.<?php endif; ?></h2>
          <p class="cta__lead" style="margin-inline:auto"><?= tr('Seguinos en redes o escribinos y te mantenemos al tanto de
            ferias, lanzamientos y planes de financiación.', 'Follow us on social media or write to us and we will keep you posted on trade shows, launches and financing plans.') ?></p>
          <a class="btn btn--amarillo" href="<?= sw_url('contact') ?>" style="margin-top:1.6rem"><?= tr('Suscribirme al Newsletter', 'Subscribe to the Newsletter') ?></a>
        </div>
      </div>
    </section>
  </main>

<?php include __DIR__ . '/../partials/footer.php'; ?>
