<?php
include 'includes/db.php';
require 'includes/PHPMailer/PHPMailer.php';
require 'includes/PHPMailer/SMTP.php';
require 'includes/PHPMailer/Exception.php';
use PHPMailer\PHPMailer\PHPMailer;

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $email = mysqli_real_escape_string($conn, $_POST['email']);
  $token = bin2hex(random_bytes(16));

  $res = mysqli_query($conn, "SELECT * FROM users WHERE email='$email'");
  if (mysqli_num_rows($res) === 1) {
    mysqli_query($conn, "INSERT INTO password_resets (email, token) VALUES ('$email', '$token')");

    $mail = new PHPMailer(true);
    try {
      $mail->isSMTP();
      $mail->Host = 'smtp.gmail.com';
      $mail->SMTPAuth = true;
      $mail->Username = 'ingsistemas412@gmail.com';
      $mail->Password = 'fhnjrxgofajeentc'; // tu clave de app
      $mail->SMTPSecure = 'tls';
      $mail->Port = 587;

      $mail->setFrom('ingsistemas412@gmail.com', 'Soporte Leofranco');
      $mail->addAddress($email);
      $mail->isHTML(true);
      $mail->Subject = 'Recupera tu contraseña';
      $mail->Body = "Haz clic aquí para restablecer tu contraseña:<br>
        <a href='http://localhost/leofranco/reset_password.php?token=$token'>Cambiar contraseña</a>";

      $mail->send();
      $message = "✅ Revisa tu correo para cambiar la contraseña.";
    } catch (Exception $e) {
      $message = "❌ Error al enviar: {$mail->ErrorInfo}";
    }
  } else {
    $message = "❌ Este correo no está registrado.";
  }
}
?>

<?php include 'includes/header.php'; ?>
<main class="container mx-auto p-4">
  <h2 class="text-2xl font-bold mb-4">¿Olvidaste tu contraseña?</h2>
  <?php if ($message) echo "<p class='mb-4 text-blue-600'>$message</p>"; ?>
  <form method="post" class="space-y-4 max-w-md">
    <input name="email" type="email" placeholder="Tu correo registrado" required class="w-full p-2 border">
    <button type="submit" class="bg-blue-600 text-white px-4 py-2">Enviar enlace</button>
  </form>
</main>
<?php include 'includes/footer.php'; ?>
