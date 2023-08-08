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

// Obtener la lista de maestros y sus clases asignadas de la base de datos
$sql = "SELECT m.id AS maestro_id, m.nombre AS maestro_nombre, GROUP_CONCAT(c.nombre SEPARATOR ', ') AS clases_asignadas
        FROM maestros m
        LEFT JOIN clases c ON m.clase_id = c.id
        GROUP BY m.id";
$result = $conn->query($sql);

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
            <!-- ... Código del botón de cierre de sesión ... -->
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
        </div>
    </div>
</body>
</html>
