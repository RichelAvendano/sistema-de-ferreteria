<?php
    require_once "../inc/session_start.php";
    require_once "main.php";
    
    $id = limpiar_cadena($_POST['cliente_id']);

    $check_cliente = conexion();
    $check_cliente = $check_cliente->query("SELECT * FROM cliente WHERE cliente_id ='$id'");
    
    if($check_cliente->rowCount()<=0){
        echo $htmlContent = '<div class="notification is-danger is-light">
                <strong class="is-size-4">!!!Ocurrio un Error!!!</strong><br>
                El Cliente no existe en el Sistema
              </div>';
        exit();
    }else{
        $datos = $check_cliente->fetch();
    }
    $check_cliente = null; 

    $cliente_nombre_exito = $datos['cliente_nombre'];

    $cedula = limpiar_cadena($_POST['cliente_cedula']);
    $nombre = limpiar_cadena($_POST['cliente_nombre']);
    $ubicacion = limpiar_cadena($_POST['cliente_ubicacion']);
    $telefono = limpiar_cadena($_POST['cliente_telefono']);

    if(verificar_datos("^[0-9]{1,8}$",$cedula)){
        echo $htmlContent = '<div class="notification is-danger" style="margin-top: 15px;">
                <strong class="is-size-4">!!!Ocurrio un Error!!!</strong><br>
                El formato de cedula es invalido
                </div>';
        exit();
    }

    if(empty($cedula) || empty($nombre) || empty($ubicacion) || empty($telefono )){
        echo $htmlContent = '<div class="notification is-danger is-light" style="margin-top: 15px;">
                <strong class="is-size-4">!!!Ocurrio un Error!!!</strong><br>
                No has llenado todos los campos
              </div>';
        exit();
    }
   

    $actualizar_cliente = conexion();
    $actualizar_cliente = $actualizar_cliente->prepare("UPDATE cliente SET cliente_cedula=:cedula, cliente_nombre=:nombre, cliente_ubicacion=:ubicacion, cliente_telefono=:telefono WHERE cliente_id=:id");

    $marcadores = [
        ':cedula' => $cedula,
        ':nombre' => $nombre,
        ':ubicacion' => $ubicacion,
        ':id'=> $id,
        'telefono' => $telefono
    ];
    
    if($actualizar_cliente->execute($marcadores)){
        echo $htmlContent = '<div class="notification is-success is-light" style="margin-top: 15px;">
                        <strong class="is-size-4">!Cliente Actualizado con Exito!</strong><br>
                        El cliente de nombre '.$cliente_nombre_exito.'
                        </div>';
    }else{
        echo $htmlContent = '<div class="notification is-danger is-light" style="margin-top: 15px;">
                        <strong class="is-size-4">!!!Ocurrio un Error!!!</strong><br>
                        No se pudo Actualizar el cliente Intente Nuevamente
                        </div>';
               
    }
    $actualizar_cliente = null;
    