<?php
session_start();

// Verificar si el usuario está autenticado como administrador
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
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
    <title>Panel de Administrador</title>
    <link href="/dist/output.css" rel="stylesheet">
</head>

<body class="bg-violet-300 flex">
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
            <li><a href="maestro.php" class="flex items-center text-black hover:text-gray-400"><span class="mr-2">Maestros</span><i class="fas fa-chalkboard-teacher"></i></a></li>
            <li><a href="#" class="flex items-center text-black hover:text-gray-400"><span class="mr-2">Alumnos</span><i class="fas fa-users"></i></a></li>
            <li><a href="#" class="flex items-center text-black hover:text-gray-400"><span class="mr-2">Clases</span><i class="fas fa-book"></i></a></li>
        </ul>
    </div>

    <!-- Contenido principal -->
    <div class="w-3/4 py-4 px-6">
        <div class="bg-white p-4 rounded shadow-md">
            <h2 class="text-2xl font-semibold mb-4">Bienvenido, <?= $_SESSION['user_name'] ?>!</h2>
            <!-- Coloca aquí tu mensaje de bienvenida -->
            <div id="cincopa_89f4f6">...</div>
            <script type="text/javascript">
                var cpo = [];
                cpo["_object"] = "cincopa_89f4f6";
                cpo["_fid"] = "AEFAZAPcXpLI";
                var _cpmp = _cpmp || [];
                _cpmp.push(cpo);
                (function() {
                    var cp = document.createElement("script");
                    cp.type = "text/javascript";
                    cp.async = true;
                    cp.src = "https://rtcdn.cincopa.com/libasync.js";
                    var c = document.getElementsByTagName("script")[0];
                    c.parentNode.insertBefore(cp, c);
                })();
            </script>
        </div>
    </div>
</body>

</html>