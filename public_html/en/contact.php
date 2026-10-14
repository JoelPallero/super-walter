<?php
declare(strict_types=1);

$lang = 'en';
$base = '../';
$activeNav = 'contacto';
$pageKey = 'contact';
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
<title>Contact · Super Walter — Let's talk about your next season</title>
<meta name="description" content="Contact Super Walter: Calle 10 Nº 490, Las Parejas, Santa Fe, Argentina. Tel +54 3471 471069. Mon–Fri 7 am to 12 pm and 2 to 6 pm, Sat 8 am to 12 pm. Technical and administrative support.">
<link rel="canonical" href="https://superwalter.com.ar/en/contact"><!-- EDITAR: dominio final -->
<?= sw_hreflang_tags() ?>

<meta property="og:type" content="website">
<meta property="og:locale" content="en_US">
<meta property="og:locale:alternate" content="es_AR">
<meta property="og:site_name" content="Super Walter">
<meta property="og:title" content="Contact · Super Walter">
<meta property="og:description" content="Write to us, call us or visit us in Las Parejas, Santa Fe. An advisor will get back to you shortly.">
<meta property="og:url" content="https://superwalter.com.ar/en/contact"><!-- EDITAR -->
<meta property="og:image" content="https://superwalter.com.ar/assets/img/og-image.jpg"><!-- EDITAR -->

<link rel="icon" href="../assets/img/isotipo.svg" type="image/svg+xml">
<link rel="apple-touch-icon" href="../assets/img/isotipo.svg">

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

<link rel="preload" as="image" href="../assets/img/sembradora-frente.webp">
<link rel="stylesheet" href="../assets/css/styles.css">

<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "LocalBusiness",
  "name": "Super Walter",
  "legalName": "Búfalo S.A.",
  "url": "https://superwalter.com.ar/en/contact",
  "telephone": "+54-3471-471069",
  "email": "ventas@superwalter.com.ar",
  "address": { "@type": "PostalAddress", "streetAddress": "Calle 10 Nº 490", "addressLocality": "Las Parejas", "addressRegion": "Santa Fe", "addressCountry": "AR" },
  "openingHours": ["Mo-Fr 07:00-12:00", "Mo-Fr 14:00-18:00", "Sa 08:00-12:00"]
}
</script>
</head>
<body>
<?php include __DIR__ . '/../partials/header.php'; ?>

<main id="main">
<span id="top"></span>

<!-- ============================ PAGE HERO ============================ -->
<section class="page-hero page-hero--photo page-hero--full" aria-label="Contact">
  <div class="ph-bg" aria-hidden="true"><img src="../assets/img/sembradora-frente.webp" alt="" width="2000" height="1334"></div>
  <div class="container">
    <h1 class="page-hero__title" data-reveal>Let's talk about your next season<span class="mark-x">.</span></h1>
    <a class="page-hero__scroll" href="#soporte" data-reveal data-reveal-delay="2" aria-label="Scroll down to the content">
      <span>Scroll to see more</span>
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M12 5v14M19 12l-7 7-7-7"/></svg>
    </a>
  </div>
</section>

<!-- ============================ SUPPORT + MAP ============================ -->
<section class="service section-pad" id="soporte" aria-labelledby="soporte-title">
  <div class="service__bg" aria-hidden="true"><img src="../assets/img/trigo.webp" alt="" loading="lazy" width="1800" height="2250"></div>
  <div class="container">
    <p class="eyebrow" data-reveal="fade"><img class="mk" src="../assets/img/mark.svg" alt="">Technical and administrative support</p>
    <h2 class="section-title" id="soporte-title" data-reveal>Visit us in Las Parejas.</h2>
    <div class="contact-grid" style="margin-top:clamp(2rem,4vw,3rem)">
      <div class="service__card" data-reveal>
        <h3>Headquarters</h3>
        <ul>
          <li>Calle 10 Nº 490, Las Parejas, Santa Fe, Argentina</li>
          <li>Showroom, industrial plant and sales offices</li>
          <li>Spare parts and used machinery service</li>
        </ul>
        <p class="service__hours"><b>Opening hours:</b><br>Monday to Friday · 7:00 am to 12:00 pm and 2:00 to 6:00 pm<br>Saturdays · 8:00 am to 12:00 pm</p>
        <a class="btn btn--amarillo" href="https://www.google.com/maps/search/?api=1&query=Calle+10+490+Las+Parejas+Santa+Fe" target="_blank" rel="noopener" style="margin-top:1.5rem">Get directions</a>
      </div>
      <div class="contact-map img-reveal" data-reveal data-reveal-delay="1">
        <div id="contactMap" role="application" aria-label="Map of the Super Walter headquarters in Las Parejas"></div>
      </div>
    </div>
  </div>
