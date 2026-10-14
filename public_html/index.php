<?php
declare(strict_types=1);

require __DIR__ . '/partials/bootstrap.php';

use SuperWalter\JsonStore;

$productos = JsonStore::all('productos.json');

$base = '';
$activeNav = '';
$pageKey = 'home';
$homeHref = '#top';
$ctaHref = '#cta';
$footerCtaHref = '#cta';
$footerLineupHref = '#lineup';
$h = static fn (?string $s): string => htmlspecialchars((string) $s, ENT_QUOTES, 'UTF-8');
$pillClass = static fn (string $variant): string => $variant === 'amarillo' ? 'pill pill--amarillo' : ($variant === 'outline' ? 'pill pill--outline' : 'pill');
?>
<!DOCTYPE html>
<html lang="es-AR">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="theme-color" content="#7f1810">

  <!-- ============ SEO ============ -->
  <title>Super Walter · Ingeniería argentina en agricultura de precisión</title>
  <meta name="description"
    content="65 años fabricando sembradoras de precisión en Argentina. Line-up W1770 Triflex, W660 y W650, siembra por sección y una red que llega a todo el país. Solicitá asesoramiento.">
  <meta name="keywords"
    content="sembradoras, agricultura de precisión, Super Walter, W1770 Triflex, siembra directa, grano fino, air drill, Las Parejas, Santa Fe">
  <link rel="canonical" href="https://superwalter.com.ar/">
  <?= sw_hreflang_tags() ?>

  <meta property="og:type" content="website">
  <meta property="og:locale" content="es_AR">
  <meta property="og:site_name" content="Super Walter">
  <meta property="og:title" content="Super Walter · Ingeniería argentina en agricultura de precisión">
  <meta property="og:description"
    content="65 años sembrando el futuro del campo argentino. Sembradoras de precisión W1770, W660 y W650.">
  <meta property="og:url" content="https://superwalter.com.ar/">
  <meta property="og:image" content="https://superwalter.com.ar/assets/img/og-image.jpg">
  <meta property="og:image:width" content="1200">
  <meta property="og:image:height" content="800">
  <meta name="twitter:card" content="summary_large_image">
  <meta name="twitter:title" content="Super Walter · Ingeniería argentina en agricultura de precisión">
  <meta name="twitter:description" content="65 años sembrando el futuro del campo argentino.">
  <meta name="twitter:image" content="https://superwalter.com.ar/assets/img/og-image.jpg">

  <link rel="icon" href="assets/img/isotipo.svg" type="image/svg+xml">
  <link rel="apple-touch-icon" href="assets/img/isotipo.svg">

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap"
    rel="stylesheet">

  <link rel="preload" as="image" href="assets/img/campo-escala.webp">
  <link rel="stylesheet" href="assets/css/styles.css">

  <script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@type": "Organization",
      "name": "Super Walter",
      "legalName": "Búfalo S.A.",
      "url": "https://superwalter.com.ar/",
      "logo": "https://superwalter.com.ar/assets/img/logo.svg",
      "foundingDate": "1960",
      "description": "Fabricante argentino de sembradoras y tecnología para agricultura de precisión, con más de 65 años de trayectoria.",
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
        "contactType": "ventas",
        "areaServed": "AR",
        "availableLanguage": "es"
      },
      "makesOffer": [{
          "@type": "Offer",
          "itemOffered": {
            "@type": "Product",
            "name": "Sembradora W1770 Triflex"
          }
        },
        {
          "@type": "Offer",
          "itemOffered": {
            "@type": "Product",
            "name": "Sembradora W660"
          }
        },
        {
          "@type": "Offer",
          "itemOffered": {
            "@type": "Product",
            "name": "Sembradora W650 Imperial"
          }
        }
      ]
    }
  </script>
</head>

<body>

