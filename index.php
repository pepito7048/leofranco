<?php include 'includes/db.php'; include 'includes/header.php'; ?>
<main class="container mx-auto p-4">
  <h1 class="text-3xl font-bold">Bienvenidos a Leofranco Importaciones</h1>
  <p class="mt-2">Venta de bicicletas para niños y adultos. Envíos a nivel nacional 🚚</p>
  <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-4">
    <?php 
      $query = mysqli_query($conn, "SELECT * FROM products");
      while($row = mysqli_fetch_assoc($query)) {
        echo "<div class='border rounded p-4 shadow'>";
        echo "<img src='assets/img/" . $row['image'] . "' alt='' class='w-full h-48 object-cover'>";
        echo "<h2 class='text-xl font-semibold mt-2'>" . $row['name'] . "</h2>";
        echo "<p class='text-green-600 font-bold'>S/ " . $row['price'] . "</p>";
        echo "<a href='product.php?id=" . $row['id'] . "' class='text-blue-500 mt-2 inline-block'>Ver más</a>";

        // ✅ Mostrar botón solo si el usuario está logueado y NO es admin
        if (isLoggedIn() && !isAdmin()) {
          echo "<form method='post' action='add_to_cart.php' class='mt-2'>";
          echo "<input type='hidden' name='id' value='" . $row['id'] . "'>";
          echo "<input type='hidden' name='name' value='" . $row['name'] . "'>";
          echo "<input type='hidden' name='price' value='" . $row['price'] . "'>";
          echo "<input type='hidden' name='qty' value='1'>";
          echo "<button type='submit' class='bg-green-600 text-white px-4 py-1 mt-1 rounded hover:bg-green-700'>🛒 Agregar al carrito</button>";
          echo "</form>";
        }

        echo "</div>";
      }
    ?>
  </div>
</main>
<?php include 'includes/footer.php'; ?>