</section>

<!-- ============================ FORM + MAP ============================ -->
<section class="cta section-pad" id="form" aria-labelledby="form-title">
  <div class="container">
    <div class="cta__panel">
      <div class="cta__grid">
        <div data-reveal>
          <p class="eyebrow on-dark" style="margin-bottom:1.2rem"><img class="mk" src="../assets/img/mark.svg" alt="">Contact us</p>
          <h2 class="cta__title" id="form-title">Find the <em>ideal seeder</em> for your farm.</h2>
          <p class="cta__lead">Fill in the form and a Super Walter advisor will get in touch with you. If you prefer, call us directly: we are available Monday to Saturday.</p>
          <div class="cta__contacts">
            <div class="cta__contact">
              <span class="ico"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M22 16.9v3a2 2 0 0 1-2.2 2 19.8 19.8 0 0 1-8.6-3 19.5 19.5 0 0 1-6-6 19.8 19.8 0 0 1-3-8.7A2 2 0 0 1 4.1 2h3a2 2 0 0 1 2 1.7c.1 1 .4 1.9.7 2.8a2 2 0 0 1-.5 2.1L8.1 9.9a16 16 0 0 0 6 6l1.3-1.3a2 2 0 0 1 2.1-.4c.9.3 1.8.6 2.8.7a2 2 0 0 1 1.7 2z"/></svg></span>
              <span><b>Phone / WhatsApp</b><a href="tel:+543471471069">+54 3471 471069</a></span>
            </div>
            <div class="cta__contact">
              <span class="ico"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect x="3" y="5" width="18" height="14" rx="2"/><path d="m3 7 9 6 9-6"/></svg></span>
              <span><b>Email</b><a href="mailto:ventas@superwalter.com.ar">ventas@superwalter.com.ar</a></span><!-- EDITAR -->
            </div>
            <div class="cta__contact">
              <span class="ico"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0z"/><circle cx="12" cy="10" r="3"/></svg></span>
              <span><b>Headquarters</b><span>Calle 10 Nº 490, Las Parejas, Santa Fe</span></span>
            </div>
          </div>
        </div>

        <form class="form" id="leadForm" data-endpoint="../api/contacto.php" data-reveal data-reveal-delay="1" novalidate>
          <input type="text" name="website" tabindex="-1" autocomplete="off" aria-hidden="true" style="position:absolute;left:-5000px">
          <div class="form__grid">
            <div class="field field--wide"><label for="f-nombre"><span class="field__num">01</span> Full name</label><input type="text" id="f-nombre" name="nombre" autocomplete="name" required placeholder="Your name"></div>
            <div class="field field--narrow"><label for="f-tel"><span class="field__num">02</span> Phone</label><input type="tel" id="f-tel" name="telefono" autocomplete="tel" required placeholder="Area code + number"></div>
            <div class="field field--narrow"><label for="f-email"><span class="field__num">03</span> Email</label><input type="email" id="f-email" name="email" autocomplete="email" required placeholder="you@email.com"></div>
            <div class="field field--wide"><label for="f-zona"><span class="field__num">04</span> City / Province</label><input type="text" id="f-zona" name="zona" required placeholder="E.g. Pergamino, Buenos Aires"></div>
            <div class="field">
              <span class="field-label" id="motivo-label"><span class="field__num">05</span> How can we help you?</span>
              <div class="chips" role="group" aria-labelledby="motivo-label">
                <label class="chip"><input type="radio" name="motivo" value="Comprar una sembradora" checked><span>Buy a seeder</span></label>
                <label class="chip"><input type="radio" name="motivo" value="Repuestos"><span>Spare parts</span></label>
                <label class="chip"><input type="radio" name="motivo" value="Soporte técnico"><span>Technical support</span></label>
                <label class="chip"><input type="radio" name="motivo" value="Financiación"><span>Financing</span></label>
                <label class="chip"><input type="radio" name="motivo" value="Otro"><span>Other</span></label>
              </div>
            </div>
            <div class="field"><label for="f-msg"><span class="field__num">06</span> Your message <span style="text-transform:none;letter-spacing:0;color:var(--texto-mute);font-weight:400">(optional)</span></label><textarea id="f-msg" name="mensaje" placeholder="Crops, hectares, seeding system..."></textarea></div>
            <div class="field"><button class="btn btn--amarillo btn--block" type="submit">Send inquiry</button></div>
          </div>
          <p class="form__note">By submitting you agree to be contacted by Super Walter. We do not share your data. This site is protected by reCAPTCHA and the Google <a href="https://policies.google.com/privacy" target="_blank" rel="noopener">Privacy Policy</a> and <a href="https://policies.google.com/terms" target="_blank" rel="noopener">Terms of Service</a> apply.</p>
          <div class="form__success" id="formSuccess" role="status" aria-live="polite">
            <b>All set! We received your inquiry.</b>
            <span>A Super Walter advisor will get in touch with you shortly.</span>
          </div>
        </form>
      </div>
    </div>
  </div>