<?php include __DIR__ . '/partials/header.php'; ?>

  <main id="main">
    <span id="top"></span>

    <!-- ============================ HERO ============================ -->
    <section class="hero" id="hero" aria-label="Presentación">
      <div class="hero__media">
        <video autoplay muted loop playsinline poster="assets/img/campo-escala.webp" id="heroVideo" aria-hidden="true">
          <source src="assets/video/hero-mobile.mp4" media="(max-width: 767px)" type="video/mp4">
          <source src="assets/video/hero.mp4" type="video/mp4">
        </video>
      </div>
      <div class="hero__scrim" aria-hidden="true"></div>

      <div class="container hero__inner">
        <div class="hero__tags">
          <span class="pill pill--outline">65 años de trayectoria</span>
          <span class="pill pill--outline">Ingeniería argentina</span>
        </div>
        <h1 class="hero__title">
          <span class="line"><span>Cada semilla</span></span>
          <span class="line"><span>tiene su</span></span>
          <span class="line"><span>lugar<span class="mark-x">.</span></span></span>
        </h1>
        <p class="hero__sub">Diseñamos y fabricamos sembradoras pensadas para trabajar con precisión, adaptarse a cada
          lote y acompañarte en cada siembra.</p>
        <div class="hero__actions">
          <a class="btn btn--amarillo" href="#lineup">Ver las sembradoras</a>
          <a class="btn btn--ghost" href="#cta">Solicitar cotización</a>
        </div>
      </div>
    </section>

    <!-- ============================ MANIFIESTO ============================ -->
    <section class="intro section-pad" id="intro" aria-labelledby="intro-title">
      <div class="container">
        <p class="eyebrow" data-reveal="fade"><img class="mk" src="assets/img/mark.svg" alt="">La marca · Búfalo S.A.
        </p>
        <div class="intro__grid">
          <h2 class="intro__statement" id="intro-title" data-reveal>
            Hace más de 60 años hacemos sembradoras para los que <em>viven el campo</em> todos los días.
          </h2>
          <div class="intro__body" data-reveal data-reveal-delay="1">
            <p>Somos <strong>Super Walter</strong>, parte de <strong>Búfalo S.A.</strong> Desde Las Parejas, en el
              corazón productivo de Santa Fe, llevamos más de seis décadas transformando ingeniería en resultados
              concretos sobre el lote.</p>
            <p>Cada sembradora que sale de nuestra planta tiene un objetivo claro: <strong>que aproveches mejor cada
                semilla, cada metro y cada kilo de fertilizante</strong>. Así entendemos la precisión.</p>
          </div>
        </div>
      </div>
    </section>

    <!-- ============================ LINE-UP ============================ -->
    <section class="lineup section-pad" id="lineup" aria-labelledby="lineup-title">
      <div class="container">
        <p class="eyebrow on-dark" data-reveal="fade"><img class="mk" src="assets/img/mark.svg" alt="">Line-up 2025 · 01
        </p>
        <h2 class="section-title" id="lineup-title" data-reveal style="color:#fff">Hay una Super Walter para tu forma de
          sembrar.</h2>

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
              <img src="<?= $h($p['hero_image']) ?>"
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
              <a class="card-model__link" href="productos/<?= $h($p['slug']) ?>"><?= $h($p['homepage_link_text'] ?? ('Ver ficha de la ' . $p['title'])) ?></a>
            </div>
          </article>
<?php else: ?>
          <article class="card-model" data-reveal<?= $i > 0 ? ' data-reveal-delay="' . min($i, 2) . '"' : '' ?>>
            <div class="card-model__media img-reveal" data-reveal>
              <div class="card-model__tags"><span class="<?= $h($pillClass($p['listing_badge']['variant'] ?? 'plain')) ?>"><?= $h($p['listing_badge']['text'] ?? '') ?></span></div>
              <img src="<?= $h($p['hero_image']) ?>"
                alt="<?= $h($p['hero_image_alt'] ?? '') ?>" loading="lazy"
                width="2000" height="1334">
            </div>
            <div class="card-model__body">
              <h3 class="card-model__name"><?= $h($p['title']) ?></h3>
              <p class="card-model__desc"><?= $h($p['lead'] ?? '') ?></p>
              <a class="card-model__link" href="productos/<?= $h($p['slug']) ?>">Ver ficha</a>
            </div>
          </article>
