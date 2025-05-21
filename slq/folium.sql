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

SELECT * FROM usuarios;

TRUNCATE TABLE usuarios;

