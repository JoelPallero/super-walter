<?php
declare(strict_types=1);

$lang = $lang ?? 'es';
$base = $base ?? '../';
$pageKey = 'product';

require __DIR__ . '/../partials/bootstrap.php';
require __DIR__ . '/../partials/icons.php';

use SuperWalter\JsonStore;

$slug = isset($_GET['slug']) ? (string) $_GET['slug'] : '';
$producto = $slug !== '' ? JsonStore::findLocalized('productos.json', $slug, $lang) : null;

if ($producto === null) {
    http_response_code(404);
    $activeNav = 'lineup';
    ?>
<!DOCTYPE html>
<html lang="<?= $lang === 'en' ? 'en' : 'es-AR' ?>">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?= tr('Producto no encontrado', 'Product not found') ?> · Super Walter</title>
  <link rel="stylesheet" href="<?= $base ?>assets/css/styles.css">
</head>
<body>
<?php include __DIR__ . '/../partials/header.php'; ?>
  <main id="main" class="section-pad">
    <div class="container" style="text-align:center;padding-block:6rem">
      <h1 class="section-title"><?= tr('No encontramos esa sembradora.', 'We could not find that seeder.') ?></h1>
      <p class="lead" style="margin-top:1rem"><a href="<?= sw_url('home') ?>#lineup" style="color:var(--bordo);font-weight:600"><?= tr('Ver todo el line-up →', 'See the full line-up →') ?></a></p>
    </div>
  </main>
<?php include __DIR__ . '/../partials/footer.php'; ?>
<?php
    exit;
}

$todos = JsonStore::allLocalized('productos.json', $lang);
$otros = array_values(array_filter($todos, static fn (array $p): bool => $p['slug'] !== $slug));

$pageSlug = $slug;
$activeNav = 'lineup';
$pillClass = static fn (string $variant): string => $variant === 'amarillo' ? 'pill pill--amarillo' : ($variant === 'outline' ? 'pill pill--outline' : 'pill');

$h = static fn (?string $s): string => htmlspecialchars((string) $s, ENT_QUOTES, 'UTF-8');
?>
<!DOCTYPE html>
<html lang="<?= $lang === 'en' ? 'en' : 'es-AR' ?>">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="theme-color" content="#7f1810">

  <!-- ============ SEO ============ -->
  <title><?= $h($producto['seo_title'] ?? $producto['title']) ?></title>
  <meta name="description" content="<?= $h($producto['seo_description'] ?? '') ?>">
  <link rel="canonical" href="https://superwalter.com.ar/<?= $h(sw_path($pageKey, $lang, $slug)) ?>">
  <?= sw_hreflang_tags() ?>


  <meta property="og:type" content="product">
  <meta property="og:locale" content="<?= $lang === 'en' ? 'en_US' : 'es_AR' ?>">
  <meta property="og:locale:alternate" content="<?= $lang === 'en' ? 'es_AR' : 'en_US' ?>">
  <meta property="og:site_name" content="Super Walter">
  <meta property="og:title" content="<?= $h($producto['og_title'] ?? $producto['title']) ?>">
  <meta property="og:description" content="<?= $h($producto['og_description'] ?? '') ?>">
  <meta property="og:url" content="https://superwalter.com.ar/<?= $h(sw_path($pageKey, $lang, $slug)) ?>">
  <meta property="og:image" content="https://superwalter.com.ar/assets/img/og-image.jpg">

  <link rel="icon" href="<?= $base ?>assets/img/isotipo.svg" type="image/svg+xml">
  <link rel="apple-touch-icon" href="<?= $base ?>assets/img/isotipo.svg">

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap"
    rel="stylesheet">

  <link rel="preload" as="image" href="<?= $base ?><?= $h($producto['hero_image']) ?>">
  <link rel="stylesheet" href="<?= $base ?>assets/css/styles.css">
</head>

<body>

<?php include __DIR__ . '/../partials/header.php'; ?>

  <main id="main">
    <span id="top"></span>

    <!-- ============================ HERO DE PRODUCTO ============================ -->
    <section class="page-hero page-hero--photo" aria-label="<?= $h($producto['title']) ?>">
      <div class="ph-bg" aria-hidden="true"><img src="<?= $base ?><?= $h($producto['hero_image']) ?>"
          alt="<?= $h($producto['hero_image_alt'] ?? '') ?>" width="2000" height="1334"></div>
      <div class="container">
        <p class="page-hero__crumb"><a href="<?= sw_url('home') ?>"><?= tr('Inicio', 'Home') ?></a> · <a href="<?= sw_url('home') ?>#lineup"><?= tr('Sembradoras', 'Seeders') ?></a>
          · <span><?= $h($producto['title']) ?></span></p>
        <div style="display:flex;flex-wrap:wrap;gap:.6rem;margin-bottom:1.2rem">
