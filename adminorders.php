<?php 
include '../includes/db.php'; 
include '../includes/auth.php'; 

if (!isAdmin()) {
  header("Location: ../index.php"); 
  exit(); 
}

include '../includes/header.php'; 

// Filtro de estado o búsqueda por correo
$estado_filtro = isset($_GET['estado']) ? $_GET['estado'] : '';
$busqueda_email = isset($_GET['email']) ? trim($_GET['email']) : '';
?>

<main class="container mx-auto p-4">
  <h2 class="text-2xl font-bold mb-4">Administrar Pedidos</h2>

  <form method="get" class="mb-4 flex flex-wrap gap-2">
    <input type="text" name="email" placeholder="Buscar por correo" value="<?= htmlspecialchars($busqueda_email) ?>" class="border p-2">
    <select name="estado" class="border p-2">
      <option value="">Todos los estados</option>
      <?php
        $estados = ['pendiente de pago', 'pagado', 'en preparación', 'en camino', 'entregado'];
        foreach ($estados as $estado) {
          $selected = ($estado === $estado_filtro) ? 'selected' : '';
          echo "<option value='$estado' $selected>$estado</option>";
        }
      ?>
    </select>
    <button type="submit" class="bg-blue-600 text-white px-4 py-2">Filtrar</button>
  </form>

  <?php
  // Actualización de estado
  if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['order_id'])) {
    $order_id = intval($_POST['order_id']);
    $new_status = mysqli_real_escape_string($conn, $_POST['status']);
    mysqli_query($conn, "UPDATE orders SET status='$new_status' WHERE id=$order_id");
    echo "<p class='text-green-600'>Estado actualizado correctamente.</p>";
  }

  // Construcción de query con filtros
  $query = "
    SELECT o.*, u.email 
    FROM orders o 
    JOIN users u ON o.user_id = u.id 
    WHERE 1=1
  ";

  if ($estado_filtro) {
    $query .= " AND o.status = '" . mysqli_real_escape_string($conn, $estado_filtro) . "'";
  }

  if ($busqueda_email) {
    $query .= " AND u.email LIKE '%" . mysqli_real_escape_string($conn, $busqueda_email) . "%'";
  }

  $query .= " ORDER BY o.id DESC";

  $orders = mysqli_query($conn, $query);

  while ($o = mysqli_fetch_assoc($orders)) {
    $color = match ($o['status']) {
      'pendiente de pago' => 'text-red-600',
      'pagado' => 'text-green-600',
      'en preparación' => 'text-yellow-600',
      'en camino' => 'text-blue-600',
      'entregado' => 'text-green-800',
      default => 'text-gray-700'
    };

    echo "<div class='border p-4 mb-4'>";
    echo "<h3 class='font-bold'>Pedido #{$o['id']}</h3>";
    echo "<p><strong>Correo del cliente:</strong> {$o['email']}</p>";
    echo "<p><strong>Nombre:</strong> " . htmlspecialchars($o['fullname']) . "</p>";
    echo "<p><strong>Teléfono:</strong> " . htmlspecialchars($o['phone']) . "</p>";
    echo "<p><strong>Dirección:</strong> " . nl2br(htmlspecialchars($o['address'])) . "</p>";
    echo "<p><strong>Método de pago:</strong> " . htmlspecialchars($o['payment_method']) . "</p>";
    echo "<p><strong>Total:</strong> S/ {$o['total']}</p>";
    echo "<p><strong>Fecha:</strong> {$o['created_at']}</p>";
    echo "<p class='font-semibold $color'><strong>Estado actual:</strong> {$o['status']}</p>";

    echo "<form method='post' class='mt-2'>";
    echo "<input type='hidden' name='order_id' value='{$o['id']}'>";
    echo "<label for='status'>Cambiar estado:</label> ";
    echo "<select name='status' class='border p-1'>";
    foreach ($estados as $estado) {
      $selected = ($o['status'] === $estado) ? 'selected' : '';
      echo "<option value='$estado' $selected>$estado</option>";
    }
    echo "</select> ";
    echo "<button type='submit' class='bg-blue-600 text-white px-2 py-1 ml-2'>Actualizar</button>";
    echo "</form>";

    $items = mysqli_query($conn, "
      SELECT oi.quantity, p.name 
      FROM order_items oi 
      JOIN products p ON oi.product_id = p.id 
      WHERE oi.order_id = {$o['id']}
    ");

    echo "<ul class='list-disc ml-6 mt-2'>";
    while ($i = mysqli_fetch_assoc($items)) {
      echo "<li>{$i['name']} x {$i['quantity']}</li>";
    }
    echo "</ul></div>";
  }
  ?>
</main>

<?php include '../includes/footer.php'; ?>

