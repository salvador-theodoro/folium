<?php
$host = 'localhost';
$user = 'root';
$pass = '';
$db_name = 'folium';

$conn = new mysqli($host, $user, $pass, $db_name);
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}