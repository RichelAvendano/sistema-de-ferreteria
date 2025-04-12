
<?php
// datos.php
require 'main.php';

header('Content-Type: application/json');

try {
    $pdo = conexion();
    $semana = isset($_GET['semana']) ? $_GET['semana'] : date('Y-\WW');

    // Obtener el primer y último día de la semana seleccionada
    $anio = substr($semana, 0, 4);
    $numeroSemana = substr($semana, -2);
    $primerDiaSemana = (new DateTime())->setISODate($anio, $numeroSemana)->format('Y-m-d');
    $ultimoDiaSemana = (new DateTime())->setISODate($anio, $numeroSemana, 7)->format('Y-m-d');

    $stmt = $pdo->prepare('SELECT DATE(factura_fecha) AS factura_fecha, SUM(factura_monto) AS total_monto FROM factura WHERE DATE(factura_fecha) BETWEEN :primerDia AND :ultimoDia GROUP BY DATE(factura_fecha) ORDER BY factura_fecha');
    $stmt->execute(['primerDia' => $primerDiaSemana, 'ultimoDia' => $ultimoDiaSemana]);
    $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $fechas = array_column($resultados, 'factura_fecha');
    $montos = array_column($resultados, 'total_monto');
    $monto_total = 0;
    foreach($montos as $rows){
        $monto_total += $rows; 
    }

    echo json_encode(['fechas' => $fechas, 'montos' => $montos, 'monto_total'=>$monto_total]);
} catch (Exception $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
?>

