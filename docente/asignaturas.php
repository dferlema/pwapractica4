<?php
require '../includes/auth.php';

if ($_SESSION['user_role'] != 1) {
    header('Location: ../login.php');
    exit();
}

// Agregar nueva asignatura
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_asignatura'])) {
    $nombre = $_POST['nombre'];
    $obs = $_POST['obs'] ?? null;
    
    $stmt = $pdo->prepare("INSERT INTO asignaturas (nombre, obs, usuario_id_creacion, fecha_creacion, hora_creacion) 
                          VALUES (?, ?, ?, NOW(), CURRENT_TIME())");
    $stmt->execute([$nombre, $obs, $_SESSION['user_id']]);
    
    header('Location: asignaturas.php');
    exit();
}

// Obtener lista de asignaturas
$stmt = $pdo->query("SELECT * FROM asignaturas ORDER BY nombre");
$asignaturas = $stmt->fetchAll(PDO::FETCH_ASSOC);

require '../includes/header.php';
?>

<h2>Gestión de Asignaturas</h2>

<div class="form-container">
    <h3>Agregar Nueva Asignatura</h3>
    <form method="POST">
        <div class="form-group">
            <label>Nombre:</label>
            <input type="text" name="nombre" required>
        </div>
        <div class="form-group">
            <label>Observaciones (opcional):</label>
            <textarea name="obs"></textarea>
        </div>
        <button type="submit" name="add_asignatura">Agregar Asignatura</button>
    </form>
</div>

<div class="table-container">
    <h3>Lista de Asignaturas</h3>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Observaciones</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($asignaturas as $asignatura): ?>
            <tr>
                <td><?= $asignatura['id'] ?></td>
                <td><?= htmlspecialchars($asignatura['nombre']) ?></td>
                <td><?= htmlspecialchars($asignatura['obs'] ?? '') ?></td>
                <td>
                    <a href="editar_asignatura.php?id=<?= $asignatura['id'] ?>">Editar</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php require '../includes/footer.php'; ?>