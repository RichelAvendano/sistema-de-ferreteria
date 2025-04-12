<?php

    require_once "main.php";

    $cedula = limpiar_cadena($_POST['cliente_cedula']);
    $nombre = limpiar_cadena($_POST['cliente_nombre']);
    $ubicacion = limpiar_cadena($_POST['cliente_ubicacion']);
    $telefono = limpiar_cadena($_POST['cliente_telefono']);

    if(empty($cedula) || empty($nombre) || empty($telefono )){
        echo $htmlContent = '<div class="notification is-danger " style="margin-top: 15px;">
                <strong class="is-size-4">!!!Ocurrio un Error!!!</strong><br>
                No has llenado todos los campos
              </div>';
        exit();
    }

    if(verificar_datos("^[0-9]{1,8}$",$cedula)){
        echo $htmlContent = '<div class="notification is-danger" style="margin-top: 15px;">
                <strong class="is-size-4">!!!Ocurrio un Error!!!</strong><br>
                El formato de cedula es invalido
              </div>';
        exit();
    }

    $check_cliente = conexion();
    $check_cliente = $check_cliente->query("SELECT cliente_cedula FROM cliente WHERE cliente_cedula = '$cedula'");
    if($check_cliente->rowCount() > 0){
        echo $htmlContent = '<div class="notification is-danger is-light" style="margin-top: 15px;">
                <strong class="is-size-4">!!!Ocurrio un Error!!!</strong><br>
                La Cedula ya esta registrada
                </div>';
        exit();
    }
    $check_cliente = null;
    
    $guardar_cliente = conexion();

    $guardar_cliente = $guardar_cliente->prepare("INSERT INTO cliente(cliente_cedula, cliente_nombre, cliente_ubicacion, cliente_telefono) VALUES(:cedula, :nombre, :ubicacion, :telefono)");
    
    $marcadores = [
        ':cedula' => $cedula,
        ':nombre' => $nombre,
        ':ubicacion' => $ubicacion,
        'telefono' => $telefono
    ];
    $guardar_cliente->execute($marcadores);

    if($guardar_cliente->rowCount() == 1){
        echo $htmlContent = '<div class="notification is-success" style="margin-top: 15px;">
                <strong class="is-size-4">!!!Registro Exitoso!!!</strong><br>
                El Cliente se ha registrado correctamente
              </div>';
        
    }else{
        echo $htmlContent = '<div class="notification is-danger" style="margin-top: 15px;">
                <strong class="is-size-4">!!!Ocurrio un Error!!!</strong><br>
                No se pudo registrar el Cliente
              </div>';
    }

    $guardar_cliente=null;