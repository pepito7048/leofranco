<?php include '../includes/db.php'; include '../includes/auth.php'; ?>
<?php if (!isAdmin()) { header('Location: ../index.php'); exit(); } ?>

<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add'])) {
  $name = $_POST['name'];
  $price = $_POST['price'];
  $description = $_POST['description'];
  $image = $_FILES['image']['name'];
  
  move_uploaded_file($_FILES['image']['tmp_name'], "../assets/img/" . $image);

  mysqli_query($conn, "INSERT INTO products (name, price, description, image) 
                       VALUES ('$name', '$price', '$description', '$image')");
}

if (isset($_GET['delete'])) {
  $id = $_GET['delete'];
  mysqli_query($conn, "DELETE FROM products WHERE id=$id");
  header('Location: products.php');
}
?>

<?php include '../includes/header.php'; ?>
<main class="container mx-auto p-4">
  <h2 class="text-2xl font-bold mb-4">Administrar Productos</h2>

  <form method="post" enctype="multipart/form-data" class="mb-6 space-y-2">
    <input name="name" type="text" placeholder="Nombre del producto" class="block w-full p-2 border" required>
    
    <input name="price" type="number" step="0.01" placeholder="Precio" class="block w-full p-2 border" required>
    
    <textarea name="description" placeholder="Descripción del producto" class="block w-full p-2 border" rows="4"></textarea>
    
    <input name="image" type="file" class="block w-full p-2 border" required>
    
    <button type="submit" name="add" class="bg-blue-600 text-white px-4 py-2">Agregar Producto</button>
  </form>

  <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
    <?php
    $res = mysqli_query($conn, "SELECT * FROM products");
    while ($row = mysqli_fetch_assoc($res)) {
      echo "<div class='border p-4'>
        <img src='../assets/img/{$row['image']}' class='w-full h-40 object-cover mb-2'>
        <h3 class='text-lg font-semibold'>{$row['name']}</h3>
        <p class='mb-1'>S/ {$row['price']}</p>";
        
      if (!empty($row['description'])) {
        echo "<p class='text-sm text-gray-600 mb-2'>{$row['description']}</p>";
      }

      echo "<div class='flex justify-between text-sm'>
          <a href='products.php?delete={$row['id']}' class='text-red-600 hover:underline'>🗑️ Eliminar</a>
          <a href='edit_product.php?id={$row['id']}' class='text-blue-600 hover:underline'>✏️ Editar</a>
        </div>
      </div>";
    }
    ?>
  </div>
</main>
<?php include '../includes/footer.php'; ?>
