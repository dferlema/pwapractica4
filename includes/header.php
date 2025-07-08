<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de Calificaciones</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <header>
        <div class="container">
            <h1>Sistema de Calificaciones</h1>
            <nav>
                <?php if (isset($_SESSION['user_id'])): ?>
                    <span>Bienvenido, <?= htmlspecialchars($_SESSION['user_name']) ?></span>
                    <?php if ($_SESSION['user_role'] == 1): ?>
                        <a href="../docente/dashboard.php">Dashboard</a>
                    <?php else: ?>
                        <a href="../estudiante/notas.php">Mis Notas</a>
                    <?php endif; ?>
                    <a href="../logout.php">Cerrar Sesión</a>
                <?php else: ?>
                    <a href="../login.php">Iniciar Sesión</a>
                <?php endif; ?>
            </nav>
        </div>
    </header>
    <main class="container">