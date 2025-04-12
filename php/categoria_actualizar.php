<?php
    require_once "../inc/session_start.php";
    require_once "main.php";
    
    $id = limpiar_cadena($_POST['categoria_id']);


    $check_categoria = conexion();
    $check_categoria = $check_categoria->query("SELECT * FROM categoria WHERE categoria_id ='$id'");

    if($check_categoria->rowCount()<=0){
        echo $htmlContent = '<div class="notification is-danger is-light">
                <strong class="is-size-4">!!!Ocurrio un Error!!!</strong><br>
                El categoria no existe en el Sistema
              </div>';
        exit();
    }else{
        $datos = $check_categoria->fetch();
    }
    $check_categoria = null;


    $nombre = limpiar_cadena($_POST['categoria_nombre']);
    $ubicacion = limpiar_cadena($_POST['categoria_ubicacion']);


    if(empty($nombre)){
        echo $htmlContent = '<div class="notification is-danger is-light" style="margin-top: 15px;">
                <strong class="is-size-4">!!!Ocurrio un Error!!!</strong><br>
                No has llenado todos los campos
              </div>';
        exit();
    }

    if(verificar_datos("[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,40}", $nombre)){
        echo $htmlContent = '<div class="notification is-danger" style="margin-top: 15px;">
                <strong class="is-size-4">!!!Ocurrio un Error!!!</strong><br>
                No has Introducido los datos correctamente
              </div>';
        exit();
    }


    $actualizar_categoria = conexion();
    $actualizar_categoria = $actualizar_categoria->prepare("UPDATE categoria SET categoria_nombre=:nombre, categoria_ubicacion=:ubicacion WHERE categoria_id=:id");

    $marcadores = [
        ':nombre' => $nombre,
        ':ubicacion' => $ubicacion,
        ':id'=> $id
    ];
    
    if($actualizar_categoria->execute($marcadores)){
        echo $htmlContent = '<div class="notification is-success is-light" style="margin-top: 15px;">
                        <strong class="is-size-4">!Categoria Actualizada con Exito!</strong><br>
                        No hubo Problemas
                        </div>';
    }else{
        echo $htmlContent = '<div class="notification is-danger is-light" style="margin-top: 15px;">
                        <strong class="is-size-4">!!!Ocurrio un Error!!!</strong><br>
                        No se pudo Actualizar la Categoria, Intente Nuevamente
                        </div>';
               
    }
    $actualizar_categoria = null;
    