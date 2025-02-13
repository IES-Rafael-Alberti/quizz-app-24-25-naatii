<?php
session_start();
require_once '../config/db.php';

// Verificar que el usuario esté autenticado
if (!isset($_SESSION["user_id"])) {
    header("Location: ../auth/login.php");
    exit();
}

// Verificar si se pasó el quiz_id por GET
if (!isset($_GET['quiz_id'])) {
    echo "<p>Falta el ID del cuestionario.</p>";
    exit();
}

$quiz_id = $_GET['quiz_id'];

// Obtener los resultados del cuestionario
$stmt = $conn->prepare("SELECT * FROM results WHERE quiz_id = ? AND user_id = ?");
$stmt->bind_param("ii", $quiz_id, $_SESSION["user_id"]);
$stmt->execute();
$result = $stmt->get_result();
$results = $result->fetch_assoc();
$stmt->close();

if (!$results) {
    echo "<p>No has completado este cuestionario aún.</p>";
    exit();
}

// Obtener estadísticas generales del cuestionario
$stmt = $conn->prepare("SELECT AVG(score) AS avg_score, COUNT(*) AS total_attempts FROM results WHERE quiz_id = ?");
$stmt->bind_param("i", $quiz_id);
$stmt->execute();
$stats = $stmt->get_result()->fetch_assoc();
$stmt->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../styles.css">

    <title>Resultados del Cuestionario</title>
</head>
<body>
    <h2>Resultados del Cuestionario</h2>

    <h3>Tu Puntaje: <?php echo htmlspecialchars($results['score']); ?></h3>

    <h3>Estadísticas del Cuestionario</h3>
    <p>Puntuación Promedio: <?php echo number_format($stats['avg_score'], 2); ?> </p>
    <p>Total de Intentos: <?php echo $stats['total_attempts']; ?></p>

    <p><a href="../dashboard/index.php">Volver al Dashboard</a></p>
</body>
</html>
