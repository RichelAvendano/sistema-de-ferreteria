<?php
// datos.php
require 'main.php';

header('Content-Type: application/json');

try {
    $pdo = conexion();
    $fecha = isset($_GET['fecha']) ? $_GET['fecha'] : date('Y-m-d');

    $stmt = $pdo->prepare('SELECT factura_fecha, factura_monto FROM factura WHERE DATE(factura_fecha) = :fecha');
    $stmt->execute(['fecha' => $fecha]);
    $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $fechas = array_column($resultados, 'factura_fecha');
    $montos = array_column($resultados, 'factura_monto');

    $check_monto_total = conexion();
    $check_monto_total = $check_monto_total->query("SELECT SUM(factura_monto) as monto_total FROM factura WHERE DATE(factura_fecha) = '$fecha'");
    $check_monto_total = $check_monto_total->fetch();
    $monto_total = $check_monto_total['monto_total'];
    $check_monto_total = null;


    echo json_encode(['fecha' => $fecha, 'fechas' => $fechas, 'montos' => $montos, 'monto_total' => $monto_total]);
} catch (Exception $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
?>
