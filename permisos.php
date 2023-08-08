<?php
session_start();

// Verificar si el usuario está autenticado como administrador
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
    header("Location: index.php");
    exit();
}

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "uniprofn3";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Obtener la lista de usuarios y sus roles de la base de datos
$sql = "SELECT id, nombre, rol FROM usuarios";
$result = $conn->query($sql);

// Manejar la actualización del rol si se envía un formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['user_id']) && isset($_POST['new_role'])) {
    $user_id = $_POST['user_id'];
    $new_role = $_POST['new_role'];

    // Actualizar el rol del usuario en la base de datos
    $update_sql = "UPDATE usuarios SET rol = '$new_role' WHERE id = $user_id";
    if ($conn->query($update_sql) === TRUE) {
        // Redirigir o mostrar un mensaje de éxito
        header("Location: permisos.php");
        exit();
    } else {
        // Manejar el error
        $error_message = "Error al actualizar el rol.";
    }
    if (isset($_POST['user_id']) && isset($_POST['habilitado'])) {
        $user_id = $_POST['user_id'];
        $habilitado = $_POST['habilitado'];

        // Actualizar la habilitación/desactivación del usuario en la base de datos
        $update_sql = "UPDATE usuarios SET habilitado = '$habilitado' WHERE id = $user_id";
        if ($conn->query($update_sql) !== TRUE) {
            $error_message = "Error al actualizar la habilitación.";
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Administración de Permisos</title>
    <link href="/dist/output.css" rel="stylesheet">
</head>
<body class="bg-white flex">
    <!-- Barra lateral -->
    <div class="bg-[#fff5d2] text-black w-1/4 py-4 px-6 h-screen">
        <!-- ... Código de la barra lateral ... -->
        <center>  <img src="./assets/logo.jpg" width="100" height="70" class="self-center"></center>
        <div class="mb-4">
            <p class="text-xl font-semibold"><?= $_SESSION['user_name'] ?></p>
            <p class="text-sm ">Administrador</p>
        </div>
        <hr class="border-t border-gray-700 my-4">
        <p class="text-sm  mb-2">Menú Administración</p>
        <ul class="space-y-2">
            <li><a href="permisos.php" class="flex items-center text-black hover:text-gray-400"><span class="mr-2">Permisos</span><i class="fas fa-user-shield"></i></a></li>
            <li><a href="maestro.php" class="flex items-center text-black hover:text-gray-400"><span class="mr-2">Maestros</span><i class="fas fa-chalkboard-teacher"></i></a></li>
            <li><a href="#" class="flex items-center text-black hover:text-gray-400"><span class="mr-2">Alumnos</span><i class="fas fa-users"></i></a></li>
            <li><a href="#" class="flex items-center text-black hover:text-gray-400"><span class="mr-2">Clases</span><i class="fas fa-book"></i></a></li>
        </ul>
    </div>
    </div>
    <!-- Contenido principal -->
    <div class="flex-grow py-4 px-6 w-full">
        <div class="flex justify-end mb-4 w-full">
            <div class="relative">
            <button class="text-gray-800 font-semibold">
                    <?= $_SESSION['user_name'] ?>
                </button>
                <ul class="absolute right-0 hidden bg-white mt-2 w-32 border shadow-md">
                    <li><a href="#" class="block px-4 py-2 text-gray-800 hover:bg-gray-100">Cerrar Sesión</a></li>
                </ul>
            </div>
        </div>
        <div class="bg-white p-4 rounded shadow-md h-screen">
            <h2 class="text-2xl font-semibold mb-4">Administración de Permisos</h2>
            <?php if (isset($error_message)): ?>
                <p class="text-red-500"><?= $error_message ?></p>
            <?php endif; ?>
            <table class="w-full">
                <thead>
                    <tr>
                        <th class="px-4 py-2">#</th>
                        <th class="px-4 py-2">Nombre</th>
                        <th class="px-4 py-2">Rol</th>
                        <th class="px-4 py-2">Desactivado</th>
                        <th class="px-4 py-2">Editar Rol</th>
                        <th class="px-4 py-2">Habilitar/Desactivar</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo '<tr>';
                            echo '<td class="border px-4 py-2">' . $row['id'] . '</td>';
                            echo '<td class="border px-4 py-2">' . $row['nombre'] . '</td>';
                            echo '<td class="border px-4 py-2">' . $row['rol'] . '</td>';
                            echo '<td class="border px-4 py-2">' . ($row['habilitado'] ? 'Sí' : 'No') . '</td>';
                            echo '<td class="border px-4 py-2">
                                <form action="permisos.php" method="post">
                                    <input type="hidden" name="user_id" value="' . $row['id'] . '">
                                    <select name="new_role" class="border rounded px-2 py-1">';
                                    foreach (['admin', 'maestro', 'alumno'] as $role) {
                                        echo '<option value="' . $role . '" ' . ($role === $row['rol'] ? 'selected' : '') . '>' . ucfirst($role) . '</option>';
                                    }
                            echo '</select>
                                <button type="submit" class="bg-blue-500 text-white px-2 py-1 rounded ml-2">Actualizar</button>
                                </form>
                            </td>';
                            echo '<td class="border px-4 py-2">
                                <form action="permisos.php" method="post">
                                    <input type="hidden" name="user_id" value="' . $row['id'] . '">
                                    <select name="habilitado" class="border rounded px-2 py-1">
                                        <option value="1" ' . ($row['habilitado'] ? 'selected' : '') . '>Habilitado</option>
                                        <option value="0" ' . (!$row['habilitado'] ? 'selected' : '') . '>Desactivado</option>
                                    </select>
                                    <button type="submit" class="bg-blue-500 text-white px-2 py-1 rounded ml-2">Actualizar</button>
                                </form>
                            </td>';
                            echo '</tr>';
                        }
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>