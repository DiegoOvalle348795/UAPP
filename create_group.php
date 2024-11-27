<?php
include 'dbcon.php';
session_start();
$user_id = 1; // ID del usuario que está creando el grupo

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $group_name = $_POST['group_name'];
    $group_code = substr(md5(uniqid(rand(), true)), 0, 6); // Generar un código único

    try {
        // Iniciar una transacción
        $conn->beginTransaction();

        // Insertar el grupo en la tabla "groups"
        $query = "INSERT INTO groups (group_name, group_code, created_by, created_at) VALUES (:group_name, :group_code, :user_id, NOW())";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':group_name', $group_name);
        $stmt->bindParam(':group_code', $group_code);
        $stmt->bindParam(':user_id', $user_id);

        if ($stmt->execute()) {
            // Obtener el ID del grupo recién creado
            $group_id = $conn->lastInsertId();

            // Insertar al creador del grupo como miembro en la tabla "group_members"
            $member_query = "INSERT INTO group_members (group_id, member_id) VALUES (:group_id, :member_id)";
            $member_stmt = $conn->prepare($member_query);
            $member_stmt->bindParam(':group_id', $group_id);
            $member_stmt->bindParam(':member_id', $user_id);

            if ($member_stmt->execute()) {
                // Confirmar la transacción
                $conn->commit();
                echo "Grupo creado con éxito. Tu código de invitación es: $group_code. Has sido añadido automáticamente como miembro.";
            } else {
                // Revertir la transacción si la inserción del miembro falla
                $conn->rollBack();
                echo "Error al añadirte como miembro del grupo.";
            }
        } else {
            // Revertir la transacción si la inserción del grupo falla
            $conn->rollBack();
            echo "Error al crear el grupo.";
        }
    } catch (Exception $e) {
        // Revertir la transacción en caso de cualquier error
        $conn->rollBack();
        echo "Error: " . $e->getMessage();
    }
}
?>

<form method="POST">
    <input type="text" name="group_name" placeholder="Group Name" required>
    <button type="submit">Crear Grupo</button>
</form>
