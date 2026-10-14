<?php
declare(strict_types=1);

/**
 * Footer compartido. El script que lo incluye debe definir antes:
 *   $base           string  ""  en páginas de raíz, "../" en productos/novedades
 *   $footerCtaHref     string       opcional, destino del botón grande del footer (default: $base.'contacto.php')
 *   $footerLineupHref  string|null  opcional: si se define, los 4 links de "Sembradoras" apuntan todos ahí
 *                                   (como hace index.html/novedades.html); si se omite, apuntan a la ficha
 *                                   real de cada modelo (como hacen las páginas de detalle).
 *   $footerScripts     string       opcional, HTML (scripts/estilos extra) que se imprime después de main.js
 * Cierra </main> (si aplica), imprime el footer, cursor, whatsapp float,
 * el script principal y cierra </body></html>.
 */

$b = htmlspecialchars($base, ENT_QUOTES, 'UTF-8');
$footerCtaHref = $footerCtaHref ?? sw_url('contact');
$homeUrl = sw_url('home');
$onHome = ($pageKey ?? '') === 'home';
$footerLineupHref = $footerLineupHref ?? null;
?>
  <!-- ============================ FOOTER ============================ -->
  <footer class="footer" aria-label="<?= tr('Pie de página', 'Site footer') ?>">
    <div class="container footer__inner">
      <div class="footer__cta">
        <div class="fc-bg" aria-hidden="true"><img src="<?= $b ?>assets/img/campo-arboles.webp" alt="" loading="lazy"
            width="2000" height="1334"></div>
        <h2><?= tr('¿Estás buscando<br><em>tu próxima sembradora</em>?', 'Looking for<br><em>your next seeder</em>?') ?></h2>
        <a class="btn btn--amarillo" href="<?= htmlspecialchars($footerCtaHref, ENT_QUOTES, 'UTF-8') ?>"><?= tr('Solicitar asesoramiento', 'Request advice') ?></a>
      </div>

      <div class="footer__divider" aria-hidden="true"></div>

      <div class="footer__brand">
        <img src="<?= $b ?>assets/img/logo-blanco.svg" alt="Super Walter" width="200" height="30">
        <p><?= tr('Ingeniería argentina en agricultura de precisión. Más de 65 años fabricando sembradoras que aprovechan cada centímetro del lote.', 'Argentine engineering in precision agriculture. Over 65 years building seeders that make the most of every inch of the field.') ?></p>
        <div class="footer__social">
          <a href="https://www.instagram.com/superwaltersembradoras/" target="_blank" rel="noopener"
            aria-label="<?= tr('Instagram de Super Walter', 'Super Walter on Instagram') ?>"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor"
              stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
              <rect x="2" y="2" width="20" height="20" rx="5" />
              <circle cx="12" cy="12" r="4" />
              <circle cx="17.5" cy="6.5" r="1" fill="currentColor" stroke="none" /></svg></a>
          <a href="https://www.facebook.com/SuperWalter.Sembradoras/" target="_blank" rel="noopener"
            aria-label="<?= tr('Facebook de Super Walter', 'Super Walter on Facebook') ?>"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor"
              stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
              <path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z" /></svg></a>
          <a href="https://www.linkedin.com/company/bufalo-super-walter" target="_blank" rel="noopener"
            aria-label="<?= tr('LinkedIn de Super Walter', 'Super Walter on LinkedIn') ?>"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor"
              stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
              <path d="M16 8a6 6 0 0 1 6 6v7h-4v-7a2 2 0 0 0-4 0v7h-4v-7a6 6 0 0 1 6-6z" />
              <rect x="2" y="9" width="4" height="12" />
              <circle cx="4" cy="4" r="2" /></svg></a>
          <a href="https://www.youtube.com/channel/UCBz12j3n-OTac0brOHcMqPQ" target="_blank" rel="noopener"
            aria-label="<?= tr('YouTube de Super Walter', 'Super Walter on YouTube') ?>"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor"
              stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
              <path
                d="M22 8a3 3 0 0 0-2-2c-1.8-.5-9-.5-9-.5s-7.2 0-9 .5a3 3 0 0 0-2 2 31 31 0 0 0 0 8 3 3 0 0 0 2 2c1.8.5 9 .5 9 .5s7.2 0 9-.5a3 3 0 0 0 2-2 31 31 0 0 0 0-8z" />
              <path d="m10 15 5-3-5-3z" fill="currentColor" stroke="none" /></svg></a>
        </div>
      </div>

      <div class="footer__divider" aria-hidden="true"></div>

      <div class="footer__links">
        <nav class="footer__col" aria-label="<?= tr('Productos', 'Products') ?>">
          <h4><?= tr('Sembradoras', 'Seeders') ?></h4>
<?php if ($footerLineupHref !== null): ?>
          <a href="<?= htmlspecialchars($footerLineupHref, ENT_QUOTES, 'UTF-8') ?>">W1770 Triflex</a>
          <a href="<?= htmlspecialchars($footerLineupHref, ENT_QUOTES, 'UTF-8') ?>">W660</a>
          <a href="<?= htmlspecialchars($footerLineupHref, ENT_QUOTES, 'UTF-8') ?>">W650 Imperial</a>
          <a href="<?= htmlspecialchars($footerLineupHref, ENT_QUOTES, 'UTF-8') ?>"><?= tr('Familia W630 · W4500', 'W630 · W4500 Family') ?></a>
