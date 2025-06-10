<?php
include 'db.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = hash('sha256', $_POST['password']);

    // Preparar a consulta para evitar SQL Injection
    $stmt = $conn->prepare("SELECT id, name1 FROM usuarios WHERE email = ? AND password1 = ? AND verificado = 1");
    $stmt->bind_param("ss", $email, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Usuário encontrado, salva dados na sessão
        $user = $result->fetch_assoc();

        $_SESSION['user_id'] = $user['id'];      // Guarda o ID do usuário
        $_SESSION['user_nome'] = $user['name1']; // Guarda o nome do usuário

        // Redireciona para a home após login
        header("Location: ../home.php");
        exit();
    } else {
        // Login inválido, pode ser melhor exibir mensagem em outra página ou com JS
        echo "Email ou senha incorretos.";
    }
} else {

    exit();
}
