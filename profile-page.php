<?php
session_start();
require 'php/db.php'; // conexão $conn

// Verifica se o usuário está logado
if (!isset($_GET['id']) && !isset($_SESSION['user_id'])) {
    header("Location: home.php");
    exit;
}

// Pega o ID do perfil da URL, ou usa o logado
$perfil_id = isset($_GET['id']) ? intval($_GET['id']) : (isset($_SESSION['user_id']) ? $_SESSION['user_id'] : 0);

$usuario_logado = $_SESSION['user_id'] ?? null;
$eh_dono = $usuario_logado == $perfil_id;



// Exibir imagem direto do banco
if (isset($_GET['exibir_imagem']) && isset($_GET['id']) && isset($_GET['type'])) {
    $id = intval($_GET['id']);
    $type = $_GET['type'] === 'banner' ? 'banner_fundo' : 'imagem_perfil';

    $stmt = $conn->prepare("SELECT $type FROM perfis WHERE id_usuario = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->bind_result($imagem_binaria);
    $stmt->fetch();
    $stmt->close();

    if ($imagem_binaria) {
        $finfo = new finfo(FILEINFO_MIME_TYPE);
        $mimeType = $finfo->buffer($imagem_binaria);
        header("Content-Type: $mimeType");
        echo $imagem_binaria;
    } else {
        http_response_code(404);
        echo "Imagem não encontrada.";
    }
    exit;
}

// Buscar dados do perfil
$stmt = $conn->prepare("SELECT perfis.*, usuarios.name1 FROM perfis JOIN usuarios ON perfis.id_usuario = usuarios.id WHERE id_usuario = ?");
$stmt->bind_param("i", $perfil_id);
$stmt->execute();
$result = $stmt->get_result();
$perfil = $result->fetch_assoc();

if (!$perfil) {
    echo "Perfil não encontrado.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Perfil de <?= htmlspecialchars($perfil['name1']); ?></title>
  <link rel="stylesheet" href="./src/css/global-styles.css">
  <link rel="stylesheet" href="./src/css/standard-header.css">
  <link rel="stylesheet" href="./src/css/profile-page-styles.css">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body>
  <header>
        <div class="header-content">
            <div class="header-left-side">
                <div class="home-button">
                    <a href="home.php">
                        <img src="./src/img/icons/logo1.png" alt="" class="home-button-icon" height="60px">
                    </a>
                </div>
                <div class="search-bar">
                    <img src="./src/img/icons/lupa.png" class="search-icon" alt="Lupa">
                    <input type="text" placeholder="Pesquisar">
                </div>
            </div>
            <div class="header-right-side">
                <!--BOTÃO AJUDA-->
                <div class="help-button def-btn">
                    <a href="help.html">
                    <button id="help-button"><span class="fa-solid fa-question"></span></button>
                    </a>
                </div>
                <!--BOTÃO CONFIG-->
                <div class="config-button def-btn">
                    <a href="config.html">
                        <button id="config-button"><span class="fa-solid fa-gear"></span></button>
                    </a>
                </div>
                <!--BOTÃO NOTIFICAÇÕES-->
                <div class="notification-button def-btn">
                    <a href="notification.html">
                        <button id="notification-button"><span class="fa-regular fa-bell"></span></button>
                    </a>
                </div>
                <!--BOTÃO PERFIL-->
                <div class="profile-button def-btn">
                        <button id="profile-button"><span class="fa-solid fa-user"></span></button>
                </div>
                <!--BOTÃO NOVO PROJETO-->
                <div class="new-project-button">
                    <a href="new-project-page.html"><span class="fa-solid fa-plus"></span></a>
                </div>
            </div>
        </div>
    </header>
    <!--MENU DROPDOWN-->
    <section class="dropdown-menu-section">
        <div class="dropdown-menu hidden" id="notification-dropdown-menu">
            oii oque isso aqui faz?
        </div>
        <div class="dropdown-menu hidden" id="profile-dropdown-menu">
            <ul>
                <?php if (isset($_SESSION['user_nome'])): ?>
                    <li id="user-name">
                        <a href="profile-page.php?id=<?php echo $_SESSION['user_id']; ?>">
                        <li id="user-name"><strong><?php echo htmlspecialchars($_SESSION['user_nome']); ?></strong></li>
                        </a>
                    </li>
                    <li><a href="php/logout.php">Sair</a></li>
                <?php else: ?>
                    <li><a href="register-page.html">Registrar</a></li>
                    <li><a href="index.html">Entrar</a></li>
                <?php endif; ?>
            </ul>
        </div>
    </section>

  <!-- Editar Perfil -->

  <?php if (isset($_SESSION['user_id']) && $_SESSION['user_id'] == $perfil['id_usuario']): ?>
  <div class="edit-profile-btn">
    <button onclick="abrirPopup()">Editar Perfil</button>
  </div>
  <div id="popup-editar-perfil" class="popup hidden">
    <div class="popup-content">
      <div class="popup-header">
        <span class="popup-title">EDITAR PERFIL</span>
        <span class="close-btn" onclick="fecharPopup()">&times;</span>
      </div>
      <form action="php/perfil.php" method="POST" enctype="multipart/form-data" class="edit-profile-form">
        <label>Descrição:</label>
        <textarea name="descricao" rows="4" cols="40" required class="text-input"><?= htmlspecialchars($perfil['descricao']) ?></textarea>

        <label>Instagram:</label>
        <input type="text" name="instagram" value="<?= htmlspecialchars($perfil['instagram']) ?>" class="text-input">

        <label>LinkedIn:</label>
        <input type="text" name="linkedin" value="<?= htmlspecialchars($perfil['linkedin']) ?>" class="text-input">

        <label>GitHub:</label>
        <input type="text" name="github" value="<?= htmlspecialchars($perfil['github']) ?>" class="text-input">

        <label>Imagem de Perfil:</label>
        <input type="file" name="imagem_perfil" accept="image/*">

        <label>Banner de Fundo:</label>
        <input type="file" name="banner_fundo" accept="image/*">

        <button type="submit" class="submit-button">Salvar Alterações</button>
      </form>
    </div>
  </div>
  <?php endif; ?>

  <main>
    <!--header perfil-->
    <div class="main-content">
      <div class="profile-header">
        <div class="header-image">
          <img src="profile-page.php?exibir_imagem=1&id=<?= $perfil_id ?>&type=banner" alt="Banner">
        </div>
        <div class="profile-pic">
          <button>
            <img src="profile-page.php?exibir_imagem=1&id=<?= $perfil_id ?>&type=perfil" alt="Foto de Perfil" width="150">
          </button>
        </div>
        <div class="profile-name">
          <span><b><?= htmlspecialchars($perfil['name1']) ?></b></span>
        </div>
      </div>
      <!--caixa da bio-->
      <div class="bio-box">
        <span class="bio-title">Descrição</span>
        <span class="bio-text"><?= nl2br(htmlspecialchars($perfil['descricao'] ?? '')) ?></span>
        <div class="bio-links">
          <span class="links-title">Links</span>
          <?php if (!empty($perfil['instagram'])): ?>
            <a href="<?= htmlspecialchars($perfil['instagram']) ?>" target="_blank" rel="noopener noreferrer">
              <img src="./src/img/icons/instagram-icon.png" alt="Instagram">
              <span>Instagram</span>
            </a>
          <?php endif; ?>
          <?php if (!empty($perfil['linkedin'])): ?>
            <a href="<?= htmlspecialchars($perfil['linkedin']) ?>" target="_blank" rel="noopener noreferrer">
              <img src="./src/img/icons/linkedin-icon.png" alt="LinkedIn">
              <span>LinkedIn</span>
            </a>
          <?php endif; ?>
          <?php if (!empty($perfil['github'])): ?>
            <a href="<?= htmlspecialchars($perfil['github']) ?>" target="_blank" rel="noopener noreferrer">
              <img src="./src/img/icons/github-icon.png" alt="GitHub">
              <span>GitHub</span>
            </a>
          <?php endif; ?>
        </div>
      </div>

      <!--projetos-->
      <div class="projects-section">
        <span class="projects-section-title">Projetos</span>
        <div class="projects-display">
          <a href="project-page.html">
            <div class="project-block">
              <div class="project-img">
                <img src="https://th.bing.com/th/id/OIP.s0wBnUKQ-3AVdbyE0Sc8dwHaF7?rs=1&pid=ImgDetMain" alt="Projeto TCC">
              </div>
              <div class="project-footer">
                <div class="project-name">
                  <span>Projeto TCC</span>
                </div>
                <button class="project-options"><span class="fa-solid fa-ellipsis-vertical"></span></button>
              </div>
            </div>
          </a>
        </div>
      </div>
    </div>
  </main>

  <script>
    function abrirPopup() {
      document.getElementById("popup-editar-perfil").classList.remove("hidden");
    }
    function fecharPopup() {
      document.getElementById("popup-editar-perfil").classList.add("hidden");
    }
  </script>
</body>
</html>
