<?php
session_start();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página Inicial</title>
    <link rel="stylesheet" href="./src/css/global-styles.css">
    <link rel="stylesheet" href="./src/css/home-styles.css">
    <link rel="stylesheet" href="./src/css/standard-header.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body>
    <header>
        <div class="header-content">
            <div class="header-left-side">
                <div class="home-button">
                    <a href="index.php">
                        <img src="./src/img/icons/logo1.png" alt="" class="home-button-icon" height="40px">
                    </a>
                </div>
                <div class="search-bar">
                    <input type="text">
                </div>
            </div>
            <div class="header-right-side">
                <!--BOTÃO AJUDA-->
                <div class="help-button">
                    <button id="help-button"><span class="fa-solid fa-question"></span></button>
                </div>
                <!--BOTÃO CONFIG-->
                <div class="config-button">
                    <button id="config-button"><span class="fa-solid fa-gear"></span></button>
                </div>
                <!--BOTÃO NOTIFICAÇÕES-->
                <div class="notification-button">
                    <button id="notification-button"><span class="fa-regular fa-bell"></span></button>
                </div>
                <!--BOTÃO PERFIL-->
                <div class="profile-button">
                    <button id="profile-button"><span class="fa-solid fa-circle-user"></span></button>
                </div>
                <!--BOTÃO TEMA-->
                <div class="theme-button">
                    <button id="theme-button"><span class="fa-solid fa-lightbulb"></span></button>
                </div>
            </div>
        </div>
    </header>
    <!--MENU DROPDOWN-->
    <section class="dropdown-menu-section">
        <div class="dropdown-menu hidden" id="notification-dropdown-menu">
            oii
        </div>
        <div class="dropdown-menu hidden" id="profile-dropdown-menu">
            <ul>
                <?php if (isset($_SESSION['user_nome'])): ?>
                    <a href="profile-page.html">
                    <li id="user-name"><strong><?php echo htmlspecialchars($_SESSION['user_nome']); ?></strong></li>
                    </a>
                    <li><a href="php/logout.php">Sair</a></li>
                <?php else: ?>
                    <li><a href="register-page.html">Registrar</a></li>
                    <li><a href="login-page.html">Entrar</a></li>
                <?php endif; ?>
            </ul>
        </div>
    </section>
    <main>
        <div class="main-content">
            <!--uma sessão-->
            <div class="main-sub-section">
                <div class="section-title">
                    <div class="section-title-text">
                        <span>Recentes</span>
                    </div>
                    <div class="section-title-line"></div>
                </div>
                <div class="carousel">
                    <button class="scroll-button left-button"></button>
                        <div class="section-blocks-container">
                            <a href="">
                                <div class="project-block">
                                    <div class="project-img">
                                        <img src="" alt="">
                                    </div>
                                    <div class="project-footer">
                                        <div class="project-name">
                                            <span>Nome do Projeto</span>
                                        </div>
                                        <button class="project-options"><span class="fa-solid fa-ellipsis-vertical"></span></button>
                                    </div>
                                </div>
                            </a>
                            <a href="">
                                <div class="project-block">
                                    <div class="project-img">
                                        <img src="" alt="">
                                    </div>
                                    <div class="project-footer">
                                        <div class="project-name">
                                            <span>Nome do Projeto</span>
                                        </div>
                                        <button class="project-options"><span class="fa-solid fa-ellipsis-vertical"></span></button>
                                    </div>
                                </div>
                            </a>
                            <a href="">
                                <div class="project-block">
                                    <div class="project-img">
                                        <img src="" alt="">
                                    </div>
                                    <div class="project-footer">
                                        <div class="project-name">
                                            <span>Nome do Projeto</span>
                                        </div>
                                        <button class="project-options"><span class="fa-solid fa-ellipsis-vertical"></span></button>
                                    </div>
                                </div>
                            </a>
                            <a href="">
                                <div class="project-block">
                                    <div class="project-img">
                                        <img src="" alt="">
                                    </div>
                                    <div class="project-footer">
                                        <div class="project-name">
                                            <span>Nome do Projeto</span>
                                        </div>
                                        <button class="project-options"><span class="fa-solid fa-ellipsis-vertical"></span></button>
                                    </div>
                                </div>
                            </a>
                            <a href="">
                                <div class="project-block">
                                    <div class="project-img">
                                        <img src="" alt="">
                                    </div>
                                    <div class="project-footer">
                                        <div class="project-name">
                                            <span>Nome do Projeto</span>
                                        </div>
                                        <button class="project-options"><span class="fa-solid fa-ellipsis-vertical"></span></button>
                                    </div>
                                </div>
                            </a>
                        </div>
                    <button class="scroll-button right-button"></button>
                </div>
            </div>
            <!--outra sessão-->
            <div class="main-sub-section">
                <div class="section-title">
                    <div class="section-title-text">
                        <span>Em alta</span>
                    </div>
                    <div class="section-title-line"></div>
                </div>
                <div class="carousel">
                    <button class="scroll-button left-button"></button>
                        <div class="section-blocks-container">
                            <a href="">
                                <div class="project-block">

                                </div>
                            </a>
                            <a href="">
                                <div class="project-block">
                                    
                                </div>
                            </a>
                            <a href="">
                                <div class="project-block">
                                    
                                </div>
                            </a>
                            <a href="">
                                <div class="project-block">
                                    
                                </div>
                            </a>
                            <a href="">
                                <div class="project-block">
                                    
                                </div>
                            </a>
                        </div>
                    <button class="scroll-button right-button"></button>
                </div>
            </div>
            <!--mais outra epa-->
            <div class="main-sub-section">
                <div class="section-title">
                    <div class="section-title-text">
                        <span>Outro exemplo</span>
                    </div>
                    <div class="section-title-line"></div>
                </div>
                <div class="carousel">
                    <button class="scroll-button left-button"></button>
                        <div class="section-blocks-container">
                            <a href="">
                                <div class="project-block">

                                </div>
                            </a>
                            <a href="">
                                <div class="project-block">
                                    
                                </div>
                            </a>
                            <a href="">
                                <div class="project-block">
                                    
                                </div>
                            </a>
                            <a href="">
                                <div class="project-block">
                                    
                                </div>
                            </a>
                            <a href="">
                                <div class="project-block">
                                    
                                </div>
                            </a>
                        </div>
                    <button class="scroll-button right-button"></button>
                </div>
            </div>
        </div>
    </main>
</body>
<script src="./js/script.js"></script>
</html>