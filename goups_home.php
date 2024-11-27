<?php
// Incluir conexión a la base de datos
include 'dbcon.php';
$userId = 1;

// Función para mostrar los grupos del usuario
function mostrarGruposUsuario($conn, $userId) {
    // Consulta para obtener los grupos a los que pertenece el usuario
    $query = "SELECT g.group_id, g.group_name 
              FROM groups g
              JOIN group_members gm ON g.group_id = gm.group_id
              WHERE gm.member_id = :user_id";
    $stmt = $conn->prepare($query);
    $stmt->execute([':user_id' => $userId]);

    // Obtener resultados
    $grupos = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Generar el HTML de las tarjetas de los grupos
    echo '<div style="display: flex; flex-wrap: wrap; gap: 10px; padding: 10px; box-sizing: border-box;">';
    foreach ($grupos as $grupo) {
        echo '<div style="width: 120px; height: 120px; background-color: #f0f0f0; border: 1px solid #ddd; border-radius: 5px; text-align: center; display: flex; flex-direction: column; justify-content: center; align-items: center;">';
        echo '<h4 style="margin: 0; font-size: 14px;">' . htmlspecialchars($grupo['group_name']) . '</h4>';
        echo '<a href="group_messages.php?group_id=' . htmlspecialchars($grupo['group_id']) . '" style="margin-top: 10px; font-size: 12px; color: blue; text-decoration: none;">Ver Grupo</a>';
        echo '</div>';
    }
    echo '</div>';
}

// Llamar a la función para mostrar los grupos
mostrarGruposUsuario($conn, $userId);
?>
