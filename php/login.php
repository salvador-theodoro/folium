<?php
include 'db.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = hash('sha256', $_POST['password']);

    $stmt = $conn->prepare("SELECT id, name1 FROM usuarios WHERE email = ? AND password1 = ?");
    $stmt->bind_param("ss", $email, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_nome'] = $user['name1'];
       
        header("Location: ../index.php");
        exit();
    } else {
        echo "Email ou senha incorretos.";
    }

    $stmt->close();
    $conn->close();
}