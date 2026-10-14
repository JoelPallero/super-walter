<?php
declare(strict_types=1);

$lang = 'en';
$base = '../';
$activeNav = 'empresa';
$pageKey = 'company';
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
  <title>Company · Super Walter — Always by the Farmer's Side</title>
  <meta name="description"
    content="Since 1957 we have built tillage and seeding implements. A family-owned company from Las Parejas, Santa Fe: over 65 years, 10,000 units sold and machines working in 11 countries.">
  <link rel="canonical" href="https://superwalter.com.ar/en/company">
<?= sw_hreflang_tags() ?>

  <meta property="og:type" content="website">
  <meta property="og:locale" content="en_US">
  <meta property="og:locale:alternate" content="es_AR">
  <meta property="og:site_name" content="Super Walter">
  <meta property="og:title" content="Company · Super Walter — Always by the Farmer's Side">
  <meta property="og:description"
    content="A family-owned company since 1957. Over 65 years building seeders in Las Parejas, Santa Fe.">
  <meta property="og:url" content="https://superwalter.com.ar/en/company">
  <meta property="og:image" content="https://superwalter.com.ar/assets/img/og-image.jpg"><!-- EDITAR -->

  <link rel="icon" href="../assets/img/isotipo.svg" type="image/svg+xml">
  <link rel="apple-touch-icon" href="../assets/img/isotipo.svg">

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap"
    rel="stylesheet">

  <link rel="preload" as="image" href="../assets/img/campo-escala.webp">
  <link rel="stylesheet" href="../assets/css/styles.css">
</head>

<body>
<?php include __DIR__ . '/../partials/header.php'; ?>

