<?php
include 'db.php';

error_reporting(E_ALL);
ini_set('display_errors', 1);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $confipassword = $_POST['confipassword'];

    // Verifica se as senhas coincidem
    if ($password !== $confipassword) {
        echo "As senhas não coincidem.";
        exit;
    }

    // Verifica se o e-mail já está registrado
    $stmt = $conn->prepare("SELECT id FROM usuarios WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();
    if ($stmt->num_rows > 0) {
        echo "Este e-mail já está registrado.";
        $stmt->close();
        exit;
    }

    // Hash da senha
    $passwordHash = hash('sha256', $password);

    // Inserção dos dados
    $stmt = $conn->prepare("INSERT INTO usuarios (name1, email, password1) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $name, $email, $passwordHash);

    if ($stmt->execute()) {
        echo "Cadastro realizado com sucesso!";
    } else {
        echo "Erro: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>