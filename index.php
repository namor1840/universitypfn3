<!doctype html>
<html>
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="/dist/output.css" rel="stylesheet">
</head>
<body>
<body class="bg-violet-300 min-h-screen flex items-center justify-center">
    <div class="bg-[#fff5d2] max-w-md p-6 rounded shadow-md">
    <img class="w-[400px] h-[375px]" src="./assets/logo.jpg" alt="log-icon">
        <h2 class="text-2xl font-semibold mb-6">Iniciar sesión</h2>
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