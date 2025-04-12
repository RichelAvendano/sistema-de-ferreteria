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

if (isset($data['cliente_id']) && !empty($data['cliente_id']) && isset($data['concepto']) && isset($data['observacion']) && isset($data['productos']) && !empty($data['productos']) && isset($data['monto']) && !empty($data)) {
    $cliente_id = htmlspecialchars($data['cliente_id']);
    $concepto = htmlspecialchars($data['concepto']);
    $observacion = htmlspecialchars($data['observacion']);
    $productos = $data['productos'];
    $monto = $data['monto'];
    $factura_id = htmlspecialchars($data['factura_id']);

    file_put_contents('php://stderr', "Cliente ID: $cliente_id, Concepto: $concepto, Observación: $observacion, Monto: $monto\n", FILE_APPEND); // Log de cliente y monto
    
    foreach ($productos as $producto) {
        file_put_contents('php://stderr', print_r($producto, TRUE), FILE_APPEND); // Log de producto
        $producto_id = htmlspecialchars($producto['id']);
        $cantidad = htmlspecialchars($producto['cantidad']);
        $cantidad = (int) $cantidad;
        
        // Verificar si el producto_id existe en la tabla producto
        $sql = "SELECT COUNT(*) FROM producto WHERE producto_id = :producto_id";
        $stmt = $conexion->prepare($sql);
        $stmt->execute(['producto_id' => $producto_id]);
        $count = $stmt->fetchColumn();       

        if ($count > 0) {

            $inventario = $conexion;
            $inventario = $inventario->query("SELECT producto_stock,producto_nombre FROM producto WHERE producto_id = $producto_id");
            $inventario = $inventario->fetch();

            $stock_producto_actual = $conexion;
            $stock_producto_actual = $stock_producto_actual->query("SELECT producto_cantidad FROM factura_producto WHERE producto_id = $producto_id AND factura_id= $factura_id");

            if($stock_producto_actual->rowCount()>0){
                $stock_producto_actual = $stock_producto_actual->fetch();
                $numeroCantidad = $stock_producto_actual['producto_cantidad'];
                $numeroCantidad = (int) $numeroCantidad;
            
                $cantidad_total =  $cantidad - $numeroCantidad ;
                $stock_producto_actual = null;

                $numeroStock = $inventario['producto_stock'];
                $numeroStock = (int) $numeroStock;

                if($cantidad_total>=0){
                    $stock_actual =  $numeroStock - $cantidad_total;
                }else{
                    $stock_actual =  $numeroStock + ($cantidad_total * -1);
                }
            
                if ($stock_actual < 0){
                    echo '
                        <div class="notification is-danger animate-bounce" style="margin-top: 15px;">
                            <strong class="is-size-4">!!!Inventario Superado!!!</strong><br>
                            El Inventario('.$inventario['producto_stock'].') del Producto: '.$inventario['producto_nombre'].' quedaria en Negativo ('.$stock_actual.') con este cambio
                        </div>';
                    exit();
                }
                $inventario = null;
                $stock_producto_actual = null;
            }                 
        }
    }

    try {
        $conexion->beginTransaction();

        // Insertar factura
        /* $sql = "INSERT INTO factura (factura_monto, factura_concepto, factura_observacion, factura_fecha, cliente_id) VALUES (:monto, :concepto, :observacion, NOW(), :cliente_id)"; */

        $sql = "UPDATE factura SET factura_monto=:monto, factura_concepto=:concepto,factura_observacion=:observacion,cliente_id=:cliente_id WHERE factura_id=:factura_id";

        $stmt = $conexion->prepare($sql);
        $stmt->execute(['monto' => $monto, 'concepto' => $concepto, 'observacion' => $observacion, 'cliente_id' => $cliente_id, 'factura_id'=>$factura_id]);

        // Obtener el ID de la factura recién insertada
        $factura_id = $conexion->lastInsertId();
        file_put_contents('php://stderr', "Factura ID: $factura_id\n", FILE_APPEND); // Log de factura ID

        // Insertar productos en factura_producto
        foreach ($productos as $producto) {
            file_put_contents('php://stderr', print_r($producto, TRUE), FILE_APPEND); // Log de producto
            $producto_id = htmlspecialchars($producto['id']);
            $cantidad = htmlspecialchars($producto['cantidad']);
            
            // Verificar si el producto_id existe en la tabla producto
            $sql = "SELECT COUNT(*) FROM producto WHERE producto_id = :producto_id";
            $stmt = $conexion->prepare($sql);
            $stmt->execute(['producto_id' => $producto_id]);
            $count = $stmt->fetchColumn();
                      
            $factura_id = htmlspecialchars($data['factura_id']);
            if ($count > 0) {

                $producto_caracteristicas = $conexion;
                $producto_caracteristicas = $producto_caracteristicas->query("SELECT producto_nombre,producto_precio,producto_stock FROM producto WHERE producto_id = ".$producto_id."");

                $producto_caracteristicas = $producto_caracteristicas->fetch();
                $producto_caracteristicas_nombre = $producto_caracteristicas['producto_nombre'];
                $producto_caracteristicas_precio = $producto_caracteristicas['producto_precio'];
                $producto_caracteristicas_stock = $producto_caracteristicas['producto_stock'];

                /* $sql = "INSERT INTO factura_producto (factura_id, producto_id, producto_cantidad, producto_nombre, producto_precio) VALUES (:factura_id, :producto_id, :cantidad, :nombre, :precio)"; */
                
                $stock_producto_actual = $conexion;
                $stock_producto_actual = $stock_producto_actual->query("SELECT producto_precio FROM factura_producto WHERE producto_id = $producto_id AND factura_id= $factura_id");
                
                if($stock_producto_actual->rowCount()>=1){
                                       
                    $stock_producto_actual = null;
    
                    $stock_producto_actual = $conexion;
                    $stock_producto_actual = $stock_producto_actual->query("SELECT producto_cantidad FROM factura_producto WHERE producto_id = $producto_id AND factura_id= $factura_id");
                    $stock_producto_actual = $stock_producto_actual->fetch();
                    $numeroCantidad = (int) $stock_producto_actual['producto_cantidad'];
                    $cantidad_total =  $cantidad - $numeroCantidad ;
                    

                    $numeroStock = (int) $producto_caracteristicas_stock;

                    if($cantidad_total>=0){
                        $stock_actual =  $numeroStock - $cantidad_total;
                    }else{
                        $stock_actual =  $numeroStock + ($cantidad_total * -1);
                    }

                    $inventario = $conexion;
                    $inventario = $inventario->prepare("UPDATE producto SET producto_stock=:stock WHERE producto_id = :producto_id");
                    $inventario->execute([
                        'stock' => $stock_actual,
                        'producto_id'=> $producto_id
                    ]);
                    $inventario = null;

                    $sql = "UPDATE factura_producto SET producto_cantidad=:cantidad WHERE factura_id=:factura_id AND producto_id=:producto_id";

                    $stmt = $conexion->prepare($sql);
                    $stmt->execute([
                        'factura_id' => $factura_id, 
                        'producto_id' => $producto_id, 
                        'cantidad' => $cantidad,

                    ]);
                                
                    $producto_caracteristicas = null;

                }else{

                    $stock_producto = $conexion;
                    $stock_producto = $stock_producto->query("SELECT producto_stock FROM producto WHERE producto_id = $producto_id");
                    $stock_producto = $stock_producto->fetch();

                    $stock_actual = $stock_producto['producto_stock'] - $cantidad;
                    $stock_producto = null;

                    $inventario = $conexion;
                    $inventario = $inventario->prepare("UPDATE producto SET producto_stock=:stock WHERE producto_id = :producto_id");
                    $inventario->execute([
                        'stock' => $stock_actual,
                        'producto_id'=> $producto_id
                    ]);
                    $inventario = null;

                    $sql = "INSERT INTO factura_producto (factura_id, producto_id, producto_cantidad, producto_nombre, producto_precio) VALUES (:factura_id, :producto_id, :cantidad, :nombre, :precio)";
                    
                    
                    $stmt = $conexion->prepare($sql);
                    $stmt->execute([
                        'factura_id' => $factura_id, 
                        'producto_id' => $producto_id, 
                        'cantidad' => $cantidad,
                        'nombre' => $producto_caracteristicas['producto_nombre'],
                        'precio' => $producto_caracteristicas['producto_precio'],
                        'factura_id' => $factura_id
                    ]);
                                
                    $producto_caracteristicas = null;
                    
                }
                
            }
        }

        $conexion->commit();
        echo '<div class="notification is-success is-light" style="margin-top: 15px;">
                <strong class="is-size-4">!!!Factura Exitosa!!!</strong><br>
                <a class="button is-link" href="index.php?view=bill_new">Agregar Nueva Factura</a>
              </div>';

    } catch (Exception $e) {
        $conexion->rollBack();
        echo '
             <div class="notification is-danger" style="margin-top: 15px;">
                <strong class="is-size-4">!!!Hubo Un Error!!!</strong><br>
                Error: '.$e->getMessage().'
              </div>'; 
    }
} else {
    echo '
             <div class="notification is-danger" style="margin-top: 15px;">
                <strong class="is-size-4">!!!Hubo Un Error!!!</strong><br>
                Datos incompletos o incorrectos.
              </div>';
}

$conexion = null;
?>
