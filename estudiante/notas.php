<?php
// estudiante/notas.php
require '../includes/auth.php';

if ($_SESSION['user_role'] != 2) {
    header('Location: ../login.php');
    exit();
}

// Obtener notas del estudiante
$stmt = $pdo->prepare("SELECT n.*, a.nombre AS asignatura 
                       FROM notas n 
                       JOIN asignaturas a ON n.asignatura_id = a.id 
                       WHERE n.usuario_id = ? 
                       ORDER BY a.nombre, n.parcial");
$stmt->execute([$_SESSION['user_id']]);
$notas = $stmt->fetchAll(PDO::FETCH_ASSOC);

require '../includes/header.php';
?>

<div class="container">
    <h2>Mis Calificaciones - <?= htmlspecialchars($_SESSION['user_name']) ?></h2>
    
    <?php if (count($notas) > 0): ?>
    <table>
        <thead>
            <tr>
                <th>Asignatura</th>
                <th>Parcial</th>
                <th>Teoría</th>
                <th>Práctica</th>
                <th>Promedio</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($notas as $nota): ?>
            <tr>
                <td><?= htmlspecialchars($nota['asignatura']) ?></td>
                <td><?= $nota['parcial'] ?></td>
                <td><?= $nota['teoria'] ?></td>
                <td><?= $nota['practica'] ?></td>
                <td><?= number_format(($nota['teoria'] + $nota['practica']) / 2, 2) ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <?php else: ?>
    <p>No tienes calificaciones registradas aún.</p>
    <?php endif; ?>
</div>

<?php require '../includes/footer.php'; ?>