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

    // Verificar si la cédula ya existe en la base de datos
    $sql = "SELECT COUNT(*) FROM cliente WHERE cliente_cedula = :cedula";
    $stmt = $conexion->prepare($sql);
    $stmt->execute(['cedula' => $cedula]);
    $cedulaExiste = $stmt->fetchColumn();

    if ($cedulaExiste) {
        // La cédula ya existe, no agregar el nuevo cliente
        echo json_encode(['error' => 'La cédula ya existe. No se puede agregar el cliente.']);
    } else {
        // La cédula no existe, proceder a agregar el nuevo cliente
        $sql = "INSERT INTO cliente (cliente_cedula, cliente_nombre, cliente_ubicacion, cliente_telefono) VALUES (:cedula, :nombre, :ubicacion, :telefono)";
        $stmt = $conexion->prepare($sql);
        $stmt->execute([
            'cedula' => $cedula, 
            'nombre' => $nombre, 
            'ubicacion' => $ubicacion,
            'telefono' => $telefono
        ]);

        // Obtener el ID del cliente recién insertado
        $cliente_id = $conexion->lastInsertId();
        
        echo json_encode(['cliente_id' => $cliente_id]);
    }
} else {
    echo json_encode(['error' => 'Datos incompletos: cedula y nombre son requeridos.']);
}

$conexion = null;
?>
