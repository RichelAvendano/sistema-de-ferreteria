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

    file_put_contents('php://stderr', "Cliente ID: $cliente_id, Concepto: $concepto, Observación: $observacion, Monto: $monto\n", FILE_APPEND); // Log de cliente y monto
    
    foreach ($productos as $producto) {
        file_put_contents('php://stderr', print_r($producto, TRUE), FILE_APPEND); // Log de producto
        $producto_id = htmlspecialchars($producto['id']);
        $cantidad = htmlspecialchars($producto['cantidad']);
        
        // Verificar si el producto_id existe en la tabla producto
        $sql = "SELECT COUNT(*) FROM producto WHERE producto_id = :producto_id";
        $stmt = $conexion->prepare($sql);
        $stmt->execute(['producto_id' => $producto_id]);
        $count = $stmt->fetchColumn();       

        if ($count > 0) {

            $inventario = $conexion;
            $inventario = $inventario->query("SELECT producto_stock,producto_nombre FROM producto WHERE producto_id = $producto_id");
            $inventario = $inventario->fetch();

            if($inventario['producto_stock'] == 0){
                echo '
                    <div class="notification is-danger animate-bounce" style="margin-top: 15px;">
                        <strong class="is-size-4">!!!Inventario Agotado!!!</strong><br>
                        El Inventario('.$inventario['producto_stock'].') del Producto: '.$inventario['producto_nombre'].' se Encuentra Agotado
                    </div>';
                exit();
            }
          
            if ($cantidad > $inventario['producto_stock']){
                echo '
                    <div class="notification is-danger animate-bounce" style="margin-top: 15px;">
                        <strong class="is-size-4">!!!Inventario Superado!!!</strong><br>
                        El Inventario('.$inventario['producto_stock'].') del Producto: '.$inventario['producto_nombre'].' es menor a la Cantidad ('.$cantidad.') Solicitada
                    </div>';
                exit();
            }                  
        } else {
            throw new Exception("Producto ID no válido: " . $producto_id);
        }
    }

    try {
        $conexion->beginTransaction();

        // Insertar factura
        $sql = "INSERT INTO factura (factura_monto, factura_concepto, factura_observacion, factura_fecha, cliente_id) VALUES (:monto, :concepto, :observacion, NOW(), :cliente_id)";
        $stmt = $conexion->prepare($sql);
        $stmt->execute(['monto' => $monto, 'concepto' => $concepto, 'observacion' => $observacion, 'cliente_id' => $cliente_id]);

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

           
            $producto_caracteristicas = $conexion;
            $producto_caracteristicas = $producto_caracteristicas->query("SELECT producto_nombre,producto_precio FROM producto WHERE producto_id = ".$producto_id."");

            $producto_caracteristicas = $producto_caracteristicas->fetch();
            $producto_caracteristicas_nombre = $producto_caracteristicas['producto_nombre'];
            $producto_caracteristicas_precio = $producto_caracteristicas['producto_precio'];
            
            if ($count > 0) {
                $sql = "INSERT INTO factura_producto (factura_id, producto_id, producto_cantidad, producto_nombre, producto_precio) VALUES (:factura_id, :producto_id, :cantidad, :nombre, :precio)";
                $stmt = $conexion->prepare($sql);
                $stmt->execute([
                    'factura_id' => $factura_id, 
                    'producto_id' => $producto_id, 
                    'cantidad' => $cantidad,
                    'nombre' => $producto_caracteristicas['producto_nombre'],
                    'precio' => $producto_caracteristicas['producto_precio']
                ]);
                
                $inventario = $conexion;
                $inventario = $inventario->query("SELECT producto_stock FROM producto WHERE producto_id = $producto_id");
                $inventario = $inventario->fetch();
                $stock_actual =  $inventario['producto_stock'] - $cantidad;
                $inventario = null;

                $inventario = $conexion;
                $inventario = $inventario->prepare("UPDATE producto SET producto_stock=:stock WHERE producto_id = :producto_id");
                $inventario->execute([
                    'stock' => $stock_actual,
                    'producto_id'=> $producto_id
                ]);
                $inventario = null;
                $producto_caracteristicas = null;
                
            } else {
                throw new Exception("Producto ID no válido: " . $producto_id);
            }
        }

        $check_factura = $conexion;
        $check_factura = $check_factura->query("SELECT cliente.cliente_cedula, cliente.cliente_nombre,cliente.cliente_ubicacion,cliente.cliente_telefono, factura.factura_fecha FROM factura INNER JOIN cliente ON factura.cliente_id = cliente.cliente_id WHERE factura.factura_id = ".$factura_id."" );
        $check_factura = $check_factura->fetch();

        $conexion->commit();
        echo '
            <input type="hidden" value="'.$factura_id.'" name="bill_id">
            <input type="hidden" name="cliente_cedula" value="'.$check_factura['cliente_cedula'].'">
            <input type="hidden" name="cliente_nombre" value="'.$check_factura['cliente_nombre'].'">
            <input type="hidden" name="cliente_ubicacion" value="'.$check_factura['cliente_ubicacion'].'">
            <input type="hidden" name="cliente_telefono" value="'.$check_factura['cliente_telefono'].'">
            <input type="hidden" name="factura_fecha" value="'.$check_factura['factura_fecha'].'">
            <div class="notification is-success is-light" style="margin-top: 15px;">
                <strong class="is-size-4">!!!Factura Exitosa!!!</strong><br>
                <a class="button is-link is-large mr-3" href="index.php?view=bill_new">Agregar Nueva Factura</a>
                <button type="submit" href="php/invoice.php" target="_blank" class="button is-success is-large"><i class="fa-solid fa-file-pdf"></i>|Imprimir</a></button> 
            </div>';

    } catch (Exception $e) {
        $conexion->rollBack();
        echo '
             <div class="notification is-danger animate-bounce" style="margin-top: 15px;">
                <strong class="is-size-4">!!!Hubo Un Error!!!</strong><br>
                Error: '.$e->getMessage().'
              </div>'; 
    }
} else {
    echo '
             <div class="notification is-danger animate-bounce" style="margin-top: 15px;">
                <strong class="is-size-4">!!!Hubo Un Error!!!</strong><br>
                Datos incompletos o incorrectos.
              </div>';
}

$conexion = null;
?>
