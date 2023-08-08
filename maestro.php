<?php
session_start();

// Verificar si el usuario está autenticado como administrador o maestro
if (!isset($_SESSION['user_id']) || ($_SESSION['user_role'] !== 'admin' && $_SESSION['user_role'] !== 'maestro')) {
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

// Obtener la lista de maestros y sus clases asignadas de la base de datos
$sql = "SELECT id, nombre, email, fecha_nacimiento, clase_asignada FROM maestros";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Maestros</title>
    <link href="./dist/output.css" rel="stylesheet">
</head>
<body class="bg-white flex">
    <!-- Barra lateral -->
    <div class="bg-[#fff5d2] w-1/4 py-4 px-6 h-screen">
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
        <div class="bg-white p-4 rounded shadow-md">
            <h2 class="text-2xl font-semibold mb-4">Maestros</h2>
            <table class="w-full">
                <thead>
                    <tr>
                        <th class="px-4 py-2">#</th>
                        <th class="px-4 py-2">Nombre</th>
                        <th class="px-4 py-2">Email</th>
                        <th class="px-4 py-2">Fecha de Nacimiento</th>
                        <th class="px-4 py-2">Clase Asignada</th>
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
                            echo '<td class="border px-4 py-2">' . $row['fecha_nacimiento'] . '</td>';
                            echo '<td class="border px-4 py-2">' . $row['clase_asignada'] . '</td>';
                            echo '<td class="border px-4 py-2">
                                <button class="bg-blue-500 text-white px-2 py-1 rounded">Editar</button>
                            </td>';
                            echo '</tr>';
                        }
                    }
                    ?>
                </tbody>
            </table>
            <?php if ($_SESSION['user_role'] === 'admin' || $_SESSION['user_role'] === 'maestro'): ?>
            <div class="mt-4">
                <button class="bg-green-500 text-white px-4 py-2 rounded">Crear Nuevo</button>
            </div>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
