<?php
declare(strict_types=1);

$lang = 'en';
$base = '../';
require __DIR__ . '/../partials/bootstrap.php';

use SuperWalter\JsonStore;

$productos = JsonStore::allLocalized('productos.json', 'en');

$activeNav = '';
$pageKey = 'home';
$homeHref = '#top';
$ctaHref = '#cta';
$footerCtaHref = '#cta';
$footerLineupHref = '#lineup';
$h = static fn (?string $s): string => htmlspecialchars((string) $s, ENT_QUOTES, 'UTF-8');
$pillClass = static fn (string $variant): string => $variant === 'amarillo' ? 'pill pill--amarillo' : ($variant === 'outline' ? 'pill pill--outline' : 'pill');
$asset = static fn (?string $u): string => preg_match('#^(https?:)?//|^/#', (string) $u) ? (string) $u : $base . ltrim((string) $u, '/');
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="theme-color" content="#7f1810">

  <!-- ============ SEO ============ -->
  <title>Super Walter · Argentine engineering in precision agriculture</title>
  <meta name="description"
    content="65 years building precision seeders in Argentina. The W1770 Triflex, W660 and W650 lineup, section control seeding and a network that reaches the whole country. Ask for advice.">
  <meta name="keywords"
    content="seeders, precision agriculture, Super Walter, W1770 Triflex, no-till seeding, fine grain, air drill, Las Parejas, Santa Fe">
  <link rel="canonical" href="https://superwalter.com.ar/en/">
  <?= sw_hreflang_tags() ?>

  <meta property="og:type" content="website">
  <meta property="og:locale" content="en_US">
  <meta property="og:locale:alternate" content="es_AR">
  <meta property="og:site_name" content="Super Walter">
  <meta property="og:title" content="Super Walter · Argentine engineering in precision agriculture">
  <meta property="og:description"
    content="65 years sowing the future of Argentine farming. W1770, W660 and W650 precision seeders.">
  <meta property="og:url" content="https://superwalter.com.ar/en/">
  <meta property="og:image" content="https://superwalter.com.ar/assets/img/og-image.jpg">
  <meta property="og:image:width" content="1200">
  <meta property="og:image:height" content="800">
  <meta name="twitter:card" content="summary_large_image">
  <meta name="twitter:title" content="Super Walter · Argentine engineering in precision agriculture">
  <meta name="twitter:description" content="65 years sowing the future of Argentine farming.">
  <meta name="twitter:image" content="https://superwalter.com.ar/assets/img/og-image.jpg">

  <link rel="icon" href="<?= $base ?>assets/img/isotipo.svg" type="image/svg+xml">
  <link rel="apple-touch-icon" href="<?= $base ?>assets/img/isotipo.svg">

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap"
    rel="stylesheet">

  <link rel="preload" as="image" href="<?= $base ?>assets/img/campo-escala.webp">
  <link rel="stylesheet" href="<?= $base ?>assets/css/styles.css">

  <script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@type": "Organization",
      "name": "Super Walter",
      "legalName": "Búfalo S.A.",
      "url": "https://superwalter.com.ar/en/",
      "logo": "https://superwalter.com.ar/assets/img/logo.svg",
      "foundingDate": "1960",
      "description": "Argentine manufacturer of seeders and precision agriculture technology, with more than 65 years of experience.",
      "address": {
        "@type": "PostalAddress",
        "streetAddress": "Calle 10 Nº 490",
        "addressLocality": "Las Parejas",
        "addressRegion": "Santa Fe",
        "addressCountry": "AR"
      },
      "contactPoint": {
        "@type": "ContactPoint",
        "telephone": "+54-3471-471069",
        "contactType": "sales",
        "areaServed": "AR",
        "availableLanguage": ["en", "es"]
      },
      "makesOffer": [{
          "@type": "Offer",
          "itemOffered": {
            "@type": "Product",
            "name": "W1770 Triflex seeder"
          }
        },
        {
          "@type": "Offer",
          "itemOffered": {
            "@type": "Product",
            "name": "W660 seeder"
          }
        },
        {
          "@type": "Offer",
          "itemOffered": {
            "@type": "Product",
            "name": "W650 Imperial seeder"
          }
        }
      ]
    }
  </script>