<main id="main">
    <span id="top"></span>

    <!-- ============================ HERO DE PÁGINA ============================ -->
    <section class="page-hero page-hero--photo page-hero--full" aria-label="The company">
      <div class="ph-bg" aria-hidden="true"><img src="../assets/img/campo-escala.webp" alt="" width="1900" height="2080">
      </div>
      <div class="container">
        <h1 class="page-hero__title" data-reveal>Always by the farmer's side<span class="mark-x">.</span></h1>
        <div class="page-hero__stats" data-reveal data-reveal-delay="2">
          <div><b>1957</b><span>The year it all began</span></div>
          <div><b>+10,000</b><span>Units sold</span></div>
          <div><b>+10</b><span>International markets</span></div>
        </div>
      </div>
    </section>

    <!-- ============================ MANIFIESTO ============================ -->
    <section class="intro section-pad" id="intro" aria-labelledby="intro-title">
      <div class="container">
        <p class="eyebrow" data-reveal="fade"><img class="mk" src="../assets/img/mark.svg" alt="">Who we are · 01</p>
        <div class="intro__grid">
          <h2 class="intro__statement" id="intro-title" data-reveal>
            We are a <em>family-owned</em> company building machines for people who live the farm every day.
          </h2>
          <div class="intro__body" data-reveal data-reveal-delay="1">
            <p>Our core mission is to <strong>build machinery with the most advanced technology and the highest
                quality</strong>, for the benefit of our fields and the people who farm them.</p>
            <p>Since the 1960s we have kept growing: we went from building our own seeder designs to producing
              <strong>disc harrows, disc plows and moldboard plows</strong>. Today we are <strong>Super Walter</strong>,
              part of <strong>Búfalo S.A.</strong>, one of Argentina's leading manufacturers of agricultural
              implements.</p>
            <p>Every machine that leaves our plant has one clear goal: <strong>to help you get more out of every
                seed, every meter and every kilo of fertilizer</strong>. That is how we understand precision.</p>
          </div>
        </div>
      </div>
    </section>

    <!-- ============================ MÉTRICAS ============================ -->
    <section class="metrics section-pad" style="padding-block:0" aria-label="Super Walter in numbers">
      <div class="container">
        <div class="metrics__panel" data-reveal>
          <p class="metrics__label"><img class="mk" src="../assets/img/mark.svg" alt="">Super Walter in numbers</p>
          <div class="metrics__grid">
            <div class="metric"><b data-count="65" data-prefix="+">0</b><span>years in the market</span></div>
            <div class="metric"><b data-count="10" data-prefix="+" data-suffix=",000">0</b><span>units
                sold</span></div>
            <div class="metric"><b data-count="13" data-suffix=",200 m²">0</b><span>of industrial plant</span></div>
            <div class="metric"><b data-count="100" data-suffix="%">0</b><span>Argentine engineering and manufacturing</span>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- ============================ PILARES ============================ -->
    <section class="tech section-pad" id="pilares" aria-labelledby="pilares-title">
      <div class="container">
        <p class="eyebrow" data-reveal="fade"><img class="mk" src="../assets/img/mark.svg" alt="">How we work · 02</p>
        <div class="tech__grid">
          <div class="tech__media img-reveal" data-reveal>
            <img src="../assets/img/ingenieria.webp"
              alt="Tractor with a Super Walter implement working on a hillside overlooking the valley" loading="lazy"
              width="1500" height="1873">
            <div class="tech__badge"><span class="pill pill--light">Las Parejas · Santa Fe</span></div>
          </div>
          <div>
            <h2 class="section-title" id="pilares-title" data-reveal style="margin-bottom:1.6rem">Advanced technology and
              high quality, season after season.</h2>
            <div class="tech__features">
              <div class="feature" data-reveal>
                <span class="feature__ico" aria-hidden="true"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M12 3l8 4.5v9L12 21l-8-4.5v-9L12 3z" />
                    <path d="M12 12l8-4.5M12 12v9M12 12L4 7.5" /></svg></span>
                <div>
                  <h3>In-house design</h3>
                  <p>We develop our machines from scratch, built around the real soil conditions of Argentina.</p>
                </div>
              </div>
              <div class="feature" data-reveal data-reveal-delay="1">
                <span class="feature__ico" aria-hidden="true"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M20 6 9 17l-5-5" /></svg></span>
                <div>
                  <h3>Certified quality</h3>
                  <p>Checks at every stage of the process and CE certification to operate in the European market.</p>
                </div>
              </div>
              <div class="feature" data-reveal data-reveal-delay="2">
                <span class="feature__ico" aria-hidden="true"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <rect x="3" y="3" width="18" height="18" rx="4" />
                    <path d="M8 12h8M12 8v8" /></svg></span>
                <div>
                  <h3>Constant innovation</h3>
                  <p>Precision agriculture, section control and monitoring: technology that proves itself in the field.</p>
                </div>
              </div>
              <div class="feature" data-reveal data-reveal-delay="3">
                <span class="feature__ico" aria-hidden="true"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0z" />
                    <circle cx="12" cy="10" r="3" /></svg></span>
                <div>
                  <h3>Family business</h3>
                  <p>Direct service, quick decisions and a network that knows your area and truly stands by you.</p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- ============================ PLANTA ============================ -->
    <section class="scale scale--legible" id="planta" aria-label="Our plant">
      <div class="scale__bg"><img src="../assets/img/campo-arboles.webp"
          alt="Super Walter seeder pulled by a tractor hard at work" loading="lazy" width="2000"
          height="1334"></div>
      <div class="container scale__inner">
        <p class="eyebrow on-dark" data-reveal><img class="mk" src="../assets/img/mark.svg" alt="">Our plant</p>
        <p class="scale__quote" data-reveal data-reveal-delay="1">Here steel <em>becomes machinery</em>.</p>
        <p class="scale__meta" data-reveal data-reveal-delay="2">Our facilities cover a 10,000 m² site,
          with a recent 3,200 m² extension dedicated to machine assembly. Everything is cut, folded,
          assembled and tested right here in Las Parejas.</p>
      </div>
    </section>

    <!-- ============================ HISTORIA ============================ -->
    <section class="legacy section-pad" id="historia" aria-labelledby="historia-title">
      <div class="container">
        <p class="eyebrow" data-reveal="fade"><img class="mk" src="../assets/img/mark.svg" alt="">History and legacy · 03
        </p>
        <div class="legacy__grid">
          <div class="legacy__media img-reveal" data-reveal>
            <img src="../assets/img/legado.webp" data-default-src="../assets/img/legado.webp" alt="Bales in a harvested field at sunset" loading="lazy"
              width="1500" height="2250">
            <div class="legacy__badge"><b>1957</b><span>Our first furrow</span></div>
          </div>
          <div>
            <h2 class="section-title" id="historia-title" data-reveal style="margin-bottom:1.5rem">Over 65 years
              growing alongside Argentine agriculture.</h2>
            <div class="timeline">
              <div class="tl-item" data-reveal data-hist-img="../assets/img/historia/1.jpg"><span class="yr">1957</span>
                <div>
                  <h3>The start of a new chapter</h3>
                  <p>After working on the farm from a very young age and spending several years as a tailor, Haroldo Scarpeccio took his first steps in industry by building pumps and seed boxes. That was the beginning of a project that soon began to grow in Las Parejas.</p>
                </div>
              </div>

              <div class="tl-item" data-reveal data-reveal-delay="1" data-hist-img="../assets/img/historia/2.jpg"><span class="yr">1960</span>
                <div>
                  <h3>Betting on industry</h3>
                  <p>Growth made it possible to buy a plot of land and build the first production shed. With an initial team of six people, Haroldo decided to leave tailoring for good and focus entirely on developing the factory.</p>
                </div>
              </div>
              <div class="tl-item" data-reveal data-reveal-delay="2" data-hist-img="../assets/img/historia/3.jpg"><span class="yr">1962</span>
                <div>
                  <h3>Industrias Walter is born</h3>
                  <p>After a restructuring of the partnership, the company was renamed Industrias Walter, keeping a brand that had already begun to earn recognition. A period of strong expansion followed and, by 1965, the company already had 120 employees.
                  </p>
                </div>
              </div>
              <div class="tl-item" data-reveal data-reveal-delay="3" data-hist-img="../assets/img/historia/4.webp"><span class="yr">THE 1990s</span>
                <div>
                  <h3>A new generation</h3>
                  <p>In a period of transformation for agriculture, Búfalo S.A. was born, dedicated to the production, distribution and sale of agricultural and road implements. Building no-till seeders opened a new chapter, together with the arrival of the next generation of the Scarpeccio family.</p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- ============================ PROCESO ============================ -->

    <!-- ============================ ALCANCE ============================ -->
    <section class="network section-pad" id="alcance" aria-labelledby="alcance-title">
      <div class="container">
        <p class="eyebrow on-dark" data-reveal="fade"><img class="mk" src="../assets/img/mark.svg" alt="">International
          reach · 05</p>
        <div class="network__grid">
          <div>
            <h2 class="section-title" id="alcance-title" data-reveal style="color:#fff">From Las Parejas to the world.</h2>
            <p class="lead" data-reveal data-reveal-delay="1" style="color:rgba(255,255,255,.72);margin-top:1.2rem">
              Our machines work in soils and climates very different from ours. The same engineering, the same
              standards, season after season.</p>
            <div class="network__stats" data-reveal data-reveal-delay="2">
              <div><b data-count="10" data-prefix="+">10</b><span>international markets</span></div>
              <div><b data-count="4" data-suffix="">4</b><span>continents reached</span></div>
            </div>
          </div>
          <div class="map-card" data-reveal data-reveal-delay="1">
            <div class="region"><span class="r-name">Argentina · Uruguay · Paraguay · Bolivia</span><span
                class="r-meta">South America</span></div>
            <div class="region"><span class="r-name">Venezuela</span><span class="r-meta">Central America</span></div>
            <div class="region"><span class="r-name">Russia · Ukraine · Moldova</span><span class="r-meta">Eastern
                Europe</span></div>
            <div class="region"><span class="r-name">Kazakhstan</span><span class="r-meta">Central Asia</span></div>
            <div class="region"><span class="r-name">South Africa</span><span class="r-meta">Southern Africa</span></div>
            <a class="btn btn--amarillo btn--block" href="<?= sw_url('branches') ?>" style="margin-top:1.5rem">Find your
              dealer</a>
          </div>
        </div>
      </div>
    </section>

    <!-- ============================ CTA breve ============================ -->
    <section class="cta section-pad">
      <div class="container">
        <div class="cta__panel" data-reveal style="text-align:center">
          <p class="eyebrow on-dark" style="justify-content:center;margin-bottom:1rem"><img class="mk"
              src="../assets/img/mark.svg" alt="">Let's talk about your next season</p>
          <h2 class="cta__title" style="max-width:none;margin-inline:auto">Tell us what you plant and we'll help you
            <em>choose your next machine</em>.</h2>
          <p class="cta__lead" style="margin-inline:auto">A factory advisor will contact you directly, no matter which
            province you are in.</p>
          <a class="btn btn--amarillo" href="<?= sw_url('contact') ?>" style="margin-top:1.6rem">Request advice</a>
        </div>
      </div>
    </section>
  </main>

<?php include __DIR__ . '/../partials/footer.php'; ?>
