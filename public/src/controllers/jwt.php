<?php
// filepath: /var/www/libreria.local/public/src/controllers/jwt.php

$secret_key = 'your_secret_key'; // Cambia esto por tu clave secreta

// Función para generar el JWT
function generarJWT($header, $payload, $secret_key) {
    $header_encoded = base64UrlEncode(json_encode($header));
    $payload_encoded = base64UrlEncode(json_encode($payload));
    
    $signature = hash_hmac('sha256', "$header_encoded.$payload_encoded", $secret_key, true);
    $signature_encoded = base64UrlEncode($signature);
    
    return "$header_encoded.$payload_encoded.$signature_encoded";
}

// Función para verificar el JWT
function verificarJWT($jwt, $secret_key) {
    list($header_encoded, $payload_encoded, $signature_encoded) = explode('.', $jwt);
    
    $signature = base64UrlEncode(hash_hmac('sha256', "$header_encoded.$payload_encoded", $secret_key, true));
    
    return ($signature === $signature_encoded);
}

// Función auxiliar para codificar en Base64 URL seguro
function base64UrlEncode($data) {
    return str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($data));
}

// Datos para el JWT
$header = [
    'alg' => 'HS256',
    'typ' => 'JWT'
];

$payload = [
    'user_id' => 123,
    'username' => 'usuario123',
    'exp' => time() + 3600 // Expira en 1 hora
];

// Generar el JWT
$jwt = generarJWT($header, $payload, $secret_key);
echo "JWT generado: " . $jwt . "\n";

// Verificar el JWT
if (verificarJWT($jwt, $secret_key)) {
    echo "JWT válido\n";
} else {
    echo "JWT inválido\n";
}
?>