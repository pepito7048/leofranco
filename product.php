<?php include 'includes/db.php'; ?>
<?php include 'includes/header.php'; ?>

<main class="container mx-auto p-4">
<?php
$id = $_GET['id'];
$res = mysqli_query($conn, "SELECT * FROM products WHERE id = $id");
$product = mysqli_fetch_assoc($res);

if (!$product) {
  echo "<p>Producto no encontrado.</p>";
} else {
  echo "<div class='grid grid-cols-1 md:grid-cols-2 gap-6'>";
  echo "<img src='assets/img/{$product['image']}' class='w-full h-auto rounded shadow'>";
  
  echo "<div>";
  echo "<h2 class='text-3xl font-bold'>{$product['name']}</h2>";
  echo "<p class='text-green-600 font-bold mt-2 text-xl'>S/ {$product['price']}</p>";

  // Mostrar descripción si existe
  if (!empty($product['description'])) {
    echo "<div class='mt-4'>";
    echo "<h3 class='font-semibold mb-1'>Descripción del producto:</h3>";
    echo "<p class='text-gray-700'>{$product['description']}</p>";
    echo "</div>";
  }

  // Solo mostrar si NO es administrador
  if (!isAdmin()) {
    echo "<form method='post' action='add_to_cart.php' class='mt-6'>";
    echo "<input type='hidden' name='id' value='{$product['id']}'>";
    echo "<input type='hidden' name='name' value='{$product['name']}'>";
    echo "<input type='hidden' name='price' value='{$product['price']}'>";
    echo "<label class='block mb-1'>Cantidad:</label>";
    echo "<input type='number' name='qty' value='1' min='1' class='border p-2 w-20'>";
    echo "<button type='submit' class='bg-green-600 text-white px-4 py-2 mt-2'>Agregar al carrito</button>";
    echo "</form>";
  }

  echo "</div></div>";
}
?>
</main>

<?php include 'includes/footer.php'; ?>



