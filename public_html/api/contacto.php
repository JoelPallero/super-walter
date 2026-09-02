<?php
declare(strict_types=1);

header('Content-Type: application/json; charset=utf-8');
require __DIR__ . '/_bootstrap.php';

use SuperWalter\GmailMailer;
use SuperWalter\Recaptcha;

function sw_h(string $s): string
{
    return htmlspecialchars($s, ENT_QUOTES, 'UTF-8');
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['ok' => false, 'error' => 'Método no permitido.']);
    exit;
}

// Honeypot anti-spam: si un bot completa este campo oculto, fingimos éxito.
if (!empty($_POST['website'])) {
    echo json_encode(['ok' => true]);
    exit;
}

$recaptcha = new Recaptcha($GLOBALS['sw_env']);
if (!$recaptcha->verify(trim($_POST['recaptcha_token'] ?? ''), 'contacto')) {
    http_response_code(422);
    echo json_encode(['ok' => false, 'error' => 'No pudimos validar el formulario. Recargá la página y probá de nuevo.']);
    exit;
}

$nombre = trim($_POST['nombre'] ?? '');
$telefono = trim($_POST['telefono'] ?? '');
$email = trim($_POST['email'] ?? '');
$zona = trim($_POST['zona'] ?? '');
$motivo = trim($_POST['motivo'] ?? $_POST['modelo'] ?? '');
$mensaje = trim($_POST['mensaje'] ?? '');

if ($nombre === '' || $telefono === '' || $email === '' || $zona === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    http_response_code(422);
    echo json_encode(['ok' => false, 'error' => 'Faltan datos obligatorios o el email no es válido.']);
    exit;
}

$html = '<h2>Nueva consulta desde superwalter.com.ar</h2>'
    . '<p><b>Nombre:</b> ' . sw_h($nombre) . '</p>'
    . '<p><b>Teléfono:</b> ' . sw_h($telefono) . '</p>'
    . '<p><b>Email:</b> ' . sw_h($email) . '</p>'
    . '<p><b>Localidad/Provincia:</b> ' . sw_h($zona) . '</p>'
    . '<p><b>Interés / motivo:</b> ' . sw_h($motivo) . '</p>'
    . '<p><b>Mensaje:</b><br>' . nl2br(sw_h($mensaje)) . '</p>';

try {
    $mailer = new GmailMailer($GLOBALS['sw_env']);
    $mailer->send(sw_env('MAIL_TO', 'ventas@superwalter.com.ar'), 'Nueva consulta — ' . $nombre, $html, $email);
    echo json_encode(['ok' => true]);
} catch (\Throwable $e) {
    error_log('[contacto] ' . $e->getMessage());
    http_response_code(500);
    echo json_encode(['ok' => false, 'error' => 'No pudimos enviar tu consulta. Probá de nuevo en unos minutos.']);
}
