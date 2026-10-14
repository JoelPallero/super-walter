<?php
declare(strict_types=1);

$base = '';
$activeNav = 'contacto';
$pageKey = 'contact';
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
<title>Contacto · Super Walter — Hablemos de tu próxima campaña</title>
<meta name="description" content="Contactá a Super Walter: Calle 10 Nº 490, Las Parejas, Santa Fe. Tel +54 3471 471069. Lun a Vie 7 a 12 y 14 a 18 hs, Sáb 8 a 12 hs. Soporte técnico y administrativo.">
<link rel="canonical" href="https://superwalter.com.ar/contacto"><!-- EDITAR: dominio final -->
<?= sw_hreflang_tags() ?>

<meta property="og:type" content="website">
<meta property="og:locale" content="es_AR">
<meta property="og:site_name" content="Super Walter">
<meta property="og:title" content="Contacto · Super Walter">
<meta property="og:description" content="Escribinos, llamanos o visitanos en Las Parejas, Santa Fe. Un asesor te contacta a la brevedad.">
<meta property="og:url" content="https://superwalter.com.ar/contacto"><!-- EDITAR -->
<meta property="og:image" content="https://superwalter.com.ar/assets/img/og-image.jpg"><!-- EDITAR -->

<link rel="icon" href="assets/img/isotipo.svg" type="image/svg+xml">
<link rel="apple-touch-icon" href="assets/img/isotipo.svg">

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

<link rel="preload" as="image" href="assets/img/sembradora-frente.webp">
<link rel="stylesheet" href="assets/css/styles.css">

<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "LocalBusiness",
  "name": "Super Walter",
  "legalName": "Búfalo S.A.",
  "url": "https://superwalter.com.ar/contacto",
  "telephone": "+54-3471-471069",
  "email": "ventas@superwalter.com.ar",
  "address": { "@type": "PostalAddress", "streetAddress": "Calle 10 Nº 490", "addressLocality": "Las Parejas", "addressRegion": "Santa Fe", "addressCountry": "AR" },
  "openingHours": ["Mo-Fr 07:00-12:00", "Mo-Fr 14:00-18:00", "Sa 08:00-12:00"]
}
</script>
</head>
<body>
<?php include __DIR__ . '/partials/header.php'; ?>

<main id="main">
<span id="top"></span>

<!-- ============================ HERO DE PÁGINA ============================ -->
<section class="page-hero page-hero--photo page-hero--full" aria-label="Contacto">
  <div class="ph-bg" aria-hidden="true"><img src="assets/img/sembradora-frente.webp" alt="" width="2000" height="1334"></div>
  <div class="container">
    <h1 class="page-hero__title" data-reveal>Hablemos de tu próxima campaña<span class="mark-x">.</span></h1>
    <a class="page-hero__scroll" href="#soporte" data-reveal data-reveal-delay="2" aria-label="Bajar al contenido">
      <span>Deslizá para ver más</span>
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M12 5v14M19 12l-7 7-7-7"/></svg>
    </a>
  </div>
</section>

<!-- ============================ SOPORTE + MAPA ============================ -->
<section class="service section-pad" id="soporte" aria-labelledby="soporte-title">
  <div class="service__bg" aria-hidden="true"><img src="assets/img/trigo.webp" alt="" loading="lazy" width="1800" height="2250"></div>
  <div class="container">
    <p class="eyebrow" data-reveal="fade"><img class="mk" src="assets/img/mark.svg" alt="">Soporte técnico y administrativo</p>
    <h2 class="section-title" id="soporte-title" data-reveal>Visitanos en Las Parejas.</h2>
    <div class="contact-grid" style="margin-top:clamp(2rem,4vw,3rem)">
      <div class="service__card" data-reveal>
        <h3>Casa central</h3>
        <ul>
          <li>Calle 10 Nº 490, Las Parejas, Santa Fe, Argentina</li>
          <li>Showroom, planta industrial y oficinas comerciales</li>
          <li>Atención de repuestos y equipos usados</li>
        </ul>
        <p class="service__hours"><b>Horarios de atención:</b><br>Lunes a viernes · 7:00 a 12:00 y 14:00 a 18:00 hs<br>Sábados · 8:00 a 12:00 hs</p>
        <a class="btn btn--amarillo" href="https://www.google.com/maps/search/?api=1&query=Calle+10+490+Las+Parejas+Santa+Fe" target="_blank" rel="noopener" style="margin-top:1.5rem">Cómo llegar</a>
      </div>
      <div class="contact-map img-reveal" data-reveal data-reveal-delay="1">
        <div id="contactMap" role="application" aria-label="Mapa de la casa central de Super Walter en Las Parejas"></div>
      </div>
    </div>
  </div>