</section>

<!-- ============================ CONTACT CARDS ============================ -->
<section class="news section-pad" aria-label="Contact details">
  <div class="container">
    <div class="contact-cards">
      <div class="contact-card" data-reveal>
        <span class="ico" aria-hidden="true"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 16.9v3a2 2 0 0 1-2.2 2 19.8 19.8 0 0 1-8.6-3 19.5 19.5 0 0 1-6-6 19.8 19.8 0 0 1-3-8.7A2 2 0 0 1 4.1 2h3a2 2 0 0 1 2 1.7c.1 1 .4 1.9.7 2.8a2 2 0 0 1-.5 2.1L8.1 9.9a16 16 0 0 0 6 6l1.3-1.3a2 2 0 0 1 2.1-.4c.9.3 1.8.6 2.8.7a2 2 0 0 1 1.7 2z"/></svg></span>
        <h3>Call us</h3>
        <p>Factory phone and WhatsApp, Monday to Saturday.</p>
        <a href="tel:+543471471069">+54 3471 471069</a>
      </div>
      <div class="contact-card" data-reveal data-reveal-delay="1">
        <span class="ico" aria-hidden="true"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="5" width="18" height="14" rx="2"/><path d="m3 7 9 6 9-6"/></svg></span>
        <h3>Write to us</h3>
        <p>Sales inquiries, spare parts and after-sales.</p>
        <a href="mailto:ventas@superwalter.com.ar">ventas@superwalter.com.ar</a><!-- EDITAR -->
      </div>
      <div class="contact-card" data-reveal data-reveal-delay="2">
        <span class="ico" aria-hidden="true"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="9"/><path d="M12 7v5l3 2"/></svg></span>
        <h3>Opening hours</h3>
        <p>Mon–Fri · 7:00 am to 12:00 pm and 2:00 to 6:00 pm<br>Sat · 8:00 am to 12:00 pm</p>
        <a href="<?= sw_url('branches') ?>">View branches →</a>
      </div>
    </div>
  </div>
</section>

</main>

<?php ob_start(); ?>
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css">
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
/* Headquarters map (Leaflet, no API key) */
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
<?php include __DIR__ . '/../partials/footer.php'; ?>
