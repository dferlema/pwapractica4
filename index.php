<?php
require 'includes/config.php';

// Redireccionar según el rol si ya está logueado
if (isset($_SESSION['user_id'])) {
    if ($_SESSION['user_role'] == 1) {
        header('Location: docente/dashboard.php');
    } else {
        header('Location: estudiante/notas.php');
    }
    exit();
}

require 'includes/header.php';
?>

<div class="welcome-container">
    <h2>Bienvenido al Sistema de Calificaciones Docente</h2>
    <p>Este sistema permite a los docentes gestionar las calificaciones de sus estudiantes y a los estudiantes ver sus propias notas.</p>
    
    <div class="action-buttons">
        <a href="login.php" class="btn">Iniciar Sesión</a>
    </div>
    
    <div class="features">
        <h3>Características principales:</h3>
        <ul>
            <li>Gestión completa de estudiantes, asignaturas y lugares educativos</li>
            <li>Registro detallado de notas (teoría y práctica)</li>
            <li>Visualización de calificaciones para estudiantes</li>
            <li>Seguimiento de auditoría en todos los registros</li>
        </ul>
    </div>
</div>

<?php require 'includes/footer.php'; ?>