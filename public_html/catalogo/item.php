<?php
declare(strict_types=1);

$lang = $lang ?? 'es';
$base = $base ?? '../';

require __DIR__ . '/../partials/bootstrap.php';

use SuperWalter\JsonStore;

$slug = isset($_GET['slug']) ? (string) $_GET['slug'] : '';
$item = $slug !== '' ? JsonStore::findLocalized('catalogo.json', $slug, $lang) : null;

$pageKey = 'catalog';
if ($item !== null) {
    $pageSlug = $slug;
}
$activeNav = 'lineup';
$h = static fn (?string $s): string => htmlspecialchars((string) $s, ENT_QUOTES, 'UTF-8');

if ($item === null) {
    http_response_code(404);
    ?>
<!DOCTYPE html>
<html lang="<?= $lang === 'en' ? 'en' : 'es-AR' ?>">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?= $h(tr('Producto no encontrado', 'Product not found')) ?> · Super Walter</title>
  <link rel="stylesheet" href="<?= $base ?>assets/css/styles.css">
</head>
<body>
<?php include __DIR__ . '/../partials/header.php'; ?>
  <main id="main" class="section-pad">
    <div class="container" style="text-align:center;padding-block:6rem">
      <h1 class="section-title"><?= $h(tr('No encontramos ese producto.', 'We could not find that product.')) ?></h1>
      <p class="lead" style="margin-top:1rem"><a href="<?= $h(sw_url('new')) ?>" style="color:var(--bordo);font-weight:600"><?= $h(tr('Ver productos nuevos →', 'See new machinery →')) ?></a></p>
    </div>
  </main>
<?php include __DIR__ . '/../partials/footer.php'; ?>
<?php
    exit;
}

$condLabel = $item['condicion'] === 'nuevo' ? tr('Nuevo', 'New') : tr('Usado', 'Used');
$condVariant = $item['condicion'] === 'nuevo' ? 'amarillo' : 'outline';
$catLabels = sw_cat_labels();
$catLabel = $catLabels[$item['categoria']] ?? tr('General', 'General');
$listingHref = sw_url($item['condicion'] === 'nuevo' ? 'new' : 'used');
$listingLabel = $item['condicion'] === 'nuevo' ? tr('Productos nuevos', 'New machinery') : tr('Productos usados', 'Used machinery');
$images = $item['images'] ?? [];
$priceFmt = $item['price'] !== null ? '$' . number_format((float) $item['price'], 0, sw_is_en() ? '.' : ',', sw_is_en() ? ',' : '.') : null;

// Productos relacionados: misma categoría y condición primero; se completa con la misma condición y luego el resto.
$relacionados = array_values(array_filter(
    JsonStore::allLocalized('catalogo.json', $lang),
    static fn (array $it): bool => $it['slug'] !== $slug
));
usort($relacionados, static fn (array $a, array $b): int =>
    (($b['categoria'] === $item['categoria']) <=> ($a['categoria'] === $item['categoria']))
    ?: (($b['condicion'] === $item['condicion']) <=> ($a['condicion'] === $item['condicion'])));
$relacionados = array_slice($relacionados, 0, 3);
?>
<!DOCTYPE html>
<html lang="<?= $lang === 'en' ? 'en' : 'es-AR' ?>">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="theme-color" content="#7f1810">

  <!-- ============ SEO ============ -->
  <title><?= $h($item['title']) ?> · Super Walter</title>
  <meta name="description" content="<?= $h(strip_tags($item['description_html'] ?? '')) ?>">
  <link rel="canonical" href="<?= $h('https://superwalter.com.ar/' . sw_path($pageKey, $lang, $slug)) ?>">
  <?= sw_hreflang_tags() ?>

  <meta property="og:type" content="product">
  <meta property="og:locale" content="<?= $lang === 'en' ? 'en_US' : 'es_AR' ?>">
  <meta property="og:locale:alternate" content="<?= $lang === 'en' ? 'es_AR' : 'en_US' ?>">
  <meta property="og:site_name" content="Super Walter">
  <meta property="og:title" content="<?= $h($item['title']) ?>">
  <meta property="og:url" content="<?= $h('https://superwalter.com.ar/' . sw_path($pageKey, $lang, $slug)) ?>">
