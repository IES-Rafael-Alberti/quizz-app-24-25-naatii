<?php
session_start();
require_once '../config/db.php';

if (!isset($_SESSION["user_id"])) {
    header("Location: ../auth/login.php");
    exit();
}

// Manejo del formulario para crear un cuestionario
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["quiz_title"])) {
    $quiz_title = trim($_POST["quiz_title"]);
    $quiz_description = trim($_POST["quiz_description"]);
    $user_id = $_SESSION["user_id"];

    if (!empty($quiz_title)) {
        $stmt = $conn->prepare("INSERT INTO quizzes (title, description, created_by) VALUES (?, ?, ?)");
        $stmt->bind_param("ssi", $quiz_title, $quiz_description, $user_id);

        if ($stmt->execute()) {
            $quiz_id = $stmt->insert_id;
            header("Location: add_questions.php?quiz_id=" . $quiz_id);
            exit();
        } else {
            echo "<p>Error al crear el cuestionario.</p>";
        }
        $stmt->close();
    } else {
        echo "<p>El título del cuestionario es obligatorio.</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../styles.css">

    <title>Crear Cuestionario</title>
</head>
<body>
    <h2>Crear Cuestionario</h2>
    <form method="POST">
        <label>Título del cuestionario:</label>
        <input type="text" name="quiz_title" required>
        <br>
        <label>Descripción (opcional):</label>
        <textarea name="quiz_description"></textarea>
        <br>
        <button type="submit">Crear Cuestionario</button>
    </form>
    <p><a href="../dashboard/index.php">Volver al Dashboard</a></p>
</body>
</html>
