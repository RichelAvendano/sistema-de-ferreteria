<?php
    header('Content-Type: text/html; charset=utf-8'); // Asegura que la respuesta se envíe como HTML
    require_once "main.php";

    $usuario = limpiar_cadena($_POST['usuario_usuario']);
    $clave1 = limpiar_cadena($_POST['usuario_clave_1']);
    $clave2 = limpiar_cadena($_POST['usuario_clave_2']);

    if(empty($usuario) || empty($clave1) || empty($clave2)){
        echo $htmlContent = 
              '<div class="notification is-danger" style="margin-top: 15px;">
                <strong class="is-size-4">!!!Ocurrio un Error!!!</strong><br>
                No has llenado todos los campos
              </div>';
        exit();
    }

    if(verificar_datos("[a-zA-Z0-9]{4,20}", $usuario)){
        echo $htmlContent ='<div class="notification is-danger" style="margin-top: 15px;">
                <strong class="is-size-4">!!!Ocurrio un Error!!!</strong><br>
                No has Introducido los datos correctamente del Usuario
              </div>';
        exit();
    }else{

        $check_usuario = conexion();
        $check_usuario = $check_usuario->query("SELECT usuario_usuario FROM usuario WHERE usuario_usuario = '$usuario'");
        if($check_usuario->rowCount() > 0){
            echo $htmlContent ='<div class="notification is-danger" style="margin-top: 15px;">
                    <strong class="is-size-4">!!!Ocurrio un Error!!!</strong><br>
                    El Nombre de Usuario ya esta registrado
                  </div>';
            exit();
        }
        $check_usuario=null;
    }

    if($clave1 != $clave2){
        echo $htmlContent = '<div class="notification is-danger" style="margin-top: 15px;">
                <strong class="is-size-4">!!!Ocurrio un Error!!!</strong><br>
                Las contraseñas no coinciden
              </div>';
        exit();
    }else{
        $clave1 = password_hash($clave1, PASSWORD_BCRYPT,['cost'=>4]);
    }

    $guardar_usuario = conexion();

    $guardar_usuario = $guardar_usuario->prepare("INSERT INTO usuario(usuario_usuario, usuario_clave) VALUES(:usuario, :clave1)");
    
    $marcadores = [
        ':usuario' => $usuario,
        ':clave1' => $clave1
    ];
    $guardar_usuario->execute($marcadores);

    if($guardar_usuario->rowCount() == 1){

        echo $htmlContent = '<div class="notification is-success is-light" style="margin-top: 15px;">
                <strong class="is-size-4">!!!Registro Exitoso!!!</strong><br>
                Vuelva al Login para Iniciar Sesion
              </div>';

    }else{
        echo $htmlContent = '<div class="notification is-danger" style="margin-top: 15px;">
                <strong class="is-size-4">!!!Ocurrio un Error!!!</strong><br>
                No se pudo registrar el usuario
              </div>';
    }

    $guardar_usuario=null;