</head>

<body>

<?php include __DIR__ . '/../partials/header.php'; ?>

  <main id="main">
    <span id="top"></span>

    <!-- ============================ HERO ============================ -->
    <section class="hero" id="hero" aria-label="Introduction">
      <div class="hero__media">
        <video autoplay muted loop playsinline poster="<?= $base ?>assets/img/campo-escala.webp" id="heroVideo" aria-hidden="true">
          <source src="<?= $base ?>assets/video/hero-mobile.mp4" media="(max-width: 767px)" type="video/mp4">
          <source src="<?= $base ?>assets/video/hero.mp4" type="video/mp4">
        </video>
      </div>
      <div class="hero__scrim" aria-hidden="true"></div>

      <div class="container hero__inner">
        <div class="hero__tags">
          <span class="pill pill--outline">65 years of experience</span>
          <span class="pill pill--outline">Argentine engineering</span>
        </div>
        <h1 class="hero__title">
          <span class="line"><span>Every seed</span></span>
          <span class="line"><span>has its</span></span>
          <span class="line"><span>place<span class="mark-x">.</span></span></span>
        </h1>
        <p class="hero__sub">We design and build seeders made to work with precision, adapt to every field and stay
          by your side through every sowing season.</p>
        <div class="hero__actions">
          <a class="btn btn--amarillo" href="#lineup">See the seeders</a>
          <a class="btn btn--ghost" href="#cta">Request a quote</a>
        </div>
      </div>
    </section>

    <!-- ============================ MANIFIESTO ============================ -->
    <section class="intro section-pad" id="intro" aria-labelledby="intro-title">
      <div class="container">
        <p class="eyebrow" data-reveal="fade"><img class="mk" src="<?= $base ?>assets/img/mark.svg" alt="">The brand · Búfalo S.A.
        </p>
        <div class="intro__grid">
          <h2 class="intro__statement" id="intro-title" data-reveal>
            For more than 60 years we have built seeders for those who <em>live the farm</em> every single day.
          </h2>
          <div class="intro__body" data-reveal data-reveal-delay="1">
            <p>We are <strong>Super Walter</strong>, part of <strong>Búfalo S.A.</strong> From Las Parejas, in the
              productive heart of Santa Fe, we have spent more than six decades turning engineering into
              real results in the field.</p>
            <p>Every seeder that leaves our plant has one clear goal: <strong>to help you get more out of every
                seed, every metre and every kilo of fertiliser</strong>. That is how we understand precision.</p>
          </div>
        </div>
      </div>
    </section>

    <!-- ============================ LINE-UP ============================ -->
    <section class="lineup section-pad" id="lineup" aria-labelledby="lineup-title">
      <div class="container">
        <p class="eyebrow on-dark" data-reveal="fade"><img class="mk" src="<?= $base ?>assets/img/mark.svg" alt="">Lineup 2025 · 01
        </p>
        <h2 class="section-title" id="lineup-title" data-reveal style="color:#fff">There is a Super Walter for your way
          of seeding.</h2>

        <div class="lineup__grid">
<?php foreach ($productos as $i => $p): ?>
<?php if (!empty($p['is_homepage_featured'])): ?>
          <article class="card-model card-model--feature" data-reveal>
            <div class="card-model__media img-reveal" data-reveal>
              <div class="card-model__tags">
<?php foreach ($p['hero_pills'] ?? [] as $pill): ?>
                <span class="<?= $h($pillClass($pill['variant'] ?? 'plain')) ?>"><?= $h($pill['text'] ?? '') ?></span>
<?php endforeach; ?>
              </div>
              <img src="<?= $h($asset($p['hero_image'])) ?>"
                alt="<?= $h($p['hero_image_alt'] ?? '') ?>" loading="lazy"
                width="2000" height="1334">
            </div>
            <div class="card-model__body">
              <h3 class="card-model__name"><?= $h($p['title']) ?></h3>
              <p class="card-model__desc"><?= $h($p['lead'] ?? '') ?></p>
              <div class="card-model__chips">
