<?php
declare(strict_types=1);

header('Content-Type: application/json; charset=utf-8');
require __DIR__ . '/_bootstrap.php';

use SuperWalter\GmailMailer;

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

$nombre = trim($_POST['nombre'] ?? '');
$telefono = trim($_POST['telefono'] ?? '');
$email = trim($_POST['email'] ?? '');
$localidad = trim($_POST['localidad'] ?? '');
$area = trim($_POST['area'] ?? '');
$mensaje = trim($_POST['mensaje'] ?? '');

if ($nombre === '' || $telefono === '' || $email === '' || $localidad === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    http_response_code(422);
    echo json_encode(['ok' => false, 'error' => 'Faltan datos obligatorios o el email no es válido.']);
    exit;
}

if (empty($_FILES['cv']) || $_FILES['cv']['error'] !== UPLOAD_ERR_OK) {
    http_response_code(422);
    echo json_encode(['ok' => false, 'error' => 'Adjuntá tu CV.']);
    exit;
}

$originalName = $_FILES['cv']['name'];
$ext = strtolower(pathinfo($originalName, PATHINFO_EXTENSION));
$maxSize = 5 * 1024 * 1024;

if (!in_array($ext, ['pdf', 'doc', 'docx'], true)) {
    http_response_code(422);
    echo json_encode(['ok' => false, 'error' => 'El CV debe ser PDF, DOC o DOCX.']);
    exit;
}
if ($_FILES['cv']['size'] > $maxSize) {
    http_response_code(422);
    echo json_encode(['ok' => false, 'error' => 'El CV supera los 5 MB.']);
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
    echo json_encode(['ok' => false, 'error' => 'No pudimos enviar tu postulación. Probá de nuevo en unos minutos.']);
}
