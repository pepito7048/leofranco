<?php include 'includes/db.php'; include 'includes/auth.php'; include 'includes/header.php'; ?>
<main class="container mx-auto p-4">
  <h2 class="text-2xl font-bold mb-4">Mis Pedidos</h2>
  <?php if (!isLoggedIn()) {
    echo "<p>Debes iniciar sesión para ver tus pedidos.</p>";
  } else {
    $user_id = $_SESSION['user_id'];
    $orders = mysqli_query($conn, "SELECT * FROM orders WHERE user_id=$user_id ORDER BY id DESC");
    while ($o = mysqli_fetch_assoc($orders)) {
      echo "<div class='border p-4 mb-4'>";
      echo "<h3 class='font-bold'>Pedido #{$o['id']}</h3>";
      echo "<p>Total: S/ {$o['total']}</p>";
      echo "<p>Estado: <span class='font-semibold text-blue-600'>{$o['status']}</span></p>";
      echo "<p>Fecha: {$o['created_at']}</p>";

      // Mostrar botón de boleta si el pedido ya fue pagado o está en proceso
      $estados_boleta = ['pagado', 'en preparación', 'en camino', 'entregado'];
      if (in_array($o['status'], $estados_boleta)) {
        echo "<a href='generar_boleta.php?id={$o['id']}' target='_blank' class='text-green-600 underline'>📄 Descargar boleta</a>";
      }

      $items = mysqli_query($conn, "SELECT oi.quantity, p.name FROM order_items oi JOIN products p ON oi.product_id = p.id WHERE oi.order_id = {$o['id']}");
      echo "<ul class='list-disc ml-6 mt-2'>";
      while ($i = mysqli_fetch_assoc($items)) {
        echo "<li>{$i['name']} x {$i['quantity']}</li>";
      }
      echo "</ul></div>";
    }
  } ?>
</main>
<?php include 'includes/footer.php'; ?>