<?php foreach ($p['homepage_chips'] ?? [] as $chip): ?>
                <span class="pill pill--outline-dark" style="color:#e8dccb"><?= $h($chip) ?></span>
<?php endforeach; ?>
              </div>
              <a class="card-model__link" href="<?= $h(sw_url('product', (string) $p['slug'])) ?>"><?= $h($p['homepage_link_text'] ?? ('View the ' . $p['title'] . ' overview')) ?></a>
            </div>
          </article>
<?php else: ?>
          <article class="card-model" data-reveal<?= $i > 0 ? ' data-reveal-delay="' . min($i, 2) . '"' : '' ?>>
            <div class="card-model__media img-reveal" data-reveal>
              <div class="card-model__tags"><span class="<?= $h($pillClass($p['listing_badge']['variant'] ?? 'plain')) ?>"><?= $h($p['listing_badge']['text'] ?? '') ?></span></div>
              <img src="<?= $h($asset($p['hero_image'])) ?>"
                alt="<?= $h($p['hero_image_alt'] ?? '') ?>" loading="lazy"
                width="2000" height="1334">
            </div>
            <div class="card-model__body">
              <h3 class="card-model__name"><?= $h($p['title']) ?></h3>
              <p class="card-model__desc"><?= $h($p['lead'] ?? '') ?></p>
              <a class="card-model__link" href="<?= $h(sw_url('product', (string) $p['slug'])) ?>">View overview</a>
            </div>
          </article>
