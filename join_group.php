
<?php
include 'dbcon.php';
session_start();
$user_id = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $group_code = $_POST['group_code'];

    $query = "SELECT group_id FROM groups WHERE group_code = '$group_code'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {
        $group = mysqli_fetch_assoc($result);
        $group_id = $group['group_id'];

        $query = "INSERT INTO group_members (group_id, user_id) VALUES ('$group_id', '$user_id')";
        mysqli_query($conn, $query);

        echo "Te has unido con exito a este grupo.";
    } else {
        echo "Tu codigo no existe wey, fijate bien cabron, no mames, 1 puto trabajo alv.";
    }
}
?>
<form method="POST">
    <input type="text" name="group_code" placeholder="Group Code" required>
    <button type="submit">ingresar al grupo</button>
</form>
