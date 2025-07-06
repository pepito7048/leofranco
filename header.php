<?php include_once 'auth.php'; ?>
<?php
$base = (strpos($_SERVER['PHP_SELF'], '/admin/') !== false) ? '../' : '';
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Leofranco Importaciones</title>
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body>
<header class="bg-blue-900 text-white p-4">
  <div class="container mx-auto flex justify-between items-center">
    <h1 class="text-xl font-bold">Leofranco Importaciones</h1>
    <nav>
      <a href="<?= $base ?>index.php" class="mx-2">Inicio</a>

      <?php if (isLoggedIn()) { ?>
        <?php if (isAdmin()) { ?>
          <a href="<?= $base ?>admin/products.php" class="mx-2">Productos</a>
          <a href="<?= $base ?>admin/adminorders.php" class="mx-2">Pedidos</a>
          <a href="<?= $base ?>logout.php" class="mx-2">Salir</a>
        <?php } else { ?>
          <a href="<?= $base ?>cart.php" class="mx-2">Carrito</a>
          <a href="<?= $base ?>search.php" class="mx-2">Buscar</a>
          <a href="<?= $base ?>contact.php" class="mx-2">Contacto</a>
          <a href="<?= $base ?>orders.php" class="mx-2">Mis pedidos</a>
          <a href="<?= $base ?>logout.php" class="mx-2">Salir</a>
        <?php } ?>
      <?php } else { ?>
        <a href="<?= $base ?>login.php" class="mx-2">Ingresar</a>
      <?php } ?>
    </nav>
  </div>
</header>



