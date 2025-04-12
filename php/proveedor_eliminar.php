<?php

$supplier_id_del = limpiar_cadena($_GET['supplier_id_del']);

$check_proveedor = conexion();
$check_proveedor_nombre = conexion();

$check_proveedor = $check_proveedor->query("SELECT proveedor_id FROM proveedor WHERE proveedor_id='$supplier_id_del'");

$check_proveedor_nombre = $check_proveedor_nombre->query("SELECT proveedor_nombre FROM proveedor WHERE proveedor_id='$supplier_id_del'");
$check_proveedor_nombre = $check_proveedor_nombre->fetchColumn();

if ($check_proveedor->rowCount() == 1) {

    $eliminar_proveedor = conexion();
    $eliminar_proveedor = $eliminar_proveedor->prepare("DELETE FROM proveedor WHERE proveedor_id=:id");

    $eliminar_proveedor->execute([":id" => $supplier_id_del]);

    if ($eliminar_proveedor->rowCount() == 1) {
        echo '  <div class="notification is-success is-light animate-bounce" style="margin-top: 15px;">
                    <strong class="is-size-4">!Eliminado Exitosamente!</strong><br>
                    Se ha eliminado el Proveedor de nombre: ' . htmlspecialchars($check_proveedor_nombre) . '
                </div>';
        $check_proveedor_nombre = null;
    } else {
        echo '  <div class="notification is-danger is-light animate-bounce" style="margin-top: 15px;">
                    <strong class="is-size-4">!!!Ocurrio un Error!!!</strong><br>
                    El Proveedor no se Pudo Eliminar
                </div>';
    }
    $eliminar_proveedor = null;
} else {
    echo '  <div class="notification is-danger is-light animate-bounce" style="margin-top: 15px;">
                <strong class="is-size-4">!!!Ocurrio un Error!!!</strong><br>
                El proveedor que intentas eliminar no existe.
            </div>';
}

$check_proveedor = null;
?>
