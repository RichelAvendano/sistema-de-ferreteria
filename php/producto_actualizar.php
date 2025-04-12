<?php
    require_once "../inc/session_start.php";
    require_once "main.php";
    
    $id = limpiar_cadena($_POST['producto_id']);


    $check_producto = conexion();
    $check_producto = $check_producto->query("SELECT * FROM producto WHERE producto_id ='$id'");

    if($check_producto->rowCount()<=0){
        echo $htmlContent = '<div class="notification is-danger is-light">
                <strong class="is-size-4">!!!Ocurrio un Error!!!</strong><br>
                El producto no existe en el Sistema
              </div>';
        exit();
    }else{
        $datos = $check_producto->fetch();
    }
    $producto_nombre_exito = $datos['producto_nombre'];

    $check_producto = null; 

    $nombre = limpiar_cadena($_POST['producto_nombre']);
    $precio = limpiar_cadena($_POST['producto_precio']);
    $stock = limpiar_cadena($_POST['producto_stock']);
    $categoria = limpiar_cadena($_POST['producto_categoria']);
    $proveedor = limpiar_cadena($_POST['producto_proveedor']);

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
        $foto = $datos['producto_foto'];
    }

    if($nombre!=$datos['producto_nombre']){
        $check_producto = conexion();
        $check_producto = $check_producto->query("SELECT producto_nombre FROM producto WHERE producto_nombre = '$nombre'");
        if($check_producto->rowCount() > 0){
            echo $htmlContent = '<div class="notification is-danger is-light" style="margin-top: 15px;">
                    <strong class="is-size-4">!!!Ocurrio un Error!!!</strong><br>
                    El Nombre del Producto ya esta registrado
                    </div>';
            exit();
        }
        $check_producto=null;
    }

    $actualizar_producto = conexion();
    $actualizar_producto = $actualizar_producto->prepare("UPDATE producto SET producto_nombre=:nombre, producto_precio=:precio, producto_stock=:stock,producto_foto=:foto, categoria_id=:categoria, proveedor_id=:proveedor WHERE producto_id=:id");

    $marcadores = [
        ':nombre' => $nombre,
        ':precio' => $precio,
        ':stock' => $stock,
        ':foto' => $foto,
        ':categoria' => $categoria,
        ':proveedor' => $proveedor,
        ':id'=> $id
    ];

    if($actualizar_producto->execute($marcadores)){
        echo $htmlContent = '<div class="notification is-success is-light" style="margin-top: 15px;">
                        <strong class="is-size-4">!Producto Actualizado con Exito!</strong><br>
                        El Producto se Ha actualizado con Exito
                        </div>';
    }else{
        echo $htmlContent = '<div class="notification is-danger is-light" style="margin-top: 15px;">
                        <strong class="is-size-4">!!!Ocurrio un Error!!!</strong><br>
                        No se pudo Actualizar el Producto Intente Nuevamente
                        </div>';
               
    }
    $actualizar_producto = null;
    