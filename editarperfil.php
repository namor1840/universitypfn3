<?php
session_start();

$servername = "v48.h.filess.io";
 $username = "NamorProjects_blackhayup";
 $password = "24961d0ecc320eea10392be9cbd172427fd82f9e";
 $dbname = "NamorProjects_blackhayup";
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'];
    $email = $_POST['email'];,
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $update_sql = "UPDATE usuarios SET nombre = '$nombre', email = '$email', password = '$password' WHERE id = {$_SESSION['user_id']}";
    if ($conn->query($update_sql) !== TRUE) {
        $error_message = "Error al actualizar el perfil.";
    } else {
        $_SESSION['user_name'] = $nombre;
    }
}

$user_id = $_SESSION['user_id'];
$sql = "SELECT nombre, email FROM usuarios WHERE id = $user_id";
$result = $conn->query($sql);
$row = $result->fetch_assoc();

$conn->close();
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Perfil</title>
    <link href="/dist/output.css" rel="stylesheet">
</head>

<body class="bg-white flex justify-center items-center h-screen">
    <div class="w-96 p-6 bg-gray-100 rounded-lg shadow-md">
        <h2 class="text-2xl font-semibold mb-4">Editar Perfil</h2>
        <?php if (isset($error_message)) : ?>
            <p class="text-red-500"><?= $error_message ?></p>
        <?php endif; ?>
        <form action="editar_perfil.php" method="post">
            <label class="block mb-2 font-semibold" for="nombre">Nombre:</label>
            <input type="text" name="nombre" value="<?= $row['nombre'] ?>" class="border rounded px-2 py-1 mb-2" required>
            <label class="block mb-2 font-semibold" for="email">Email:</label>
            <input type="email" name="email" value="<?= $row['email'] ?>" class="border rounded px-2 py-1 mb-2" required>
            <label class="block mb-2 font-semibold" for="password">Contraseña:</label>
            <input type="password" name="password" placeholder="Nueva Contraseña" class="border rounded px-2 py-1 mb-4">
            <button type="submit" class="bg-blue-500 text-white px-2 py-1 rounded">Guardar Cambios</button>
        </form>
        <a href="javascript:history.back();" class="block mt-4 text-center text-gray-600">Cancelar</a>
    </div>
</body>

</html>