<?php foreach ($producto['hero_pills'] ?? [] as $pill): ?>
          <span class="<?= $h($pillClass($pill['variant'] ?? 'plain')) ?>"><?= $h($pill['text'] ?? '') ?></span>
<?php endforeach; ?>
        </div>
        <h1 class="section-title" data-reveal style="color:#fff;max-width:22ch"><?= $h($producto['title']) ?><span class="mark-x">.</span></h1>
        <p class="lead" data-reveal data-reveal-delay="1" style="color:rgba(255,255,255,.78);margin-top:1.1rem"><?= $h($producto['lead'] ?? '') ?></p>
        <div class="hero__actions" style="opacity:1;transform:none;margin-top:2rem;justify-content:flex-start">
          <a class="btn btn--amarillo" href="<?= sw_url('contact') ?>"><?= $h($producto['cta_hero_text'] ?? tr('Consultar', 'Inquire')) ?></a>
          <a class="btn btn--ghost" href="<?= sw_url('home') ?>#lineup"><?= tr('Ver todo el line-up', 'See the full line-up') ?></a>
        </div>
      </div>
    </section>

    <!-- ============================ FICHA ============================ -->
    <section class="tech section-pad" id="ficha" aria-labelledby="ficha-title">
      <div class="container">
        <p class="eyebrow" data-reveal="fade"><img class="mk" src="<?= $base ?>assets/img/mark.svg" alt=""><?= $h($producto['ficha_eyebrow'] ?? tr('Ficha del modelo', 'Model specs')) ?> · 01
        </p>
<?php if (($producto['ficha_layout'] ?? '') === 'side_image'): ?>
        <div class="tech__grid">
          <div class="tech__media img-reveal" data-reveal>
            <img src="<?= $base ?><?= $h($producto['ficha_image'] ?? $producto['hero_image']) ?>"
              alt="<?= $h($producto['ficha_image_alt'] ?? '') ?>" loading="lazy" width="1500" height="1500">
<?php if (!empty($producto['ficha_badge'])): ?>
            <div class="tech__badge"><span class="pill pill--light"><?= $h($producto['ficha_badge']) ?></span></div>
<?php endif; ?>
          </div>
          <div>
            <h2 class="section-title" id="ficha-title" data-reveal style="margin-bottom:1.6rem"><?= $h($producto['ficha_heading'] ?? '') ?></h2>
            <div class="tech__features">
<?php foreach ($producto['features'] ?? [] as $i => $f): ?>
              <div class="feature" data-reveal<?= $i > 0 ? ' data-reveal-delay="' . min($i, 3) . '"' : '' ?>>
                <span class="feature__ico" aria-hidden="true"><?= sw_feature_icon($f['icon'] ?? 'bars') ?></span>
                <div>
                  <h3><?= $h($f['title'] ?? '') ?></h3>
                  <p><?= $h($f['text'] ?? '') ?></p>
                </div>
              </div>
<?php endforeach; ?>
            </div>
          </div>
        </div>
<?php else: ?>
        <h2 class="section-title" id="ficha-title" data-reveal style="margin-bottom:2rem"><?= $h($producto['ficha_heading'] ?? '') ?></h2>
<?php if (($producto['ficha_layout'] ?? '') === 'single_image' && !empty($producto['ficha_image'])): ?>
        <div style="background:var(--paper-2);border-radius:var(--leaf);padding:clamp(1.6rem,4vw,3rem);box-shadow:var(--shadow-sm)"
          data-reveal>
          <img src="<?= $base ?><?= $h($producto['ficha_image']) ?>" alt="<?= $h($producto['ficha_image_alt'] ?? '') ?>" loading="lazy" width="1573"
            height="494" style="width:100%;height:auto;object-fit:contain">
        </div>
<?php endif; ?>
        <div class="tech__features" style="margin-top:clamp(1.6rem,3vw,2.4rem)">
<?php $blocks = ($producto['ficha_layout'] ?? '') === 'no_image_multi_model' ? ($producto['sub_models'] ?? []) : ($producto['features'] ?? []); ?>
<?php foreach ($blocks as $i => $f): ?>
          <div class="feature" data-reveal<?= $i > 0 ? ' data-reveal-delay="' . min($i, 3) . '"' : '' ?>>
            <span class="feature__ico" aria-hidden="true"><?= sw_feature_icon($f['icon'] ?? 'bars') ?></span>
            <div>
              <h3><?= $h($f['title'] ?? '') ?></h3>
              <p><?= $h($f['text'] ?? '') ?></p>
            </div>
          </div>
