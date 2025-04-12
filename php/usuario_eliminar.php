<?php

$user_id_del = limpiar_cadena($_GET['user_id_del']);

$check_usuario = conexion();
$check_usuario_nombre = conexion();

$check_usuario = $check_usuario->query("SELECT usuario_id FROM usuario WHERE usuario_id='$user_id_del'");

$check_usuario_nombre = $check_usuario_nombre->query("SELECT usuario_usuario FROM usuario WHERE usuario_id='$user_id_del'");
$check_usuario_nombre = $check_usuario_nombre->fetchColumn();

if($check_usuario->rowCount() == 1){

    $eliminar_usuario = conexion();
    $eliminar_usuario = $eliminar_usuario->prepare("DELETE FROM usuario WHERE usuario_id=:id");

    $eliminar_usuario->execute([":id"=>$user_id_del]);

    if($eliminar_usuario->rowCount() == 1){
        echo '  <div class="notification is-success is-light animate-bounce" style="margin-top: 15px;">
                    <strong class="is-size-4">!Eliminado Exitosamente!</strong><br>
                    Se ha eliminado el Usuario de nombre: '.$check_usuario_nombre.'
                </div>';
        $check_usuario_nombre = null;
    }else{
        echo '  <div class="notification is-danger is-light animate-bounce" style="margin-top: 15px;">
                    <strong class="is-size-4">!!!Ocurrio un Error!!!</strong><br>
                    El Usuario no se Pudo Eliminar
                </div>';
    }
    $eliminar_usuario = null;   
}else{
    echo '  <div class="notification is-danger is-light animate-bounce" style="margin-top: 15px;">
                <strong class="is-size-4">!!!Ocurrio un Error!!!</strong><br>
                El usuario que intentas eliminar no existe.
            </div>';
}

$check_usuario = null;