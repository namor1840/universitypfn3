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

// Obtener la lista de alumnos y sus clases asignadas
$sql = "SELECT a.id AS alumno_id, a.nombre AS alumno_nombre, c.id AS clase_id, c.nombre AS clase_nombre
        FROM alumnos a
        LEFT JOIN clases c ON a.clase_id = c.id";
$result = $conn->query($sql);

// Obtener la lista de todas las clases para el formulario de cambio
$sql_clases = "SELECT id, nombre FROM clases";
$result_clases = $conn->query($sql_clases);

// Manejar la actualización de la clase si se envía un formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['alumno_id']) && isset($_POST['nueva_clase_id'])) {
    $alumno_id = $_POST['alumno_id'];
    $nueva_clase_id = $_POST['nueva_clase_id'];

    // Actualizar la clase asignada del alumno en la base de datos
    $update_sql = "UPDATE alumnos SET clase_id = $nueva_clase_id WHERE id = $alumno_id";
    if ($conn->query($update_sql) !== TRUE) {
        $error_message = "Error al actualizar la clase asignada.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Alumnos</title>
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
          
        </div>
        <div class="bg-white p-4 rounded shadow-md h-screen">
            <h2 class="text-2xl font-semibold mb-4">Lista de Alumnos</h2>
            <?php if (isset($error_message)): ?>
                <p class="text-red-500"><?= $error_message ?></p>
            <?php endif; ?>
            <table class="w-full">
                <thead>
                    <tr>
                        <th class="px-4 py-2">#</th>
                        <th class="px-4 py-2">Alumno</th>
                        <th class="px-4 py-2">Clase Asignada</th>
                        <th class="px-4 py-2">Cambiar Clase</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo '<tr>';
                            echo '<td class="border px-4 py-2">' . $row['alumno_id'] . '</td>';
                            echo '<td class="border px-4 py-2">' . $row['alumno_nombre'] . '</td>';
                            echo '<td class="border px-4 py-2">' . ($row['clase_nombre'] ?: 'Ninguna') . '</td>';
                            echo '<td class="border px-4 py-2">
                                <form action="alumnolista.php" method="post">
                                    <input type="hidden" name="alumno_id" value="' . $row['alumno_id'] . '">
                                    <select name="nueva_clase_id" class="border rounded px-2 py-1">';
                                    echo '<option value="">Seleccione una clase</option>';
                                    while ($clase = $result_clases->fetch_assoc()) {
                                        echo '<option value="' . $clase['id'] . '">' . $clase['nombre'] . '</option>';
                                    }
                            echo '</select>
                                <button type="submit" class="bg-blue-500 text-white px-2 py-1 rounded ml-2">Cambiar</button>
                                </form>
                            </td>';
                            echo '</tr>';
                        }
                    } else {
                        echo '<tr><td colspan="4">No se encontraron alumnos</td></tr>';
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
