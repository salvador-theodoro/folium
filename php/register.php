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

            echo <<<HTML
            <!DOCTYPE html>
            <html lang="pt-BR">
            <head>
            <meta charset="UTF-8" />
            <title>Registro concluído</title>
            <style>
                /* Pop-up overlay e container */
                .popup-overlay {
                position: fixed;
                top: 0; left: 0; width: 100%; height: 100%;
                background: rgba(0, 0, 0, 0.6);
                display: flex;
                justify-content: center;
                align-items: center;
                z-index: 2000;
                font-family: "Ligconsolata", sans-serif;
                font-weight: bold;
                }

                /* Caixa do pop-up */
                .popup {
                background-color: #f7f7f7; /* igual header */
                padding: 30px 40px;
                border-radius: 30px;
                box-shadow: 0 0 20px #00000055;
                max-width: 400px;
                width: 90%;
                text-align: center;
                color: #000000;
                }

                /* Título */
                .popup h2 {
                margin-top: 0;
                font-size: 28px;
                margin-bottom: 15px;
                }

                /* Texto */
                .popup p {
                font-size: 16px;
                margin-bottom: 25px;
                }

                /* Botão */
                .popup button {
                background-color: #8752D2; /* sua cor roxa */
                border: none;
                border-radius: 50px;
                padding: 12px 25px;
                color: white;
                font-weight: bold;
                font-size: 16px;
                cursor: pointer;
                transition: background-color 0.3s ease;
                font-family: "Ligconsolata", sans-serif;
                }

                .popup button:hover {
                background-color: #6b3bb8; /* roxo mais escuro */
                }

            </style>
            </head>
            <body>
            <div class="popup-overlay">
                <div class="popup">
                <h2>Registro concluído</h2>
                <p>O código foi enviado para seu e-mail. Verifique para ativar sua conta.</p>
                <button onclick="window.location.href='../index.html'">Ir para Login</button>
                </div>
            </div>
            </body>
            </html>
            HTML;
exit;

        $stmt->close();

    } catch (Exception $e) {
        echo "Erro ao enviar o e-mail: {$mail->ErrorInfo}";
    }

    $conn->close();
}
?>

?>
