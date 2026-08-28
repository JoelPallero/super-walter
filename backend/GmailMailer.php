<?php
declare(strict_types=1);

namespace SuperWalter;

/**
 * Envía mails como marketing@superwalter.com.ar usando el refresh_token
 * de Gmail (OAuth) ya autorizado por WP Mail SMTP. No requiere SMTP
 * usuario/contraseña ni librerías externas: habla directo con la API
 * REST de Google vía curl.
 */
class GmailMailer
{
    private string $clientId;
    private string $clientSecret;
    private string $refreshToken;
    private string $fromEmail;
    private string $fromName;

    public function __construct(array $env)
    {
        $this->clientId = $env['GOOGLE_CLIENT_ID'] ?? '';
        $this->clientSecret = $env['GOOGLE_CLIENT_SECRET'] ?? '';
        $this->refreshToken = $env['GOOGLE_REFRESH_TOKEN'] ?? '';
        $this->fromEmail = $env['MAIL_FROM'] ?? '';
        $this->fromName = $env['NAME_FROM'] ?? '';

        if ($this->clientId === '' || $this->clientSecret === '' || $this->refreshToken === '' || $this->fromEmail === '') {
            throw new \RuntimeException('Faltan credenciales de Gmail en el .env');
        }
    }

    private function getAccessToken(): string
    {
        $ch = curl_init('https://oauth2.googleapis.com/token');
        curl_setopt_array($ch, [
            CURLOPT_POST => true,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT => 15,
            CURLOPT_POSTFIELDS => http_build_query([
                'client_id' => $this->clientId,
                'client_secret' => $this->clientSecret,
                'refresh_token' => $this->refreshToken,
                'grant_type' => 'refresh_token',
            ]),
        ]);
        $response = curl_exec($ch);
        $curlError = curl_error($ch);
        curl_close($ch);

        if ($response === false) {
            throw new \RuntimeException('No se pudo conectar con Google: ' . $curlError);
        }

        $data = json_decode($response, true);
        if (!is_array($data) || empty($data['access_token'])) {
            throw new \RuntimeException('No se pudo renovar el token de Gmail: ' . $response);
        }

        return $data['access_token'];
    }

    /**
     * @param array<int, array{name:string, type:string, content:string}> $attachments
     */
    public function send(string $to, string $subject, string $htmlBody, string $replyTo = '', array $attachments = []): void
    {
        $accessToken = $this->getAccessToken();
        $boundary = 'sw_' . bin2hex(random_bytes(16));

        $headers = [];
        $headers[] = 'From: ' . $this->encodeHeader($this->fromName) . ' <' . $this->fromEmail . '>';
        $headers[] = 'To: ' . $to;
        if ($replyTo !== '') {
            $headers[] = 'Reply-To: ' . $replyTo;
        }
        $headers[] = 'Subject: ' . $this->encodeHeader($subject);
        $headers[] = 'MIME-Version: 1.0';
        $headers[] = 'Content-Type: multipart/mixed; boundary="' . $boundary . '"';

        $body = "--{$boundary}\r\n";
        $body .= "Content-Type: text/html; charset=UTF-8\r\n";
        $body .= "Content-Transfer-Encoding: 8bit\r\n\r\n";
        $body .= $htmlBody . "\r\n";

        foreach ($attachments as $att) {
            $body .= "--{$boundary}\r\n";
            $body .= 'Content-Type: ' . $att['type'] . '; name="' . $att['name'] . "\"\r\n";
            $body .= "Content-Transfer-Encoding: base64\r\n";
            $body .= 'Content-Disposition: attachment; filename="' . $att['name'] . "\"\r\n\r\n";
            $body .= chunk_split(base64_encode($att['content']));
        }
        $body .= "--{$boundary}--";

        $raw = implode("\r\n", $headers) . "\r\n\r\n" . $body;
        $rawEncoded = rtrim(strtr(base64_encode($raw), '+/', '-_'), '=');

        $ch = curl_init('https://gmail.googleapis.com/gmail/v1/users/me/messages/send');
        curl_setopt_array($ch, [
            CURLOPT_POST => true,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT => 20,
            CURLOPT_HTTPHEADER => [
                'Authorization: Bearer ' . $accessToken,
                'Content-Type: application/json',
            ],
            CURLOPT_POSTFIELDS => json_encode(['raw' => $rawEncoded]),
        ]);
        $response = curl_exec($ch);
        $status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $curlError = curl_error($ch);
        curl_close($ch);

        if ($response === false) {
            throw new \RuntimeException('No se pudo conectar con Gmail: ' . $curlError);
        }
        if ($status < 200 || $status >= 300) {
            throw new \RuntimeException("Gmail API respondió {$status}: {$response}");
        }
    }

    private function encodeHeader(string $value): string
    {
        return '=?UTF-8?B?' . base64_encode($value) . '?=';
    }
}
