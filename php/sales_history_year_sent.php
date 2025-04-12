<?php
require 'main.php';

header('Content-Type: application/json');

try {
    $pdo = conexion();
    $anio = isset($_GET['anio']) ? $_GET['anio'] : date('Y');

    // Obtener el primer y último día del año seleccionado
    $primerDiaAnio = "$anio-01-01";
    $ultimoDiaAnio = "$anio-12-31";

    $stmt = $pdo->prepare('SELECT MONTH(factura_fecha) AS mes, SUM(factura_monto) AS total_monto FROM factura WHERE DATE(factura_fecha) BETWEEN :primerDia AND :ultimoDia GROUP BY mes ORDER BY mes');
    $stmt->execute(['primerDia' => $primerDiaAnio, 'ultimoDia' => $ultimoDiaAnio]);
    $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $meses = array_column($resultados, 'mes');
    $montos = array_column($resultados, 'total_monto');
    $monto_total = 0;
    foreach($montos as $rows){
        $monto_total += $rows; 
    }

    // Rellenar meses faltantes con 0 ventas
    $ventasPorMes = array_fill(1, 12, 0);
    foreach($resultados as $resultado) {
        $ventasPorMes[$resultado['mes']] = $resultado['total_monto'];
    }
    $montos = array_values($ventasPorMes);

    echo json_encode(['meses' => $meses, 'montos' => $montos, 'monto_total' => $monto_total]);
} catch (Exception $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
?>
