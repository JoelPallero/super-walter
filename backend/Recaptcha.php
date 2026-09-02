<?php
declare(strict_types=1);

namespace SuperWalter;

/**
 * Verifica un token de reCAPTCHA v3 contra la API de Google.
 * El umbral de score se configura en RECAPTCHA_SCORE_THRESHOLD (.env),
 * así se puede ajustar la sensibilidad sin tocar código.
 */
class Recaptcha
{
    private string $secretKey;
    private float $minScore;

    public function __construct(array $env)
    {
        $this->secretKey = $env['RECAPTCHA_SECRET_KEY'] ?? '';
        $this->minScore = isset($env['RECAPTCHA_SCORE_THRESHOLD']) && $env['RECAPTCHA_SCORE_THRESHOLD'] !== ''
            ? (float) $env['RECAPTCHA_SCORE_THRESHOLD']
            : 0.5;
    }

    /**
     * Devuelve true si el token es válido y el score alcanza el umbral.
     * Si no hay secret key configurada, deja pasar (para no romper el
     * formulario en entornos donde reCAPTCHA todavía no está dado de alta).
     */
    public function verify(string $token, string $expectedAction = ''): bool
    {
        if ($this->secretKey === '') {
            return true;
        }
        if ($token === '') {
            return false;
        }

        $ch = curl_init('https://www.google.com/recaptcha/api/siteverify');
        curl_setopt_array($ch, [
            CURLOPT_POST => true,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT => 10,
            CURLOPT_POSTFIELDS => http_build_query([
                'secret' => $this->secretKey,
                'response' => $token,
            ]),
        ]);
        $response = curl_exec($ch);
        curl_close($ch);

        if ($response === false) {
            return false;
        }

        $data = json_decode($response, true);
        if (!is_array($data) || empty($data['success'])) {
            return false;
        }
        if ($expectedAction !== '' && ($data['action'] ?? '') !== $expectedAction) {
            return false;
        }

        $score = isset($data['score']) ? (float) $data['score'] : 0.0;
        return $score >= $this->minScore;
    }
}