</section>

<!-- ============================ FORM + MAPA ============================ -->
<section class="cta section-pad" id="form" aria-labelledby="form-title">
  <div class="container">
    <div class="cta__panel">
      <div class="cta__grid">
        <div data-reveal>
          <p class="eyebrow on-dark" style="margin-bottom:1.2rem"><img class="mk" src="assets/img/mark.svg" alt="">Contáctenos</p>
          <h2 class="cta__title" id="form-title">Encontrá la <em>sembradora ideal</em> para tu campo.</h2>
          <p class="cta__lead">Completá el formulario y un asesor de Super Walter se comunica con vos. Si preferís, llamanos directo: atendemos de lunes a sábado.</p>
          <div class="cta__contacts">
            <div class="cta__contact">
              <span class="ico"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M22 16.9v3a2 2 0 0 1-2.2 2 19.8 19.8 0 0 1-8.6-3 19.5 19.5 0 0 1-6-6 19.8 19.8 0 0 1-3-8.7A2 2 0 0 1 4.1 2h3a2 2 0 0 1 2 1.7c.1 1 .4 1.9.7 2.8a2 2 0 0 1-.5 2.1L8.1 9.9a16 16 0 0 0 6 6l1.3-1.3a2 2 0 0 1 2.1-.4c.9.3 1.8.6 2.8.7a2 2 0 0 1 1.7 2z"/></svg></span>
              <span><b>Teléfono / WhatsApp</b><a href="tel:+543471471069">+54 3471 471069</a></span>
            </div>
            <div class="cta__contact">
              <span class="ico"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect x="3" y="5" width="18" height="14" rx="2"/><path d="m3 7 9 6 9-6"/></svg></span>
              <span><b>Email</b><a href="mailto:ventas@superwalter.com.ar">ventas@superwalter.com.ar</a></span><!-- EDITAR -->
            </div>
            <div class="cta__contact">
              <span class="ico"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0z"/><circle cx="12" cy="10" r="3"/></svg></span>
              <span><b>Casa central</b><span>Calle 10 Nº 490, Las Parejas, Santa Fe</span></span>
            </div>
          </div>
        </div>

        <form class="form" id="leadForm" data-endpoint="api/contacto.php" data-reveal data-reveal-delay="1" novalidate>
          <input type="text" name="website" tabindex="-1" autocomplete="off" aria-hidden="true" style="position:absolute;left:-5000px">
          <div class="form__grid">
            <div class="field field--wide"><label for="f-nombre"><span class="field__num">01</span> Nombre y apellido</label><input type="text" id="f-nombre" name="nombre" autocomplete="name" required placeholder="Tu nombre"></div>
            <div class="field field--narrow"><label for="f-tel"><span class="field__num">02</span> Teléfono</label><input type="tel" id="f-tel" name="telefono" autocomplete="tel" required placeholder="Cód. + número"></div>
            <div class="field field--narrow"><label for="f-email"><span class="field__num">03</span> Email</label><input type="email" id="f-email" name="email" autocomplete="email" required placeholder="tu@email.com"></div>
            <div class="field field--wide"><label for="f-zona"><span class="field__num">04</span> Localidad / Provincia</label><input type="text" id="f-zona" name="zona" required placeholder="Ej: Pergamino, Bs. As."></div>
            <div class="field">
              <span class="field-label" id="motivo-label"><span class="field__num">05</span> ¿En qué te podemos ayudar?</span>
              <div class="chips" role="group" aria-labelledby="motivo-label">
                <label class="chip"><input type="radio" name="motivo" value="Comprar una sembradora" checked><span>Comprar una sembradora</span></label>
                <label class="chip"><input type="radio" name="motivo" value="Repuestos"><span>Repuestos</span></label>
                <label class="chip"><input type="radio" name="motivo" value="Soporte técnico"><span>Soporte técnico</span></label>
                <label class="chip"><input type="radio" name="motivo" value="Financiación"><span>Financiación</span></label>
                <label class="chip"><input type="radio" name="motivo" value="Otro"><span>Otro</span></label>
              </div>
            </div>
            <div class="field"><label for="f-msg"><span class="field__num">06</span> Tu mensaje <span style="text-transform:none;letter-spacing:0;color:var(--texto-mute);font-weight:400">(opcional)</span></label><textarea id="f-msg" name="mensaje" placeholder="Cultivos, hectáreas, sistema de siembra..."></textarea></div>
            <div class="field"><button class="btn btn--amarillo btn--block" type="submit">Enviar consulta</button></div>
          </div>
          <p class="form__note">Al enviar aceptás ser contactado por Super Walter. No compartimos tus datos. Este sitio está protegido por reCAPTCHA y aplican la <a href="https://policies.google.com/privacy" target="_blank" rel="noopener">Política de Privacidad</a> y los <a href="https://policies.google.com/terms" target="_blank" rel="noopener">Términos de Servicio</a> de Google.</p>
          <div class="form__success" id="formSuccess" role="status" aria-live="polite">
            <b>¡Listo! Recibimos tu consulta.</b>
            <span>Un asesor de Super Walter se va a comunicar con vos a la brevedad.</span>
          </div>
        </form>
      </div>
    </div>
  </div>
