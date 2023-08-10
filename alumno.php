<?php
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'alumno') {
    header("Location: index.php");
    exit();
}

// Verificar si el usuario está autenticado y redireccionar si es necesario

include_once("conexion.php"); // Incluir el archivo de conexión

// Obtener información de maestros, alumnos, clases y calificaciones
// Realiza las consultas SQL necesarias y muestra la información en la página
?>
<!DOCTYPE html>
<html>

<head>
    <title>Panel de Alumnos</title>
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
        <p class="text-sm">Alumno</p>
    </div>
    <hr class="border-t border-gray-700 my-4">
    <p class="text-sm mb-2 text-center">Menú Alumno</p>
    <ul class="space-y-2">
        <li class="flex justify-center"><a href="misclases.php" class="text-black hover:text-gray-400"><span class="mr-2">Mis Clases</span><i class="fas fa-user-shield"></i></a></li>
        
    </ul>
</div>

    <!-- Contenido principal -->
    <div class="w-3/4 py-4 px-6 w-full">
        <div class="bg-white p-4 rounded shadow-md w-90">
            <h2 class="text-2xl font-semibold mb-4">Bienvenido, <?= $_SESSION['user_name'] ?>!</h2>
            <div class="flex-grow py-4 px-6 w-full">
           
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
    </div>
    </div>
        </div>
     <center><img src="./assets/uni.jpg" class=""</center>
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