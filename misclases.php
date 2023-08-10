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

// Obtener la información del alumno actual
$user_id = $_SESSION['user_id'];
$sql_alumno = "SELECT u.nombre AS alumno_nombre, c.nombre AS clase_asignada
               FROM usuarios u
               LEFT JOIN alumnos a ON u.id = a.id
               LEFT JOIN clases c ON a.clase_id = c.id
               WHERE u.id = $user_id";
$result_alumno = $conn->query($sql_alumno);
$row_alumno = $result_alumno->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mis Materias</title>
    <link href="/dist/output.css" rel="stylesheet">
</head>

<body class="bg-white flex">
    <!-- Barra lateral -->
    <div class="bg-[#fff5d2] w-1/4 py-4 px-6 h-screen fixed top-0 left-0 bottom-0 overflow-y-auto border-r-2 border-gray-300">
        <center> <img src="./assets/logo.jpg" width="230" height="70" class="self-center"></center>
        <div class="mb-4 text-center">
            <p class="text-xl font-semibold"><?= $_SESSION['user_name'] ?></p>
            <p class="text-sm">Alumno</p>
        </div>
        <hr class="border-t border-gray-700 my-4">
        <p class="text-sm mb-2 text-center">Menú Alumno</p>
        <ul class="space-y-2">
            <li class="flex justify-center"><a href="mismaterias.php" class="text-black hover:text-gray-400"><span class="mr-2">Mis Materias</span><i class="fas fa-book"></i></a></li>
            <li class="flex justify-center"><a href="cambiarclase.php" class="text-black hover:text-gray-400"><span class="mr-2">Cambiar Clase</span><i class="fas fa-exchange-alt"></i></a></li>
            <li class="flex justify-center"><a href="logout.php" class="text-black hover:text-gray-400"><span class="mr-2">Cerrar Sesión</span><i class="fas fa-sign-out-alt"></i></a></li>
        </ul>
    </div>

    <!-- Contenido principal -->
    <div class="flex-grow py-4 px-6 w-full">
        <div class="bg-white p-4 rounded shadow-md h-screen">
            <h2 class="text-2xl font-semibold mb-4">Mis Materias</h2>
            <p class="mb-4">Bienvenido, <?= $row_alumno['alumno_nombre'] ?>. Aquí está tu materia asignada:</p>
            <table class="w-full">
                <thead>
                    <tr>
                        <th class="px-4 py-2">Alumno</th>
                        <th class="px-4 py-2">Materia Asignada</th>
                        <th class="px-4 py-2">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="border px-4 py-2"><?= $row_alumno['alumno_nombre'] ?></td>
                        <td class="border px-4 py-2"><?= $row_alumno['clase_asignada'] ?></td>
                        <td class="border px-4 py-2">
                            <a href="cambiarclase.php" class="text-blue-500"><i class="fas fa-edit"></i> Cambiar Clase</a>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</body>

</html>
