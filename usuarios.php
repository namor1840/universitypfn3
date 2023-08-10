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

// Obtener la lista de usuarios y sus roles de la base de datos
$sql = "SELECT id, nombre, rol FROM usuarios";
$result = $conn->query($sql);

// Manejar la eliminación de usuarios si se envía un formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_user'])) {
    $user_id = $_POST['delete_user'];

    // Eliminar el usuario de la base de datos
    $delete_sql = "DELETE FROM usuarios WHERE id = $user_id";
    if ($conn->query($delete_sql) !== TRUE) {
        $error_message = "Error al eliminar el usuario.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administración de Usuarios</title>
    <link href="/dist/output.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
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
        <p class="text-sm">Administrador</p>
    </div>
    <hr class="border-t border-gray-700 my-4">
    <p class="text-sm mb-2 text-center">Menú Administración</p>
    <ul class="space-y-2">
        <li class="flex justify-center"><a href="permisos.php" class="text-black hover:text-gray-400"><span class="mr-2">Permisos</span></a></li>
        <li class="flex justify-center"><a href="maestrolista.php" class="text-black hover:text-gray-400"><span class="mr-2">Maestros</span></a></li>
        <li class="flex justify-center"><a href="alumnolista.php" class="text-black hover:text-gray-400"><span class="mr-2">Alumnos</span></a></li>
        <li class="flex justify-center"><a href="clases.php" class="text-black hover:text-gray-400"><span class="mr-2">Clases</span></a></li>
        <li class="flex justify-center"><a href="usuarios.php" class="text-black hover:text-gray-400"><span class="mr-2">Usuarios</span></a></li>
    </ul>
</div>


    <!-- Contenido principal -->
    <div class="flex-grow py-4 px-6 w-full">
        <div class="bg-white p-4 rounded shadow-md h-screen">
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
            <h2 class="text-2xl font-semibold mb-4">Administración de Usuarios</h2>
            <?php if (isset($error_message)) : ?>
                <p class="text-red-500"><?= $error_message ?></p>
            <?php endif; ?>
            <table class="w-full">
                <thead>
                    <tr>
                        <th class="px-4 py-2">#</th>
                        <th class="px-4 py-2">Nombre</th>
                        <th class="px-4 py-2">Rol</th>
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
                            echo '<td class="border px-4 py-2">' . ucfirst($row['rol']) . '</td>';
                            echo '<td class="border px-4 py-2">
                                <a href="editar_usuario.php?id=' . $row['id'] . '" class="text-blue-500"><i class="fas fa-edit"></i></a>
                                <form action="usuarios.php" method="post" class="inline">
                                    <input type="hidden" name="delete_user" value="' . $row['id'] . '">
                                    <button type="submit" class="text-red-500" onclick="return confirm(\'¿Estás seguro de eliminar este usuario?\')"><i class="fas fa-trash"></i></button>
                                </form>
                            </td>';
                            echo '</tr>';
                        }
                    } else {
                        echo '<tr><td colspan="4">No se encontraron usuarios</td></tr>';
                    }
                    ?>
                </tbody>
            </table>
            <!-- Botón para agregar nuevo usuario -->
            <div class="mt-4">
                <a href="nuevo_usuario.php" class="bg-blue-500 text-white px-4 py-2 rounded">
                    <i class="fas fa-user-plus"></i> Agregar Nuevo Usuario
                </a>
            </div>
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
