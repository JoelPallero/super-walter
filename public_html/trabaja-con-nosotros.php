<?php
declare(strict_types=1);

$base = '';
$activeNav = 'trabajo';
$pageKey = 'careers';
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
<title>Trabajá con nosotros · Super Walter — Sumate a nuestro equipo</title>
<meta name="description" content="¿Te interesa sumarte al equipo de Super Walter? Completá tus datos y adjuntá tu CV. Fábrica de implementos agrícolas en Las Parejas, Santa Fe, con más de 65 años de trayectoria.">
<link rel="canonical" href="https://superwalter.com.ar/trabaja-con-nosotros"><!-- EDITAR: dominio final -->
<?= sw_hreflang_tags() ?>

<meta property="og:type" content="website">
<meta property="og:locale" content="es_AR">
<meta property="og:site_name" content="Super Walter">
<meta property="og:title" content="Trabajá con nosotros · Super Walter">
<meta property="og:description" content="Sumate al equipo de una fábrica argentina con más de 65 años de trayectoria. Dejanos tu CV.">
<meta property="og:url" content="https://superwalter.com.ar/trabaja-con-nosotros"><!-- EDITAR -->
<meta property="og:image" content="https://superwalter.com.ar/assets/img/og-image.jpg"><!-- EDITAR -->

<link rel="icon" href="assets/img/isotipo.svg" type="image/svg+xml">
<link rel="apple-touch-icon" href="assets/img/isotipo.svg">

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

<link rel="preload" as="image" href="assets/img/tractor-loma.webp">
<link rel="stylesheet" href="assets/css/styles.css">
</head>
<body>
<?php include __DIR__ . '/partials/header.php'; ?>

<main id="main">
<span id="top"></span>

<!-- ============================ HERO DE PÁGINA ============================ -->
<section class="page-hero page-hero--photo" aria-label="Trabajá con nosotros">
  <div class="ph-bg" aria-hidden="true"><img src="assets/img/tractor-loma.webp" alt="" width="1200" height="1350"></div>
  <div class="container">
    <p class="page-hero__crumb"><a href="./">Inicio</a> · <span>Trabajá con nosotros</span></p>
    <p class="eyebrow on-dark" data-reveal="fade"><img class="mk" src="assets/img/mark.svg" alt="">Trabajá con nosotros</p>
    <h1 class="section-title" data-reveal style="color:#fff;max-width:15ch">¿Te interesa sumarte a nuestro equipo<span class="mark-x">?</span></h1>
    <p class="lead" data-reveal data-reveal-delay="1" style="color:rgba(255,255,255,.78);margin-top:1.1rem">No pierdas tiempo: completá tus datos y adjuntá tu CV. Buscamos gente que quiera hacer máquinas de las que se sienta orgullosa.</p>
    <div class="hero__actions" style="opacity:1;transform:none;margin-top:2rem;justify-content:flex-start">
      <a class="btn btn--amarillo" href="#postulacion">Dejar mi CV</a>
      <a class="btn btn--ghost" href="empresa">Conocer la empresa</a>
    </div>
  </div>
</section>

<!-- ============================ MANIFIESTO ============================ -->
<section class="intro section-pad" id="intro" aria-labelledby="intro-title">
  <div class="container">
    <p class="eyebrow" data-reveal="fade"><img class="mk" src="assets/img/mark.svg" alt="">Trabajar en Super Walter · 01</p>
    <div class="intro__grid">
      <h2 class="intro__statement" id="intro-title" data-reveal>
        Acá se fabrica de verdad: <em>acero, ingeniería y campo</em>, todos los días.
      </h2>
      <div class="intro__body" data-reveal data-reveal-delay="1">
        <p><strong>Búfalo S.A.</strong> es una de las empresas líderes en la fabricación de implementos agrícolas de la Argentina. Nuestros productos se elaboran acorde a las nuevas tecnologías, en una planta de <strong>13.200 m²</strong> en Las Parejas, Santa Fe.</p>
        <p>Somos una empresa <strong>familiar</strong> con más de 65 años de trayectoria. Eso significa trato directo, decisiones rápidas y equipos que se conocen por el nombre.</p>
        <p>Si te gusta el trabajo bien hecho y querés que lo que hacés se vea trabajando en el lote, este es tu lugar.</p>
      </div>
    </div>
  </div>
