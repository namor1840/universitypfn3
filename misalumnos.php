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

// Obtener el maestro actual
$maestro_id = $_SESSION['user_id'];

// Obtener la lista de alumnos asignados al maestro
$sql = "SELECT a.id AS alumno_id, a.nombre AS alumno_nombre, c.nombre AS clase_nombre
        FROM alumnos a
        INNER JOIN clases c ON a.clase_id = c.id
        INNER JOIN maestros m ON c.id = m.clase_id
        WHERE m.id = $maestro_id";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mis Alumnos</title>
    <link href="/dist/output.css" rel="stylesheet">
</head>
<body class="bg-white flex">
    <!-- Barra lateral -->
    <div class="bg-[#fff5d2] w-1/4 py-4 px-6 h-screen">
        <center> <img src="./assets/logo.jpg" width="100" height="70" class="self-center"></center>
        <div class="mb-4">
            <p class="text-xl font-semibold"><?= $_SESSION['user_name'] ?></p>
            <p class="text-sm ">Maestro</p>
        </div>
        <hr class="border-t border-gray-700 my-4">
        <p class="text-sm  mb-2">Menú Maestros</p>
        <ul class="space-y-2">
            <li><a href="misalumnos.php" class="flex items-center text-black hover:text-gray-400"><span class="mr-2">Alumnos</span><i class="fas fa-user-shield"></i></a></li>
            <hr class="border-t border-gray-700 my-4">
            <li><a href="logout.php" class="flex items-center text-black hover:text-gray-400"><span class="mr-2">Cerrar sesion</span><i class="fas fa-user-shield"></i></a></li>
        </ul>
    </div>
    <!-- Contenido principal -->
    <div class="flex-grow py-4 px-6 w-full">
        <div class="flex justify-end mb-4 w-full">
            <!-- ... Código del botón de cierre de sesión ... -->
        </div>
        <div class="bg-white p-4 rounded shadow-md h-screen">
            <h2 class="text-2xl font-semibold mb-4">Mis Alumnos</h2>
            <table class="w-full">
                <thead>
                    <tr>
                        <th class="px-4 py-2">#</th>
                        <th class="px-4 py-2">Alumno</th>
                        <th class="px-4 py-2">Clase</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo '<tr>';
                            echo '<td class="border px-4 py-2">' . $row['alumno_id'] . '</td>';
                            echo '<td class="border px-4 py-2">' . $row['alumno_nombre'] . '</td>';
                            echo '<td class="border px-4 py-2">' . $row['clase_nombre'] . '</td>';
                            echo '</tr>';
                        }
                    } else {
                        echo '<tr><td colspan="3">No se encontraron alumnos asignados</td></tr>';
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