<?php if (!empty($images[0])): ?>
  <meta property="og:image" content="https://superwalter.com.ar/<?= $h($images[0]) ?>">
<?php endif; ?>

  <link rel="icon" href="<?= $base ?>assets/img/isotipo.svg" type="image/svg+xml">
  <link rel="apple-touch-icon" href="<?= $base ?>assets/img/isotipo.svg">

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap"
    rel="stylesheet">

  <link rel="stylesheet" href="<?= $base ?>assets/css/styles.css">
</head>

<body>

<?php include __DIR__ . '/../partials/header.php'; ?>

  <main id="main">
    <span id="top"></span>

    <!-- ============================ HERO ============================ -->
    <section class="page-hero<?= !empty($images[0]) ? ' page-hero--photo' : '' ?>" aria-label="<?= $h($item['title']) ?>">
<?php if (!empty($images[0])): ?>
      <div class="ph-bg" aria-hidden="true"><img src="<?= $base ?><?= $h($images[0]) ?>" alt="<?= $h($item['image_alt'] ?? $item['title']) ?>" width="2000" height="1334"></div>
<?php endif; ?>
      <div class="container">
        <p class="page-hero__crumb"><a href="<?= $h(sw_url('home')) ?>"><?= $h(tr('Inicio', 'Home')) ?></a> · <a href="<?= $h($listingHref) ?>"><?= $h($listingLabel) ?></a> ·
          <span><?= $h($item['title']) ?></span></p>
        <div style="display:flex;flex-wrap:wrap;gap:.6rem;margin-bottom:1.2rem">
          <span class="pill pill--<?= $h($condVariant) ?>"><?= $h($condLabel) ?></span>
          <span class="pill pill--outline"><?= $h($catLabel) ?></span>
        </div>
        <h1 class="section-title" data-reveal style="color:#fff;max-width:26ch"><?= $h($item['title']) ?><span class="mark-x"></span></h1>
<?php if ($priceFmt !== null): ?>
        <p class="lead" data-reveal data-reveal-delay="1" style="color:rgba(255,255,255,.9);margin-top:1.1rem;font-weight:700"><?= $h($priceFmt) ?></p>
<?php endif; ?>
      </div>
    </section>

    <!-- ============================ GALERÍA + FICHA ============================ -->
    <section class="tech section-pad" id="ficha" aria-labelledby="ficha-title">
      <div class="container">
        <h2 class="visually-hidden" id="ficha-title"><?= $h($item['title']) ?></h2>
<?php if (count($images) > 1): ?>
        <div class="gallery" data-reveal>
          <div class="gallery__main"><img id="galleryMain" src="<?= $base ?><?= $h($images[0]) ?>" alt="<?= $h($item['image_alt'] ?? $item['title']) ?>" loading="lazy"></div>
          <div class="gallery__thumbs">
<?php foreach ($images as $i => $img): ?>
            <button type="button" class="gallery__thumb<?= $i === 0 ? ' is-active' : '' ?>" data-full="<?= $base ?><?= $h($img) ?>"><img src="<?= $base ?><?= $h($img) ?>" alt="" loading="lazy"></button>
<?php endforeach; ?>
          </div>
        </div>
<?php endif; ?>

        <div class="intro__body" data-reveal style="max-width:none;margin-top:clamp(1.6rem,3vw,2.4rem)">
          <?= $item['description_html'] ?? '' ?>
        </div>

<?php if (!empty($item['specs'])): ?>
        <h3 style="margin-top:clamp(1.6rem,3vw,2.4rem)"><?= $h(tr('Características', 'Specifications')) ?></h3>
        <table class="specs-table">
          <tbody>
<?php foreach ($item['specs'] as $spec): ?>
<?php if (str_contains($spec, '|')): [$specLabel, $specValue] = array_map('trim', explode('|', $spec, 2)); ?>
            <tr><th scope="row"><?= $h($specLabel) ?></th><td><?= $h($specValue) ?></td></tr>
