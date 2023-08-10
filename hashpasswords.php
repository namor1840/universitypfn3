<?php
require_once 'conexion.php';

$sql = "SELECT id, password FROM usuarios";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $hashed_password = password_hash($row['password'], PASSWORD_DEFAULT);
        $update_sql = "UPDATE usuarios SET password = '$hashed_password' WHERE id = {$row['id']}";
        $conn->query($update_sql);
    }
    echo "Contraseñas hasheadas correctamente.";
} else {
    echo "No se encontraron usuarios.";
}
?>
