<?php
require 'vendor/autoload.php';
use \Firebase\JWT\JWT;
use \Firebase\JWT\Key;

$key = "chave_secreta"; // Chave secreta usada para assinar o token

$headers = getallheaders();
$authHeader = $headers['Authorization'] ?? '';

if ($authHeader) {
    list($jwt) = sscanf($authHeader, 'Bearer %s');

    if ($jwt) {
        try {
            // Verificar o token JWT
            $decoded = JWT::decode($jwt, new Key($key, 'HS256'));

            // Retornar dados do usuário
            echo json_encode([
                'message' => 'Acesso autorizado.',
                'userId' => $decoded->userId,
                'email' => $decoded->email
            ]);
        } catch (Exception $e) {
            http_response_code(401);
            echo json_encode(['message' => 'Token inválido ou expirado.']);
        }
    } else {
        http_response_code(400);
        echo json_encode(['message' => 'Token não encontrado.']);
    }
} else {
    http_response_code(400);
    echo json_encode(['message' => 'Cabeçalho Authorization ausente.']);
}
?>
