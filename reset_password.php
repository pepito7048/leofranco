<?php
include 'includes/db.php';
$token = $_GET['token'] ?? '';
$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $token = $_POST['token'];
  $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

  $res = mysqli_query($conn, "SELECT email FROM password_resets WHERE token='$token' ORDER BY created_at DESC LIMIT 1");
  if ($row = mysqli_fetch_assoc($res)) {
    $email = $row['email'];
    mysqli_query($conn, "UPDATE users SET password='$password' WHERE email='$email'");
    mysqli_query($conn, "DELETE FROM password_resets WHERE email='$email'");
    $message = "✅ Contraseña actualizada correctamente. <a href='login.php' class='underline'>Iniciar sesión</a>";
  } else {
    $message = "❌ Token inválido o expirado.";
  }
}
?>

<?php include 'includes/header.php'; ?>
<main class="container mx-auto p-4">
  <h2 class="text-2xl font-bold mb-4">Cambiar Contraseña</h2>
  <?php if ($message) echo "<p class='mb-4 text-blue-600'>$message</p>"; ?>
  <?php if (!$message): ?>
  <form method="post" class="space-y-4 max-w-md">
    <input type="hidden" name="token" value="<?= htmlspecialchars($token) ?>">
    <input name="password" type="password" placeholder="Nueva contraseña" required class="w-full p-2 border">
    <button type="submit" class="bg-green-600 text-white px-4 py-2">Guardar nueva contraseña</button>
  </form>
  <?php endif; ?>
</main>
<?php include 'includes/footer.php'; ?>