<?php endif; ?>
<?php endforeach; ?>
        </div>
      </div>
    </section>

    <!-- ============================ ESCALA ============================ -->
    <section class="scale" id="scale" aria-label="Scale of work">
      <div class="scale__bg"><img src="<?= $base ?>assets/img/campo-escala.webp"
          alt="Super Walter seeder working in a vast golden field under an open sky" loading="lazy"
          width="1900" height="2080"></div>
      <div class="container scale__inner">
        <p class="eyebrow on-dark" data-reveal><img class="mk" src="<?= $base ?>assets/img/mark.svg" alt="">Precision at scale</p>
        <p class="scale__quote" data-reveal data-reveal-delay="1">Sow only where it is needed. <em>Less overlap,
            fewer inputs and more efficiency on every hectare.</em></p>
        <p class="scale__meta" data-reveal data-reveal-delay="2">Every pass avoids overlaps and cuts seed waste,
          achieving uniform establishment across the whole field. This is what the technology looks like when it
          really works.</p>
      </div>
    </section>

    <!-- ============================ TECNOLOGÍA ============================ -->
    <section class="tech section-pad" id="tech" aria-labelledby="tech-title">
      <div class="container">
        <p class="eyebrow" data-reveal="fade"><img class="mk" src="<?= $base ?>assets/img/mark.svg" alt="">Technology and innovation ·
          02</p>
        <div class="tech__grid">
          <div class="tech__media img-reveal" data-reveal>
            <img src="<?= $base ?>assets/img/tractor-loma.webp"
              alt="Tractor with a Super Walter seeder sowing on a hillside at sunset" loading="lazy" width="1200"
              height="1350">
            <div class="tech__badge"><span class="pill pill--light">Precision agriculture</span></div>
          </div>
          <div>
            <h2 class="section-title" id="tech-title" data-reveal style="margin-bottom:1.6rem">We design every seeder
              so that every seed finds its place.</h2>
            <div class="tech__features">
              <div class="feature" data-reveal>
                <span class="feature__ico" aria-hidden="true"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M4 20V10M12 20V4M20 20v-6" /></svg></span>
                <div>
                  <h3>Section control</h3>
                  <p>The machine automatically shuts off rows that have already been sown, avoiding overlap and
                    lowering the cost per hectare.</p>
                </div>
              </div>
              <div class="feature" data-reveal data-reveal-delay="1">
                <span class="feature__ico" aria-hidden="true"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="12" r="9" />
                    <path d="M12 7v5l3 2" /></svg></span>
                <div>
                  <h3>Air Drill metering</h3>
                  <p>Precise, consistent pneumatic distribution of seed and fertiliser, even at high working
                    speeds.</p>
                </div>
              </div>
              <div class="feature" data-reveal data-reveal-delay="2">
                <span class="feature__ico" aria-hidden="true"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <rect x="3" y="3" width="18" height="18" rx="4" />
                    <path d="M8 12h8M12 8v8" /></svg></span>
                <div>
                  <h3>ISOBUS monitoring</h3>
                  <p>Full control from the cab: seeding rate, inputs and the performance of each row unit in real time.</p>
                </div>
              </div>
              <div class="feature" data-reveal data-reveal-delay="3">
                <span class="feature__ico" aria-hidden="true"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M12 3l8 4.5v9L12 21l-8-4.5v-9L12 3z" />
                    <path d="M12 12l8-4.5M12 12v9M12 12L4 7.5" /></svg></span>
                <div>
                  <h3>Triflex chassis</h3>
                  <p>Triple articulation that follows the terrain and keeps seeding depth even across the full
                    working width.</p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- ============================ MÉTRICAS ============================ -->
    <section class="metrics section-pad" aria-label="Super Walter figures">
      <div class="container">
        <div class="metrics__panel" data-reveal>
          <p class="metrics__label"><img class="mk" src="<?= $base ?>assets/img/mark.svg" alt="">Super Walter in numbers</p>
          <div class="metrics__grid">
            <div class="metric"><b data-count="65" data-suffix="+">0</b><span>years supporting Argentine
                farmers</span></div>
            <div class="metric"><b data-count="9" data-suffix="">0</b><span>models across fine and coarse grain</span>
            </div>
            <div class="metric"><b data-count="1" data-suffix="st">0</b><span>CITA innovation award · W1770</span>
            </div>
            <div class="metric"><b data-count="100" data-suffix="%">0</b><span>nationally engineered and built</span>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- ============================ BENEFICIOS ============================ -->
    <section class="benefits section-pad" id="benefits" aria-labelledby="benefits-title">
      <div class="container">
        <p class="eyebrow" data-reveal="fade"><img class="mk" src="<?= $base ?>assets/img/mark.svg" alt="">Why Super Walter · 03
        </p>
        <h2 class="section-title" id="benefits-title" data-reveal>Technology that makes the difference in the field.</h2>
        <div class="benefits__grid">
          <div class="benefit" data-reveal="sweep"><span class="benefit__n">01</span>
            <h3>Proven robustness</h3>
            <p>Machines built to last season after season, with spare parts available across the country.</p>
          </div>
          <div class="benefit" data-reveal="sweep" data-reveal-delay="1"><span class="benefit__n">02</span>
            <h3>Real precision</h3>
            <p>Seeding uniformity that translates into better emergence and higher yield per hectare.</p>
          </div>
          <div class="benefit" data-reveal="sweep" data-reveal-delay="2"><span class="benefit__n">03</span>
            <h3>Input efficiency</h3>
            <p>Section control and precise metering: every seed and every kilo of fertiliser in its place.</p>
          </div>
          <div class="benefit" data-reveal="sweep" data-reveal-delay="3"><span class="benefit__n">04</span>
            <h3>Close to you</h3>
            <p>An Argentine factory, direct support and a dealer network that knows your area.</p>
          </div>
        </div>
      </div>
    </section>

    <!-- ============================ HISTORIA ============================ -->
    <section class="legacy section-pad" id="legacy" aria-labelledby="legacy-title">
      <div class="container">
        <p class="eyebrow" data-reveal="fade"><img class="mk" src="<?= $base ?>assets/img/mark.svg" alt="">History and legacy · 04
        </p>
        <div class="legacy__grid">
          <div class="legacy__media img-reveal" data-reveal>
            <img src="<?= $base ?>assets/img/ingenieria.webp" data-default-src="<?= $base ?>assets/img/ingenieria.webp"
              alt="Red tractor with a Super Walter seeder on a hillside overlooking the valley" loading="lazy" width="1500"
              height="1873">
            <div class="legacy__badge"><b>1960</b><span>Our first furrow</span></div>
          </div>
          <div>
            <h2 class="section-title" id="legacy-title" data-reveal style="margin-bottom:1.5rem">More than 60 years
              growing alongside Argentine farming.</h2>
            <div class="timeline">
              <div class="tl-item" data-reveal data-hist-img="<?= $base ?>assets/img/historia/1.jpg"><span class="yr">1957</span>
                <div>
                  <h3>The beginning</h3>
                  <p>Haroldo Scarpeccio takes his first steps in industry, manufacturing pumps and seed boxes.</p>
                </div>
              </div>
              <div class="tl-item" data-reveal data-reveal-delay="1" data-hist-img="<?= $base ?>assets/img/historia/2.jpg"><span class="yr">1960</span>
                <div>
                  <h3>The first factory.</h3>
                  <p>Growth makes it possible to buy a plot of land, build the first shed and begin a new chapter with six people.</p>
                </div>
              </div>
              <div class="tl-item" data-reveal data-reveal-delay="2" data-hist-img="<?= $base ?>assets/img/historia/3.jpg"><span class="yr">1962</span>
                <div>
                  <h3>Industrias Walter is born</h3>
                  <p>The company takes the name Industrias Walter and enters a period of strong growth in agricultural machinery.</p>
                </div>
              </div>
              <div class="tl-item" data-reveal data-reveal-delay="3" data-hist-img="<?= $base ?>assets/img/historia/4.webp"><span class="yr">1990s</span>
                <div>
                  <h3>Búfalo S.A. is born</h3>
                  <p>A new chapter focused on farm implements and no-till seeders, with the Scarpeccio family carrying the project forward.</p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- ============================ PROCESO ============================ -->
    <section class="process section-pad" id="process" aria-labelledby="process-title">
      <div class="container">
        <p class="eyebrow on-dark" data-reveal="fade"><img class="mk" src="<?= $base ?>assets/img/mark.svg" alt="">From steel to field
          · 05</p>
        <h2 class="section-title" id="process-title" data-reveal style="color:#fff">How a Super Walter is born.</h2>
        <div class="process__layout">
          <figure class="process__photo img-reveal" data-reveal>
            <img src="<?= $base ?>assets/img/w1770.webp" alt="Super Walter W1770 seeder working in the field at sunset"
              loading="lazy" width="2000" height="1334">
          </figure>
          <div class="process__carousel" data-reveal data-reveal-delay="1">
            <div class="hscroll" id="processScroll">
              <div class="hscroll__row">
                <article class="step">
                  <div class="step__bar" aria-hidden="true"></div>
                  <h3>Design and engineering</h3>
                  <p>Every machine starts from our own development, shaped around the real conditions of Argentine
                    soil.</p>
                </article>
                <article class="step">
                  <div class="step__bar" aria-hidden="true"></div>
                  <h3>Made in Argentina</h3>
                  <p>Cutting, bending and assembly at our plant, with quality checks at every stage.</p>
                </article>
                <article class="step">
                  <div class="step__bar" aria-hidden="true"></div>
                  <h3>Field testing</h3>
                  <p>We validate every innovation where it matters: actually sowing, in the field, measuring results.</p>
                </article>
                <article class="step">
                  <div class="step__bar" aria-hidden="true"></div>
                  <h3>Delivery and support</h3>
                  <p>Commissioning, training and ongoing technical support together with our dealer network.</p>
                </article>
              </div>
            </div>
            <div class="process__nav">
              <span class="process__hint">Swipe or use the arrows</span>
              <div class="process__arrows">
                <button class="process__arrow" id="procPrev" type="button" aria-label="Previous card"><svg
                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round"
                    stroke-linejoin="round" aria-hidden="true">
                    <path d="m15 18-6-6 6-6" /></svg></button>
                <button class="process__arrow" id="procNext" type="button" aria-label="Next card"><svg
                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round"
                    stroke-linejoin="round" aria-hidden="true">
                    <path d="m9 18 6-6-6-6" /></svg></button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- ============================ TESTIMONIOS ============================ -->
    <section class="voices section-pad" id="voices" aria-labelledby="voices-title">
      <div class="container">
        <p class="eyebrow on-dark" data-reveal="fade"><img class="mk" src="<?= $base ?>assets/img/mark.svg" alt="">Real stories · 06
        </p>
        <h2 class="section-title" id="voices-title" data-reveal style="color:#fff">What those who use it every day
          have to say.</h2>
        <div class="reviews" id="reviews">
          <div class="reviews__stage">
            <figure class="review is-active">
              <div class="review__stars" aria-label="5 out of 5">★★★★★</div>
              <blockquote>"I am the user of a Super Walter Imperial W650, and we have had it for 3 years now. We are
                very happy with the machine; it copes very well with uneven ground."</blockquote>
              <figcaption><b>Germán Uanini</b><span>Los Molles, Córdoba · Imperial W650</span></figcaption>
            </figure>
            <figure class="review">
              <div class="review__stars" aria-label="5 out of 5">★★★★★</div>
              <blockquote>"It has been 2 years since we bought an Imperial W650. Honestly, we are very happy; the
                machine runs really well."</blockquote>
              <figcaption><b>Guillermo Prosdocimo</b><span>Colonia Caroya, Córdoba · Imperial W650</span></figcaption>
            </figure>
          </div>
          <div class="reviews__dots" aria-label="Review navigation"></div>
        </div>
      </div>
    </section>

    <!-- ============================ RED ============================ -->
    <section class="network section-pad" id="network" aria-labelledby="network-title">
      <div class="container">
        <p class="eyebrow on-dark" data-reveal="fade"><img class="mk" src="<?= $base ?>assets/img/mark.svg" alt="">Dealer
          network · 07</p>
        <div class="network__grid">
          <div>
            <h2 class="section-title" id="network-title" data-reveal style="color:#fff">Close to you, in every
              productive region of the country.</h2>
            <p class="lead" data-reveal data-reveal-delay="1" style="color:rgba(255,255,255,.72);margin-top:1.2rem">A
              network of dealers and technical support to stand by you in the main farming areas of the country.
              Wherever there is farmland, there is Super Walter.</p>
            <div class="network__stats" data-reveal data-reveal-delay="2">
              <div><b data-count="20" data-suffix="+">20+</b><span>sales and service points</span></div>
              <div><b data-count="6" data-suffix="">6</b><span>provinces covered</span></div>
            </div>
          </div>
          <div class="map-card" data-reveal data-reveal-delay="1">
            <div class="region"><span class="r-name">Santa Fe</span><span class="r-meta">Head office · Las
                Parejas</span></div>
            <div class="region"><span class="r-name">Córdoba</span><span class="r-meta">Dealers</span></div>
            <div class="region"><span class="r-name">Buenos Aires</span><span class="r-meta">Dealers</span></div>
            <div class="region"><span class="r-name">La Pampa</span><span class="r-meta">Dealers</span></div>
            <div class="region"><span class="r-name">Entre Ríos</span><span class="r-meta">Dealers</span></div>
            <div class="region"><span class="r-name">Litoral · NOA · NEA</span><span class="r-meta">Enquire</span>
            </div>
            <a class="btn btn--amarillo btn--block" href="<?= $h(sw_url('branches')) ?>" style="margin-top:1.5rem">Find your
              dealer</a>
          </div>
        </div>
      </div>
    </section>

    <!-- ============================ POSTVENTA ============================ -->
    <section class="service section-pad" id="service" aria-labelledby="service-title">
      <div class="service__bg" aria-hidden="true"><img src="<?= $base ?>assets/img/trigo.webp" alt="" loading="lazy" width="1800"
          height="2250"></div>
      <div class="container">
        <p class="eyebrow" data-reveal="fade"><img class="mk" src="<?= $base ?>assets/img/mark.svg" alt="">Service and after-sales · 08
        </p>
        <h2 class="section-title" id="service-title" data-reveal>We stay with you after delivery.</h2>
        <div class="service__grid">
          <div class="service__card" data-reveal>
            <h3>Technical support</h3>
            <ul>
              <li>Direct assistance from the factory and the dealer network</li>
              <li>Commissioning and operator training</li>
              <li>Diagnosis and support throughout the season</li>
            </ul>
            <p class="service__hours"><b>Technical support hours:</b><br>Mon to Fri 7:00–12:00 / 14:00–18:00 · Sat 8:00–12:00
            </p>
          </div>
          <div class="service__card" data-reveal data-reveal-delay="1">
            <h3>Spare parts and used machinery</h3>
            <ul>
              <li>Genuine spare parts available across the country</li>
              <li>Carefully selected and inspected used machines</li>
              <li>Online store for enquiries and orders</li>
            </ul>
            <p class="service__hours"><b>Head office:</b><br>Calle 10 Nº 490, Las Parejas, Santa Fe</p>
          </div>
        </div>
      </div>
    </section>

    <!-- ============================ NOTICIAS ============================ -->
    <section class="news section-pad" id="news" aria-labelledby="news-title">
      <div class="container">
        <p class="eyebrow" data-reveal="fade"><img class="mk" src="<?= $base ?>assets/img/mark.svg" alt="">News and technical
          content · 09</p>
        <h2 class="section-title" id="news-title" data-reveal>What is happening at Super Walter.</h2>
        <div class="news__grid">
          <article class="news-card" data-reveal>
            <div class="news-card__img"><span class="news-card__pill pill pill--amarillo">Innovation</span><img
                src="<?= $base ?>assets/img/w1770.webp" alt="W1770 seeder in the field" loading="lazy" width="2000"
                height="1334"></div>
            <div class="news-card__body">
              <h3>The W1770 Triflex wins the CITA award</h3>
              <p style="color:var(--texto-mute)">Recognition for innovation in the triple-articulated folding system.</p>
              <a class="news-card__link" href="<?= $h(sw_url('news')) ?>">Read more</a>
            </div>
          </article>
          <article class="news-card" data-reveal data-reveal-delay="1">
            <div class="news-card__img"><span class="news-card__pill pill">Technical note</span><img
                src="<?= $base ?>assets/img/legado.webp" alt="Wheat bales in a harvested field" loading="lazy" width="1500"
                height="2250"></div>
            <div class="news-card__body">
              <h3>Section control: how much you really save</h3>
              <p style="color:var(--texto-mute)">Why shutting off rows that are already sown lowers the cost per hectare
                season after season.</p>
              <a class="news-card__link" href="<?= $h(sw_url('news')) ?>">Read more</a>
            </div>
          </article>
          <article class="news-card" data-reveal data-reveal-delay="2">
            <div class="news-card__img"><span class="news-card__pill pill">Agronomy</span><img
                src="<?= $base ?>assets/img/trigo.webp" alt="Golden wheat field under a clear sky" loading="lazy" width="1800"
                height="2250"></div>
            <div class="news-card__body">
              <h3>Does sowing faster always mean producing more?</h3>
              <p style="color:var(--texto-mute)">Speed, uniformity and depth: the balance that defines
                emergence.</p>
              <a class="news-card__link" href="<?= $h(sw_url('news')) ?>">Read more</a>
            </div>
          </article>
        </div>
        <p class="form__note" data-reveal style="color:var(--texto-mute);margin-top:1.3rem"><a href="<?= $h(sw_url('news')) ?>"
            style="color:var(--bordo);font-weight:600">See all news →</a></p>
      </div>
    </section>

    <!-- ============================ CTA + FORM ============================ -->
    <section class="cta section-pad" id="cta" aria-labelledby="cta-title">
      <div class="container">
        <div class="cta__panel">
          <div class="cta__grid">
            <div data-reveal>
              <p class="eyebrow on-dark" style="margin-bottom:1.2rem"><img class="mk" src="<?= $base ?>assets/img/mark.svg"
                  alt="">Let's talk about your next season</p>
              <h2 class="cta__title" id="cta-title">Find the <em>ideal seeder</em> for your farm.</h2>
              <p class="cta__lead">Tell us what you sow and how many hectares you work. An advisor will help you choose
                the right seeder and send you a quote.</p>
              <div class="cta__contacts">
                <div class="cta__contact">
                  <span class="ico"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                      stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                      <path
                        d="M22 16.9v3a2 2 0 0 1-2.2 2 19.8 19.8 0 0 1-8.6-3 19.5 19.5 0 0 1-6-6 19.8 19.8 0 0 1-3-8.7A2 2 0 0 1 4.1 2h3a2 2 0 0 1 2 1.7c.1 1 .4 1.9.7 2.8a2 2 0 0 1-.5 2.1L8.1 9.9a16 16 0 0 0 6 6l1.3-1.3a2 2 0 0 1 2.1-.4c.9.3 1.8.6 2.8.7a2 2 0 0 1 1.7 2z" />
                      </svg></span>
                  <span><b>Phone / WhatsApp</b><a href="tel:+543471471069">+54 3471 471069</a></span><!-- EDITAR -->
                </div>
                <div class="cta__contact">
                  <span class="ico"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                      stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                      <rect x="3" y="5" width="18" height="14" rx="2" />
                      <path d="m3 7 9 6 9-6" /></svg></span>
                  <span><b>Email</b><a href="mailto:ventas@superwalter.com.ar">ventas@superwalter.com.ar</a></span>
                  <!-- EDITAR -->
                </div>
                <div class="cta__contact">
                  <span class="ico"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                      stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                      <path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0z" />
                      <circle cx="12" cy="10" r="3" /></svg></span>
                  <span><b>Head office</b><span>Calle 10 Nº 490, Las Parejas, Santa Fe</span></span>
                </div>
              </div>
            </div>

            <form class="form" id="leadForm" data-endpoint="<?= $base ?>api/contacto.php" data-reveal data-reveal-delay="1"
              novalidate>
              <input type="text" name="website" tabindex="-1" autocomplete="off" aria-hidden="true"
                style="position:absolute;left:-5000px">
              <div class="form__grid">
                <div class="field field--wide"><label for="f-nombre"><span class="field__num">01</span> Full
                    name</label><input type="text" id="f-nombre" name="nombre" autocomplete="name" required
                    placeholder="Your name"></div>
                <div class="field field--narrow"><label for="f-tel"><span class="field__num">02</span>
                    Phone</label><input type="tel" id="f-tel" name="telefono" autocomplete="tel" required
                    placeholder="Area code + number"></div>
                <div class="field field--narrow"><label for="f-email"><span class="field__num">03</span>
                    Email</label><input type="email" id="f-email" name="email" autocomplete="email" required
                    placeholder="you@email.com"></div>
                <div class="field field--wide"><label for="f-zona"><span class="field__num">04</span> Town /
                    Province</label><input type="text" id="f-zona" name="zona" required
                    placeholder="E.g. Pergamino, Buenos Aires"></div>
                <div class="field">
                  <span class="field-label" id="modelo-label"><span class="field__num">05</span> Which model are you
                    interested in?</span>
                  <div class="chips" role="group" aria-labelledby="modelo-label">
                    <label class="chip"><input type="radio" name="modelo" value="W1770 Triflex" checked><span>W1770
                        Triflex</span></label>
                    <label class="chip"><input type="radio" name="modelo" value="W660"><span>W660</span></label>
                    <label class="chip"><input type="radio" name="modelo" value="W650 Imperial"><span>W650
                        Imperial</span></label>
                    <label class="chip"><input type="radio" name="modelo" value="Asesoramiento"><span>I need
                        advice</span></label>
                  </div>
                </div>
                <div class="field"><label for="f-msg"><span class="field__num">06</span> Your message <span
                      style="text-transform:none;letter-spacing:0;color:var(--texto-mute);font-weight:400">(optional)</span></label><textarea
                    id="f-msg" name="mensaje" placeholder="Crops, hectares, seeding system..."></textarea></div>
                <div class="field"><button class="btn btn--amarillo btn--block" type="submit">Request
                    advice</button></div>
              </div>
              <p class="form__note">By submitting you agree to be contacted by Super Walter. We do not share your data.
                This site is protected by reCAPTCHA and the Google <a href="https://policies.google.com/privacy"
                  target="_blank" rel="noopener">Privacy Policy</a> and <a
                  href="https://policies.google.com/terms" target="_blank" rel="noopener">Terms of Service</a>
                apply.</p>
              <div class="form__success" id="formSuccess" role="status" aria-live="polite">
                <b>Done! We have received your enquiry.</b>
                <span>A Super Walter advisor will get in touch with you shortly.</span>
              </div>
            </form>
          </div>
        </div>
      </div>
    </section>
  </main>

<?php include __DIR__ . '/../partials/footer.php'; ?>