<?php else: ?>
            <tr><td colspan="2"><?= $h($spec) ?></td></tr>
<?php endif; ?>
<?php endforeach; ?>
          </tbody>
        </table>
<?php endif; ?>
      </div>
    </section>

    <!-- ============================ CTA + FORM ============================ -->
    <section class="cta section-pad" id="cotizar" aria-labelledby="cotizar-title">
      <div class="container">
        <div class="cta__panel">
          <div class="cta__grid">
            <div data-reveal>
              <p class="eyebrow on-dark" style="margin-bottom:1.2rem"><img class="mk" src="<?= $base ?>assets/img/mark.svg"
                  alt=""><?= $h(tr('Hablemos de tu próxima campaña', "Let's talk about your next season")) ?></p>
              <h2 class="cta__title" id="cotizar-title"><?= $h(tr('¿Te interesa ', 'Interested in ')) ?><em><?= $h($item['title']) ?></em>?</h2>
              <p class="cta__lead"><?= $h(tr('Completá el formulario y un asesor de Super Walter se comunica con vos para avanzar con la consulta.', 'Fill in the form and a Super Walter advisor will get in touch with you to move forward with your inquiry.')) ?></p>
              <div class="cta__contacts">
                <div class="cta__contact">
                  <span class="ico"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                      stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                      <path
                        d="M22 16.9v3a2 2 0 0 1-2.2 2 19.8 19.8 0 0 1-8.6-3 19.5 19.5 0 0 1-6-6 19.8 19.8 0 0 1-3-8.7A2 2 0 0 1 4.1 2h3a2 2 0 0 1 2 1.7c.1 1 .4 1.9.7 2.8a2 2 0 0 1-.5 2.1L8.1 9.9a16 16 0 0 0 6 6l1.3-1.3a2 2 0 0 1 2.1-.4c.9.3 1.8.6 2.8.7a2 2 0 0 1 1.7 2z" />
                      </svg></span>
                  <span><b><?= $h(tr('Teléfono / WhatsApp', 'Phone / WhatsApp')) ?></b><a href="tel:+543471471069">+54 3471 471069</a></span>
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
                <div class="field field--wide"><label for="f-nombre"><span class="field__num">01</span> <?= $h(tr('Nombre y apellido', 'Full name')) ?></label><input type="text" id="f-nombre" name="nombre" autocomplete="name" required
                    placeholder="<?= $h(tr('Tu nombre', 'Your name')) ?>"></div>
                <div class="field field--narrow"><label for="f-tel"><span class="field__num">02</span>
                    <?= $h(tr('Teléfono', 'Phone')) ?></label><input type="tel" id="f-tel" name="telefono" autocomplete="tel" required
                    placeholder="<?= $h(tr('Cód. + número', 'Area code + number')) ?>"></div>
                <div class="field field--narrow"><label for="f-email"><span class="field__num">03</span>
                    Email</label><input type="email" id="f-email" name="email" autocomplete="email" required
                    placeholder="tu@email.com"></div>
                <div class="field field--wide"><label for="f-zona"><span class="field__num">04</span> <?= $h(tr('Localidad / Provincia', 'City / State')) ?></label><input type="text" id="f-zona" name="zona" required
                    placeholder="<?= $h(tr('Ej: Pergamino, Bs. As.', 'E.g. Pergamino, Buenos Aires')) ?>"></div>
                <div class="field field--wide"><label for="f-modelo"><span class="field__num">05</span> <?= $h(tr('Estás consultando por', 'You are inquiring about')) ?></label><input type="text" id="f-modelo" name="modelo" class="product-form__value"
                    value="" readonly style="background:var(--paper-2);color:var(--texto-mute);cursor:default"></div>
                <div class="field"><label for="f-msg"><span class="field__num">06</span> <?= $h(tr('Tu mensaje', 'Your message')) ?> <span
                      style="text-transform:none;letter-spacing:0;color:var(--texto-mute);font-weight:400"><?= $h(tr('(opcional)', '(optional)')) ?></span></label><textarea
                    id="f-msg" name="mensaje" placeholder="<?= $h(tr('Contanos qué necesitás...', 'Tell us what you need...')) ?>"></textarea></div>
                <div class="field"><button class="btn btn--amarillo btn--block" type="submit"><?= $h(tr('Enviar consulta', 'Send inquiry')) ?></button></div>
              </div>
