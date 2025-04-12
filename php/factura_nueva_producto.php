<?php

require_once "main.php";

try {
    $conexion = conexion();
    $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Error de conexión: " . $e->getMessage());
}

if (isset($_POST['query'])) {
    $query = htmlspecialchars($_POST['query']);
    $sql = "SELECT * FROM producto WHERE producto_nombre LIKE :query";
    $stmt = $conexion->prepare($sql);
    $stmt->execute(['query' => "%$query%"]);

    if ($stmt->rowCount() > 0) {
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo "<div class='resultado-producto is-6 title m-0 p-2' data-id='" . $row['producto_id'] . "' data-nombre='" . $row['producto_nombre'] . "' data-precio='" . $row['producto_precio'] . "' data-foto='" . $row['producto_foto'] . "' data-stock='" . $row['producto_stock'] . "'>" . $row['producto_nombre'] . " - $" . $row['producto_precio'] . "</div>";
        }
    } else {
        echo "<div>No se encontraron productos</div>";
    }
}

$conexion = null;
?>
