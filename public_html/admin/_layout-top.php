<?php
declare(strict_types=1);
/** Requiere $pageTitle (string) definido antes de incluir. */
$pageTitle = $pageTitle ?? 'Panel admin · Super Walter';
?><!DOCTYPE html>
<html lang="es-AR">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="robots" content="noindex, nofollow">
<title><?= htmlspecialchars($pageTitle, ENT_QUOTES, 'UTF-8') ?></title>
<style>
  :root { --bordo:#7f1810; --texto:#1c1917; --texto-mute:#6b6560; --paper:#f7f4ef; --paper-2:#efe9df; --line:#e2dbcd; }
  * { box-sizing:border-box; }
  body { margin:0; font-family:-apple-system,Segoe UI,Roboto,Arial,sans-serif; color:var(--texto); background:var(--paper); }
  a { color:var(--bordo); }
  .bar { background:var(--texto); color:#fff; padding:.9rem 1.5rem; display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:.6rem; }
  .bar a { color:#fff; text-decoration:none; margin-right:1.2rem; font-weight:600; }
  .bar a:hover { text-decoration:underline; }
  .wrap { max-width:1100px; margin:0 auto; padding:2rem 1.5rem 4rem; }
  h1 { font-size:1.6rem; margin:0 0 1.5rem; }
  h2 { font-size:1.2rem; margin:2rem 0 .8rem; }
  table { width:100%; border-collapse:collapse; background:#fff; border:1px solid var(--line); }
  th, td { text-align:left; padding:.6rem .8rem; border-bottom:1px solid var(--line); font-size:.92rem; vertical-align:top; }
  th { background:var(--paper-2); }
  .btn { display:inline-block; background:var(--bordo); color:#fff; padding:.5rem 1rem; border-radius:6px; text-decoration:none; font-size:.9rem; border:none; cursor:pointer; font-weight:600; }
  .btn:hover { opacity:.9; }
  .btn--ghost { background:transparent; color:var(--bordo); border:1px solid var(--bordo); }
  .btn--danger { background:#9c2b20; }
  .actions { display:flex; gap:.5rem; flex-wrap:wrap; }
  .field { margin-bottom:1.1rem; }
  label { display:block; font-weight:600; font-size:.85rem; margin-bottom:.3rem; }
  input[type=text], input[type=date], input[type=password], input[type=file], select, textarea {
    width:100%; padding:.55rem .7rem; border:1px solid var(--line); border-radius:6px; font-size:.92rem; font-family:inherit; background:#fff;
  }
  textarea { min-height:6rem; font-family:ui-monospace,SFMono-Regular,Consolas,monospace; font-size:.85rem; }
  textarea.prose { font-family:inherit; min-height:9rem; }
  .hint { color:var(--texto-mute); font-size:.8rem; margin-top:.25rem; }
  .grid2 { display:grid; grid-template-columns:1fr 1fr; gap:1rem; }
  .checks label { display:inline-flex; align-items:center; gap:.4rem; font-weight:400; margin-right:1rem; }
  .flash { padding:.8rem 1rem; border-radius:6px; margin-bottom:1.2rem; font-size:.9rem; }
  .flash--ok { background:#e4f3e6; color:#215b2c; }
  .flash--error { background:#fbe4e1; color:#8a251b; }
  fieldset { border:1px solid var(--line); border-radius:8px; padding:1rem; margin:0 0 1.2rem; }
  legend { font-weight:700; padding:0 .4rem; }
  img.thumb { max-width:60px; max-height:60px; object-fit:cover; border-radius:4px; }
</style>
</head>
<body>
<div class="bar">
  <div><a href="index.php">Panel admin</a><a href="../index.php" target="_blank">Ver sitio ↗</a></div>
  <div><a href="logout.php">Cerrar sesión</a></div>
</div>
<div class="wrap">
