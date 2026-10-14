<?php
declare(strict_types=1);

header('Content-Type: application/json; charset=utf-8');
require __DIR__ . '/_bootstrap.php';

use SuperWalter\GmailMailer;
use SuperWalter\Recaptcha;

function sw_msg(string $es, string $en): string
{
    return (($_POST['lang'] ?? '') === 'en') ? $en : $es;
}

function sw_h(string $s): string
{
    return htmlspecialchars($s, ENT_QUOTES, 'UTF-8');
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['ok' => false, 'error' => sw_msg('Método no permitido.', 'Method not allowed.')]);
    exit;
}

// Honeypot anti-spam: si un bot completa este campo oculto, fingimos éxito.
if (!empty($_POST['website'])) {
    echo json_encode(['ok' => true]);
    exit;
}

$recaptcha = new Recaptcha($GLOBALS['sw_env']);
if (!$recaptcha->verify(trim($_POST['recaptcha_token'] ?? ''), 'trabajo')) {
    http_response_code(422);
    echo json_encode(['ok' => false, 'error' => sw_msg('No pudimos validar el formulario. Recargá la página y probá de nuevo.', 'We could not validate the form. Reload the page and try again.')]);
    exit;
}

$nombre = trim($_POST['nombre'] ?? '');
$telefono = trim($_POST['telefono'] ?? '');
$email = trim($_POST['email'] ?? '');
$localidad = trim($_POST['localidad'] ?? '');
$area = trim($_POST['area'] ?? '');
$mensaje = trim($_POST['mensaje'] ?? '');

if ($nombre === '' || $telefono === '' || $email === '' || $localidad === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    http_response_code(422);
    echo json_encode(['ok' => false, 'error' => sw_msg('Faltan datos obligatorios o el email no es válido.', 'Required fields are missing or the email is not valid.')]);
    exit;
}

if (empty($_FILES['cv']) || $_FILES['cv']['error'] !== UPLOAD_ERR_OK) {
    http_response_code(422);
    echo json_encode(['ok' => false, 'error' => sw_msg('Adjuntá tu CV.', 'Please attach your CV.')]);
    exit;
}

$originalName = $_FILES['cv']['name'];
$ext = strtolower(pathinfo($originalName, PATHINFO_EXTENSION));
$maxSize = 5 * 1024 * 1024;

if (!in_array($ext, ['pdf', 'doc', 'docx'], true)) {
    http_response_code(422);
    echo json_encode(['ok' => false, 'error' => sw_msg('El CV debe ser PDF, DOC o DOCX.', 'The CV must be a PDF, DOC or DOCX file.')]);
    exit;
}
if ($_FILES['cv']['size'] > $maxSize) {
    http_response_code(422);
    echo json_encode(['ok' => false, 'error' => sw_msg('El CV supera los 5 MB.', 'The CV exceeds 5 MB.')]);
    exit;
}

$mimeByExt = [
    'pdf' => 'application/pdf',
    'doc' => 'application/msword',
    'docx' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
];

$attachments = [[
    'name' => basename($originalName),
    'type' => $mimeByExt[$ext],
    'content' => file_get_contents($_FILES['cv']['tmp_name']),
]];

$html = '<h2>Nueva postulación desde superwalter.com.ar</h2>'
    . '<p><b>Nombre:</b> ' . sw_h($nombre) . '</p>'
    . '<p><b>Teléfono:</b> ' . sw_h($telefono) . '</p>'
    . '<p><b>Email:</b> ' . sw_h($email) . '</p>'
    . '<p><b>Localidad:</b> ' . sw_h($localidad) . '</p>'
    . '<p><b>Área de interés:</b> ' . sw_h($area) . '</p>'
    . '<p><b>Mensaje:</b><br>' . nl2br(sw_h($mensaje)) . '</p>';

try {
    $mailer = new GmailMailer($GLOBALS['sw_env']);
    $mailer->send(sw_env('MAIL_TO_RRHH', 'rrhh@superwalter.com.ar'), 'Nueva postulación — ' . $nombre, $html, $email, $attachments);
    echo json_encode(['ok' => true]);
} catch (\Throwable $e) {
    error_log('[trabajo] ' . $e->getMessage());
    http_response_code(500);
    echo json_encode(['ok' => false, 'error' => sw_msg('No pudimos enviar tu postulación. Probá de nuevo en unos minutos.', 'We could not send your application. Please try again in a few minutes.')]);
}
