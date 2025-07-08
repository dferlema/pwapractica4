<?php
// docente/dashboard.php
require '../includes/auth.php';

if ($_SESSION['user_role'] != 1) {
    header('Location: ../login.php');
    exit();
}

require '../includes/header.php';
?>

<div class="container">
    <h2>Bienvenido, <?= htmlspecialchars($_SESSION['user_name']) ?> (Docente)</h2>
    
    <div class="stats">
        <div class="stat-card">
            <h3>Estudiantes</h3>
            <?php
            $stmt = $pdo->query("SELECT COUNT(*) FROM usuarios WHERE rol = 2");
            echo "<p>" . $stmt->fetchColumn() . "</p>";
            ?>
            <a href="estudiantes.php">Ver todos</a>
        </div>
        
        <div class="stat-card">
            <h3>Asignaturas</h3>
            <?php
            $stmt = $pdo->query("SELECT COUNT(*) FROM asignaturas");
            echo "<p>" . $stmt->fetchColumn() . "</p>";
            ?>
            <a href="asignaturas.php">Ver todas</a>
        </div>
        
        <div class="stat-card">
            <h3>Lugares</h3>
            <?php
            $stmt = $pdo->query("SELECT COUNT(*) FROM lugares");
            echo "<p>" . $stmt->fetchColumn() . "</p>";
            ?>
            <a href="lugares.php">Ver todos</a>
        </div>
    </div>
</div>

<?php require '../includes/footer.php'; ?>