<?php
session_start();
if (isset($_POST['index'])) {
  $i = $_POST['index'];
  if (isset($_SESSION['cart'][$i])) {
    unset($_SESSION['cart'][$i]);
    $_SESSION['cart'] = array_values($_SESSION['cart']); // Reordenar el índice
  }
}
header('Location: cart.php');
exit();
