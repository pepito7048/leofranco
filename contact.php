<?php include 'includes/header.php'; ?>
<main class="container mx-auto p-4 max-w-xl">
  <h2 class="text-3xl font-bold mb-4 text-center">Contáctanos</h2>
  <p class="mb-6 text-gray-700 text-center">¿Tienes dudas o sugerencias? Escríbenos directamente o comunícate por nuestras redes sociales.</p>

  <div class="flex justify-center gap-4 mb-6">
    <a href="https://wa.me/51970800315" target="_blank" class="bg-green-500 hover:bg-green-600 text-white font-semibold py-2 px-4 rounded-full flex items-center gap-2">
      <img src="https://cdn-icons-png.flaticon.com/24/733/733585.png" alt="WhatsApp" class="w-5 h-5">
      WhatsApp
    </a>
    <a href="https://www.instagram.com/importacionesleofrancope/" target="_blank" class="bg-gradient-to-r from-pink-500 via-red-500 to-yellow-500 text-white font-semibold py-2 px-4 rounded-full flex items-center gap-2">
      <img src="https://cdn-icons-png.flaticon.com/24/2111/2111463.png" alt="Instagram" class="w-5 h-5">
      Instagram
    </a>
  </div>

  <form method="post" action="contact.php" class="bg-white p-6 rounded-lg shadow">
    <input name="name" type="text" placeholder="Tu nombre" required class="block w-full p-2 border mb-2 rounded">
    <input name="email" type="email" placeholder="Tu correo" required class="block w-full p-2 border mb-2 rounded">
    <textarea name="message" placeholder="Tu mensaje" required class="block w-full p-2 border mb-4 rounded"></textarea>
    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded w-full">Enviar mensaje</button>
  </form>

  <?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      echo "<p class='mt-4 text-green-600 text-center'>✅ Mensaje enviado correctamente. Te responderemos pronto.</p>";
    }
  ?>
</main>
<?php include 'includes/footer.php'; ?>


