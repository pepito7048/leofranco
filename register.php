<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include 'includes/db.php';
require 'includes/PHPMailer/PHPMailer.php';
require 'includes/PHPMailer/SMTP.php';
require 'includes/PHPMailer/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $email = mysqli_real_escape_string($conn, $_POST['email']);
  $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
  $token = bin2hex(random_bytes(16));

  // Validar que no esté registrado
  $exists = mysqli_query($conn, "SELECT * FROM users WHERE email='$email'");
  if (mysqli_num_rows($exists) > 0) {
    $message = "❌ Este correo ya está registrado.";
  } else {
    // Insertar en tabla temporal
    mysqli_query($conn, "INSERT INTO pending_users (email, password, token) VALUES ('$email', '$password', '$token')");

    // Enviar correo
    $mail = new PHPMailer(true);
    try {
      $mail->isSMTP();
      $mail->Host = 'smtp.gmail.com';
      $mail->SMTPAuth = true;
      $mail->Username = 'ingsistemas412@gmail.com'; // ✅ TU CORREO
      $mail->Password = 'fhnjrxgofajeentc';         // ✅ TU CLAVE DE APP GMAIL
      $mail->SMTPSecure = 'tls';
      $mail->Port = 587;

      $mail->setFrom('ingsistemas412@gmail.com', 'Leofranco Importaciones');
      $mail->addAddress($email);
      $mail->isHTML(true);
      $mail->Subject = 'Confirma tu cuenta';
      $mail->Body = "Hola,<br><br>
        Gracias por registrarte. Haz clic en el siguiente enlace para confirmar tu cuenta:<br><br>
        <a href='http://localhost/leofranco/verificar_registro.php?token=$token'>
        Verificar mi cuenta</a><br><br>
        Si no solicitaste esto, ignora este correo.";

      $mail->send();
      $message = "✅ Revisa tu correo para confirmar tu cuenta.";
    } catch (Exception $e) {
      $message = "❌ Error al enviar el correo: {$mail->ErrorInfo}";
    }
  }
}
?>

<?php include 'includes/header.php'; ?>
<main class="container mx-auto p-4">
  <h2 class="text-2xl font-bold mb-4">Registrarse</h2>
  <?php if ($message) echo "<p class='text-blue-600 mb-4'>$message</p>"; ?>
  <form method="post" class="space-y-4 max-w-md">
    <input name="email" type="email" placeholder="Correo electrónico" required class="w-full p-2 border">
    <input name="password" type="password" placeholder="Contraseña" required class="w-full p-2 border">
    <button type="submit" class="bg-blue-600 text-white px-4 py-2">Crear cuenta</button>
  </form>
</main>
<?php include 'includes/footer.php'; ?>




