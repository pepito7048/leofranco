<?php include 'includes/db.php'; session_start(); ?>
<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $pass = $_POST['password'];

    $query = mysqli_query($conn, "SELECT * FROM users WHERE email='$email'");
    if ($user = mysqli_fetch_assoc($query)) {
        if (password_verify($pass, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['role'] = $user['role'];
            header("Location: index.php");
            exit();
        } else {
            $error = "Contraseña incorrecta.";
        }
    } else {
        $error = "Correo no registrado.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Iniciar sesión - Mundo Bici</title>
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
  <style>
    body {
      font-family: 'Inter', sans-serif;
      background-image: url('https://images.unsplash.com/photo-1586769852836-daa4d50a01c1?auto=format&fit=crop&w=1470&q=80');
      background-size: cover;
      background-position: center;
    }
    .backdrop {
      backdrop-filter: blur(6px);
      background-color: rgba(255, 255, 255, 0.85);
    }
  </style>
</head>
<body class="flex items-center justify-center min-h-screen p-4">

  <div class="w-full max-w-md p-8 rounded-xl shadow-2xl backdrop">
    <div class="flex items-center justify-center mb-6">
      <img src="https://cdn-icons-png.flaticon.com/512/747/747310.png" class="w-12 h-12 mr-2" alt="Bici logo">
      <h2 class="text-2xl font-bold text-gray-800">Bienvenido a Mundo Bici</h2>
    </div>

    <?php if (isset($error)) echo "<p class='text-red-600 text-sm mb-4 text-center'>$error</p>"; ?>

    <form method="post" class="space-y-4">
      <div>
        <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Correo electrónico</label>
        <input name="email" type="email" placeholder="correo@ejemplo.com"
               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500 text-sm" required>
      </div>

      <div>
        <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Contraseña</label>
        <input name="password" type="password" placeholder="********"
               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500 text-sm" required>
      </div>

      <button type="submit"
              class="w-full bg-green-600 hover:bg-green-700 text-white text-sm font-medium py-2 rounded-md transition-all duration-200">
        Ingresar
      </button>
    </form>

    <div class="mt-6 text-center text-sm text-gray-600">
      ¿No tienes cuenta? <a href="register.php" class="text-green-600 hover:underline">Regístrate aquí</a><br>
      ¿Olvidaste tu contraseña? <a href="forgot_password.php" class="text-green-600 hover:underline">Recupérala aquí</a>
    </div>
  </div>

</body>
</html>

