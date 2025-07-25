CREATE DATABASE IF NOT EXISTS folium;
USE folium;

CREATE TABLE usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name1 VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password1 VARCHAR(64) NOT NULL, 
    criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    verificado TINYINT(1) DEFAULT 0,
    hash1 varchar(255) not null
);

DROP TABLE usuarios;
DROP TABLE perfis;

SELECT * FROM usuarios;

TRUNCATE TABLE usuarios;


CREATE TABLE perfis (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_usuario INT NOT NULL,
    descricao TEXT,
    instagram VARCHAR(255),
    linkedin VARCHAR(255),
    github VARCHAR(255),
    imagem_perfil longblob,
    banner_fundo longblob,
    FOREIGN KEY (id_usuario) REFERENCES usuarios(id) ON DELETE CASCADE
);

SELECT * FROM perfis WHERE id_usuario = 1;

DELIMITER $$

CREATE PROCEDURE deletar_usuario(IN usuario_id INT)
BEGIN
    DELETE FROM usuarios WHERE id = usuario_id;
END$$

DELIMITER ;

CALL deletar_usuario(7); -- Substitua 5 pelo ID do usuário que deseja apagar
