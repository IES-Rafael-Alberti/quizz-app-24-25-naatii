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

// Obtener las preguntas del cuestionario
$stmt = $conn->prepare("SELECT * FROM questions WHERE quiz_id = ?");
$stmt->bind_param("i", $quiz_id);
$stmt->execute();
$result = $stmt->get_result();
$questions = $result->fetch_all(MYSQLI_ASSOC);
$stmt->close();

// Verificar si se ha enviado el formulario con las respuestas
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $score = 0;
    $total_questions = count($questions);

    // Validar las respuestas y contar el puntaje
    foreach ($questions as $question) {
        $user_answer = $_POST["question_" . $question["question_id"]];
        if ($user_answer == $question["correct_option"]) {
            $score++;
        }
    }

    // Guardar los resultados en la base de datos
    $user_id = $_SESSION["user_id"];
    $stmt = $conn->prepare("INSERT INTO results (quiz_id, user_id, score) VALUES (?, ?, ?)");
    $stmt->bind_param("iii", $quiz_id, $user_id, $score);
    $stmt->execute();
    $stmt->close();

    // Mostrar retroalimentación
    echo "<h2>Tu Puntaje: $score de $total_questions</h2>";
    echo "<p><a href='../dashboard/index.php'>Volver al Dashboard</a></p>";
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../styles.css">

    <title>Realizar Cuestionario</title>
</head>
<body>
    <h2>Realizar Cuestionario</h2>
    <form method="POST">
        <?php foreach ($questions as $question): ?>
            <h3><?php echo htmlspecialchars($question['question_text']); ?></h3>
            <label>
                <input type="radio" name="question_<?php echo $question['question_id']; ?>" value="option_a" required>
                <?php echo htmlspecialchars($question['option_a']); ?>
            </label><br>
            <label>
                <input type="radio" name="question_<?php echo $question['question_id']; ?>" value="option_b" required>
                <?php echo htmlspecialchars($question['option_b']); ?>
            </label><br>
            <label>
                <input type="radio" name="question_<?php echo $question['question_id']; ?>" value="option_c" required>
                <?php echo htmlspecialchars($question['option_c']); ?>
            </label><br>
            <label>
                <input type="radio" name="question_<?php echo $question['question_id']; ?>" value="option_d" required>
                <?php echo htmlspecialchars($question['option_d']); ?>
            </label><br>
        <?php endforeach; ?>
        <br>
        <button type="submit">Enviar Respuestas</button>
    </form>
    <p><a href="../dashboard/index.php">Volver al Dashboard</a></p>
</body>
</html>
