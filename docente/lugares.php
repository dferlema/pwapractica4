<?php
require '../includes/auth.php';

if ($_SESSION['user_role'] != 1) {
    header('Location: ../login.php');
    exit();
}

// Agregar nuevo lugar
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_lugar'])) {
    $nombre = $_POST['nombre'];
    $obs = $_POST['obs'] ?? null;
    
    $stmt = $pdo->prepare("INSERT INTO lugares (nombre, obs, usuario_id_creacion, fecha_creacion, hora_creacion) 
                          VALUES (?, ?, ?, NOW(), CURRENT_TIME())");
    $stmt->execute([$nombre, $obs, $_SESSION['user_id']]);
    
    header('Location: lugares.php');
    exit();
}

// Obtener lista de lugares
$stmt = $pdo->query("SELECT * FROM lugares ORDER BY nombre");
$lugares = $stmt->fetchAll(PDO::FETCH_ASSOC);

require '../includes/header.php';
?>

<h2>Gestión de Lugares Educativos</h2>

<div class="form-container">
    <h3>Agregar Nuevo Lugar</h3>
    <form method="POST">
        <div class="form-group">
            <label>Nombre:</label>
            <input type="text" name="nombre" required>
        </div>
        <div class="form-group">
            <label>Observaciones (opcional):</label>
            <textarea name="obs"></textarea>
        </div>
        <button type="submit" name="add_lugar">Agregar Lugar</button>
    </form>
</div>

<div class="table-container">
    <h3>Lista de Lugares</h3>
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
            <?php foreach ($lugares as $lugar): ?>
            <tr>
                <td><?= $lugar['id'] ?></td>
                <td><?= htmlspecialchars($lugar['nombre']) ?></td>
                <td><?= htmlspecialchars($lugar['obs'] ?? '') ?></td>
                <td>
                    <a href="editar_lugar.php?id=<?= $lugar['id'] ?>">Editar</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php require '../includes/footer.php'; ?>