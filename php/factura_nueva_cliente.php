
<?php

require_once "main.php";

try {
    $conexion = conexion();
    $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Error de conexión: " . $e->getMessage());
}

if (isset($_POST['query'])) {
    $query = htmlspecialchars($_POST['query']);
    $sql = "SELECT * FROM cliente WHERE cliente_cedula LIKE :query";
    $stmt = $conexion->prepare($sql);
    $stmt->execute(['query' => "$query%"]);
    
    if ($stmt->rowCount() > 0) {
        $cont = 0; // Inicializa el contador
    
        while (($row = $stmt->fetch(PDO::FETCH_ASSOC)) && $cont < 8) { // Agrega la condición para un máximo de 5 iteraciones
            if ($row) { // Comprueba si $row es un array
                echo "<div class='resultado' data-cliente_id='" . $row['cliente_id'] . "' data-cedula='" . $row['cliente_cedula'] . "' data-nombre='" . $row['cliente_nombre'] . "' data-ubicacion='" . $row['cliente_ubicacion'] . "' data-telefono=".$row['cliente_telefono'].">" . $row['cliente_cedula'] . " - " . $row['cliente_nombre'] . "</div>";
                $cont++;
            }
        }
    } else {
        echo "<div class='has-text-centered '>
                <p class='pb-2'>No se encontraron resultados</p>
                <button class='button is-success' type='button' onclick='guardarCliente()'>Guardar Cliente</button>
                <div id='result' class='pt-3'></div>
             </div>
             <div class='has-text-centered '>
                <a class='button is-danger is-light is-small' onclick='eliminarDatosCliente()'>Eliminar Datos</a>
                <div id='result' class='pt-3'></div>
              </div>
             ";
        
    }
    
}

$conexion = null;
?>