<?php endforeach; ?>
        </div>
<?php endif; ?>
      </div>
    </section>

    <!-- ============================ BENEFICIOS ============================ -->
    <section class="benefits section-pad" id="beneficios" aria-labelledby="beneficios-title">
      <div class="container">
        <p class="eyebrow" data-reveal="fade"><img class="mk" src="<?= $base ?>assets/img/mark.svg" alt=""><?= tr('Por qué elegirla', 'Why choose it') ?> · 02
        </p>
        <h2 class="section-title" id="beneficios-title" data-reveal><?= $h($producto['benefits_heading'] ?? '') ?></h2>
        <div class="benefits__grid">
<?php foreach ($producto['benefits'] ?? [] as $i => $b): ?>
          <div class="benefit" data-reveal="sweep"<?= $i > 0 ? ' data-reveal-delay="' . min($i, 3) . '"' : '' ?>><span class="benefit__n"><?= $h($b['number'] ?? '') ?></span>
            <h3><?= $h($b['title'] ?? '') ?></h3>
            <p><?= $h($b['text'] ?? '') ?></p>
          </div>
<?php endforeach; ?>
        </div>
      </div>
    </section>

    <!-- ============================ CTA + FORM ============================ -->
    <section class="cta section-pad" id="cotizar" aria-labelledby="cotizar-title">
      <div class="container">
        <div class="cta__panel">
          <div class="cta__grid">
            <div data-reveal>
              <p class="eyebrow on-dark" style="margin-bottom:1.2rem"><img class="mk" src="<?= $base ?>assets/img/mark.svg"
                  alt=""><?= tr('Hablemos de tu próxima campaña', "Let's talk about your next season") ?></p>
              <h2 class="cta__title" id="cotizar-title"><?= $producto['cta_title_html'] ?? '' ?></h2>
              <p class="cta__lead"><?= $h($producto['cta_lead'] ?? '') ?></p>
              <div class="cta__contacts">
                <div class="cta__contact">
                  <span class="ico"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                      stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                      <path
                        d="M22 16.9v3a2 2 0 0 1-2.2 2 19.8 19.8 0 0 1-8.6-3 19.5 19.5 0 0 1-6-6 19.8 19.8 0 0 1-3-8.7A2 2 0 0 1 4.1 2h3a2 2 0 0 1 2 1.7c.1 1 .4 1.9.7 2.8a2 2 0 0 1-.5 2.1L8.1 9.9a16 16 0 0 0 6 6l1.3-1.3a2 2 0 0 1 2.1-.4c.9.3 1.8.6 2.8.7a2 2 0 0 1 1.7 2z" />
                      </svg></span>
                  <span><b><?= tr('Teléfono / WhatsApp', 'Phone / WhatsApp') ?></b><a href="tel:+543471471069">+54 3471 471069</a></span>
                </div>
                <div class="cta__contact">
                  <span class="ico"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                      stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                      <rect x="3" y="5" width="18" height="14" rx="2" />
                      <path d="m3 7 9 6 9-6" /></svg></span>
                  <span><b>Email</b><a href="mailto:ventas@superwalter.com.ar">ventas@superwalter.com.ar</a></span>
                </div>
              </div>
            </div>

            <form class="form product-form" id="leadForm" data-endpoint="<?= $base ?>api/contacto.php" data-reveal
              data-reveal-delay="1" novalidate>
              <input type="text" name="website" tabindex="-1" autocomplete="off" aria-hidden="true"
                style="position:absolute;left:-5000px">
              <div class="form__grid">
                <div class="field field--wide"><label for="f-nombre"><span class="field__num">01</span> <?= tr('Nombre y
                    apellido', 'Full name') ?></label><input type="text" id="f-nombre" name="nombre" autocomplete="name" required
                    placeholder="<?= $h(tr('Tu nombre', 'Your name')) ?>"></div>
                <div class="field field--narrow"><label for="f-tel"><span class="field__num">02</span>
                    <?= tr('Teléfono', 'Phone') ?></label><input type="tel" id="f-tel" name="telefono" autocomplete="tel" required
                    placeholder="<?= $h(tr('Cód. + número', 'Area code + number')) ?>"></div>
                <div class="field field--narrow"><label for="f-email"><span class="field__num">03</span>
                    Email</label><input type="email" id="f-email" name="email" autocomplete="email" required
                    placeholder="tu@email.com"></div>
                <div class="field field--wide"><label for="f-zona"><span class="field__num">04</span> <?= tr('Localidad /
                    Provincia', 'City / State') ?></label><input type="text" id="f-zona" name="zona" required
                    placeholder="<?= $h(tr('Ej: Pergamino, Bs. As.', 'E.g. Pergamino, Buenos Aires')) ?>"></div>
                <div class="field field--wide"><label for="f-modelo"><span class="field__num">05</span> <?= tr('Estás
                    consultando por', 'You are inquiring about') ?></label><input type="text" id="f-modelo" name="modelo" class="product-form__value"
                    value="" readonly style="background:var(--paper-2);color:var(--texto-mute);cursor:default"></div>
                <div class="field"><label for="f-msg"><span class="field__num">06</span> <?= tr('Tu mensaje', 'Your message') ?> <span
                      style="text-transform:none;letter-spacing:0;color:var(--texto-mute);font-weight:400">(<?= tr('opcional', 'optional') ?>)</span></label><textarea
                    id="f-msg" name="mensaje" placeholder="<?= $h($producto['form_message_placeholder'] ?? '') ?>"></textarea></div>
                <div class="field"><button class="btn btn--amarillo btn--block" type="submit"><?= tr('Solicitar
                    cotización', 'Request a quote') ?></button></div>
              </div>
              <p class="form__note"><?php if ($lang === 'en'): ?>By submitting you agree to be contacted by Super Walter. We do not share your data. This
                site is protected by reCAPTCHA and the Google <a href="https://policies.google.com/privacy"
                  target="_blank" rel="noopener">Privacy Policy</a> and <a
                  href="https://policies.google.com/terms" target="_blank" rel="noopener">Terms of Service</a> apply.<?php else: ?>Al enviar aceptás ser contactado por Super Walter. No compartimos tus datos. Este
                sitio está protegido por reCAPTCHA y aplican la <a href="https://policies.google.com/privacy"
                  target="_blank" rel="noopener">Política de Privacidad</a> y los <a
                  href="https://policies.google.com/terms" target="_blank" rel="noopener">Términos de Servicio</a> de
                Google.<?php endif; ?></p>
              <div class="form__success" id="formSuccess" role="status" aria-live="polite">
                <b><?= tr('¡Listo! Recibimos tu consulta.', 'Done! We received your inquiry.') ?></b>
                <span><?= tr('Un asesor de Super Walter se va a comunicar con vos a la brevedad.', 'A Super Walter advisor will contact you shortly.') ?></span>
              </div>
            </form>
          </div>
        </div>
      </div>
    </section>

    <!-- ============================ OTROS MODELOS ============================ -->
    <section class="lineup section-pad" id="otros" aria-labelledby="otros-title">
      <div class="container">
        <p class="eyebrow on-dark" data-reveal="fade"><img class="mk" src="<?= $base ?>assets/img/mark.svg" alt=""><?= tr('Seguí viendo
          el line-up', 'Keep exploring the line-up') ?></p>
        <h2 class="section-title" id="otros-title" data-reveal style="color:#fff"><?= tr('Productos relacionados.', 'Related products.') ?></h2>
        <div class="lineup__grid">
<?php foreach ($otros as $i => $p): ?>
          <article class="card-model" data-reveal<?= $i > 0 ? ' data-reveal-delay="' . min($i, 2) . '"' : '' ?>>
            <div class="card-model__media img-reveal" data-reveal>
              <div class="card-model__tags">
                <span class="<?= $h($pillClass($p['listing_badge']['variant'] ?? 'plain')) ?>"><?= $h($p['listing_badge']['text'] ?? '') ?></span>
              </div>
              <img src="<?= $base ?><?= $h($p['hero_image']) ?>"
                alt="<?= $h($p['hero_image_alt'] ?? '') ?>" loading="lazy"
                width="2000" height="1334">
            </div>
            <div class="card-model__body">
              <h3 class="card-model__name"><?= $h($p['title']) ?></h3>
              <p class="card-model__desc"><?= $h($p['lead'] ?? '') ?></p>
              <a class="card-model__link" href="<?= $h(sw_url('product', $p['slug'])) ?>"><?= tr('Ver ficha', 'View specs') ?></a>
            </div>
          </article>
<?php endforeach; ?>
        </div>
      </div>
    </section>
  </main>

<?php include __DIR__ . '/../partials/footer.php'; ?>
