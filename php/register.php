<?php
include 'db.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../vendor/autoload.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confipassword = $_POST['confipassword'];
    $name = $_POST['name'];

    if ($password !== $confipassword) {
        die('As senhas não coincidem.');
    }

    $passwordHash = hash('sha256', $password);

    $check = $conn->prepare("SELECT id FROM usuarios WHERE email = ?");
    $check->bind_param("s", $email);
    $check->execute();
    $check->store_result();

    if ($check->num_rows > 0) {
        echo "Esse e-mail já está registrado.";
        exit();
    }

    $hash = sprintf('%07X', mt_rand(0,0xFFFFFFF));

    $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'folium.tcc@gmail.com';
        $mail->Password = 'itfo gpau zjvo lwcw';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        $mail->setFrom('folium.tcc@gmail.com', 'Folium');
        $mail->addAddress($email);

        $mail->isHTML(true);
        $mail->Subject = 'Verifique seu e-mail para confirmar sua conta';
        $mail->Body = "Olá, $name! Clique no link abaixo para verificar seu e-mail e ativar sua conta:<br>
        <a href='http://localhost/folium/php/verify_email.php?hash=$hash'>Clique aqui para verificar seu e-mail</a>";

        $mail->send();

        // Insere o usuário
        $stmt = $conn->prepare("INSERT INTO usuarios (email, password1, name1, verificado, hash1) VALUES (?, ?, ?, 0, ?)");
        $stmt->bind_param("ssss", $email, $passwordHash, $name, $hash);
        $stmt->execute();

        // Pega o ID do novo usuário
        $novo_id = $stmt->insert_id;

        // Cria perfil vazio para o novo usuário
        $stmt2 = $conn->prepare("INSERT INTO perfis (id_usuario) VALUES (?)");
        $stmt2->bind_param("i", $novo_id);
        $stmt2->execute();
        $stmt2->close();

        echo 'O e-mail de verificação foi enviado para ' . $email;

        $stmt->close();

    } catch (Exception $e) {
        echo "Erro ao enviar o e-mail: {$mail->ErrorInfo}";
    }

    $conn->close();
}
?>
