<?php
declare(strict_types=1);

$base = '';
$activeNav = 'empresa';
$pageKey = 'company';
require __DIR__ . '/partials/i18n.php';
$footerLineupHref = sw_url('home') . '#lineup';
?>
<!DOCTYPE html>
<html lang="es-AR">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="theme-color" content="#7f1810">

  <!-- ============ SEO ============ -->
  <title>Empresa · Super Walter — Siempre junto al productor</title>
  <meta name="description"
    content="Desde 1957 fabricamos implementos para el laboreo de la tierra y la siembra. Empresa familiar de Las Parejas, Santa Fe: más de 65 años, 10.000 unidades vendidas y máquinas trabajando en 11 países.">
  <link rel="canonical" href="https://superwalter.com.ar/empresa"><!-- EDITAR: dominio final -->
<?= sw_hreflang_tags() ?>

  <meta property="og:type" content="website">
  <meta property="og:locale" content="es_AR">
  <meta property="og:site_name" content="Super Walter">
  <meta property="og:title" content="Empresa · Super Walter — Siempre junto al productor">
  <meta property="og:description"
    content="Empresa familiar desde 1957. Más de 65 años fabricando sembradoras en Las Parejas, Santa Fe.">
  <meta property="og:url" content="https://superwalter.com.ar/empresa"><!-- EDITAR -->
  <meta property="og:image" content="https://superwalter.com.ar/assets/img/og-image.jpg"><!-- EDITAR -->

  <link rel="icon" href="assets/img/isotipo.svg" type="image/svg+xml">
  <link rel="apple-touch-icon" href="assets/img/isotipo.svg">

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap"
    rel="stylesheet">

  <link rel="preload" as="image" href="assets/img/campo-escala.webp">
  <link rel="stylesheet" href="assets/css/styles.css">
</head>

<body>
<?php include __DIR__ . '/partials/header.php'; ?>

