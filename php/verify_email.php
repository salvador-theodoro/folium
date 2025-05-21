<?php
include 'db.php';

if (isset($_GET['hash'])) {
    $hash = $_GET['hash'];

    // Verifica se o hash existe e pega o status de verificação
    $stmt = $conn->prepare("SELECT verificado FROM usuarios WHERE hash1 = ?");
    $stmt->bind_param("s", $hash);
    $stmt->execute();
    $stmt->bind_result($verificado);

    if ($stmt->fetch()) {
        $stmt->close();

        if ($verificado == 1) {
            echo "Esse e-mail já foi verificado.";
        } else {
            // Atualiza o status para verificado
            $update = $conn->prepare("UPDATE usuarios SET verificado = 1 WHERE hash1 = ?");
            $update->bind_param("s", $hash);
            $update->execute();
            $update->close();

            echo "E-mail verificado com sucesso! Agora você pode fazer login.";
        }
    } else {
        echo "Hash não encontrado.";
    }
} else {
    echo "Hash não fornecido.";
}

$conn->close();