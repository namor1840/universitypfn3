<?php
session_start();

$servername = "localhost";
$username = "id21126023_root";
$password = "Roman18*";
$dbname = "id21126023_universidad";


$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Obtener la lista de usuarios y sus roles de la base de datos
$sql = "SELECT id, nombre, email, rol, habilitado FROM usuarios";
$result = $conn->query($sql);

// Manejar la actualización de usuarios si se envía un formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['edit_user'])) {
        $user_id = $_POST['edit_user'];
        $nombre = $_POST['nombre'];
        $email = $_POST['email'];
        $rol = $_POST['rol'];

        // Actualizar los datos del usuario en la base de datos
        $update_sql = "UPDATE usuarios SET nombre = '$nombre', email = '$email', rol = '$rol' WHERE id = $user_id";
        if ($conn->query($update_sql) !== TRUE) {
            $error_message = "Error al actualizar los datos del usuario.";
        }
    } elseif (isset($_POST['delete_user'])) {
        $user_id = $_POST['delete_user'];

        // Eliminar el usuario de la base de datos
        $delete_sql = "DELETE FROM usuarios WHERE id = $user_id";
        if ($conn->query($delete_sql) !== TRUE) {
            $error_message = "Error al eliminar el usuario.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administración de Usuarios</title>
    <link href="/dist/output.css" rel="stylesheet">
</head>

<body class="bg-white flex">
    <!-- Barra lateral -->
    <div class="bg-[#fff5d2] w-1/4 py-4 px-6 h-screen">
        <center> <img src="./assets/logo.jpg" width="100" height="70" class="self-center"></center>
        <div class="mb-4">
            <p class="text-xl font-semibold"><?= $_SESSION['user_name'] ?></p>
            <p class="text-sm ">Administrador</p>
        </div>
        <hr class="border-t border-gray-700 my-4">
        <p class="text-sm  mb-2">Menú Administración</p>
        <ul class="space-y-2">
            <li><a href="permisos.php" class="flex items-center text-black hover:text-gray-400"><span class="mr-2">Permisos</span><i class="fas fa-user-shield"></i></a></li>
            <li><a href="maestrolista.php" class="flex items-center text-black hover:text-gray-400"><span class="mr-2">Maestros</span><i class="fas fa-chalkboard-teacher"></i></a></li>
            <li><a href="alumnolista.php" class="flex items-center text-black hover:text-gray-400"><span class="mr-2">Alumnos</span><i class="fas fa-users"></i></a></li>
            <li><a href="clases.php" class="flex items-center text-black hover:text-gray-400"><span class="mr-2">Clases</span><i class="fas fa-book"></i></a></li>
            <li><a href="usuarios.php" class="flex items-center text-black hover:text-gray-400"><span class="mr-2">Usuarios</span><i class="fas fa-book"></i></a></li>
        </ul>
    </div>

    <!-- Contenido principal -->
    <div class="flex-grow py-4 px-6 w-full">
        <div class="flex justify-end mb-4 w-full">
            <div class="flex justify-end mb-4 w-full">
                <div class="relative">
                    <button class="text-gray-800 font-semibold">
                        <?= $_SESSION['user_name'] ?>
                    </button>
                    <ul class="absolute right-0 hidden bg-white mt-2 w-32 border shadow-md">
                        <li><a href="logout.php" class="block px-4 py-2 text-gray-800 hover:bg-gray-100">Cerrar Sesión</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="bg-white p-4 rounded shadow-md h-screen">
            <h2 class="text-2xl font-semibold mb-4">Administración de Usuarios</h2>
            <?php if (isset($error_message)) : ?>
                <p class="text-red-500"><?= $error_message ?></p>
            <?php endif; ?>
            <form action="usuarios.php" method="post" class="mb-4">
                <label class="block mb-2 font-semibold">Agregar Nuevo Usuario</label>
                <input type="text" name="nombre" placeholder="Nombre" class="border rounded px-2 py-1 mb-2" required>
                <input type="email" name="email" placeholder="Email" class="border rounded px-2 py-1 mb-2" required>
                <input type="password" name="password" placeholder="Contraseña" class="border rounded px-2 py-1 mb-2" required>
                <select name="rol" class="border rounded px-2 py-1 mb-2">
                    <option value="admin">Admin</option>
                    <option value="maestro">Maestro</option>
                    <option value="alumno">Alumno</option>
                </select>
                <button type="submit" class="bg-blue-500 text-white px-2 py-1 rounded">Agregar Usuario</button>
            </form>
            <table class="w-full">
                <thead>
                    <tr>
                        <th class="px-4 py-2">#</th>
                        <th class="px-4 py-2">Nombre</th>
                        <th class="px-4 py-2">Email</th>
                        <th class="px-4 py-2">Rol</th>
                        <th class="px-4 py-2">Habilitado</th>
                        <th class="px-4 py-2">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo '<tr>';
                            echo '<td class="border px-4 py-2">' . $row['id'] . '</td>';
                            echo '<td class="border px-4 py-2">' . $row['nombre'] . '</td>';
                            echo '<td class="border px-4 py-2">' . $row['email'] . '</td>';
                            echo '<td class="border px-4 py-2">' . ucfirst($row['rol']) . '</td>';
                            echo '<td class="border px-4 py-2">' . ($row['habilitado'] ? 'Sí' : 'No') . '</td>';
                            echo '<td class="border px-4 py-2">
                                <form action="usuarios.php" method="post">
                                    <input type="hidden" name="edit_user" value="' . $row['id'] . '">
                                    <input type="text" name="nombre" value="' . $row['nombre'] . '" class="border rounded px-2 py-1 mb-2" required>
                                    <input type="email" name="email" value="' . $row['email'] . '" class="border rounded px-2 py-1 mb-2" required>
                                    <select name="rol" class="border rounded px-2 py-1 mb-2">
                                        <option value="admin" ' . ($row['rol'] === 'admin' ? 'selected' : '') . '>Admin</option>
                                        <option value="maestro" ' . ($row['rol'] === 'maestro' ? 'selected' : '') . '>Maestro</option>
                                        <option value="alumno" ' . ($row['rol'] === 'alumno' ? 'selected' : '') . '>Alumno</option>
                                    </select>
                                    <button type="submit" class="bg-blue-500 text-white px-2 py-1 rounded">Guardar</button>
                                </form>
                                <form action="usuarios.php" method="post" onsubmit="return confirm(\'¿Estás seguro de eliminar este usuario?\')">
                                    <input type="hidden" name="delete_user" value="' . $row['id'] . '">
                                    <button type="submit" class="bg-red-500 text-white px-2 py-1 rounded">Eliminar</button>
                                </form>
                            </td>';
                            echo '</tr>';
                        }
                    } else {
                        echo '<tr><td colspan="6">No se encontraron usuarios</td></tr>';
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</body>

</html>