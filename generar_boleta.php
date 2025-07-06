<?php
require('includes/fpdf/fpdf.php');
include 'includes/db.php';
session_start();

if (!isset($_SESSION['user_id'])) {
  exit('Acceso no autorizado');
}

$order_id = intval($_GET['id'] ?? 0);
$user_id = $_SESSION['user_id'];

// Validar que el pedido pertenezca al usuario y tenga un estado permitido
$estados_permitidos = ['pagado', 'en preparación', 'en camino', 'entregado'];
$estado_str = "'" . implode("','", $estados_permitidos) . "'";

$res = mysqli_query($conn, "
  SELECT o.*, u.email 
  FROM orders o 
  JOIN users u ON o.user_id = u.id 
  WHERE o.id = $order_id 
    AND o.user_id = $user_id 
    AND o.status IN ($estado_str)
");
$order = mysqli_fetch_assoc($res);

if (!$order) {
  exit('No tienes acceso a este pedido o aún no está disponible para descargar.');
}

// Crear PDF
$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial','B',16);

$pdf->Cell(0,10,"Boleta de Pago - Leofranco Importaciones",0,1,"C");
$pdf->SetFont('Arial','',12);
$pdf->Ln(10);

$pdf->Cell(0,10,"Pedido #{$order['id']}",0,1);
$pdf->Cell(0,10,"Cliente: {$order['fullname']}",0,1);
$pdf->Cell(0,10,"Correo: {$order['email']}",0,1);
$pdf->Cell(0,10,"Teléfono: {$order['phone']}",0,1);
$pdf->Cell(0,10,"Dirección: {$order['address']}",0,1);
$pdf->Cell(0,10,"Método de pago: {$order['payment_method']}",0,1);
$pdf->Cell(0,10,"Fecha: {$order['created_at']}",0,1);
$pdf->Ln(10);

// Detalles del pedido
$pdf->Cell(0,10,"Detalle de Productos:",0,1);
$items = mysqli_query($conn, "
  SELECT oi.quantity, p.name, p.price 
  FROM order_items oi 
  JOIN products p ON oi.product_id = p.id 
  WHERE oi.order_id = $order_id
");

$total = 0;
while ($i = mysqli_fetch_assoc($items)) {
  $subtotal = $i['price'] * $i['quantity'];
  $pdf->Cell(0,10,"{$i['name']} x {$i['quantity']} - S/ {$subtotal}",0,1);
  $total += $subtotal;
}

$pdf->Ln(5);
$pdf->Cell(0,10,"Total: S/ " . number_format($total, 2),0,1,'R');

$pdf->Output("I", "Boleta_Pedido_{$order_id}.pdf");
?>

