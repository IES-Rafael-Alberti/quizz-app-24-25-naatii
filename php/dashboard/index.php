<?php
session_start(); // Iniciar sesión
require_once '../config/db.php';

if (!isset($_SESSION["user_id"])) {
    header("Location: ../auth/login.php"); // Redirigir si no está autenticado
    exit();
}

$sql = "SELECT quiz_id, title FROM quizzes WHERE created_by = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $_SESSION["user_id"]);
$stmt->execute();
$result = $stmt->get_result();
$quizzes = $result->fetch_all(MYSQLI_ASSOC);
$stmt->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../styles.css">

    <title>Dashboard</title>
</head>
<body>
    <h2>Bienvenido, <?php echo htmlspecialchars($_SESSION["username"]); ?>!</h2>
    <p><a href="../auth/logout.php">Cerrar Sesión</a></p>

    <h3>Opciones:</h3>
    <ul>
        <li><a href="../quizzes/create_quiz.php">Crear Cuestionario</a></li>
        
        <!-- Mostrar los cuestionarios si existen -->
        <?php if (empty($quizzes)): ?>
            <p>No tienes cuestionarios creados. <a href="../quizzes/create_quiz.php">Crear un cuestionario</a>.</p>
        <?php else: ?>
            <h3>Mis Cuestionarios</h3>
            <ul>
                <?php foreach ($quizzes as $quiz): ?>
                    <li>
                        <a href="../quizzes/take_quiz.php?quiz_id=<?php echo $quiz['quiz_id']; ?>">
                            <?php echo htmlspecialchars($quiz['title']); ?>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>

        <h3>Mis Resultados</h3>
    <?php if (empty($quizzes)): ?>
        <p>No tienes cuestionarios resueltos.</p>
    <?php else: ?>
        <ul>
            <?php foreach ($quizzes as $quiz): ?>
                <li>
                    <a href="../quizzes/results.php?quiz_id=<?php echo $quiz['quiz_id']; ?>"><?php echo htmlspecialchars($quiz['title']); ?></a>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>
    </ul>
</body>
</html>