<?php endif; ?>
<?php endforeach; ?>
        </div>
      </div>
    </section>

    <!-- ============================ ESCALA ============================ -->
    <section class="scale" id="scale" aria-label="Escala de trabajo">
      <div class="scale__bg"><img src="assets/img/campo-escala.webp"
          alt="Sembradora Super Walter trabajando en un extenso lote dorado bajo un cielo abierto" loading="lazy"
          width="1900" height="2080"></div>
      <div class="container scale__inner">
        <p class="eyebrow on-dark" data-reveal><img class="mk" src="assets/img/mark.svg" alt="">Precisión a escala</p>
        <p class="scale__quote" data-reveal data-reveal-delay="1">Sembrá solo donde hace falta. <em>Menos superposición,
            menos insumos y más eficiencia en cada hectárea.</em></p>
        <p class="scale__meta" data-reveal data-reveal-delay="2">Cada pasada evita solapamientos y reduce el desperdicio
          de semilla, logrando una implantación uniforme en todo el lote. Así se ve la tecnología cuando trabaja de
          verdad.</p>
      </div>
    </section>

    <!-- ============================ TECNOLOGÍA ============================ -->
    <section class="tech section-pad" id="tech" aria-labelledby="tech-title">
      <div class="container">
        <p class="eyebrow" data-reveal="fade"><img class="mk" src="assets/img/mark.svg" alt="">Tecnología e innovación ·
          02</p>
        <div class="tech__grid">
          <div class="tech__media img-reveal" data-reveal>
            <img src="assets/img/tractor-loma.webp"
              alt="Tractor con sembradora Super Walter sembrando en una loma al atardecer" loading="lazy" width="1200"
              height="1350">
            <div class="tech__badge"><span class="pill pill--light">Agricultura de precisión</span></div>
          </div>
          <div>
            <h2 class="section-title" id="tech-title" data-reveal style="margin-bottom:1.6rem">Diseñamos cada sembradora
              para que cada semilla encuentre su lugar.</h2>
            <div class="tech__features">
              <div class="feature" data-reveal>
                <span class="feature__ico" aria-hidden="true"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M4 20V10M12 20V4M20 20v-6" /></svg></span>
                <div>
                  <h3>Corte por sección</h3>
                  <p>La máquina apaga automáticamente las líneas ya sembradas, evitando superposiciones y bajando el
                    costo por hectárea.</p>
                </div>
              </div>
              <div class="feature" data-reveal data-reveal-delay="1">
                <span class="feature__ico" aria-hidden="true"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="12" r="9" />
                    <path d="M12 7v5l3 2" /></svg></span>
                <div>
                  <h3>Dosificación Air Drill</h3>
                  <p>Distribución neumática precisa y constante de semilla y fertilizante, aún a alta velocidad de
                    avance.</p>
                </div>
              </div>
              <div class="feature" data-reveal data-reveal-delay="2">
                <span class="feature__ico" aria-hidden="true"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <rect x="3" y="3" width="18" height="18" rx="4" />
                    <path d="M8 12h8M12 8v8" /></svg></span>
                <div>
                  <h3>Monitoreo ISOBUS</h3>
                  <p>Control total desde la cabina: densidad, insumos y desempeño de cada cuerpo en tiempo real.</p>
                </div>
              </div>
              <div class="feature" data-reveal data-reveal-delay="3">
                <span class="feature__ico" aria-hidden="true"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M12 3l8 4.5v9L12 21l-8-4.5v-9L12 3z" />
                    <path d="M12 12l8-4.5M12 12v9M12 12L4 7.5" /></svg></span>
                <div>
                  <h3>Chasis Triflex</h3>
                  <p>Triple articulación que copia el terreno y mantiene la profundidad de siembra pareja en todo el
                    ancho de labor.</p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- ============================ MÉTRICAS ============================ -->
    <section class="metrics section-pad" aria-label="Cifras Super Walter">
      <div class="container">
        <div class="metrics__panel" data-reveal>
          <p class="metrics__label"><img class="mk" src="assets/img/mark.svg" alt="">Super Walter en números</p>
          <div class="metrics__grid">
            <div class="metric"><b data-count="65" data-suffix="+">0</b><span>años acompañando al productor
                argentino</span></div>
            <div class="metric"><b data-count="9" data-suffix="">0</b><span>modelos entre grano fino y grueso</span>
            </div>
            <div class="metric"><b data-count="1" data-suffix="º">0</b><span>premio CITA a la innovación · W1770</span>
            </div>
            <div class="metric"><b data-count="100" data-suffix="%">0</b><span>ingeniería y fabricación nacional</span>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- ============================ BENEFICIOS ============================ -->
    <section class="benefits section-pad" id="benefits" aria-labelledby="benefits-title">
      <div class="container">
        <p class="eyebrow" data-reveal="fade"><img class="mk" src="assets/img/mark.svg" alt="">Por qué Super Walter · 03
        </p>
        <h2 class="section-title" id="benefits-title" data-reveal>Tecnología que hace la diferencia en el lote.</h2>
        <div class="benefits__grid">
          <div class="benefit" data-reveal="sweep"><span class="benefit__n">01</span>
            <h3>Robustez probada</h3>
            <p>Máquinas diseñadas para durar campañas, con repuestos disponibles en todo el país.</p>
          </div>
          <div class="benefit" data-reveal="sweep" data-reveal-delay="1"><span class="benefit__n">02</span>
            <h3>Precisión real</h3>
            <p>Uniformidad de siembra que se traduce en mejor emergencia y más rinde por hectárea.</p>
          </div>
          <div class="benefit" data-reveal="sweep" data-reveal-delay="2"><span class="benefit__n">03</span>
            <h3>Eficiencia de insumos</h3>
            <p>Corte por sección y dosificación precisa: cada semilla y cada kilo de fertilizante en su lugar.</p>
          </div>
          <div class="benefit" data-reveal="sweep" data-reveal-delay="3"><span class="benefit__n">04</span>
            <h3>Cercanía</h3>
            <p>Fábrica argentina, soporte directo y una red de concesionarios que conoce tu zona.</p>
          </div>
        </div>
      </div>
    </section>

    <!-- ============================ HISTORIA ============================ -->
    <section class="legacy section-pad" id="legacy" aria-labelledby="legacy-title">
      <div class="container">
        <p class="eyebrow" data-reveal="fade"><img class="mk" src="assets/img/mark.svg" alt="">Historia y legado · 04
        </p>
        <div class="legacy__grid">
          <div class="legacy__media img-reveal" data-reveal>
            <img src="assets/img/ingenieria.webp" data-default-src="assets/img/ingenieria.webp"
              alt="Tractor rojo con sembradora Super Walter en una loma con vista al valle" loading="lazy" width="1500"
              height="1873">
            <div class="legacy__badge"><b>1960</b><span>Nuestro primer surco</span></div>
          </div>
          <div>
            <h2 class="section-title" id="legacy-title" data-reveal style="margin-bottom:1.5rem">Más de 60 años
              creciendo junto al campo argentino.</h2>
            <div class="timeline">
              <div class="tl-item" data-reveal data-hist-img="assets/img/historia/1.jpg"><span class="yr">1957</span>
                <div>
                  <h3>El comienzo</h3>
                  <p>Haroldo Scarpeccio da sus primeros pasos en la industria con la fabricación de bombeadores y cajones sembradores.</p>
                </div>
              </div>
              <div class="tl-item" data-reveal data-reveal-delay="1" data-hist-img="assets/img/historia/2.jpg"><span class="yr">1960</span>
                <div>
                  <h3>La primera fábrica.</h3>
                  <p>El crecimiento permite comprar un terreno, construir el primer galpón y comenzar una nueva etapa con seis personas.</p>
                </div>
              </div>
              <div class="tl-item" data-reveal data-reveal-delay="2" data-hist-img="assets/img/historia/3.jpg"><span class="yr">1962</span>
                <div>
                  <h3>Nace Industrias Walter</h3>
                  <p>La empresa adopta el nombre Industrias Walter y comienza una etapa de fuerte crecimiento en maquinaria agrícola.</p>
                </div>
              </div>
              <div class="tl-item" data-reveal data-reveal-delay="3" data-hist-img="assets/img/historia/4.webp"><span class="yr">AÑOS 90</span>
                <div>
                  <h3>Nace Búfalo S.A.</h3>
                  <p>Una nueva etapa enfocada en implementos agrícolas y sembradoras para siembra directa, con la familia Scarpeccio dando continuidad al proyecto.</p>
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
        <p class="eyebrow on-dark" data-reveal="fade"><img class="mk" src="assets/img/mark.svg" alt="">Del acero al lote
          · 05</p>
        <h2 class="section-title" id="process-title" data-reveal style="color:#fff">Así nace una Super Walter.</h2>
        <div class="process__layout">
          <figure class="process__photo img-reveal" data-reveal>
            <img src="assets/img/w1770.webp" alt="Sembradora Super Walter W1770 trabajando en el lote al atardecer"
              loading="lazy" width="2000" height="1334">
          </figure>
          <div class="process__carousel" data-reveal data-reveal-delay="1">
            <div class="hscroll" id="processScroll">
              <div class="hscroll__row">
                <article class="step">
                  <div class="step__bar" aria-hidden="true"></div>
                  <h3>Diseño e ingeniería</h3>
                  <p>Cada equipo parte de un desarrollo propio, pensado sobre las condiciones reales del suelo
                    argentino.</p>
                </article>
                <article class="step">
                  <div class="step__bar" aria-hidden="true"></div>
                  <h3>Fabricación nacional</h3>
                  <p>Corte, plegado y armado en nuestra planta, con controles de calidad en cada etapa.</p>
                </article>
                <article class="step">
                  <div class="step__bar" aria-hidden="true"></div>
                  <h3>Prueba a campo</h3>
                  <p>Validamos cada innovación donde importa: sembrando de verdad, en el lote, midiendo resultados.</p>
                </article>
                <article class="step">
                  <div class="step__bar" aria-hidden="true"></div>
                  <h3>Entrega y acompañamiento</h3>
                  <p>Puesta en marcha, capacitación y soporte técnico continuo junto a la red de concesionarios.</p>
                </article>
              </div>
            </div>
            <div class="process__nav">
              <span class="process__hint">Deslizá o usá las flechas</span>
              <div class="process__arrows">
                <button class="process__arrow" id="procPrev" type="button" aria-label="Tarjeta anterior"><svg
                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round"
                    stroke-linejoin="round" aria-hidden="true">
                    <path d="m15 18-6-6 6-6" /></svg></button>
                <button class="process__arrow" id="procNext" type="button" aria-label="Tarjeta siguiente"><svg
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
        <p class="eyebrow on-dark" data-reveal="fade"><img class="mk" src="assets/img/mark.svg" alt="">Casos reales · 06
        </p>
        <h2 class="section-title" id="voices-title" data-reveal style="color:#fff">Lo que dice el que la usa todos los
          días.</h2>
        <div class="reviews" id="reviews">
          <div class="reviews__stage">
            <figure class="review is-active">
              <div class="review__stars" aria-label="5 de 5">★★★★★</div>
              <blockquote>"Soy usuario de una Imperial W650 de Super Walter, hace 3 años ya que la tenemos. Estamos muy
                conformes con la máquina, se adapta muy bien a los suelos quebrados."</blockquote>
              <figcaption><b>Germán Uanini</b><span>Los Molles, Córdoba · Imperial W650</span></figcaption>
            </figure>
            <figure class="review">
              <div class="review__stars" aria-label="5 de 5">★★★★★</div>
              <blockquote>"Hace 2 años ya, compramos una Imperial W650. La verdad estamos muy conformes, anda muy bien
                la máquina."</blockquote>
              <figcaption><b>Guillermo Prosdocimo</b><span>Colonia Caroya, Córdoba · Imperial W650</span></figcaption>
            </figure>
          </div>
          <div class="reviews__dots" aria-label="Navegación de reseñas"></div>
        </div>
      </div>
    </section>

    <!-- ============================ RED ============================ -->
    <section class="network section-pad" id="network" aria-labelledby="network-title">
      <div class="container">
        <p class="eyebrow on-dark" data-reveal="fade"><img class="mk" src="assets/img/mark.svg" alt="">Red de
          concesionarios · 07</p>
        <div class="network__grid">
          <div>
            <h2 class="section-title" id="network-title" data-reveal style="color:#fff">Cerca tuyo, en cada región
              productiva del país.</h2>
            <p class="lead" data-reveal data-reveal-delay="1" style="color:rgba(255,255,255,.72);margin-top:1.2rem">Una
              red de concesionarios y soporte técnico para acompañarte en las principales zonas agrícolas del país.
              Donde hay campo, hay Super Walter.</p>
            <div class="network__stats" data-reveal data-reveal-delay="2">
              <div><b data-count="20" data-suffix="+">20+</b><span>puntos de venta y servicio</span></div>
              <div><b data-count="6" data-suffix="">6</b><span>provincias con cobertura</span></div>
            </div>
          </div>
          <div class="map-card" data-reveal data-reveal-delay="1">
            <div class="region"><span class="r-name">Santa Fe</span><span class="r-meta">Casa central · Las
                Parejas</span></div>
            <div class="region"><span class="r-name">Córdoba</span><span class="r-meta">Concesionarios</span></div>
            <div class="region"><span class="r-name">Buenos Aires</span><span class="r-meta">Concesionarios</span></div>
            <div class="region"><span class="r-name">La Pampa</span><span class="r-meta">Concesionarios</span></div>
            <div class="region"><span class="r-name">Entre Ríos</span><span class="r-meta">Concesionarios</span></div>
            <div class="region"><span class="r-name">Litoral · NOA · NEA</span><span class="r-meta">Consultá</span>
            </div>
            <a class="btn btn--amarillo btn--block" href="sucursales" style="margin-top:1.5rem">Encontrá tu
              concesionario</a>
          </div>
        </div>
      </div>
    </section>

    <!-- ============================ POSTVENTA ============================ -->
    <section class="service section-pad" id="service" aria-labelledby="service-title">
      <div class="service__bg" aria-hidden="true"><img src="assets/img/trigo.webp" alt="" loading="lazy" width="1800"
          height="2250"></div>
      <div class="container">
        <p class="eyebrow" data-reveal="fade"><img class="mk" src="assets/img/mark.svg" alt="">Servicio y postventa · 08
        </p>
        <h2 class="section-title" id="service-title" data-reveal>Seguimos con vos después de la entrega.</h2>
        <div class="service__grid">
          <div class="service__card" data-reveal>
            <h3>Soporte técnico</h3>
            <ul>
              <li>Asistencia directa de fábrica y red de concesionarios</li>
              <li>Puesta en marcha y capacitación de operarios</li>
              <li>Diagnóstico y acompañamiento durante la campaña</li>
            </ul>
            <p class="service__hours"><b>Atención técnica:</b><br>Lun a Vie 7:00–12:00 / 14:00–18:00 · Sáb 8:00–12:00
            </p>
          </div>
          <div class="service__card" data-reveal data-reveal-delay="1">
            <h3>Repuestos y usados</h3>
            <ul>
              <li>Repuestos originales disponibles en todo el país</li>
              <li>Equipos usados seleccionados y revisados</li>
              <li>Tienda online para consultas y pedidos</li>
            </ul>
            <p class="service__hours"><b>Casa central:</b><br>Calle 10 Nº 490, Las Parejas, Santa Fe</p>
          </div>
        </div>
      </div>
    </section>

    <!-- ============================ NOTICIAS ============================ -->
    <section class="news section-pad" id="news" aria-labelledby="news-title">
      <div class="container">
        <p class="eyebrow" data-reveal="fade"><img class="mk" src="assets/img/mark.svg" alt="">Novedades y contenido
          técnico · 09</p>
        <h2 class="section-title" id="news-title" data-reveal>Lo que está pasando en Super Walter.</h2>
        <div class="news__grid">
          <article class="news-card" data-reveal>
            <div class="news-card__img"><span class="news-card__pill pill pill--amarillo">Innovación</span><img
                src="assets/img/w1770.webp" alt="Sembradora W1770 en el campo" loading="lazy" width="2000"
                height="1334"></div>
            <div class="news-card__body">
              <h3>La W1770 Triflex gana el premio CITA</h3>
              <p style="color:var(--texto-mute)">Reconocimiento a la innovación en el sistema de plegado triple
                articulado.</p>
              <a class="news-card__link" href="novedades">Leer más</a>
            </div>
          </article>
          <article class="news-card" data-reveal data-reveal-delay="1">
            <div class="news-card__img"><span class="news-card__pill pill">Nota técnica</span><img
                src="assets/img/legado.webp" alt="Fardos de trigo en un campo cosechado" loading="lazy" width="1500"
                height="2250"></div>
            <div class="news-card__body">
              <h3>Corte por sección: cuánto se ahorra de verdad</h3>
              <p style="color:var(--texto-mute)">Por qué apagar las líneas ya sembradas baja el costo por hectárea
                campaña tras campaña.</p>
              <a class="news-card__link" href="novedades">Leer más</a>
            </div>
          </article>
          <article class="news-card" data-reveal data-reveal-delay="2">
            <div class="news-card__img"><span class="news-card__pill pill">Agronomía</span><img
                src="assets/img/trigo.webp" alt="Campo de trigo dorado bajo cielo despejado" loading="lazy" width="1800"
                height="2250"></div>
            <div class="news-card__body">
              <h3>¿Sembrar más rápido siempre significa producir más?</h3>
              <p style="color:var(--texto-mute)">Velocidad, uniformidad y profundidad: el equilibrio que define la
                emergencia.</p>
              <a class="news-card__link" href="novedades">Leer más</a>
            </div>
          </article>
        </div>
        <p class="form__note" data-reveal style="color:var(--texto-mute);margin-top:1.3rem"><a href="novedades"
            style="color:var(--bordo);font-weight:600">Ver todas las novedades →</a></p>
      </div>
    </section>

    <!-- ============================ CTA + FORM ============================ -->
    <section class="cta section-pad" id="cta" aria-labelledby="cta-title">
      <div class="container">
        <div class="cta__panel">
          <div class="cta__grid">
            <div data-reveal>
              <p class="eyebrow on-dark" style="margin-bottom:1.2rem"><img class="mk" src="assets/img/mark.svg"
                  alt="">Hablemos de tu próxima campaña</p>
              <h2 class="cta__title" id="cta-title">Encontrá la <em>sembradora ideal</em> para tu campo.</h2>
              <p class="cta__lead">Contanos qué sembrás y cuántas hectáreas trabajás. Un asesor te ayuda a elegir la
                sembradora justa y te acerca la cotización.</p>
              <div class="cta__contacts">
                <div class="cta__contact">
                  <span class="ico"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                      stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                      <path
                        d="M22 16.9v3a2 2 0 0 1-2.2 2 19.8 19.8 0 0 1-8.6-3 19.5 19.5 0 0 1-6-6 19.8 19.8 0 0 1-3-8.7A2 2 0 0 1 4.1 2h3a2 2 0 0 1 2 1.7c.1 1 .4 1.9.7 2.8a2 2 0 0 1-.5 2.1L8.1 9.9a16 16 0 0 0 6 6l1.3-1.3a2 2 0 0 1 2.1-.4c.9.3 1.8.6 2.8.7a2 2 0 0 1 1.7 2z" />
                      </svg></span>
                  <span><b>Teléfono / WhatsApp</b><a href="tel:+543471471069">+54 3471 471069</a></span><!-- EDITAR -->
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
                  <span><b>Casa central</b><span>Calle 10 Nº 490, Las Parejas, Santa Fe</span></span>
                </div>
              </div>
            </div>

            <form class="form" id="leadForm" data-endpoint="api/contacto.php" data-reveal data-reveal-delay="1"
              novalidate>
              <input type="text" name="website" tabindex="-1" autocomplete="off" aria-hidden="true"
                style="position:absolute;left:-5000px">
              <div class="form__grid">
                <div class="field field--wide"><label for="f-nombre"><span class="field__num">01</span> Nombre y
                    apellido</label><input type="text" id="f-nombre" name="nombre" autocomplete="name" required
                    placeholder="Tu nombre"></div>
                <div class="field field--narrow"><label for="f-tel"><span class="field__num">02</span>
                    Teléfono</label><input type="tel" id="f-tel" name="telefono" autocomplete="tel" required
                    placeholder="Cód. + número"></div>
                <div class="field field--narrow"><label for="f-email"><span class="field__num">03</span>
                    Email</label><input type="email" id="f-email" name="email" autocomplete="email" required
                    placeholder="tu@email.com"></div>
                <div class="field field--wide"><label for="f-zona"><span class="field__num">04</span> Localidad /
                    Provincia</label><input type="text" id="f-zona" name="zona" required
                    placeholder="Ej: Pergamino, Bs. As."></div>
                <div class="field">
                  <span class="field-label" id="modelo-label"><span class="field__num">05</span> ¿Qué modelo te
                    interesa?</span>
                  <div class="chips" role="group" aria-labelledby="modelo-label">
                    <label class="chip"><input type="radio" name="modelo" value="W1770 Triflex" checked><span>W1770
                        Triflex</span></label>
                    <label class="chip"><input type="radio" name="modelo" value="W660"><span>W660</span></label>
                    <label class="chip"><input type="radio" name="modelo" value="W650 Imperial"><span>W650
                        Imperial</span></label>
                    <label class="chip"><input type="radio" name="modelo" value="Asesoramiento"><span>Necesito
                        asesoramiento</span></label>
                  </div>
                </div>
                <div class="field"><label for="f-msg"><span class="field__num">06</span> Tu mensaje <span
                      style="text-transform:none;letter-spacing:0;color:var(--texto-mute);font-weight:400">(opcional)</span></label><textarea
                    id="f-msg" name="mensaje" placeholder="Cultivos, hectáreas, sistema de siembra..."></textarea></div>
                <div class="field"><button class="btn btn--amarillo btn--block" type="submit">Solicitar
                    asesoramiento</button></div>
              </div>
              <p class="form__note">Al enviar aceptás ser contactado por Super Walter. No compartimos tus datos. Este
                sitio está protegido por reCAPTCHA y aplican la <a href="https://policies.google.com/privacy"
                  target="_blank" rel="noopener">Política de Privacidad</a> y los <a
                  href="https://policies.google.com/terms" target="_blank" rel="noopener">Términos de Servicio</a> de
                Google.</p>
              <div class="form__success" id="formSuccess" role="status" aria-live="polite">
                <b>¡Listo! Recibimos tu consulta.</b>
                <span>Un asesor de Super Walter se va a comunicar con vos a la brevedad.</span>
              </div>
            </form>
          </div>
        </div>
      </div>
    </section>
  </main>

<?php include __DIR__ . '/partials/footer.php'; ?>
