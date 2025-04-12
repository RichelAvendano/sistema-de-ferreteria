<?php
    require_once "../inc/session_start.php";
    require_once "main.php";

    $nombre = limpiar_cadena($_POST['producto_nombre']);
    $precio = limpiar_cadena($_POST['producto_precio']);
    $stock = limpiar_cadena($_POST['producto_stock']);
    $categoria = limpiar_cadena($_POST['producto_categoria']);
    $proveedor = limpiar_cadena($_POST['producto_proveedor']);


    if(empty($nombre) || empty($precio) || empty($stock) || empty($categoria) || empty($proveedor)){
        echo $htmlContent = '<div class="notification is-danger " style="margin-top: 15px;">
                <strong class="is-size-4">!!!Ocurrio un Error!!!</strong><br>
                No has llenado todos los campos
              </div>';
        exit();
    }
    
    if(verificar_datos("[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,40}", $nombre) || verificar_datos("[0-9]{1,25}", $precio) || verificar_datos("[0-9]{1,25}", $stock) || verificar_datos('[0-9]{1,25}',$categoria)){
        echo $htmlContent = '<div class="notification is-danger" style="margin-top: 15px;">
                <strong class="is-size-4">!!!Ocurrio un Error!!!</strong><br>
                No has Introducido los datos correctamente
              </div>';
        exit();
    }

    $check_producto_nombre = conexion();
    $check_producto_nombre = $check_producto_nombre->query("SELECT producto_nombre FROM producto WHERE producto_nombre = '$nombre'");
    if($check_producto_nombre->rowCount() > 0){
        echo $htmlContent = '<div class="notification is-danger" style="margin-top: 15px;">
                <strong class="is-size-4">!!!Ocurrio un Error!!!</strong><br>
                El Nombre del Producto ya esta registrado
                </div>';
        exit();
    }
    $check_producto_nombre=null;

    $img_dir = "../img/productos/";

    if($_FILES['producto_foto']['name']!="" && $_FILES['producto_foto']['size']>0){
        if(!file_exists($img_dir)){
            if(!mkdir($img_dir,0777)){
                echo $htmlContent = '<div class="notification is-danger" style="margin-top: 15px;">
                <strong class="is-size-4">!!!Ocurrio un Error!!!</strong><br>
                Error al crear el Directorio
              </div>';
              exit();
            }
        }

        if(mime_content_type($_FILES['producto_foto']['tmp_name']) != "image/png" && mime_content_type($_FILES['producto_foto']['tmp_name']) != "image/jpeg"){
            echo $htmlContent = '<div class="notification is-danger" style="margin-top: 15px;">
                <strong class="is-size-4">!!!Ocurrio un Error!!!</strong><br>
                La Imagen es de un Formato no Permitido
              </div>';
              exit();
        }

        if(($_FILES['producto_foto']['size'])/1024 > 10240){
            echo $htmlContent = '<div class="notification is-danger" style="margin-top: 15px;">
                <strong class="is-size-4">!!!Ocurrio un Error!!!</strong><br>
                La Imagen es muy Pesada, Maximo 10MB
              </div>';
              exit();
        }

        switch(mime_content_type($_FILES['producto_foto']['tmp_name'])){
            case 'image/png':
                $img_ext = ".png";
            break;
            case 'image/jpeg':
                $img_ext = ".jpg";
            break;
        }

        chmod($img_dir,0777);

        $img_nombre = renombrar_fotos($nombre);
        $foto= $img_nombre . $img_ext;

        if(!move_uploaded_file($_FILES['producto_foto']['tmp_name'],$img_dir.$foto)){
            echo $htmlContent = '<div class="notification is-danger" style="margin-top: 15px;">
                <strong class="is-size-4">!!!Ocurrio un Error!!!</strong><br>
                La Imagen no se pudo Mover
              </div>';
              exit();
        }
    }else{
        $foto="";
    }

    $guardar_producto = conexion();
    $guardar_producto = $guardar_producto->prepare(" INSERT INTO producto (producto_nombre, producto_precio, producto_stock, producto_foto, categoria_id, proveedor_id) VALUES(:nombre, :precio, :stock, :foto, :categoria_id, :proveedor_id)");
    
    $marcadores = [
        ':nombre' => $nombre,
        ':precio' => $precio,
        ':stock' => $stock,
        ':foto' => $foto,
        ':categoria_id' => $categoria,
        ':proveedor_id' => $proveedor
    ];
    $guardar_producto->execute($marcadores);

    if($guardar_producto->rowCount() == 1){
        echo $htmlContent = '<div class="notification is-success is-light" style="margin-top: 15px;">
                <strong class="is-size-4">!!!Registro Exitoso!!!</strong><br>
                El Producto se ha registrado correctamente
              </div>';
              exit();
        
    }else{
        if(is_file($img_dir.$foto)){
            chmod($img_dir.$foto,0777);
            unlink($img_dir.$foto);
        }
        echo $htmlContent = '<div class="notification is-danger" style="margin-top: 15px;">
                <strong class="is-size-4">!!!Ocurrio un Error!!!</strong><br>
                No se pudo registrar el Producto
              </div>';
            exit();
    }

    $guardar_producto=null;