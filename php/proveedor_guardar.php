<?php

    require_once "main.php";

    // Variables del proveedor
    $proveedor_nombre = limpiar_cadena($_POST['proveedor_nombre']);
    $proveedor_rif = limpiar_cadena($_POST['proveedor_rif']);
    $proveedor_direccion = limpiar_cadena($_POST['proveedor_direccion']);
    $proveedor_telefono = limpiar_cadena($_POST['proveedor_telefono']);
    $proveedor_contacto_persona = limpiar_cadena($_POST['proveedor_contacto_persona']);
    $proveedor_contacto_telefono = limpiar_cadena($_POST['proveedor_contacto_telefono']);
    $proveedor_condicion_pago = limpiar_cadena($_POST['proveedor_condicion_pago']);
    $proveedor_observacion = limpiar_cadena($_POST['proveedor_observacion']);

    // Verifica si los campos están vacíos
    if (empty($proveedor_nombre) || empty($proveedor_rif) || empty($proveedor_direccion) || 
        empty($proveedor_telefono)  || empty($proveedor_condicion_pago)) {
        
        echo $htmlContent = '<div class="notification is-danger" style="margin-top: 15px;">
                <strong class="is-size-4">!!!Ocurrio un Error!!!</strong><br>
                No has llenado todos los campos del proveedor
              </div>';
        exit();
    }

    // Verifica si el proveedor ya está registrado
    $check_proveedor = conexion();
    $check_proveedor = $check_proveedor->query("SELECT proveedor_nombre FROM proveedor WHERE proveedor_rif = '$proveedor_rif'");
    if ($check_proveedor->rowCount() > 0) {
        echo $htmlContent = '<div class="notification is-danger" style="margin-top: 15px;">
                <strong class="is-size-4">!!!Ocurrio un Error!!!</strong><br>
                El proveedor ya está registrado
              </div>';
        exit();
    }
    $check_proveedor = null;

    // Guarda el nuevo proveedor
    $guardar_proveedor = conexion();
    $guardar_proveedor = $guardar_proveedor->prepare("INSERT INTO proveedor (
        proveedor_nombre, proveedor_rif, proveedor_direccion, proveedor_telefono, 
        proveedor_contacto_persona, proveedor_contacto_telefono, proveedor_condicion_pago, 
        proveedor_observacion) VALUES (
        :nombre, :rif, :direccion, :telefono, :contacto_persona, :contacto_telefono, 
        :condicion_pago, :observacion)");
    
    $marcadores = [
        ':nombre' => $proveedor_nombre,
        ':rif' => $proveedor_rif,
        ':direccion' => $proveedor_direccion,
        ':telefono' => $proveedor_telefono,
        ':contacto_persona' => $proveedor_contacto_persona,
        ':contacto_telefono' => $proveedor_contacto_telefono,
        ':condicion_pago' => $proveedor_condicion_pago,
        ':observacion' => $proveedor_observacion
    ];
    $guardar_proveedor->execute($marcadores);

    if ($guardar_proveedor->rowCount() == 1) {
        echo $htmlContent = '<div class="notification is-success is-light" style="margin-top: 15px;">
                <strong class="is-size-4">!!!Registro Exitoso!!!</strong><br>
                El proveedor se ha registrado correctamente
              </div>';
        
    } else {
        echo $htmlContent = '<div class="notification is-danger" style="margin-top: 15px;">
                <strong class="is-size-4">!!!Ocurrio un Error!!!</strong><br>
                No se pudo registrar el proveedor
              </div>';
    }

    $guardar_proveedor = null;
?>