</section>

<!-- ============================ POR QUÉ ============================ -->
<section class="benefits section-pad" id="beneficios" aria-labelledby="beneficios-title">
  <div class="container">
    <p class="eyebrow" data-reveal="fade"><img class="mk" src="assets/img/mark.svg" alt="">Por qué sumarte · 02</p>
    <h2 class="section-title" id="beneficios-title" data-reveal>Una industria que crece, con los pies en la tierra.</h2>
    <div class="benefits__grid">
      <div class="benefit" data-reveal="sweep"><span class="benefit__n">01</span><h3>Industria nacional</h3><p>Ingeniería y fabricación 100% argentina, con máquinas que hoy trabajan en once países.</p></div>
      <div class="benefit" data-reveal="sweep" data-reveal-delay="1"><span class="benefit__n">02</span><h3>Empresa familiar</h3><p>Más de 65 años de trayectoria y un equipo donde tu trabajo se ve y se reconoce.</p></div>
      <div class="benefit" data-reveal="sweep" data-reveal-delay="2"><span class="benefit__n">03</span><h3>Formación continua</h3><p>Capacitación técnica permanente y proyectos de innovación en agricultura de precisión.</p></div>
      <div class="benefit" data-reveal="sweep" data-reveal-delay="3"><span class="benefit__n">04</span><h3>Proyección</h3><p>Una planta en crecimiento, con certificación CE y presencia en las principales ferias del mundo.</p></div>
    </div>
  </div>
</section>

<!-- ============================ ÁREAS ============================ -->
<section class="news section-pad" id="areas" aria-labelledby="areas-title">
  <div class="container">
    <p class="eyebrow" data-reveal="fade"><img class="mk" src="assets/img/mark.svg" alt="">Áreas de trabajo · 03</p>
    <h2 class="section-title" id="areas-title" data-reveal>Dónde podés sumarte.</h2>
    <div class="areas">
      <article class="area" data-reveal>
        <div><h3>Producción y montaje</h3><p>Soldadura, armado, pintura y control de calidad en planta.</p></div>
        <span class="pill">Las Parejas</span>
      </article>
      <article class="area" data-reveal data-reveal-delay="1">
        <div><h3>Ingeniería y diseño</h3><p>Desarrollo de producto, cálculo, CAD y prueba a campo.</p></div>
        <span class="pill">Las Parejas</span>
      </article>
      <article class="area" data-reveal data-reveal-delay="2">
        <div><h3>Comercial y postventa</h3><p>Asesoramiento a productores, red de concesionarios y soporte técnico.</p></div>
        <span class="pill">Todo el país</span>
      </article>
      <article class="area" data-reveal data-reveal-delay="3">
        <div><h3>Administración</h3><p>Compras, logística, administración y sistemas.</p></div>
        <span class="pill">Las Parejas</span>
      </article>
    </div>
    <p class="form__note" data-reveal style="color:var(--texto-mute);margin-top:1.3rem">EDITAR: reemplazar por las búsquedas abiertas reales cuando el cliente las informe.</p>
  </div>
</section>

