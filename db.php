<?php
$host = 'localhost';  // Geralmente 'localhost'
$db = 'example_auth_stateless';
$user = 'root';  // O usuário do seu banco de dados
$pass = '';  // Senha do seu banco de dados (se houver)

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}
?>