<?php else: ?>
          <a href="<?= sw_url('product', 'w1770-triflex') ?>">W1770 Triflex</a>
          <a href="<?= sw_url('product', 'w660') ?>">W660</a>
          <a href="<?= sw_url('product', 'w650-imperial') ?>">W650 Imperial</a>
          <a href="<?= sw_url('product', 'familia-w630-w4500-rastra-at') ?>"><?= tr('Familia W630 · W4500', 'W630 · W4500 Family') ?></a>
<?php endif; ?>
        </nav>
        <nav class="footer__col" aria-label="<?= tr('Compañía', 'Company') ?>">
          <h4><?= tr('Compañía', 'Company') ?></h4>
          <a href="<?= sw_url('company') ?>"><?= tr('Empresa', 'About us') ?></a>
          <a href="<?= sw_url('news') ?>"><?= tr('Novedades', 'News') ?></a>
          <a href="<?= sw_url('branches') ?>"><?= tr('Sucursales', 'Branches') ?></a>
          <a href="<?= $onHome ? '#service' : $homeUrl . '#service' ?>"><?= tr('Servicio y postventa', 'Service & after-sales') ?></a>
          <a href="<?= sw_url('careers') ?>"><?= tr('Trabajá con nosotros', 'Careers') ?></a>
          <a href="<?= sw_url('contact') ?>"><?= tr('Contacto', 'Contact') ?></a>
        </nav>
        <div class="footer__contact">
          <h4><?= tr('Contacto', 'Contact') ?></h4>
          <div class="row">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
              stroke-linejoin="round" aria-hidden="true">
              <path
                d="M22 16.9v3a2 2 0 0 1-2.2 2 19.8 19.8 0 0 1-8.6-3 19.5 19.5 0 0 1-6-6 19.8 19.8 0 0 1-3-8.7A2 2 0 0 1 4.1 2h3a2 2 0 0 1 2 1.7c.1 1 .4 1.9.7 2.8a2 2 0 0 1-.5 2.1L8.1 9.9a16 16 0 0 0 6 6l1.3-1.3a2 2 0 0 1 2.1-.4c.9.3 1.8.6 2.8.7a2 2 0 0 1 1.7 2z" />
              </svg>
            <span><b>+54 3471 471069</b><?= tr('Lun a Sáb · Atención técnica', 'Mon–Sat · Technical support') ?></span>
          </div>
          <div class="row">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
              stroke-linejoin="round" aria-hidden="true">
              <rect x="3" y="5" width="18" height="14" rx="2" />
              <path d="m3 7 9 6 9-6" /></svg>
            <a href="mailto:ventas@superwalter.com.ar"><b>ventas@superwalter.com.ar</b></a>
          </div>
          <div class="row">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
              stroke-linejoin="round" aria-hidden="true">
              <path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0z" />
              <circle cx="12" cy="10" r="3" /></svg>
            <span><b>Las Parejas, Santa Fe</b>Calle 10 Nº 490</span>
          </div>
        </div>
      </div>

      <div class="footer__bottom">
        <p>© <span id="year">2025</span> Super Walter — Búfalo S.A.</p>
        <p><?= tr('Ingeniería argentina · Agricultura de precisión', 'Argentine engineering · Precision agriculture') ?></p>
      </div>
    </div>
  </footer>

  <!-- Cursor gota (se activa solo en desktop con puntero fino) -->
  <div class="cursor" id="cursor" aria-hidden="true"><img src="<?= $b ?>assets/img/cursor.svg" alt=""></div>

  <!-- Botón flotante de WhatsApp (falta cargar el número) -->
  <a href="#" class="whatsapp-float" target="_blank" rel="noopener" aria-label="<?= tr('Escribinos por WhatsApp', 'Message us on WhatsApp') ?>">
    <svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
      <path d="M12 2a10 10 0 0 0-8.6 15.1L2 22l5.06-1.33A10 10 0 1 0 12 2Zm0 18.2a8.17 8.17 0 0 1-4.17-1.14l-.3-.18-3.1.81.83-3.02-.2-.31A8.2 8.2 0 1 1 12 20.2Zm4.53-6.13c-.25-.12-1.47-.72-1.7-.8-.23-.08-.4-.12-.56.13-.17.25-.65.8-.8.96-.15.17-.29.19-.54.06-.25-.12-1.06-.39-2.01-1.23-.74-.66-1.24-1.47-1.39-1.72-.14-.25-.02-.38.11-.51.11-.11.25-.29.37-.44.12-.15.16-.25.25-.42.08-.17.04-.31-.02-.44-.06-.12-.56-1.35-.77-1.85-.2-.48-.41-.42-.56-.43h-.48c-.17 0-.44.06-.67.31-.23.25-.87.85-.87 2.08 0 1.23.89 2.42 1.02 2.58.12.17 1.75 2.67 4.24 3.75.59.26 1.05.41 1.41.52.59.19 1.13.16 1.55.1.47-.07 1.47-.6 1.68-1.18.21-.58.21-1.08.15-1.18-.06-.1-.23-.16-.48-.28Z"/>
    </svg>
  </a>

  <script src="<?= $b ?>assets/js/main.js" defer></script>
<?= $footerScripts ?? '' ?>
</body>

</html>
