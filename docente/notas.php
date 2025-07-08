<?php
require '../includes/auth.php';

if ($_SESSION['user_role'] != 1) {
    header('Location: ../login.php');
    exit();
}

// Agregar nueva nota
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_nota'])) {
    $asignatura_id = $_POST['asignatura_id'];
    $usuario_id = $_POST['usuario_id'];
    $parcial = $_POST['parcial'];
    $teoria = $_POST['teoria'];
    $practica = $_POST['practica'];
    $obs = $_POST['obs'] ?? null;
    
    $stmt = $pdo->prepare("INSERT INTO notas 
                          (asignatura_id, usuario_id, parcial, teoria, practica, obs, usuario_id_creacion, fecha_creacion, hora_creacion) 
                          VALUES (?, ?, ?, ?, ?, ?, ?, NOW(), CURRENT_TIME())");
    $stmt->execute([$asignatura_id, $usuario_id, $parcial, $teoria, $practica, $obs, $_SESSION['user_id']]);
    
    header('Location: notas.php');
    exit();
}

// Obtener lista de estudiantes
$stmt = $pdo->query("SELECT id, nombre FROM usuarios WHERE rol = 2 ORDER BY nombre");
$estudiantes = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Obtener lista de asignaturas
$stmt = $pdo->query("SELECT id, nombre FROM asignaturas ORDER BY nombre");
$asignaturas = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Obtener todas las notas
$stmt = $pdo->query("SELECT n.*, a.nombre AS asignatura, u.nombre AS estudiante 
                     FROM notas n 
                     JOIN asignaturas a ON n.asignatura_id = a.id 
                     JOIN usuarios u ON n.usuario_id = u.id 
                     ORDER BY u.nombre, a.nombre, n.parcial");
$notas = $stmt->fetchAll(PDO::FETCH_ASSOC);

require '../includes/header.php';
?>

<h2>Gestión de Notas</h2>

<div class="form-container">
    <h3>Agregar Nueva Nota</h3>
    <form method="POST">
        <div class="form-group">
            <label>Estudiante:</label>
            <select name="usuario_id" required>
                <option value="">Seleccionar estudiante</option>
                <?php foreach ($estudiantes as $estudiante): ?>
                <option value="<?= $estudiante['id'] ?>"><?= htmlspecialchars($estudiante['nombre']) ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="form-group">
            <label>Asignatura:</label>
            <select name="asignatura_id" required>
                <option value="">Seleccionar asignatura</option>
                <?php foreach ($asignaturas as $asignatura): ?>
                <option value="<?= $asignatura['id'] ?>"><?= htmlspecialchars($asignatura['nombre']) ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="form-group">
            <label>Parcial:</label>
            <select name="parcial" required>
                <option value="1">Primer Parcial</option>
                <option value="2">Segundo Parcial</option>
                <option value="3">Mejoramiento</option>
            </select>
        </div>
        <div class="form-group">
            <label>Nota Teoría:</label>
            <input type="number" step="0.01" min="0" max="10" name="teoria" required>
        </div>
        <div class="form-group">
            <label>Nota Práctica:</label>
            <input type="number" step="0.01" min="0" max="10" name="practica" required>
        </div>
        <div class="form-group">
            <label>Observaciones (opcional):</label>
            <textarea name="obs"></textarea>
        </div>
        <button type="submit" name="add_nota">Agregar Nota</button>
    </form>
</div>

<div class="table-container">
    <h3>Lista de Notas</h3>
    <table>
        <thead>
            <tr>
                <th>Estudiante</th>
                <th>Asignatura</th>
                <th>Parcial</th>
                <th>Teoría</th>
                <th>Práctica</th>
                <th>Promedio</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($notas as $nota): ?>
            <tr>
                <td><?= htmlspecialchars($nota['estudiante']) ?></td>
                <td><?= htmlspecialchars($nota['asignatura']) ?></td>
                <td><?= $nota['parcial'] == 1 ? '1er' : ($nota['parcial'] == 2 ? '2do' : 'Mejor.') ?></td>
                <td><?= $nota['teoria'] ?></td>
                <td><?= $nota['practica'] ?></td>
                <td><?= number_format(($nota['teoria'] + $nota['practica']) / 2, 2) ?></td>
                <td>
                    <a href="editar_nota.php?id=<?= $nota['id'] ?>">Editar</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php require '../includes/footer.php'; ?>