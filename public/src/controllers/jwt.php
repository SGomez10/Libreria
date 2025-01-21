<?php
// Clave secreta para firmar el token
$secret_key = "mi_clave_secreta";

// Función para generar el JWT
function generarJWT($header, $payload, $secret_key) {
    // Codificar en Base64 URL el header y el payload
    $header_encoded = base64UrlEncode(json_encode($header));
    $payload_encoded = base64UrlEncode(json_encode($payload));
    
    // Crear la firma
    $signature = hash_hmac('sha256', "$header_encoded.$payload_encoded", $secret_key, true);
    $signature_encoded = base64UrlEncode($signature);
    
    // Combinar todos los elementos en el JWT
    return "$header_encoded.$payload_encoded.$signature_encoded";
}

// Función para verificar el JWT
function verificarJWT($jwt, $secret_key) {
    // Separar el token en sus tres partes
    list($header_encoded, $payload_encoded, $signature_encoded) = explode('.', $jwt);
    
    // Verificar la firma
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