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

// Obtener la lista de maestros y sus clases asignadas de la base de datos
$sql = "SELECT m.id AS maestro_id, m.nombre AS maestro_nombre, GROUP_CONCAT(c.nombre SEPARATOR ', ') AS clases_asignadas
        FROM maestros m
        LEFT JOIN clases c ON m.clase_id = c.id
        GROUP BY m.id";
$result = $conn->query($sql);

// Obtener la lista de usuarios que no son maestros para agregar nuevos maestros
$usuarios_sql = "SELECT * FROM usuarios WHERE rol != 'maestro'";
$usuarios_result = $conn->query($usuarios_sql);

// Manejar la actualización de clases asignadas si se envía un formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['maestro_id']) && isset($_POST['clases'])) {
    $maestro_id = $_POST['maestro_id'];
    $clases = implode(',', $_POST['clases']);

    // Actualizar las clases asignadas del maestro en la base de datos
    $update_sql = "UPDATE maestros SET clase_id = '$clases' WHERE id = $maestro_id";
    if ($conn->query($update_sql) !== TRUE) {
        $error_message = "Error al actualizar las clases asignadas del maestro.";
    }
}

// Agregar nuevo maestro desde lista de usuarios
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['usuario_id']) && isset($_POST['clase_id'])) {
    $usuario_id = $_POST['usuario_id'];
    $clase_id = $_POST['clase_id'];

    // Insertar nuevo maestro en la tabla de maestros
    $insert_sql = "INSERT INTO maestros (nombre, email, clase_id) SELECT nombre, email, $clase_id FROM usuarios WHERE id = $usuario_id";
    if ($conn->query($insert_sql) !== TRUE) {
        $error_message = "Error al agregar el nuevo maestro.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Maestros</title>
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

    <!-- Contenido principal -->
    <div class="flex-grow py-4 px-6 w-full">
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
        <div class="bg-white p-4 rounded shadow-md h-screen">
            <h2 class="text-2xl font-semibold mb-4">Lista de Maestros y Clases Asignadas</h2>
            <?php if (isset($error_message)): ?>
                <p class="text-red-500"><?= $error_message ?></p>
            <?php endif; ?>
            <table class="w-full">
                <thead>
                    <tr>
                        <th class="px-4 py-2">#</th>
                        <th class="px-4 py-2">Maestro</th>
                        <th class="px-4 py-2">Clases Asignadas</th>
                        <th class="px-4 py-2">Cambiar Clases</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo '<tr>';
                            echo '<td class="border px-4 py-2">' . $row['maestro_id'] . '</td>';
                            echo '<td class="border px-4 py-2">' . $row['maestro_nombre'] . '</td>';
                            echo '<td class="border px-4 py-2">' . $row['clases_asignadas'] . '</td>';
                            echo '<td class="border px-4 py-2">
                                <form action="maestrolista.php" method="post">
                                    <input type="hidden" name="maestro_id" value="' . $row['maestro_id'] . '">
                                    <select name="clases[]" multiple class="border rounded px-2 py-1" size="3">';
                                        $clases = explode(', ', $row['clases_asignadas']);
                                        $clase_result = $conn->query("SELECT * FROM clases");
                                        if ($clase_result->num_rows > 0) {
                                            while ($clase_row = $clase_result->fetch_assoc()) {
                                                echo '<option value="' . $clase_row['id'] . '" ' . (in_array($clase_row['nombre'], $clases) ? 'selected' : '') . '>' . $clase_row['nombre'] . '</option>';
                                            }
                                        }
                            echo '</select>
                                    <button type="submit" class="bg-blue-500 text-white px-2 py-1 rounded">Guardar</button>
                                </form>
                            </td>';
                            echo '</tr>';
                        }
                    } else {
                        echo '<tr><td colspan="4">No se encontraron maestros</td></tr>';
                    }
                    ?>
                </tbody>
            </table>

            <!-- Formulario para agregar nuevo maestro desde lista de usuarios -->
            <div class="mt-4">
                <h3 class="text-lg font-semibold mb-2">Agregar Nuevo Maestro</h3>
                <form action="maestrolista.php" method="post">
                    <label class="block font-semibold mb-1">Seleccione un Usuario:</label>
                    <select name="usuario_id" class="border rounded px-2 py-1 mb-2" required>
                        <option value="" disabled selected>Seleccione un usuario</option>
                        <?php
                        if ($usuarios_result->num_rows > 0) {
                            while ($usuario_row = $usuarios_result->fetch_assoc()) {
                                echo '<option value="' . $usuario_row['id'] . '">' . $usuario_row['nombre'] . '</option>';
                            }
                        }
                        ?>
                    </select>
                    <label class="block font-semibold mb-1">Seleccione una Clase:</label>
                    <select name="clase_id" class="border rounded px-2 py-1 mb-2" required>
                        <option value="" disabled selected>Seleccione una clase</option>
                        <?php
                        $clase_result = $conn->query("SELECT * FROM clases");
                        if ($clase_result->num_rows > 0) {
                            while ($clase_row = $clase_result->fetch_assoc()) {
                                echo '<option value="' . $clase_row['id'] . '">' . $clase_row['nombre'] . '</option>';
                            }
                        }
                        ?>
                    </select>
                    <button type="submit" class="bg-blue-500 text-white px-2 py-1 rounded">Agregar Maestro</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
