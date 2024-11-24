<?php $conn = new PDO('mysql:host=localhost;dbname=socialdb', 'root', ''); ?>
<?php
$host = 'localhost'; // Cambia según tu configuración
$db = 'socialdb';
$user = 'root';
$pass = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8mb4", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Error de conexión: " . $e->getMessage());
}
?>