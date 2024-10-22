<?php
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    if (empty($email) || empty($password)) {
        echo json_encode(['message' => 'Todos os campos são obrigatórios.']);
        exit();
    }

    // Verifica se o usuário já existe
    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email");
    $stmt->bindParam(':email', $email);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        echo json_encode(['message' => 'E-mail já cadastrado.']);
        exit();
    }

    // Hash da senha
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Inserir novo usuário no banco de dados
    $stmt = $pdo->prepare("INSERT INTO users (email, password) VALUES (:email, :password)");
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':password', $hashed_password);

    if ($stmt->execute()) {
        echo json_encode(['message' => 'Usuário registrado com sucesso!']);
    } else {
        echo json_encode(['message' => 'Erro ao registrar usuário.']);
    }
}
?>
