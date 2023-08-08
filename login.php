<?php
session_start();
ini_set('display_errors', 1); error_reporting(-1);
// Verificar si el usuario ya está autenticado, en ese caso redireccionar
if (isset($_SESSION['user_id'])) {
    switch ($_SESSION['user_role']) {
        case 'admin':
            header("Location: admin.php");
            exit();
        case 'maestro':
            header("Location: maestro.php");
            exit();
        case 'alumno':
            header("Location: alumno.php");
            exit();
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Archivo de conexión a la base de datos (ajusta los datos según tu configuración)
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "universidad";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Conexión fallida: " . $conn->connect_error);
    }

    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql = "SELECT id, nombre, rol, habilitado FROM usuarios WHERE email = '$email' AND password = '$password'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        if ($row['habilitado'] == 0) {
            $error_message = "El usuario está desactivado.";
        } else {
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['user_name'] = $row['nombre'];
            $_SESSION['user_role'] = $row['rol'];

            if ($row['rol'] === 'admin') {
                header("Location: admin.php");
            } elseif ($row['rol'] === 'maestro') {
                header("Location: maestro.php");
            } elseif ($row['rol'] === 'alumno') {
                header("Location: alumno.php");
            }
            exit();
        }
    } else {
        $error_message = "Credenciales inválidas.";
    }

    $conn->close();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Inicio de sesión</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center">
    <div class="bg-white max-w-md p-6 rounded shadow-md">
        <h2 class="text-2xl font-semibold mb-6">Iniciar sesión</h2>
        <?php if (isset($error_message)): ?>
        <p class="text-red-500 mb-4"><?= $error_message ?></p>
        <?php endif; ?>
        <form action="login.php" method="post">
            <div class="mb-4">
                <label for="email" class="block text-gray-700 text-sm font-bold mb-2">Email:</label>
                <input type="text" name="email" id="email" required
                       class="w-full px-3 py-2 rounded border border-gray-300 focus:outline-none focus:border-blue-500">
            </div>

            <div class="mb-6">
                <label for="password" class="block text-gray-700 text-sm font-bold mb-2">Contraseña:</label>
                <input type="password" name="password" id="password" required
                       class="w-full px-3 py-2 rounded border border-gray-300 focus:outline-none focus:border-blue-500">
            </div>

            <div class="flex justify-end">
                <input type="submit" value="Iniciar sesión"
                       class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">
            </div>
        </form>
    </div>
</body>
</html>
