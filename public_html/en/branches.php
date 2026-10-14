<?php
declare(strict_types=1);

$lang = 'en';
$base = '../';
$activeNav = 'sucursales';
$pageKey = 'branches';
require __DIR__ . '/../partials/i18n.php';
$footerLineupHref = sw_url('home') . '#lineup';
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="theme-color" content="#7f1810">

<!-- ============ SEO ============ -->
<title>Super Walter Branches · Find your nearest dealer</title>
<meta name="description" content="Find the nearest Super Walter branch or dealer. A network of more than 70 sales and service points across Argentina, Bolivia and Paraguay.">
<link rel="canonical" href="https://superwalter.com.ar/en/branches"><!-- EDITAR: dominio final -->
<?= sw_hreflang_tags() ?>

<meta property="og:type" content="website">
<meta property="og:locale" content="en_US">
<meta property="og:locale:alternate" content="es_AR">
<meta property="og:site_name" content="Super Walter">
<meta property="og:title" content="Super Walter Branches · Find your nearest dealer">
<meta property="og:description" content="A network of more than 70 sales and service points across Argentina, Bolivia and Paraguay.">
<meta property="og:url" content="https://superwalter.com.ar/en/branches"><!-- EDITAR -->
<meta property="og:image" content="https://superwalter.com.ar/assets/img/og-image.jpg"><!-- EDITAR -->

<link rel="icon" href="../assets/img/isotipo.svg" type="image/svg+xml">
<link rel="apple-touch-icon" href="../assets/img/isotipo.svg">

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

<link rel="stylesheet" href="../assets/css/styles.css">
</head>
<body>
<?php include __DIR__ . '/../partials/header.php'; ?>

<main id="main">
<span id="top"></span>

<!-- ============================ PAGE HERO ============================ -->
<section class="page-hero" aria-label="Branches">
  <div class="container">
    <p class="eyebrow on-dark" data-reveal="fade"><img class="mk" src="../assets/img/mark.svg" alt="">Dealer network</p>
    <h1 class="section-title" data-reveal style="color:#fff;max-width:16ch">Find your nearest branch.</h1>
    <p class="lead" data-reveal data-reveal-delay="1" style="color:rgba(255,255,255,.78);margin-top:1.1rem">More than 70 sales and technical service points across Argentina, Bolivia and Paraguay. Filter by country and province or search directly for your town.</p>
  </div>
</section>

<!-- ============================ SEARCH ============================ -->
<section class="suc-search section-pad" aria-label="Branch search">
  <div class="container">
    <div class="suc-toolbar" data-reveal>
      <div class="suc-countries" role="group" aria-label="Filter by country">
        <button type="button" class="suc-country is-active" data-country="Argentina" aria-pressed="true">Argentina</button>
        <button type="button" class="suc-country" data-country="Bolivia" aria-pressed="false">Bolivia</button>
        <button type="button" class="suc-country" data-country="Paraguay" aria-pressed="false">Paraguay</button>
      </div>
      <div class="suc-fields">
        <div class="field" style="grid-column:auto">
          <label for="sucBuscar" class="visually-hidden">Search by name or town</label>
          <input type="text" id="sucBuscar" placeholder="Search by name or town...">
        </div>
        <div class="field" style="grid-column:auto">
          <label for="sucProvincia" class="visually-hidden">Province</label>
          <select id="sucProvincia"><option value="">All provinces</option></select>
        </div>
      </div>
      <p class="suc-count" id="sucCount"><b>0</b> branches found</p>
    </div>
  </div>
</section>

<!-- ============================ LIST + MAP ============================ -->
<section class="suc-locator" aria-label="Branch list and map">
  <div class="container">
    <div class="suc-locator__grid">
      <div class="suc-list" id="sucList" aria-live="polite">
        <!-- Rendered by assets/js/sucursales.js -->
      </div>
      <div class="suc-map-wrap">
        <div id="sucMap" role="application" aria-label="Super Walter branch map"></div>
      </div>
    </div>
  </div>
</section>

<!-- ============================ Short CTA ============================ -->
<section class="section-pad" style="padding-block:0 clamp(3rem,6vw,5rem)">
  <div class="container">
    <div class="cta__panel" data-reveal style="text-align:center">
      <p class="eyebrow on-dark" style="justify-content:center;margin-bottom:1rem"><img class="mk" src="../assets/img/mark.svg" alt="">Can't find your area?</p>
      <h2 class="cta__title" style="max-width:none">We'll help you find your <em>dealer</em>.</h2>
      <p class="cta__lead" style="margin-inline:auto">Write to us and a factory advisor will contact you directly, no matter which province you are in.</p>
      <a class="btn btn--amarillo" href="<?= sw_url('contact') ?>" style="margin-top:1.6rem">Request advice</a>
    </div>
  </div>
</section>
</main>

<?php ob_start(); ?>
<script src="../assets/js/sucursales-data.js" defer></script>
<script src="../assets/js/sucursales.js" defer></script>
<?php $footerScripts = ob_get_clean(); ?>
<?php include __DIR__ . '/../partials/footer.php'; ?>
