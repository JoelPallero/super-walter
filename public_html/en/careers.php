<?php
declare(strict_types=1);

$lang = 'en';
$base = '../';
$activeNav = 'trabajo';
$pageKey = 'careers';
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
<title>Careers · Super Walter — Join Our Team</title>
<meta name="description" content="Interested in joining the Super Walter team? Fill in your details and attach your CV. Agricultural implement manufacturer in Las Parejas, Santa Fe, with over 65 years of experience.">
<link rel="canonical" href="https://superwalter.com.ar/en/careers">
<?= sw_hreflang_tags() ?>

<meta property="og:type" content="website">
<meta property="og:locale" content="en_US">
<meta property="og:locale:alternate" content="es_AR">
<meta property="og:site_name" content="Super Walter">
<meta property="og:title" content="Careers · Super Walter">
<meta property="og:description" content="Join the team at an Argentine manufacturer with over 65 years of experience. Send us your CV.">
<meta property="og:url" content="https://superwalter.com.ar/en/careers">
<meta property="og:image" content="https://superwalter.com.ar/assets/img/og-image.jpg"><!-- EDITAR -->

<link rel="icon" href="../assets/img/isotipo.svg" type="image/svg+xml">
<link rel="apple-touch-icon" href="../assets/img/isotipo.svg">

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

<link rel="preload" as="image" href="../assets/img/tractor-loma.webp">
<link rel="stylesheet" href="../assets/css/styles.css">
</head>
<body>
<?php include __DIR__ . '/../partials/header.php'; ?>

<main id="main">
<span id="top"></span>

<!-- ============================ HERO DE PÁGINA ============================ -->
<section class="page-hero page-hero--photo" aria-label="Careers">
  <div class="ph-bg" aria-hidden="true"><img src="../assets/img/tractor-loma.webp" alt="" width="1200" height="1350"></div>
  <div class="container">
    <p class="page-hero__crumb"><a href="<?= sw_url('home') ?>">Home</a> · <span>Careers</span></p>
    <p class="eyebrow on-dark" data-reveal="fade"><img class="mk" src="../assets/img/mark.svg" alt="">Careers</p>
    <h1 class="section-title" data-reveal style="color:#fff;max-width:15ch">Interested in joining our team<span class="mark-x">?</span></h1>
    <p class="lead" data-reveal data-reveal-delay="1" style="color:rgba(255,255,255,.78);margin-top:1.1rem">Don't wait: fill in your details and attach your CV. We're looking for people who want to build machines they can be proud of.</p>
    <div class="hero__actions" style="opacity:1;transform:none;margin-top:2rem;justify-content:flex-start">
      <a class="btn btn--amarillo" href="#postulacion">Send my CV</a>
      <a class="btn btn--ghost" href="<?= sw_url('company') ?>">Learn about the company</a>
    </div>
  </div>
</section>

<!-- ============================ MANIFIESTO ============================ -->
<section class="intro section-pad" id="intro" aria-labelledby="intro-title">
  <div class="container">
    <p class="eyebrow" data-reveal="fade"><img class="mk" src="../assets/img/mark.svg" alt="">Working at Super Walter · 01</p>
    <div class="intro__grid">
      <h2 class="intro__statement" id="intro-title" data-reveal>
        Here we really build things: <em>steel, engineering and farming</em>, every day.
      </h2>
      <div class="intro__body" data-reveal data-reveal-delay="1">
        <p><strong>Búfalo S.A.</strong> is one of Argentina's leading manufacturers of agricultural implements. Our products are built with the latest technology in a <strong>13,200 m²</strong> plant in Las Parejas, Santa Fe.</p>
        <p>We are a <strong>family-owned</strong> company with over 65 years of experience. That means direct service, quick decisions and teams who know each other by name.</p>
        <p>If you take pride in a job well done and want to see your work out in the field, this is your place.</p>
      </div>
    </div>
  </div>
</section>

<!-- ============================ POR QUÉ ============================ -->
<section class="benefits section-pad" id="beneficios" aria-labelledby="beneficios-title">
  <div class="container">
    <p class="eyebrow" data-reveal="fade"><img class="mk" src="../assets/img/mark.svg" alt="">Why join us · 02</p>
    <h2 class="section-title" id="beneficios-title" data-reveal>A growing industry, with its feet on the ground.</h2>
    <div class="benefits__grid">
      <div class="benefit" data-reveal="sweep"><span class="benefit__n">01</span><h3>Argentine industry</h3><p>100% Argentine engineering and manufacturing, with machines now working in eleven countries.</p></div>
      <div class="benefit" data-reveal="sweep" data-reveal-delay="1"><span class="benefit__n">02</span><h3>Family business</h3><p>Over 65 years of history and a team where your work is seen and recognized.</p></div>
      <div class="benefit" data-reveal="sweep" data-reveal-delay="2"><span class="benefit__n">03</span><h3>Ongoing training</h3><p>Continuous technical training and innovation projects in precision agriculture.</p></div>
      <div class="benefit" data-reveal="sweep" data-reveal-delay="3"><span class="benefit__n">04</span><h3>Career growth</h3><p>A growing plant, with CE certification and a presence at the world's major trade shows.</p></div>
    </div>
  </div>
</section>

