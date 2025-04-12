<?php

require_once "main.php";

try {
    $conexion = conexion();
    $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die(json_encode(["error" => "Error de conexión: " . $e->getMessage()]));
}

if(isset($_POST['ubicacion'])){
    $ubicacion = htmlspecialchars($_POST['ubicacion']);
}else{
    $ubicacion = "";
}

if (isset($_POST['cedula']) && isset($_POST['nombre']) && isset($_POST['telefono'])) {
    $cedula = htmlspecialchars($_POST['cedula']);
    $nombre = htmlspecialchars($_POST['nombre']);
    $telefono =  htmlspecialchars($_POST['telefono']);
    $cliente_id = htmlspecialchars($_POST['cliente_id']);


    $sql = "UPDATE cliente SET cliente_cedula=:cedula, cliente_nombre=:nombre, cliente_ubicacion=:ubicacion, cliente_telefono=:telefono WHERE cliente_id=:cliente_id";
    $stmt = $conexion->prepare($sql);
    $stmt->execute([
        'cedula' => $cedula, 
        'nombre' => $nombre, 
        'ubicacion' => $ubicacion,
        'telefono' => $telefono,
        'cliente_id' => $cliente_id
    ]);

    echo json_encode(['cliente_id' => $cliente_id]);

} else {
    echo json_encode(['error' => 'Datos incompletos: cedula y nombre son requeridos.']);
}

$conexion = null;
?>
