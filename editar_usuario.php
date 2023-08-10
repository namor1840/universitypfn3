<?php
session_start();

   $servername = "localhost";
    $username = "id21126023_admin";
    $password = "Roman18*";
    $dbname = "id21126023_universidad";
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Obtener el ID del usuario a editar
if (isset($_GET['id'])) {
    $user_id = $_GET['id'];
} else {
    header("Location: usuarios.php");
    exit();
}

// Obtener los datos del usuario de la base de datos
$user_sql = "SELECT id, nombre, rol FROM usuarios WHERE id = $user_id";
$user_result = $conn->query($user_sql);

if ($user_result->num_rows === 0) {
    header("Location: usuarios.php");
    exit();
}

$user_data = $user_result->fetch_assoc();

// Manejar la actualización de usuarios si se envía un formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'];
    $rol = $_POST['rol'];

    // Actualizar los datos del usuario en la base de datos
    $update_sql = "UPDATE usuarios SET nombre = '$nombre', rol = '$rol' WHERE id = $user_id";
    if ($conn->query($update_sql) !== TRUE) {
        $error_message = "Error al actualizar los datos del usuario.";
    } else {
        header("Location: usuarios.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Usuario</title>
    <link href="/dist/output.css" rel="stylesheet">
</head>

<body class="bg-white flex">
    <!-- Barra lateral -->
    <div class="bg-[#fff5d2] w-1/4 py-4 px-6 h-screen">
        <!-- ... Código de la barra lateral ... -->
    </div>

    <!-- Contenido principal -->
    <div class="flex-grow py-4 px-6 w-full">
        <div class="flex justify-end mb-4 w-full">
            <!-- ... Código del botón de usuario ... -->
        </div>
        <div class="bg-white p-4 rounded shadow-md h-screen">
            <h2 class="text-2xl font-semibold mb-4">Editar Usuario</h2>
            <?php if (isset($error_message)) : ?>
                <p class="text-red-500"><?= $error_message ?></p>
            <?php endif; ?>
            <form action="editar_usuario.php?id=<?= $user_data['id'] ?>" method="post">
                <label class="block mb-2 font-semibold">Nombre</label>
                <input type="text" name="nombre" value="<?= $user_data['nombre'] ?>" class="border rounded px-2 py-1 mb-2" required>
                <label class="block mb-2 font-semibold">Rol</label>
                <select name="rol" class="border rounded px-2 py-1 mb-2">
                    <option value="admin" <?= ($user_data['rol'] === 'admin') ? 'selected' : '' ?>>Admin</option>
                    <option value="maestro" <?= ($user_data['rol'] === 'maestro') ? 'selected' : '' ?>>Maestro</option>
                    <option value="alumno" <?= ($user_data['rol'] === 'alumno') ? 'selected' : '' ?>>Alumno</option>
                </select>
                <button type="submit" class="bg-blue-500 text-white px-2 py-1 rounded">Guardar Cambios</button>
            </form>
        </div>
    </div>
</body>

</html>
