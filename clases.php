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

// Obtener la lista de clases y los maestros asignados de la base de datos
$sql = "SELECT c.id AS clase_id, c.nombre AS clase_nombre, m.id AS maestro_id, m.nombre AS maestro_nombre
        FROM clases c
        LEFT JOIN maestros m ON c.id = m.clase_id";
$result = $conn->query($sql);

// Manejar la actualización del maestro asignado si se envía un formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['clase_id']) && isset($_POST['maestro_id'])) {
    $clase_id = $_POST['clase_id'];
    $maestro_id = $_POST['maestro_id'];

    // Actualizar el maestro asignado en la tabla 'maestros'
    $update_sql = "UPDATE maestros SET clase_id = $clase_id WHERE id = $maestro_id";
    if ($conn->query($update_sql) !== TRUE) {
        $error_message = "Error al actualizar el maestro asignado.";
    }

    // Redirigir después de procesar la solicitud
    header("Location: clases.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Clases y Maestros Asignados</title>
    <link href="/dist/output.css" rel="stylesheet">
</head>
<body class="bg-white flex">
    <!-- Barra lateral -->
 <div class="bg-[#fff5d2] w-1/4 py-4 px-6 h-screen fixed top-0 left-0 bottom-0 overflow-y-auto border-r-2 border-gray-300">
    <center> <img src="./assets/logo.jpg" width="230" height="70" class="self-center"></center>
    <div class="mb-4 text-center">
        <p class="text-xl font-semibold"><?= $_SESSION['user_name'] ?></p>
        <p class="text-sm">Administrador</p>
    </div>
    <hr class="border-t border-gray-700 my-4">
    <p class="text-sm mb-2 text-center">Menú Administración</p>
    <ul class="space-y-2">
        <li class="flex justify-center"><a href="permisos.php" class="text-black hover:text-gray-400"><span class="mr-2">Permisos</span><i class="fas fa-user-shield"></i></a></li>
        <li class="flex justify-center"><a href="maestrolista.php" class="text-black hover:text-gray-400"><span class="mr-2">Maestros</span><i class="fas fa-chalkboard-teacher"></i></a></li>
        <li class="flex justify-center"><a href="alumnolista.php" class="text-black hover:text-gray-400"><span class="mr-2">Alumnos</span><i class="fas fa-users"></i></a></li>
        <li class="flex justify-center"><a href="clases.php" class="text-black hover:text-gray-400"><span class="mr-2">Clases</span><i class="fas fa-book"></i></a></li>
        <li class="flex justify-center"><a href="usuarios.php" class="text-black hover:text-gray-400"><span class="mr-2">Usuarios</span><i class="fas fa-users"></i></a></li>
    </ul>
</div>

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
        </div>            </div>
        <div class="bg-white p-4 rounded shadow-md h-screen">
            <h2 class="text-2xl font-semibold mb-4">Lista de Clases y Maestros Asignados</h2>
            <?php if (isset($error_message)): ?>
                <p class="text-red-500"><?= $error_message ?></p>
            <?php endif; ?>
            <table class="w-full">
                <thead>
                    <tr>
                        <th class="px-4 py-2">#</th>
                        <th class="px-4 py-2">Clase</th>
                        <th class="px-4 py-2">Maestro Asignado</th>
                        <th class="px-4 py-2">Cambiar Maestro</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo '<tr>';
                            echo '<td class="border px-4 py-2">' . $row['clase_id'] . '</td>';
                            echo '<td class="border px-4 py-2">' . $row['clase_nombre'] . '</td>';
                            echo '<td class="border px-4 py-2">' . ($row['maestro_nombre'] ?: 'Sin Asignar') . '</td>';
                            echo '<td class="border px-4 py-2">
                                <form action="clases.php" method="post">
                                    <input type="hidden" name="clase_id" value="' . $row['clase_id'] . '">
                                    <select name="maestro_id" class="border rounded px-2 py-1">
                                        <option value="">Sin Asignar</option>';
                            // Obtener la lista de maestros para el select
                            $maestros_sql = "SELECT id, nombre FROM maestros";
                            $maestros_result = $conn->query($maestros_sql);
                            while ($maestro = $maestros_result->fetch_assoc()) {
                                echo '<option value="' . $maestro['id'] . '" ' . ($maestro['id'] == $row['maestro_id'] ? 'selected' : '') . '>' . $maestro['nombre'] . '</option>';
                            }
                            echo '</select>
                                    <button type="submit" class="bg-blue-500 text-white px-2 py-1 rounded ml-2">Actualizar</button>
                                </form>
                            </td>';
                            echo '</tr>';
                        }
                    } else {
                        echo '<tr><td colspan="4">No se encontraron clases</td></tr>';
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
