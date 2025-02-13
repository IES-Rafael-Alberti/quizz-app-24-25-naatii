<?php
session_start();
require_once '../config/db.php';

if (!isset($_SESSION["user_id"])) {
    header("Location: ../auth/login.php");
    exit();
}

// Verificar que se pasa el ID del cuestionario
if (!isset($_GET['quiz_id'])) {
    echo "<p>Falta el ID del cuestionario.</p>";
    exit();
}

$quiz_id = $_GET['quiz_id'];

// Manejo del formulario para agregar preguntas
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["question_text"])) {
    $question_text = trim($_POST["question_text"]);
    $option_a = trim($_POST["option_a"]);
    $option_b = trim($_POST["option_b"]);
    $option_c = trim($_POST["option_c"]);
    $option_d = trim($_POST["option_d"]);
    $correct_option = $_POST["correct_option"];

    if (!empty($question_text) && !empty($option_a) && !empty($option_b) && !empty($option_c) && !empty($option_d) && isset($correct_option)) {
        $stmt = $conn->prepare("INSERT INTO questions (quiz_id, question_text, option_a, option_b, option_c, option_d, correct_option) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("issssss", $quiz_id, $question_text, $option_a, $option_b, $option_c, $option_d, $correct_option);

        if ($stmt->execute()) {
            echo "<p>Pregunta añadida exitosamente.</p>";
        } else {
            echo "<p>Error al agregar la pregunta.</p>";
        }

        $stmt->close();
    } else {
        echo "<p>Por favor, complete todos los campos.</p>";
    }
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../styles.css">

    <title>Agregar Pregunta</title>
</head>
<body>
    <h2>Agregar Pregunta al Cuestionario</h2>
    <form method="POST">
        <label>Pregunta:</label>
        <input type="text" name="question_text" required>
        <br>
        <label>Opción A:</label>
        <input type="text" name="option_a" required>
        <br>
        <label>Opción B:</label>
        <input type="text" name="option_b" required>
        <br>
        <label>Opción C:</label>
        <input type="text" name="option_c" required>
        <br>
        <label>Opción D:</label>
        <input type="text" name="option_d" required>
        <br>
        <label>Opción Correcta:</label>
        <select name="correct_option" required>
            <option value="option_a">Opción A</option>
            <option value="option_b">Opción B</option>
            <option value="option_c">Opción C</option>
            <option value="option_d">Opción D</option>
        </select>
        <br>
        <button type="submit">Añadir Pregunta</button>
    </form>

    <p><a href="../dashboard/index.php">Volver al Dashboard</a></p>
    <p><a href="create_quiz.php">Crear otro cuestionario</a></p>
</body>
</html>
