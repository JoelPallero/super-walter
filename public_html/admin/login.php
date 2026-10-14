<?php
declare(strict_types=1);

require __DIR__ . '/_bootstrap.php';

if (sw_admin_is_logged_in()) {
    header('Location: index.php');
    exit;
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!sw_admin_csrf_check()) {
        $error = 'Sesión expirada, probá de nuevo.';
    } else {
        $user = trim((string) ($_POST['user'] ?? ''));
        $pass = (string) ($_POST['pass'] ?? '');
        $ok = false;
        $configured = true;

        if (\SuperWalter\Database::enabled()) {
            $st = \SuperWalter\Database::pdo()->prepare('SELECT id, password_hash FROM usuarios WHERE usuario = ? AND activo = 1');
            $st->execute([$user]);
            $row = $st->fetch();
            // Se verifica siempre contra un hash (aunque el usuario no exista) para no revelar usuarios por tiempo de respuesta.
            $ok = password_verify($pass, $row['password_hash'] ?? '$2y$12$invalidinvalidinvalidinvalidinvalidinvalidinvalidinvalid') && $row;
            if ($ok) {
                \SuperWalter\Database::pdo()->prepare('UPDATE usuarios SET ultimo_acceso = NOW() WHERE id = ?')->execute([$row['id']]);
            }
        } else {
            $expectedUser = sw_env('ADMIN_USER');
            $expectedHash = sw_env('ADMIN_PASSWORD_HASH');
            $configured = $expectedUser !== '' && $expectedHash !== '';
            $ok = $configured && hash_equals($expectedUser, $user) && password_verify($pass, $expectedHash);
        }

        if (!$configured) {
            $error = 'El panel admin no está configurado (falta ADMIN_USER / ADMIN_PASSWORD_HASH en el .env).';
        } elseif ($ok) {
            session_regenerate_id(true);
            $_SESSION['admin'] = true;
            header('Location: index.php');
            exit;
        } else {
            sleep(1);
            $error = 'Usuario o contraseña incorrectos.';
        }
    }
}

$pageTitle = 'Iniciar sesión · Panel admin';
?><!DOCTYPE html>
<html lang="es-AR">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="robots" content="noindex, nofollow">
<title><?= htmlspecialchars($pageTitle, ENT_QUOTES, 'UTF-8') ?></title>
<style>
  body { margin:0; min-height:100vh; display:flex; align-items:center; justify-content:center; background:#1c1917; font-family:-apple-system,Segoe UI,Roboto,Arial,sans-serif; }
  form { background:#fff; padding:2rem; border-radius:10px; width:100%; max-width:340px; }
  h1 { font-size:1.2rem; margin:0 0 1.2rem; }
  label { display:block; font-weight:600; font-size:.85rem; margin:.8rem 0 .3rem; }
  input { width:100%; padding:.6rem .7rem; border:1px solid #ddd; border-radius:6px; font-size:.95rem; box-sizing:border-box; }
  button { width:100%; margin-top:1.4rem; background:#7f1810; color:#fff; border:none; padding:.7rem; border-radius:6px; font-weight:600; cursor:pointer; }
  .error { background:#fbe4e1; color:#8a251b; padding:.6rem .8rem; border-radius:6px; font-size:.85rem; margin-bottom:1rem; }
</style>
</head>
<body>
<form method="post" novalidate>
  <h1>Panel admin · Super Walter</h1>
<?php if ($error !== ''): ?>
  <p class="error"><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?></p>
<?php endif; ?>
  <?= sw_admin_csrf_field() ?>
  <label for="user">Usuario</label>
  <input type="text" id="user" name="user" autocomplete="username" required autofocus>
  <label for="pass">Contraseña</label>
  <input type="password" id="pass" name="pass" autocomplete="current-password" required>
  <button type="submit">Ingresar</button>
</form>
</body>
</html>
