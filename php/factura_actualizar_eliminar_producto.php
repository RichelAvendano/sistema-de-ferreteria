<?php

require_once "main.php";

try {
    $conexion = conexion();
    $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Error de conexión: " . $e->getMessage());
}

$data = json_decode(file_get_contents('php://input'), true);
file_put_contents('php://stderr', print_r($data, TRUE)); // Log de datos recibidos

$producto_id = htmlspecialchars($data['producto_id']);
$factura_id = htmlspecialchars($data['factura_id']);
$producto_cantidad = htmlspecialchars($data['producto_cantidad']);

if(isset($data['producto_stock'])){
    $producto_stock = htmlspecialchars($data['producto_stock']);
}else{
    echo '<div class="notification is-danger is-light animate-bounce m-3 p-2" style="width:100%" colspan="9">
            <strong class="is-size-5">!!!Producto Eliminado!!!</strong><br>
        </div>';
    exit();
}


if(isset($data['producto_nombre'])){
    $producto_nombre = htmlspecialchars($data['producto_nombre']);  
}

$producto_id = (int) $producto_id;
$producto_stock = (int) $producto_stock;
$producto_cantidad = (int) $producto_cantidad;

$stock_actual = $producto_stock + $producto_cantidad;

if($producto_stock == 0 && $producto_id >= 100000){
 
    $eliminar_producto = $conexion;
    $eliminar_producto = $eliminar_producto->query("DELETE FROM factura_producto WHERE factura_id = $factura_id AND producto_id IS NULL AND producto_nombre = '$producto_nombre'");

    echo '<div class="notification is-danger is-light animate-bounce m-3 p-2" style="width:100%" colspan="9">
            <strong class="is-size-5">!!!Producto Eliminado!!!</strong><br>
        </div>';

    $eliminar_producto = null;

    $actualizar_factura = $conexion;
    $actualizar_factura = $actualizar_factura->query("SELECT SUM(producto_cantidad * producto_precio) AS acumulado FROM factura_producto WHERE factura_id = $factura_id AND producto_id IS NULL AND producto_nombre = '$producto_nombre'");
            
    $actualizar_factura = $actualizar_factura->fetch();
    $acumulado = $actualizar_factura['acumulado'];
    
    $acumulado = floatval($acumulado);
    $actualizar_factura = $conexion;

    $actualizar_factura = $actualizar_factura->prepare("UPDATE factura SET factura_monto =:acumulado WHERE factura_id=:factura_id");
    $actualizar_factura->execute([
        'acumulado' => $acumulado,
        'factura_id' => $factura_id
    ]);
    $actualizar_factura = null;

    exit();

}

$eliminar_producto = $conexion;
$eliminar_producto = $eliminar_producto->query("DELETE FROM factura_producto WHERE factura_id = $factura_id AND producto_id=$producto_id");

echo '<div class="notification is-danger is-light animate-bounce m-3 p-2" style="width:100%" colspan="9">
            <strong class="is-size-5">!!!Producto Eliminado!!!</strong><br>
        </div>';

if($eliminar_producto->rowCount()>0){

    $actualizar_stock = $conexion;
    $actualizar_stock = $actualizar_stock->query("UPDATE producto SET producto_stock=$stock_actual WHERE producto_id=$producto_id");

    $actualizar_factura = $conexion;
    $actualizar_factura = $actualizar_factura->query("SELECT SUM(producto_cantidad * producto_precio) AS acumulado FROM factura_producto WHERE factura_id=".$factura_id."");
            
    $actualizar_factura = $actualizar_factura->fetch();
    $acumulado = $actualizar_factura['acumulado'];

    $acumulado = floatval($acumulado);
    $actualizar_factura = $conexion;

    $actualizar_factura = $actualizar_factura->prepare("UPDATE factura SET factura_monto =:acumulado WHERE factura_id=:factura_id");
    $actualizar_factura->execute([
        'acumulado' => $acumulado,
        'factura_id' => $factura_id
    ]);
    $actualizar_factura = null;

}
