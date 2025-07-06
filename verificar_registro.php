<?php
include 'includes/db.php';

$token = $_GET['token'] ?? '';

if ($token) {
  $res = mysqli_query($conn, "SELECT * FROM pending_users WHERE token = '$token'");
  if (mysqli_num_rows($res) === 1) {
    $data = mysqli_fetch_assoc($res);

    // Crear usuario real
    $email = $data['email'];
    $password = $data['password'];

    mysqli_query($conn, "INSERT INTO users (email, password) VALUES ('$email', '$password')");

    // Eliminar de tabla temporal
    mysqli_query($conn, "DELETE FROM pending_users WHERE token = '$token'");

    echo "Cuenta creada y verificada. Ya puedes iniciar sesión.";
  } else {
    echo "Token inválido o ya verificado.";
  }
} else {
  echo "Token faltante.";
}
?>

