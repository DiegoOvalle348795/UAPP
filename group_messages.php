
<?php
require_once 'dbcon.php';

$group_id = $_GET['group_id'] ?? null;

if (!$group_id) {
    echo "Error: Grupo no especificado.";
    exit();
}

// Obtener los mensajes del grupo
$query = "SELECT gm.message, m.firstname, m.lastname, gm.sent_at FROM group_messages gm 
          JOIN members m ON gm.user_id = m.user_id 
          WHERE gm.group_id = :group_id ORDER BY gm.sent_at ASC";
$stmt = $conn->prepare($query);
$stmt->execute([':group_id' => $group_id]);
$messages = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<h2>Mensajes del Grupo</h2>
<ul>
    <?php foreach ($messages as $message): ?>
        <li>
            <strong><?= htmlspecialchars($message['firstname'] . ' ' . $message['lastname']) ?>:</strong>
            <?= htmlspecialchars($message['message']) ?>
            <em>(<?= htmlspecialchars($message['sent_at']) ?>)</em>
        </li>
    <?php endforeach; ?>
</ul>

<form method="POST" action="send_message.php">
    <input type="hidden" name="group_id" value="<?= $group_id ?>">
    <textarea name="message" placeholder="Escribe tu mensaje aquí" required></textarea>
    <button type="submit">Enviar</button>
</form>