<!-- ============================ ÁREAS ============================ -->
<section class="news section-pad" id="areas" aria-labelledby="areas-title">
  <div class="container">
    <p class="eyebrow" data-reveal="fade"><img class="mk" src="../assets/img/mark.svg" alt="">Areas of work · 03</p>
    <h2 class="section-title" id="areas-title" data-reveal>Where you can join us.</h2>
    <div class="areas">
      <article class="area" data-reveal>
        <div><h3>Production and assembly</h3><p>Welding, assembly, painting and quality control at the plant.</p></div>
        <span class="pill">Las Parejas</span>
      </article>
      <article class="area" data-reveal data-reveal-delay="1">
        <div><h3>Engineering and design</h3><p>Product development, calculations, CAD and field testing.</p></div>
        <span class="pill">Las Parejas</span>
      </article>
      <article class="area" data-reveal data-reveal-delay="2">
        <div><h3>Sales and after-sales</h3><p>Advice for farmers, dealer network and technical support.</p></div>
        <span class="pill">Nationwide</span>
      </article>
      <article class="area" data-reveal data-reveal-delay="3">
        <div><h3>Administration</h3><p>Purchasing, logistics, administration and IT.</p></div>
        <span class="pill">Las Parejas</span>
      </article>
    </div>
    <p class="form__note" data-reveal style="color:var(--texto-mute);margin-top:1.3rem">EDITAR: replace with the actual open positions once the client provides them.</p>
  </div>
</section>

<!-- ============================ FORM POSTULACIÓN ============================ -->
<section class="cta section-pad" id="postulacion" aria-labelledby="postulacion-title">
  <div class="container">
    <div class="cta__panel">
      <div class="cta__grid">
        <div data-reveal>
          <p class="eyebrow on-dark" style="margin-bottom:1.2rem"><img class="mk" src="../assets/img/mark.svg" alt="">Apply</p>
          <h2 class="cta__title" id="postulacion-title">Send us your <em>CV</em> and we'll keep you in mind.</h2>
          <p class="cta__lead">Fill in your details and attach your résumé. We keep your application on file and will contact you when a position opens that fits your profile.</p>
          <div class="cta__contacts">
            <div class="cta__contact">
              <span class="ico"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0z"/><circle cx="12" cy="10" r="3"/></svg></span>
              <span><b>Plant</b><span>Calle 10 Nº 490, Las Parejas, Santa Fe</span></span>
            </div>
            <div class="cta__contact">
              <span class="ico"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="12" cy="12" r="9"/><path d="M12 7v5l3 2"/></svg></span>
              <span><b>Opening hours</b><span>Mon to Fri 7 am to 12 pm and 2 to 6 pm · Sat 8 am to 12 pm</span></span>
            </div>
            <div class="cta__contact">
              <span class="ico"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect x="3" y="5" width="18" height="14" rx="2"/><path d="m3 7 9 6 9-6"/></svg></span>
              <span><b>HR email</b><a href="mailto:rrhh@superwalter.com.ar">rrhh@superwalter.com.ar</a></span><!-- EDITAR -->
            </div>
          </div>
        </div>

        <form class="form" id="leadForm" data-endpoint="../api/trabajo.php" enctype="multipart/form-data" data-reveal data-reveal-delay="1" novalidate>
          <input type="text" name="website" tabindex="-1" autocomplete="off" aria-hidden="true" style="position:absolute;left:-5000px">
          <div class="form__grid">
            <div class="field field--wide"><label for="f-nombre"><span class="field__num">01</span> Full name</label><input type="text" id="f-nombre" name="nombre" autocomplete="name" required placeholder="Your name"></div>
            <div class="field field--narrow"><label for="f-tel"><span class="field__num">02</span> Phone</label><input type="tel" id="f-tel" name="telefono" autocomplete="tel" required placeholder="Area code + number"></div>
            <div class="field field--narrow"><label for="f-email"><span class="field__num">03</span> Email</label><input type="email" id="f-email" name="email" autocomplete="email" required placeholder="you@email.com"></div>
            <div class="field field--wide"><label for="f-localidad"><span class="field__num">04</span> City</label><input type="text" id="f-localidad" name="localidad" required placeholder="E.g. Las Parejas, Santa Fe"></div>
            <div class="field">
              <span class="field-label" id="area-label"><span class="field__num">05</span> Which area would you like to work in?</span>
              <div class="chips" role="group" aria-labelledby="area-label">
                <label class="chip"><input type="radio" name="area" value="Producción y montaje" checked><span>Production and assembly</span></label>
                <label class="chip"><input type="radio" name="area" value="Ingeniería y diseño"><span>Engineering and design</span></label>
                <label class="chip"><input type="radio" name="area" value="Comercial y postventa"><span>Sales and after-sales</span></label>
                <label class="chip"><input type="radio" name="area" value="Administración"><span>Administration</span></label>
              </div>
            </div>
            <div class="field">
              <label for="f-cv"><span class="field__num">06</span> Attach your CV</label>
              <input type="file" id="f-cv" name="cv" accept=".pdf,.doc,.docx" required>
              <span class="field__hint">PDF, DOC or DOCX formats · up to 5 MB</span>
            </div>
            <div class="field"><label for="f-msg"><span class="field__num">07</span> Your message <span style="text-transform:none;letter-spacing:0;color:var(--texto-mute);font-weight:400">(optional)</span></label><textarea id="f-msg" name="mensaje" placeholder="Briefly tell us about your experience..."></textarea></div>
            <div class="field"><button class="btn btn--amarillo btn--block" type="submit">Submit application</button></div>
          </div>
          <p class="form__note">By submitting you agree that Super Walter may store your data for recruitment purposes. We do not share it with third parties. This site is protected by reCAPTCHA and the Google <a href="https://policies.google.com/privacy" target="_blank" rel="noopener">Privacy Policy</a> and <a href="https://policies.google.com/terms" target="_blank" rel="noopener">Terms of Service</a> apply.</p>
          <div class="form__success" id="formSuccess" role="status" aria-live="polite">
            <b>All set! We've received your application.</b>
            <span>If your profile matches an open position, we'll be in touch.</span>
          </div>
        </form>
      </div>
    </div>
  </div>
</section>
</main>

<?php include __DIR__ . '/../partials/footer.php'; ?>
