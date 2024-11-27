<?php
include 'dbcon.php';
session_start();
$user_id = 1;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $group_code = $_POST['group_code'];

    // Preparar y ejecutar la consulta para obtener el group_id basado en el group_code
    $query = "SELECT group_id FROM groups WHERE group_code = :group_code";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':group_code', $group_code);
    $stmt->execute();

    // Verificar si se encontró el grupo
    if ($stmt->rowCount() > 0) {
        $group = $stmt->fetch(PDO::FETCH_ASSOC);
        $group_id = $group['group_id'];

        // Insertar al usuario como miembro en el grupo
        $member_query = "INSERT INTO group_members (group_id, member_id) VALUES (:group_id, :member_id)";
        $member_stmt = $conn->prepare($member_query);
        $member_stmt->bindParam(':group_id', $group_id);
        $member_stmt->bindParam(':member_id', $user_id);

        if ($member_stmt->execute()) {
            echo "Te has unido con éxito a este grupo.";
        } else {
            echo "Error al unirte al grupo.";
        }
    } else {
        echo "Tu código no existe, por favor verifica e intenta de nuevo.";
    }
}
?>

<form method="POST">
    <input type="text" name="group_code" placeholder="Group Code" required>
    <button type="submit">Ingresar al grupo</button>
</form>