</section>

<!-- ============================ TARJETAS DE CONTACTO ============================ -->
<section class="news section-pad" aria-label="Datos de contacto">
  <div class="container">
    <div class="contact-cards">
      <div class="contact-card" data-reveal>
        <span class="ico" aria-hidden="true"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 16.9v3a2 2 0 0 1-2.2 2 19.8 19.8 0 0 1-8.6-3 19.5 19.5 0 0 1-6-6 19.8 19.8 0 0 1-3-8.7A2 2 0 0 1 4.1 2h3a2 2 0 0 1 2 1.7c.1 1 .4 1.9.7 2.8a2 2 0 0 1-.5 2.1L8.1 9.9a16 16 0 0 0 6 6l1.3-1.3a2 2 0 0 1 2.1-.4c.9.3 1.8.6 2.8.7a2 2 0 0 1 1.7 2z"/></svg></span>
        <h3>Llamanos</h3>
        <p>Teléfono y WhatsApp de fábrica, de lunes a sábado.</p>
        <a href="tel:+543471471069">+54 3471 471069</a>
      </div>
      <div class="contact-card" data-reveal data-reveal-delay="1">
        <span class="ico" aria-hidden="true"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="5" width="18" height="14" rx="2"/><path d="m3 7 9 6 9-6"/></svg></span>
        <h3>Escribinos</h3>
        <p>Consultas comerciales, repuestos y postventa.</p>
        <a href="mailto:ventas@superwalter.com.ar">ventas@superwalter.com.ar</a><!-- EDITAR -->
      </div>
      <div class="contact-card" data-reveal data-reveal-delay="2">
        <span class="ico" aria-hidden="true"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="9"/><path d="M12 7v5l3 2"/></svg></span>
        <h3>Horarios</h3>
        <p>Lun a Vie · 7:00 a 12:00 y 14:00 a 18:00 hs<br>Sáb · 8:00 a 12:00 hs</p>
        <a href="sucursales">Ver sucursales →</a>
      </div>
    </div>
  </div>
</section>

</main>

<?php ob_start(); ?>
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css">
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
/* Mapa de la casa central (Leaflet, sin API key) */
window.addEventListener('load', function () {
  var el = document.getElementById('contactMap');
  if (!el || typeof L === 'undefined') return;
  var coords = [-32.6836, -61.5386]; /* EDITAR: coordenadas exactas de la planta */
  var map = L.map(el, { scrollWheelZoom: false }).setView(coords, 15);
  L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    maxZoom: 19, attribution: '&copy; OpenStreetMap'
  }).addTo(map);
  L.marker(coords, {
    icon: L.divIcon({ className: 'suc-pin', html: '<span></span>', iconSize: [26, 30], iconAnchor: [13, 30], popupAnchor: [0, -28] })
  }).addTo(map).bindPopup('<b>Super Walter</b><br>Calle 10 Nº 490<br>Las Parejas, Santa Fe').openPopup();
});
</script>
<?php $footerScripts = ob_get_clean(); ?>
<?php include __DIR__ . '/partials/footer.php'; ?>
