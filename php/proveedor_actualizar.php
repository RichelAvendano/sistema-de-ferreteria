<?php

require_once "main.php";

// Variables del proveedor
$proveedor_id = limpiar_cadena($_POST['proveedor_id']);
$proveedor_nombre = limpiar_cadena($_POST['proveedor_nombre']);
$proveedor_rif = limpiar_cadena($_POST['proveedor_rif']);
$proveedor_direccion = limpiar_cadena($_POST['proveedor_direccion']);
$proveedor_telefono = limpiar_cadena($_POST['proveedor_telefono']);
$proveedor_contacto_persona = limpiar_cadena($_POST['proveedor_contacto_persona']);
$proveedor_contacto_telefono = limpiar_cadena($_POST['proveedor_contacto_telefono']);
$proveedor_condicion_pago = limpiar_cadena($_POST['proveedor_condicion_pago']);
$proveedor_observacion = limpiar_cadena($_POST['proveedor_observacion']);

// Verifica si los campos están vacíos
if (empty($proveedor_id) || empty($proveedor_nombre) || empty($proveedor_rif) || empty($proveedor_direccion) || 
    empty($proveedor_telefono) || empty($proveedor_condicion_pago)) {

    echo $htmlContent = '<div class="notification is-danger" style="margin-top: 15px;">
            <strong class="is-size-4">!!!Ocurrio un Error!!!</strong><br>
            No has llenado todos los campos del proveedor
          </div>';
    exit();
}

// Verifica si el RIF ya está registrado por otro proveedor
$check_proveedor = conexion();
$check_proveedor = $check_proveedor->query("SELECT proveedor_id FROM proveedor WHERE proveedor_rif = '$proveedor_rif' AND proveedor_id != '$proveedor_id'");
if ($check_proveedor->rowCount() > 0) {
    echo $htmlContent = '<div class="notification is-danger" style="margin-top: 15px;">
            <strong class="is-size-4">!!!Ocurrio un Error!!!</strong><br>
            El RIF del proveedor ya está registrado por otro proveedor
          </div>';
    exit();
}
$check_proveedor = null;

// Actualiza el proveedor
$actualizar_proveedor = conexion();
$actualizar_proveedor = $actualizar_proveedor->prepare("UPDATE proveedor SET
    proveedor_nombre = :nombre,
    proveedor_rif = :rif,
    proveedor_direccion = :direccion,
    proveedor_telefono = :telefono,
    proveedor_contacto_persona = :contacto_persona,
    proveedor_contacto_telefono = :contacto_telefono,
    proveedor_condicion_pago = :condicion_pago,
    proveedor_observacion = :observacion
    WHERE proveedor_id = :id");

$marcadores = [
    ':id' => $proveedor_id,
    ':nombre' => $proveedor_nombre,
    ':rif' => $proveedor_rif,
    ':direccion' => $proveedor_direccion,
    ':telefono' => $proveedor_telefono,
    ':contacto_persona' => $proveedor_contacto_persona,
    ':contacto_telefono' => $proveedor_contacto_telefono,
    ':condicion_pago' => $proveedor_condicion_pago,
    ':observacion' => $proveedor_observacion
];
$actualizar_proveedor->execute($marcadores);

if ($actualizar_proveedor->rowCount() == 1) {
    echo $htmlContent = '<div class="notification is-success is-light" style="margin-top: 15px;">
            <strong class="is-size-4">!!!Actualización Exitosa!!!</strong><br>
            El proveedor se ha actualizado correctamente
          </div>';
    
} else {
    echo $htmlContent = '<div class="notification is-danger" style="margin-top: 15px;">
            <strong class="is-size-4">!!!Ocurrio un Error!!!</strong><br>
            No se pudo actualizar el proveedor
          </div>';
}

$actualizar_proveedor = null;
?>
