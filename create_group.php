
<?php
include 'dbcon.php';
session_start();
$user_id = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $group_name = $_POST['group_name'];
    $group_code = substr(md5(uniqid(rand(), true)), 0, 6); // Generate unique code

    $query = "INSERT INTO groups (group_name, group_code, created_by, created_at) VALUES ('$group_name', '$group_code', '$user_id', NOW())";
    mysqli_query($conn, $query);

    echo "grupo creado con exito, tu codigo de invitacion es: $group_code";
}
?>
<form method="POST">
    <input type="text" name="group_name" placeholder="Group Name" required>
    <button type="submit">crear grupo</button>
</form>
