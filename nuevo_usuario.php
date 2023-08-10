<?php
session_start();
ini_set('display_errors', 1); error_reporting(-1);
require_once 'conexion.php';

if ($_SESSION['user_role'] !== 'admin') {
    header("Location: index.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $rol = $_POST['rol'];

    $insert_sql = "INSERT INTO usuarios (nombre, email, password, rol) VALUES ('$nombre', '$email', '$password', '$rol')";
    if ($conn->query($insert_sql) === TRUE) {
        header("Location: usuarios.php");
        exit();
    } else {
        $error_message = "Error al agregar el nuevo usuario.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Nuevo Usuario</title>
    <link href="/dist/output.css" rel="stylesheet">
</head>
<body class="bg-gray-100 flex justify-center items-center h-screen">
    <div class="bg-white p-8 rounded shadow w-1/3">
        <h2 class="text-2xl font-semibold mb-4">Nuevo Usuario</h2>
        
        <?php if (isset($error_message)): ?>
            <p class="text-red-500 mb-4"><?= $error_message ?></p>
        <?php endif; ?>

        <form action="nuevo_usuario.php" method="post">
            <label class="block font-semibold">Nombre:</label>
            <input type="text" name="nombre" class="border rounded px-2 py-1 w-full mb-2" required>
            <label class="block font-semibold">Correo Electrónico:</label>
            <input type="email" name="email" class="border rounded px-2 py-1 w-full mb-2" required>
            <label class="block font-semibold">Contraseña:</label>
            <input type="password" name="password" class="border rounded px-2 py-1 w-full mb-2" required>
            <label class="block font-semibold">Rol:</label>
            <select name="rol" class="border rounded px-2 py-1 mb-4">
                <option value="admin">Admin</option>
                <option value="maestro">Maestro</option>
                <option value="alumno">Alumno</option>
            </select>
            <div class="flex justify-between">
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Agregar Usuario</button>
                <a href="usuarios.php" class="bg-gray-400 text-white px-4 py-2 rounded">Cancelar</a>
            </div>
        </form>
    </div>
</body>
</html>