<!-- ============================ FORM POSTULACIÓN ============================ -->
<section class="cta section-pad" id="postulacion" aria-labelledby="postulacion-title">
  <div class="container">
    <div class="cta__panel">
      <div class="cta__grid">
        <div data-reveal>
          <p class="eyebrow on-dark" style="margin-bottom:1.2rem"><img class="mk" src="assets/img/mark.svg" alt="">Postulate</p>
          <h2 class="cta__title" id="postulacion-title">Dejanos tu <em>CV</em> y te tenemos en cuenta.</h2>
          <p class="cta__lead">Completá tus datos y adjuntá tu currículum. Guardamos tu postulación en nuestra base y te contactamos cuando se abra una búsqueda que encaje con tu perfil.</p>
          <div class="cta__contacts">
            <div class="cta__contact">
              <span class="ico"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0z"/><circle cx="12" cy="10" r="3"/></svg></span>
              <span><b>Planta</b><span>Calle 10 Nº 490, Las Parejas, Santa Fe</span></span>
            </div>
            <div class="cta__contact">
              <span class="ico"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="12" cy="12" r="9"/><path d="M12 7v5l3 2"/></svg></span>
              <span><b>Horarios</b><span>Lun a Vie 7 a 12 y 14 a 18 hs · Sáb 8 a 12 hs</span></span>
            </div>
            <div class="cta__contact">
              <span class="ico"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect x="3" y="5" width="18" height="14" rx="2"/><path d="m3 7 9 6 9-6"/></svg></span>
              <span><b>Email de RRHH</b><a href="mailto:rrhh@superwalter.com.ar">rrhh@superwalter.com.ar</a></span><!-- EDITAR -->
            </div>
          </div>
        </div>

        <form class="form" id="leadForm" data-endpoint="api/trabajo.php" enctype="multipart/form-data" data-reveal data-reveal-delay="1" novalidate>
          <input type="text" name="website" tabindex="-1" autocomplete="off" aria-hidden="true" style="position:absolute;left:-5000px">
          <div class="form__grid">
            <div class="field field--wide"><label for="f-nombre"><span class="field__num">01</span> Nombre y apellido</label><input type="text" id="f-nombre" name="nombre" autocomplete="name" required placeholder="Tu nombre"></div>
            <div class="field field--narrow"><label for="f-tel"><span class="field__num">02</span> Teléfono</label><input type="tel" id="f-tel" name="telefono" autocomplete="tel" required placeholder="Cód. + número"></div>
            <div class="field field--narrow"><label for="f-email"><span class="field__num">03</span> Email</label><input type="email" id="f-email" name="email" autocomplete="email" required placeholder="tu@email.com"></div>
            <div class="field field--wide"><label for="f-localidad"><span class="field__num">04</span> Localidad</label><input type="text" id="f-localidad" name="localidad" required placeholder="Ej: Las Parejas, Santa Fe"></div>
            <div class="field">
              <span class="field-label" id="area-label"><span class="field__num">05</span> ¿En qué área te gustaría trabajar?</span>
              <div class="chips" role="group" aria-labelledby="area-label">
                <label class="chip"><input type="radio" name="area" value="Producción y montaje" checked><span>Producción y montaje</span></label>
                <label class="chip"><input type="radio" name="area" value="Ingeniería y diseño"><span>Ingeniería y diseño</span></label>
                <label class="chip"><input type="radio" name="area" value="Comercial y postventa"><span>Comercial y postventa</span></label>
                <label class="chip"><input type="radio" name="area" value="Administración"><span>Administración</span></label>
              </div>
            </div>
            <div class="field">
              <label for="f-cv"><span class="field__num">06</span> Adjuntá tu CV</label>
              <input type="file" id="f-cv" name="cv" accept=".pdf,.doc,.docx" required>
              <span class="field__hint">Formatos PDF, DOC o DOCX · hasta 5 MB</span>
            </div>
            <div class="field"><label for="f-msg"><span class="field__num">07</span> Tu mensaje <span style="text-transform:none;letter-spacing:0;color:var(--texto-mute);font-weight:400">(opcional)</span></label><textarea id="f-msg" name="mensaje" placeholder="Contanos brevemente tu experiencia..."></textarea></div>
            <div class="field"><button class="btn btn--amarillo btn--block" type="submit">Enviar postulación</button></div>
          </div>
          <p class="form__note">Al enviar aceptás que Super Walter guarde tus datos para procesos de selección. No los compartimos con terceros. Este sitio está protegido por reCAPTCHA y aplican la <a href="https://policies.google.com/privacy" target="_blank" rel="noopener">Política de Privacidad</a> y los <a href="https://policies.google.com/terms" target="_blank" rel="noopener">Términos de Servicio</a> de Google.</p>
          <div class="form__success" id="formSuccess" role="status" aria-live="polite">
            <b>¡Listo! Recibimos tu postulación.</b>
            <span>Si tu perfil encaja con una búsqueda abierta, nos comunicamos con vos.</span>
          </div>
        </form>
      </div>
    </div>
  </div>
</section>
</main>

<?php include __DIR__ . '/partials/footer.php'; ?>
