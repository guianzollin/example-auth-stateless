<?php
require 'db.php';
require 'vendor/autoload.php'; // Autoload do JWT

use \Firebase\JWT\JWT;

$key = "chave_secreta"; // Chave secreta
$issuer = "http://localhost"; // Servidor emissor

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $email = $_POST['email'];
    $password = $_POST['password'];

    // Verificar credenciais do usuário
    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email");
    $stmt->bindParam(':email', $email);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {
        // Dados para o token JWT
        $payload = [
            'iss' => $issuer,
            'iat' => time(),
            'exp' => time() + 3600, // Expira em 1 hora
            'userId' => $user['id'],
            'email' => $user['email']
        ];

        // Gerar token JWT
        $jwt = JWT::encode($payload, $key, 'HS256');

        // Retornar token JWT
        echo json_encode([
            'message' => 'Login realizado com sucesso!',
            'token' => $jwt
        ]);
    } else {
        // Credenciais inválidas
        echo json_encode(['message' => 'Credenciais inválidas']);
    }
}
?>
