<?php include 'includes/db.php'; include 'includes/header.php'; ?>
<main class="container mx-auto p-4">
  <h2 class="text-2xl font-bold mb-4">Resultados de búsqueda</h2>
  <form method="get" action="search.php" class="mb-4">
    <input type="text" name="q" placeholder="Buscar..." class="p-2 border w-full">
  </form>
  <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
  <?php
  if (isset($_GET['q'])) {
    $q = mysqli_real_escape_string($conn, $_GET['q']);
    $res = mysqli_query($conn, "SELECT * FROM products WHERE name LIKE '%$q%'");
    if (mysqli_num_rows($res) == 0) {
      echo "<p>No se encontraron productos.</p>";
    }
    while ($row = mysqli_fetch_assoc($res)) {
      echo "<div class='border p-4'><img src='assets/img/{$row['image']}' class='w-full h-40 object-cover'><h3 class='text-lg'>{$row['name']}</h3><p>S/ {$row['price']}</p><a href='product.php?id={$row['id']}' class='text-blue-600'>Ver más</a></div>";
    }
  }
  ?>
  </div>
</main>
<?php include 'includes/footer.php'; ?>