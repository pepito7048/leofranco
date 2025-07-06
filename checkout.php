<?php 
include 'includes/db.php'; 
include 'includes/header.php'; 
session_start(); 
?>

<main class="container mx-auto p-4">
  <h2 class="text-2xl font-bold mb-4">Checkout</h2>

  <?php
  if (!isset($_SESSION['user_id'])) {
    echo "<p>Debes iniciar sesión para continuar.</p>";
  } elseif (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
    echo "<p>Tu carrito está vacío.</p>";
  } elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_SESSION['user_id'];
    $fullname = mysqli_real_escape_string($conn, $_POST['fullname']);
    $address = mysqli_real_escape_string($conn, $_POST['address']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $payment = mysqli_real_escape_string($conn, $_POST['payment_method']);
    $total = 0;

    foreach ($_SESSION['cart'] as $item) {
      $total += $item['price'] * $item['qty'];
    }

    mysqli_query($conn, "INSERT INTO orders (user_id, total, status, fullname, address, phone, payment_method, created_at) 
                         VALUES ($user_id, $total, 'pendiente de pago', '$fullname', '$address', '$phone', '$payment', NOW())");

    $order_id = mysqli_insert_id($conn);

    foreach ($_SESSION['cart'] as $item) {
      $pid = $item['id'];
      $qty = $item['qty'];
      mysqli_query($conn, "INSERT INTO order_items (order_id, product_id, quantity) VALUES ($order_id, $pid, $qty)");
    }

    unset($_SESSION['cart']);
    echo "<p class='text-green-600 font-bold'>Gracias por tu compra. Tu pedido ha sido registrado.</p>";

  } else {
  ?>

  <form method="post" class="grid gap-4 max-w-md" oninput="mostrarMetodoPago()">
    <input type="text" name="fullname" placeholder="Nombre completo" required class="border p-2">
    <input type="text" name="address" placeholder="Dirección de envío" required class="border p-2">
    <input type="text" name="phone" placeholder="Teléfono" required class="border p-2">

    <label class="font-semibold">Método de pago:</label>
    <select name="payment_method" id="metodo_pago" required class="border p-2">
      <option value="">Selecciona una opción</option>
      <option value="Yape">Yape</option>
      <option value="Transferencia">Transferencia bancaria</option>
      <option value="Tarjeta">Tarjeta de débito/crédito</option>
    </select>

    <!-- QR YAPE -->
    <div id="qr_yape" class="hidden border p-2 bg-gray-50 rounded">
      <p class="font-semibold">Escanea este QR con Yape:</p>
      <img src="assets/img/qr_yape.png" alt="QR Yape" class="w-40 mt-2">
    </div>

    <!-- Transferencia -->
    <div id="cuenta_transferencia" class="hidden border p-2 bg-gray-50 rounded">
      <p class="font-semibold">Número de cuenta para transferencia:</p>
      <p class="mt-1">Banco BCP: <strong>123-4567890-0-00</strong></p>
      <p>CCI: <strong>002-123-4567890000-00</strong></p>
    </div>

    <button type="submit" class="bg-blue-600 text-white px-4 py-2">Confirmar Pedido</button>
  </form>

  <script>
    function mostrarMetodoPago() {
      const metodo = document.getElementById('metodo_pago').value;
      document.getElementById('qr_yape').style.display = (metodo === 'Yape') ? 'block' : 'none';
      document.getElementById('cuenta_transferencia').style.display = (metodo === 'Transferencia') ? 'block' : 'none';
    }

    // Mostrar correctamente si se reenvía el formulario
    window.addEventListener('DOMContentLoaded', mostrarMetodoPago);
  </script>

  <?php } ?>
</main>

<?php include 'includes/footer.php'; ?>


