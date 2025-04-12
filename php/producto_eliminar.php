<?php

$product_id_del = limpiar_cadena($_GET['product_id_del']);

$check_producto = conexion();
$check_producto_nombre = conexion();

$check_producto = $check_producto->query("SELECT * FROM producto WHERE producto_id='$product_id_del'");

$check_producto_nombre = $check_producto_nombre->query("SELECT producto_nombre FROM producto WHERE producto_id='$product_id_del'");
$check_producto_nombre = $check_producto_nombre->fetchColumn();


if($check_producto->rowCount() == 1){
    $eliminar_producto = conexion();
    $eliminar_producto = $eliminar_producto->prepare("DELETE FROM producto WHERE producto_id=:id");
    
    $check_producto = $check_producto->fetch();
    $archivo = 'img/productos/'.$check_producto['producto_foto'];
    if(file_exists($archivo)) {
        @unlink($archivo);
    }

    $eliminar_producto->execute([":id"=>$product_id_del]);

    if($eliminar_producto->rowCount() == 1){

        echo '  <div class="notification is-success is-light animate-bounce" style="margin-top: 15px;">
                    <strong class="is-size-4">!Eliminado Exitosamente!</strong><br>
                    Se ha eliminado el Producto de nombre: '.$check_producto_nombre.'
                </div>';
        $check_producto_nombre = null;

    $eliminar_producto = null;
    }else{
        echo '  <div class="notification is-danger is-light animate-bounce" style="margin-top: 15px;">
                    <strong class="is-size-4">!!!Ocurrio un Error!!!</strong><br>
                    No podemos eliminar el producto ya que tiene productos registrados
                </div>';
    }
}else{
    echo '  <div class="notification is-danger is-light animate-bounce" style="margin-top: 15px;">
                <strong class="is-size-4">!!!Ocurrio un Error!!!</strong><br>
                El producto que intentas eliminar no existe.
            </div>';
}

$check_producto = null;