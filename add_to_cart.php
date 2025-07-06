<?php session_start();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $item = [
    'id' => $_POST['id'],
    'name' => $_POST['name'],
    'price' => $_POST['price'],
    'qty' => $_POST['qty']
  ];
  $_SESSION['cart'][] = $item;
}
header("Location: cart.php");