<?php
session_start();
require_once 'db.php'; // aqui tem o $conn MySQLi

if (!isset($_SESSION['user_id'])) {
    http_response_code(403);
    exit('Acesso negado.');
}

$id_usuario = $_SESSION['user_id'];

$descricao = $_POST['descricao'] ?? '';
$instagram = $_POST['instagram'] ?? '';
$linkedin = $_POST['linkedin'] ?? '';
$github = $_POST['github'] ?? '';

$imagem_perfil = null;
$banner_fundo = null;

if (isset($_FILES['imagem_perfil']) && $_FILES['imagem_perfil']['error'] === UPLOAD_ERR_OK) {
    $imagem_perfil = file_get_contents($_FILES['imagem_perfil']['tmp_name']);
}

if (isset($_FILES['banner_fundo']) && $_FILES['banner_fundo']['error'] === UPLOAD_ERR_OK) {
    $banner_fundo = file_get_contents($_FILES['banner_fundo']['tmp_name']);
}

// Verifica se já existe perfil
$stmt = $conn->prepare("SELECT id FROM perfis WHERE id_usuario = ?");
$stmt->bind_param("i", $id_usuario);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows > 0) {
    // Atualiza
    $stmt->close();

    // Monta query com campos que vão ser atualizados
    $sql = "UPDATE perfis SET descricao = ?, instagram = ?, linkedin = ?, github = ?";
    $types = "ssss";
    $params = [$descricao, $instagram, $linkedin, $github];

    if ($imagem_perfil !== null) {
        $sql .= ", imagem_perfil = ?";
        $types .= "b";
        $params[] = $imagem_perfil;
    }

    if ($banner_fundo !== null) {
        $sql .= ", banner_fundo = ?";
        $types .= "b";
        $params[] = $banner_fundo;
    }

    $sql .= " WHERE id_usuario = ?";
    $types .= "i";
    $params[] = $id_usuario;

    $stmt = $conn->prepare($sql);

    // bind_param com blobs precisa usar referência e send_long_data
    $bind_names[] = $types;
    for ($i = 0; $i < count($params); $i++) {
        $bind_name = "bind" . $i;
        $$bind_name = $params[$i];
        $bind_names[] = &$$bind_name;
    }

    call_user_func_array([$stmt, 'bind_param'], $bind_names);

    // Envia dados blobs
    $pos = 0;
    foreach (str_split($types) as $key => $t) {
        if ($t === 'b') {
            $stmt->send_long_data($key, $params[$key]);
        }
    }

    $stmt->execute();

} else {
    // Insere novo registro
    $stmt->close();
    $sql = "INSERT INTO perfis (id_usuario, descricao, instagram, linkedin, github, imagem_perfil, banner_fundo) VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);

    // Para o bind_param, define tipos. 'b' para blobs e outros para strings/int
    // O "b" funciona para blobs, mas deve usar send_long_data para enviar os dados
    $stmt->bind_param("issssbb", $id_usuario, $descricao, $instagram, $linkedin, $github, $dummy1, $dummy2);

    // dummy placeholders para blobs
    $dummy1 = null;
    $dummy2 = null;

    // Executa bind com placeholders
    // Depois envia dados blob
    $stmt->send_long_data(5, $imagem_perfil ?? "");
    $stmt->send_long_data(6, $banner_fundo ?? "");

    $stmt->execute();
}

if ($stmt->error) {
    http_response_code(500);
    echo "Erro ao salvar perfil: " . $stmt->error;
} else {
    // Redireciona para a página de perfil do usuário logado
    header("Location: ../profile-page.php?id=" . $id_usuario);
    exit;
}

$stmt->close();
$conn->close();

?>
