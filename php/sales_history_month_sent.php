<?php
require 'main.php';

header('Content-Type: application/json');

try {
    $pdo = conexion();
    $mes = isset($_GET['mes']) ? $_GET['mes'] : date('Y-m');

    // Obtener el primer y último día del mes seleccionado
    $anio = substr($mes, 0, 4);
    $mesSeleccionado = substr($mes, -2);
    $primerDiaMes = (new DateTime("$anio-$mesSeleccionado-01"))->format('Y-m-d');
    $ultimoDiaMes = (new DateTime("$anio-$mesSeleccionado-01 last day of this month"))->format('Y-m-d');

    $stmt = $pdo->prepare('SELECT DATE(factura_fecha) AS factura_fecha, SUM(factura_monto) AS total_monto FROM factura WHERE DATE(factura_fecha) BETWEEN :primerDia AND :ultimoDia GROUP BY DATE(factura_fecha) ORDER BY factura_fecha');
    $stmt->execute(['primerDia' => $primerDiaMes, 'ultimoDia' => $ultimoDiaMes]);
    $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $fechas = array_column($resultados, 'factura_fecha');
    $montos = array_column($resultados, 'total_monto');
    $monto_total = 0;
    foreach($montos as $rows){
        $monto_total += $rows; 
    }

    echo json_encode(['fechas' => $fechas, 'montos' => $montos, 'monto_total' => $monto_total]);
} catch (Exception $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
?>
