<?php
session_start();
require_once 'config/db.php'; // Importamos la conexión a la base de datos

// Verificar conexión con la base de datos
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Si el usuario ya está autenticado, redirigirlo al dashboard
if (isset($_SESSION["user_id"])) {
    header("Location: dashboard/index.php");
    exit();
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./styles.css">
    <title>Bienvenido a la Aplicación de Cuestionarios</title>
</head>
<body>
    <h2>Bienvenido a la Aplicación de Cuestionarios</h2>
    <p>En esta aplicación podrás crear y realizar cuestionarios de manera sencilla. Los instructores pueden crear cuestionarios con múltiples preguntas, y los estudiantes podrán responderlos y recibir retroalimentación instantánea sobre su rendimiento.</p>

    <h3>Iniciar Sesión</h3>
    <p>Para comenzar, por favor <a href="auth/login.php">inicia sesión.</a></p>

    <p>¿No tienes cuenta? <a href="auth/register.php">Regístrate aquí</a></p>

    <?php
    // Cerrar la conexión con la base de datos
    $conn->close();
    ?>
</body>
</html>
