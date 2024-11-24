<?php
require_once 'dbcon.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    echo "<p>No has iniciado sesión. Por favor, <a href='login.php'>inicia sesión</a>.</p>";
    exit();
}
$user_id = $_SESSION['user_id'];

// Manejar la creación de un nuevo grupo
if (isset($_POST['create_group'])) {
    $group_name = $_POST['group_name'];
    $group_code = substr(md5(uniqid(rand(), true)), 0, 6);

    $query = "INSERT INTO groups (group_name, group_code, created_by, created_at) VALUES (:group_name, :group_code, :created_by, NOW())";
    $stmt = $pdo->prepare($query);
    $stmt->execute([
        ':group_name' => $group_name,
        ':group_code' => $group_code,
        ':created_by' => $user_id
    ]);

    echo "Grupo creado con éxito. Código: $group_code";
}

// Manejar unirse a un grupo
if (isset($_POST['join_group'])) {
    $group_code = $_POST['group_code'];

    $query = "SELECT group_id FROM groups WHERE group_code = :group_code";
    $stmt = $pdo->prepare($query);
    $stmt->execute([':group_code' => $group_code]);

    if ($stmt->rowCount() > 0) {
        $group = $stmt->fetch(PDO::FETCH_ASSOC);
        $group_id = $group['group_id'];

        $query = "INSERT INTO group_members (group_id, user_id) VALUES (:group_id, :user_id)";
        $stmt = $pdo->prepare($query);
        $stmt->execute([':group_id' => $group_id, ':user_id' => $user_id]);

        echo "Te has unido al grupo con éxito.";
    } else {
        echo "Código de grupo no válido.";
    }
}

// Obtener los grupos del usuario
$query = "SELECT g.group_id, g.group_name FROM groups g 
          JOIN group_members gm ON g.group_id = gm.group_id 
          WHERE gm.user_id = :user_id";
$stmt = $pdo->prepare($query);
$stmt->execute([':user_id' => $user_id]);
$groups = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<h1>Mis Grupos</h1>
<ul>
    <?php foreach ($groups as $group): ?>
        <li>
            <a href="group.php?group_id=<?= $group['group_id'] ?>">
                <?= htmlspecialchars($group['group_name']) ?>
            </a>
        </li>
    <?php endforeach; ?>
</ul>

<h2>Crear un Grupo</h2>
<form method="POST">
    <input type="text" name="group_name" placeholder="Nombre del grupo" required>
    <button type="submit" name="create_group">Crear Grupo</button>
</form>

<h2>Unirse a un Grupo</h2>
<form method="POST">
    <input type="text" name="group_code" placeholder="Código del grupo" required>
    <button type="submit" name="join_group">Unirse al Grupo</button>
</form>
