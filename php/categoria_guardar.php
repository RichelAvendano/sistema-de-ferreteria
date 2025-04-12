<?php

    require_once "main.php";

    $nombre = limpiar_cadena($_POST['categoria_nombre']);
    $ubicacion = limpiar_cadena($_POST['categoria_ubicacion']);

    if(empty($nombre)){
        echo $htmlContent = '<div class="notification is-danger is-light" style="margin-top: 15px;">
                <strong class="is-size-4">!!!Ocurrio un Error!!!</strong><br>
                Rellena el Campo de Nombre
              </div>';
        exit();
    }

    

    $check_nombre = conexion();
    $check_nombre = $check_nombre->query("SELECT categoria_nombre FROM categoria WHERE categoria_nombre = '$nombre'");
    if($check_nombre->rowCount() > 0){
        echo $htmlContent = '<div class="notification is-danger is-light" style="margin-top: 15px;">
                <strong class="is-size-4">!!!Ocurrio un Error!!!</strong><br>
                Esta Categoria ya esta Registrada
                </div>';
        exit();
    }
    $check_nombre=null;

    $guardar_categoria = conexion();

    $guardar_categoria = $guardar_categoria->prepare("INSERT INTO categoria(categoria_nombre, categoria_ubicacion) VALUES(:nombre, :ubicacion)");
    
    $marcadores = [
        ':nombre' => $nombre,
        ':ubicacion' => $ubicacion
    ];

    $guardar_categoria->execute($marcadores);

    if($guardar_categoria->rowCount() == 1){
        echo $htmlContent = '<div class="notification is-success is-light" style="margin-top: 15px;">
                <strong class="is-size-4">!!!Registro Exitoso!!!</strong><br>
                La Categoria se ha registrado correctamente
              </div>';
        
    }else{
        echo $htmlContent = '<div class="notification is-danger is-light" style="margin-top: 15px;">
                <strong class="is-size-4">!!!Ocurrio un Error!!!</strong><br>
                No se pudo registrar la Categoria
              </div>';
    }

    $guardar_categoria=null;