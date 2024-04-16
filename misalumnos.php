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
    <style>
        /* Estilos CSS para el menú desplegable */
        .user-menu {
            display: none;
            position: absolute;
            background-color: white;
            border: 1px solid #ccc;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            z-index: 1;
        }

        .user-button:hover + .user-menu,
        .user-menu:hover {
            display: block;
        }
    </style>
</head>
<body class="bg-white flex">
    <!-- Barra lateral -->
    <div class="bg-[#fff5d2] w-1/4 py-4 px-6 h-screen fixed top-0 left-0 bottom-0 overflow-y-auto border-r-2 border-gray-300">
    <center> <img src="./assets/logo.jpg" width="230" height="70" class="self-center"></center>
    <div class="mb-4 text-center">
        <p class="text-xl font-semibold"><?= $_SESSION['user_name'] ?></p>
        <p class="text-sm">Maestro</p>
    </div>
    <hr class="border-t border-gray-700 my-4">
    <p class="text-sm mb-2 text-center">Menú Maestros</p>
    <ul class="space-y-2">
        <li class="flex justify-center"><a href="misalumnos.php" class="text-black hover:text-gray-400"><span class="mr-2">Permisos</span><i class="fas fa-user-shield"></i></a></li>
        
    </ul>
</div>
    <!-- Contenido principal -->
    <div class="flex-grow py-4 px-6 w-full">
        <div class="flex justify-end mb-4 w-full">
        <div class="flex justify-end mb-4 w-full">
        <div class="relative">
            <button class="user-button text-gray-800 font-semibold">
                <?= $_SESSION['user_name'] ?>
            </button>
            <ul class="user-menu absolute hidden bg-white mt-2 w-32 border shadow-md">
                <li><a href="editarperfil.php" class="block px-4 py-2 text-gray-800 hover:bg-gray-100">Editar Perfil</a></li>
                <li><a href="logout.php" class="block px-4 py-2 text-gray-800 hover:bg-gray-100">Cerrar Sesión</a></li>
            </ul>
        </div>
        </div>            </div>
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
    <script>
        // JavaScript para cerrar el menú desplegable cuando se hace clic fuera de él
        window.addEventListener('click', function(event) {
            var userMenu = document.querySelector('.user-menu');
            if (!userMenu.contains(event.target)) {
                userMenu.style.display = 'none';
            }
        });
    </script>
</body>
</html>
