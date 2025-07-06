<?php
include '../includes/db.php';
include '../includes/auth.php';
if (!isAdmin()) { header('Location: ../index.php'); exit(); }

$id = intval($_GET['id']);
$result = mysqli_query($conn, "SELECT * FROM products WHERE id = $id");
$product = mysqli_fetch_assoc($result);

if (!$product) {
  echo "<p class='p-4'>Producto no encontrado.</p>";
  exit;
}

// Si se envió el formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update'])) {
  $name = $_POST['name'];
  $price = $_POST['price'];
  $description = $_POST['description'];

  // Si se sube nueva imagen
  if (!empty($_FILES['image']['name'])) {
    $image = $_FILES['image']['name'];
    move_uploaded_file($_FILES['image']['tmp_name'], "../assets/img/" . $image);
    mysqli_query($conn, "UPDATE products SET name='$name', price='$price', description='$description', image='$image' WHERE id=$id");
  } else {
    mysqli_query($conn, "UPDATE products SET name='$name', price='$price', description='$description' WHERE id=$id");
  }

  header("Location: products.php");
  exit;
}
?>

<?php include '../includes/header.php'; ?>
<main class="container mx-auto p-4">
  <h2 class="text-2xl font-bold mb-4">Editar Producto</h2>

  <form method="post" enctype="multipart/form-data" class="space-y-4">
    <input type="text" name="name" value="<?= htmlspecialchars($product['name']) ?>" class="w-full p-2 border" required>

    <input type="number" name="price" step="0.01" value="<?= $product['price'] ?>" class="w-full p-2 border" required>

    <textarea name="description" class="w-full p-2 border" rows="4"><?= htmlspecialchars($product['description']) ?></textarea>

    <div>
      <p class="mb-1">Imagen actual:</p>
      <img src="../assets/img/<?= $product['image'] ?>" class="h-32 mb-2">
      <input type="file" name="image" class="w-full p-2 border">
    </div>

    <button type="submit" name="update" class="bg-green-600 text-white px-4 py-2">Actualizar Producto</button>
  </form>
</main>
<?php include '../includes/footer.php'; ?>

