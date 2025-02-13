<?php
$host = 'mysql'; // Nombre del servicio en Docker
$dbname = 'quiz_app';
$username = 'admin';
$password = 'admin';

$conn = new mysqli($host, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}
?>