<main id="main">
    <span id="top"></span>

    <!-- ============================ HERO DE PÁGINA ============================ -->
    <section class="page-hero page-hero--photo page-hero--full" aria-label="La empresa">
      <div class="ph-bg" aria-hidden="true"><img src="assets/img/campo-escala.webp" alt="" width="1900" height="2080">
      </div>
      <div class="container">
        <h1 class="page-hero__title" data-reveal>Siempre junto al productor<span class="mark-x">.</span></h1>
        <div class="page-hero__stats" data-reveal data-reveal-delay="2">
          <div><b>1957</b><span>El año en que empezó todo</span></div>
          <div><b>+10.000</b><span>Unidades vendidas</span></div>
          <div><b>+10</b><span>Mercados internacionales</span></div>
        </div>
      </div>
    </section>

    <!-- ============================ MANIFIESTO ============================ -->
    <section class="intro section-pad" id="intro" aria-labelledby="intro-title">
      <div class="container">
        <p class="eyebrow" data-reveal="fade"><img class="mk" src="assets/img/mark.svg" alt="">Quiénes somos · 01</p>
        <div class="intro__grid">
          <h2 class="intro__statement" id="intro-title" data-reveal>
            Somos una empresa <em>familiar</em> que hace máquinas para los que viven el campo todos los días.
          </h2>
          <div class="intro__body" data-reveal data-reveal-delay="1">
            <p>Nuestra misión primordial es <strong>fabricar maquinaria con la tecnología más avanzada y la más alta
                calidad</strong>, en beneficio de nuestros campos y de quienes los cultivan.</p>
            <p>Desde la década del 60 crecimos sin parar: pasamos de fabricar sembradoras de diseño propio a producir
              <strong>rastras, arados de discos y arados de rejas</strong>. Hoy somos <strong>Super Walter</strong>,
              parte de <strong>Búfalo S.A.</strong>, una de las empresas líderes en la fabricación de implementos
              agrícolas de la Argentina.</p>
            <p>Cada máquina que sale de nuestra planta tiene un objetivo claro: <strong>que aproveches mejor cada
                semilla, cada metro y cada kilo de fertilizante</strong>. Así entendemos la precisión.</p>
          </div>
        </div>
      </div>
    </section>

    <!-- ============================ MÉTRICAS ============================ -->
    <section class="metrics section-pad" style="padding-block:0" aria-label="Super Walter en números">
      <div class="container">
        <div class="metrics__panel" data-reveal>
          <p class="metrics__label"><img class="mk" src="assets/img/mark.svg" alt="">Super Walter en números</p>
          <div class="metrics__grid">
            <div class="metric"><b data-count="65" data-prefix="+">0</b><span>años en el mercado</span></div>
            <div class="metric"><b data-count="10" data-prefix="+" data-suffix=".000">0</b><span>unidades
                vendidas</span></div>
            <div class="metric"><b data-count="13" data-suffix=".200 m²">0</b><span>de planta industrial</span></div>
            <div class="metric"><b data-count="100" data-suffix="%">0</b><span>ingeniería y fabricación nacional</span>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- ============================ PILARES ============================ -->
    <section class="tech section-pad" id="pilares" aria-labelledby="pilares-title">
      <div class="container">
        <p class="eyebrow" data-reveal="fade"><img class="mk" src="assets/img/mark.svg" alt="">Cómo trabajamos · 02</p>
        <div class="tech__grid">
          <div class="tech__media img-reveal" data-reveal>
            <img src="assets/img/ingenieria.webp"
              alt="Tractor con implemento Super Walter trabajando en una loma con vista al valle" loading="lazy"
              width="1500" height="1873">
            <div class="tech__badge"><span class="pill pill--light">Las Parejas · Santa Fe</span></div>
          </div>
          <div>
            <h2 class="section-title" id="pilares-title" data-reveal style="margin-bottom:1.6rem">Tecnología avanzada y
              alta calidad, campaña tras campaña.</h2>
            <div class="tech__features">
              <div class="feature" data-reveal>
                <span class="feature__ico" aria-hidden="true"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M12 3l8 4.5v9L12 21l-8-4.5v-9L12 3z" />
                    <path d="M12 12l8-4.5M12 12v9M12 12L4 7.5" /></svg></span>
                <div>
                  <h3>Diseño propio</h3>
                  <p>Desarrollamos nuestras máquinas desde cero, pensadas sobre las condiciones reales del suelo
                    argentino.</p>
                </div>
              </div>
              <div class="feature" data-reveal data-reveal-delay="1">
                <span class="feature__ico" aria-hidden="true"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M20 6 9 17l-5-5" /></svg></span>
                <div>
                  <h3>Calidad certificada</h3>
                  <p>Controles en cada etapa del proceso y certificación CE para operar en el mercado europeo.</p>
                </div>
              </div>
              <div class="feature" data-reveal data-reveal-delay="2">
                <span class="feature__ico" aria-hidden="true"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <rect x="3" y="3" width="18" height="18" rx="4" />
                    <path d="M8 12h8M12 8v8" /></svg></span>
                <div>
                  <h3>Innovación constante</h3>
                  <p>Agricultura de precisión, corte por sección y monitoreo: tecnología que se mide en el lote.</p>
                </div>
              </div>
              <div class="feature" data-reveal data-reveal-delay="3">
                <span class="feature__ico" aria-hidden="true"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0z" />
                    <circle cx="12" cy="10" r="3" /></svg></span>
                <div>
                  <h3>Empresa familiar</h3>
                  <p>Trato directo, decisiones rápidas y una red que conoce tu zona y te acompaña de verdad.</p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- ============================ PLANTA ============================ -->
    <section class="scale scale--legible" id="planta" aria-label="Nuestra planta">
      <div class="scale__bg"><img src="assets/img/campo-arboles.webp"
          alt="Sembradora Super Walter traccionada por un tractor en pleno trabajo" loading="lazy" width="2000"
          height="1334"></div>
      <div class="container scale__inner">
        <p class="eyebrow on-dark" data-reveal><img class="mk" src="assets/img/mark.svg" alt="">Nuestra planta</p>
        <p class="scale__quote" data-reveal data-reveal-delay="1">Acá el acero <em>se vuelve máquina</em>.</p>
        <p class="scale__meta" data-reveal data-reveal-delay="2">Nuestras instalaciones abarcan un terreno de 10.000 m²,
          con una ampliación reciente de 3.200 m² destinados al montaje de las máquinas. Todo se corta, se pliega, se
          arma y se prueba acá, en Las Parejas.</p>
      </div>
    </section>

    <!-- ============================ HISTORIA ============================ -->
    <section class="legacy section-pad" id="historia" aria-labelledby="historia-title">
      <div class="container">
        <p class="eyebrow" data-reveal="fade"><img class="mk" src="assets/img/mark.svg" alt="">Historia y legado · 03
        </p>
        <div class="legacy__grid">
          <div class="legacy__media img-reveal" data-reveal>
            <img src="assets/img/legado.webp" data-default-src="assets/img/legado.webp" alt="Fardos en un campo cosechado al atardecer" loading="lazy"
              width="1500" height="2250">
            <div class="legacy__badge"><b>1957</b><span>Nuestro primer surco</span></div>
          </div>
          <div>
            <h2 class="section-title" id="historia-title" data-reveal style="margin-bottom:1.5rem">Más de 65 años
              creciendo junto al campo argentino.</h2>
            <div class="timeline">
              <div class="tl-item" data-reveal data-hist-img="assets/img/historia/1.jpg"><span class="yr">1957</span>
                <div>
                  <h3>El comienzo de una nueva etapa</h3>
                  <p>Después de trabajar desde muy joven en el campo y dedicarse durante varios años a la sastrería, Haroldo Scarpeccio dio sus primeros pasos en la industria con la fabricación de bombeadores y cajones sembradores. Así comenzó un proyecto que pronto empezó a crecer en Las Parejas.</p>
                </div>
              </div>

              <div class="tl-item" data-reveal data-reveal-delay="1" data-hist-img="assets/img/historia/2.jpg"><span class="yr">1960</span>
                <div>
                  <h3>La apuesta por la industria</h3>
                  <p>El crecimiento permitió comprar un terreno y construir el primer galpón de producción. Con un equipo inicial de seis personas, Haroldo decidió dejar definitivamente la sastrería para concentrarse por completo en el desarrollo de la fábrica.</p>
                </div>
              </div>
              <div class="tl-item" data-reveal data-reveal-delay="2" data-hist-img="assets/img/historia/3.jpg"><span class="yr">1962</span>
                <div>
                  <h3>Nace Industrias Walter</h3>
                  <p>Luego de una reorganización de la sociedad, la empresa pasó a llamarse Industrias Walter, conservando una marca que ya había comenzado a ganar reconocimiento. Se inició entonces una etapa de fuerte expansión y, para 1965, la empresa ya contaba con 120 personas.
                  </p>
                </div>
              </div>
              <div class="tl-item" data-reveal data-reveal-delay="3" data-hist-img="assets/img/historia/4.webp"><span class="yr">AÑOS 90</span>
                <div>
                  <h3>Una nueva generación</h3>
                  <p>En un contexto de transformación para el agro nació Búfalo S.A., dedicada a la producción, distribución y venta de implementos agrícolas y viales. La fabricación de sembradoras para siembra directa abrió una nueva etapa, acompañada por la incorporación de la siguiente generación de la familia Scarpeccio.</p>
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
        <p class="eyebrow on-dark" data-reveal="fade"><img class="mk" src="assets/img/mark.svg" alt="">Alcance
          internacional · 05</p>
        <div class="network__grid">
          <div>
            <h2 class="section-title" id="alcance-title" data-reveal style="color:#fff">De Las Parejas al mundo.</h2>
            <p class="lead" data-reveal data-reveal-delay="1" style="color:rgba(255,255,255,.72);margin-top:1.2rem">
              Nuestras máquinas trabajan en suelos y climas muy distintos al nuestro. La misma ingeniería, la misma
              exigencia, en cada campaña.</p>
            <div class="network__stats" data-reveal data-reveal-delay="2">
              <div><b data-count="10" data-prefix="+">10</b><span>mercados internacionales</span></div>
              <div><b data-count="4" data-suffix="">4</b><span>continentes alcanzados</span></div>
            </div>
          </div>
          <div class="map-card" data-reveal data-reveal-delay="1">
            <div class="region"><span class="r-name">Argentina · Uruguay · Paraguay · Bolivia</span><span
                class="r-meta">Sudamérica</span></div>
            <div class="region"><span class="r-name">Venezuela</span><span class="r-meta">Centroamérica</span></div>
            <div class="region"><span class="r-name">Rusia · Ucrania · Moldavia</span><span class="r-meta">Europa del
                Este</span></div>
            <div class="region"><span class="r-name">Kazajstán</span><span class="r-meta">Asia Central</span></div>
            <div class="region"><span class="r-name">Sudáfrica</span><span class="r-meta">África Austral</span></div>
            <a class="btn btn--amarillo btn--block" href="sucursales" style="margin-top:1.5rem">Encontrá tu
              concesionario</a>
          </div>
        </div>
      </div>
    </section>

    <!-- ============================ CTA breve ============================ -->
    <section class="cta section-pad">
      <div class="container">
        <div class="cta__panel" data-reveal style="text-align:center">
          <p class="eyebrow on-dark" style="justify-content:center;margin-bottom:1rem"><img class="mk"
              src="assets/img/mark.svg" alt="">Hablemos de tu próxima campaña</p>
          <h2 class="cta__title" style="max-width:none;margin-inline:auto">Contanos qué sembrás y te ayudamos a
            <em>elegir tu próxima máquina</em>.</h2>
          <p class="cta__lead" style="margin-inline:auto">Un asesor de fábrica te contacta directo, sin importar en qué
            provincia estés.</p>
          <a class="btn btn--amarillo" href="contacto" style="margin-top:1.6rem">Solicitar asesoramiento</a>
        </div>
      </div>
    </section>
  </main>

<?php include __DIR__ . '/partials/footer.php'; ?>