<?php if ($lang === 'en'): ?>
              <p class="form__note">By submitting you agree to be contacted by Super Walter. We do not share your data. This
                site is protected by reCAPTCHA and the Google <a href="https://policies.google.com/privacy"
                  target="_blank" rel="noopener">Privacy Policy</a> and <a
                  href="https://policies.google.com/terms" target="_blank" rel="noopener">Terms of Service</a>
                apply.</p>
<?php else: ?>
              <p class="form__note">Al enviar aceptás ser contactado por Super Walter. No compartimos tus datos. Este
                sitio está protegido por reCAPTCHA y aplican la <a href="https://policies.google.com/privacy"
                  target="_blank" rel="noopener">Política de Privacidad</a> y los <a
                  href="https://policies.google.com/terms" target="_blank" rel="noopener">Términos de Servicio</a> de
                Google.</p>
<?php endif; ?>
              <div class="form__success" id="formSuccess" role="status" aria-live="polite">
                <b><?= $h(tr('¡Listo! Recibimos tu consulta.', 'Done! We received your inquiry.')) ?></b>
                <span><?= $h(tr('Un asesor de Super Walter se va a comunicar con vos a la brevedad.', 'A Super Walter advisor will contact you shortly.')) ?></span>
              </div>
            </form>
          </div>
        </div>
      </div>
    </section>

<?php if (!empty($relacionados)): ?>
    <!-- ============================ PRODUCTOS RELACIONADOS ============================ -->
    <section class="news section-pad" id="relacionados" aria-labelledby="relacionados-title">
      <div class="container">
        <p class="eyebrow" data-reveal="fade"><img class="mk" src="<?= $base ?>assets/img/mark.svg" alt=""><?= $h(tr('Seguí viendo', 'Keep exploring')) ?></p>
        <h2 class="section-title" id="relacionados-title" data-reveal><?= $h(tr('Productos relacionados.', 'Related products.')) ?></h2>
        <div class="news__grid">
<?php foreach ($relacionados as $i => $it): ?>
          <article class="news-card" data-reveal<?= $i > 0 ? ' data-reveal-delay="' . min($i, 2) . '"' : '' ?>>
            <div class="news-card__img">
              <span class="news-card__pill pill <?= $it['condicion'] === 'nuevo' ? 'pill--amarillo' : '' ?>"><?= $h($it['condicion'] === 'nuevo' ? tr('Nuevo', 'New') : tr('Usado', 'Used')) ?></span>
<?php if (!empty($it['images'][0])): ?>
              <img src="<?= $base ?><?= $h($it['images'][0]) ?>" alt="<?= $h($it['image_alt'] ?? $it['title']) ?>" loading="lazy" width="1800" height="1350">
<?php endif; ?>
            </div>
            <div class="news-card__body">
              <p class="news-card__meta"><?= $h($catLabels[$it['categoria']] ?? tr('General', 'General')) ?></p>
              <h3><?= $h($it['title']) ?></h3>
<?php if ($it['price'] !== null): ?>
              <p style="color:var(--texto);font-weight:700">$<?= number_format((float) $it['price'], 0, sw_is_en() ? '.' : ',', sw_is_en() ? ',' : '.') ?></p>
<?php endif; ?>
              <a class="news-card__link" href="<?= $h(sw_url('catalog', $it['slug'])) ?>"><?= $h(tr('Ver ficha', 'View details')) ?></a>
            </div>
          </article>
<?php endforeach; ?>
        </div>
      </div>
    </section>
<?php endif; ?>
  </main>

<?php include __DIR__ . '/../partials/footer.php'; ?>
