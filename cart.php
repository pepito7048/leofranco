<?php include 'includes/db.php'; include 'includes/header.php'; ?>
<main class="container mx-auto p-4">
  <h2 class="text-2xl font-bold mb-4">Tu carrito</h2>
  <?php
  if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
    echo "<p>No hay productos en el carrito.</p>";
  } else {
    $total = 0;
    echo "<table class='w-full text-left'><tr><th>Producto</th><th>Cantidad</th><th>Precio</th><th>Acción</th></tr>";
    foreach ($_SESSION['cart'] as $index => $item) {
      $subtotal = $item['price'] * $item['qty'];
      $total += $subtotal;
      echo "<tr>";
      echo "<td>{$item['name']}</td>";
      echo "<td>{$item['qty']}</td>";
      echo "<td>S/ {$subtotal}</td>";
      echo "<td>
              <form method='post' action='remove_from_cart.php'>
                <input type='hidden' name='index' value='{$index}'>
                <button type='submit' class='text-red-600 hover:underline'>Eliminar</button>
              </form>
            </td>";
      echo "</tr>";
    }
    echo "</table>";
    echo "<p class='mt-4 font-bold'>Total: S/ {$total}</p>";
    echo "<a href='checkout.php' class='bg-green-600 text-white px-4 py-2 mt-2 inline-block'>Proceder al pago</a>";
  }
  ?>
</main>
<?php include 'includes/footer.php'; ?>
