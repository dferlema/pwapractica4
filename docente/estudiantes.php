<?php
// docente/estudiantes.php
require '../includes/auth.php';

if ($_SESSION['user_role'] != 1) {
    header('Location: ../login.php');
    exit();
}

// Lógica para agregar nuevo estudiante
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_student'])) {
    $nombre = $_POST['nombre'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    
    $stmt = $pdo->prepare("INSERT INTO usuarios (nombre, email, contrasena, rol, usuario_id_creacion, fecha_creacion, hora_creacion) 
                          VALUES (?, ?, ?, 2, ?, NOW(), CURRENT_TIME())");
    $stmt->execute([$nombre, $email, $password, $_SESSION['user_id']]);
    
    header('Location: estudiantes.php');
    exit();
}

// Obtener lista de estudiantes
$stmt = $pdo->query("SELECT * FROM usuarios WHERE rol = 2 ORDER BY nombre");
$estudiantes = $stmt->fetchAll(PDO::FETCH_ASSOC);

require '../includes/header.php';
?>

<div class="container">
    <h2>Gestión de Estudiantes</h2>
    
    <div class="form-container">
        <h3>Agregar Nuevo Estudiante</h3>
        <form method="POST">
            <div class="form-group">
                <label>Nombre Completo:</label>
                <input type="text" name="nombre" required>
            </div>
            <div class="form-group">
                <label>Email:</label>
                <input type="email" name="email" required>
            </div>
            <div class="form-group">
                <label>Contraseña:</label>
                <input type="password" name="password" required>
            </div>
            <button type="submit" name="add_student">Agregar Estudiante</button>
        </form>
    </div>
    
    <div class="table-container">
        <h3>Lista de Estudiantes</h3>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Email</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($estudiantes as $estudiante): ?>
                <tr>
                    <td><?= $estudiante['id'] ?></td>
                    <td><?= htmlspecialchars($estudiante['nombre']) ?></td>
                    <td><?= htmlspecialchars($estudiante['email']) ?></td>
                    <td>
                        <a href="asignar_asignatura.php?estudiante_id=<?= $estudiante['id'] ?>">Asignar Materia</a>
                        <a href="ingresar_nota.php?estudiante_id=<?= $estudiante['id'] ?>">Ingresar Nota</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?php require '../includes/footer.php'; ?>