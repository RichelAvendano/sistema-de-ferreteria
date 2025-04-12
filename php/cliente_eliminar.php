<?php

$client_id_del = limpiar_cadena($_GET['client_id_del']);

$check_cliente = conexion();
$check_cliente_nombre = conexion();

$check_cliente = $check_cliente->query("SELECT cliente_id FROM cliente WHERE cliente_id='$client_id_del'");

$check_cliente_nombre = $check_cliente_nombre->query("SELECT cliente_nombre FROM cliente WHERE cliente_id='$client_id_del'");
$check_cliente_nombre = $check_cliente_nombre->fetchColumn();

if($check_cliente->rowCount() == 1){

    $check_clientes = conexion();
    $check_clientes = $check_clientes->query("SELECT cliente_id FROM cliente WHERE cliente_id='$client_id_del' LIMIT 1");

    if($check_clientes->rowCount() <= 1){

        $eliminar_cliente = conexion();
        $eliminar_cliente = $eliminar_cliente->prepare("DELETE FROM cliente WHERE cliente_id=:id");

        $eliminar_cliente->execute([":id"=>$client_id_del]);

        if($eliminar_cliente->rowCount() == 1){
            echo '  <div class="notification is-success is-light animate-bounce" style="margin-top: 15px;">
                        <strong class="is-size-4">!Eliminado Exitosamente!</strong><br>
                        Se ha eliminado el cliente de nombre: '.$check_cliente_nombre.'
                    </div>';
            $check_cliente_nombre = null;
        }else{
            echo '  <div class="notification is-danger is-light animate-bounce" style="margin-top: 15px;">
                        <strong class="is-size-4">!!!Ocurrio un Error!!!</strong><br>
                        El cliente no se Pudo Eliminar
                    </div>';
        }
        $eliminar_cliente = null;
    }else{
        echo '  <div class="notification is-danger is-light animate-bounce" style="margin-top: 15px;">
                    <strong class="is-size-4">!!!Ocurrio un Error!!!</strong><br>
                    No podemos eliminar el cliente ya que tiene productos registrados
                </div>';
    }
    $check_clientes = null;
}else{
    echo '  <div class="notification is-danger is-light animate-bounce" style="margin-top: 15px;">
                <strong class="is-size-4">!!!Ocurrio un Error!!!</strong><br>
                El cliente que intentas eliminar no existe.
            </div>';
}

$check_cliente = null;