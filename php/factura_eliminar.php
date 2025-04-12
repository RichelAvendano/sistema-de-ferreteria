<?php

$product_id_del = limpiar_cadena($_GET['bill_id_del']);

$check_factura = conexion();
$check_factura = $check_factura->query("SELECT * FROM factura WHERE factura_id='$product_id_del'");

if($check_factura->rowCount() == 1){
    $eliminar_factura = conexion();
    $eliminar_factura = $eliminar_factura->prepare("DELETE FROM factura WHERE factura_id=:id");
    
    $eliminar_factura_producto = conexion();
    $eliminar_factura_producto = $eliminar_factura_producto->prepare("DELETE FROM factura_producto WHERE factura_id=:id");

    $eliminar_factura->execute([":id"=>$product_id_del]);
    $eliminar_factura_producto->execute([":id"=>$product_id_del]);

    if($eliminar_factura->rowCount() == 1){

        echo '  <div class="notification is-success is-light animate-bounce" style="margin-top: 15px;">
                    <strong class="is-size-4">!Eliminado Exitosamente!</strong><br>
                    Se ha eliminado la Factura Exitosamente
                </div>';

    $eliminar_factura_producto = null;
    $eliminar_factura = null;
    }
}else{
    echo '  <div class="notification is-danger is-light animate-bounce" style="margin-top: 15px;">
                <strong class="is-size-4">!!!Ocurrio un Error!!!</strong><br>
                El factura que intentas eliminar no existe.
            </div>';
}

$check_factura = null;