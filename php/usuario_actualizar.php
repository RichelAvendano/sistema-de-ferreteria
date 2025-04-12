<?php
    require_once "../inc/session_start.php";
    require_once "main.php";
    
    $id = limpiar_cadena($_POST['usuario_id']);


    $check_usuario = conexion();
    $check_usuario = $check_usuario->query("SELECT * FROM usuario WHERE usuario_id ='$id'");

    if($check_usuario->rowCount()<=0){
        echo $htmlContent = '<div class="notification is-danger is-light">
                <strong class="is-size-4">!!!Ocurrio un Error!!!</strong><br>
                El usuario no existe en el Sistema
              </div>';
        exit();
    }else{
        $datos = $check_usuario->fetch();
    }
    $check_usuario = null;

    $usuario = limpiar_cadena($_POST['usuario_usuario']);
    $clave1 = limpiar_cadena($_POST['usuario_clave_1']);
    $clave2 = limpiar_cadena($_POST['usuario_clave_2']);

    if( empty($usuario)){
        echo $htmlContent = '<div class="notification is-danger is-light" style="margin-top: 15px;">
                <strong class="is-size-4">!!!Ocurrio un Error!!!</strong><br>
                No has llenado todos los campos
              </div>';
        exit();
    }

    if(verificar_datos("[a-zA-Z0-9]{4,20}", $usuario)){
        echo $htmlContent = '<div class="notification is-danger" style="margin-top: 15px;">
                <strong class="is-size-4">!!!Ocurrio un Error!!!</strong><br>
                No has Introducido los datos correctamente
              </div>';
        exit();
    }


    if($usuario!=$datos['usuario_usuario']){
        $check_usuario = conexion();
        $check_usuario = $check_usuario->query("SELECT usuario_usuario FROM usuario WHERE usuario_usuario = '$usuario'");
        if($check_usuario->rowCount() > 0){
            echo $htmlContent = '<div class="notification is-danger is-light" style="margin-top: 15px;">
                    <strong class="is-size-4">!!!Ocurrio un Error!!!</strong><br>
                    El Nombre de Usuario ya esta registrado
                    </div>';
            exit();
        }
        $check_usuario=null;
    }
    
    if($clave1!="" || $clave2!=""){

        if($clave1 != $clave2){
            echo $htmlContent = '<div class="notification is-danger is-light" style="margin-top: 15px;">
                    <strong class="is-size-4">!!!Ocurrio un Error!!!</strong><br>
                    Las contraseñas no coinciden
                    </div>';
            exit();
        }else{
            $clave1 = password_hash($clave1, PASSWORD_BCRYPT,['cost'=>4]);
        }
        
            
    }else{
        $clave = $datos['usuario_clave'];
    }

    $actualizar_usuario = conexion();
    $actualizar_usuario = $actualizar_usuario->prepare("UPDATE usuario SET usuario_usuario=:usuario, usuario_clave=:clave WHERE usuario_id=:id");

    $marcadores = [
        ':usuario' => $usuario,
        ':clave' => $clave1,
        ':id'=> $id
    ];
    
    if($actualizar_usuario->execute($marcadores)){
        echo $htmlContent = '<div class="notification is-success is-light" style="margin-top: 15px;">
                        <strong class="is-size-4">!Usuario Actualizado con Exito!</strong><br>
                        Actualizacion Exitosa
                        </div>';
    }else{
        echo $htmlContent = '<div class="notification is-danger is-light" style="margin-top: 15px;">
                        <strong class="is-size-4">!!!Ocurrio un Error!!!</strong><br>
                        No se pudo Actualizar el Usuario Intente Nuevamente
                        </div>';
               
    }
    $actualizar_usuario = null;
    