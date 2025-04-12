<?php 

    $inicio = ($pagina > 0) ? (($registros * $pagina) - $registros) : 0;
    $tabla = "";

    if (isset($busqueda) && $busqueda != "") {
        
        $consulta_datos = "SELECT * FROM proveedor WHERE proveedor_" . $search_op . " LIKE '%" . $busqueda . "%' ORDER BY proveedor_id ASC LIMIT $inicio, $registros";

        // Consulta total
        $consulta_total = "SELECT COUNT(proveedor_id) FROM proveedor WHERE proveedor_" . $search_op . " LIKE '%" . $busqueda . "%'";

    } else {
        $consulta_datos = "SELECT * FROM proveedor ORDER BY proveedor_id ASC LIMIT $inicio, $registros";
        $consulta_total = "SELECT COUNT(proveedor_id) FROM proveedor";
    }

    $conexion = conexion();

    $datos = $conexion->query($consulta_datos);
    $datos = $datos->fetchAll();

    $total = $conexion->query($consulta_total);
    $total = (int) $total->fetchColumn();

    $Npaginas = ceil($total / $registros);

    $tabla .= '
        <div class="table-container">
            <table class="table is-bordered is-fullwidth table-custom-bordered">
                <thead>
                    <tr class="has-background-link-90">
                        <th class="has-text-black" style="text-align: center">#</th>
                        <th class="has-text-black" style="text-align: center">Nombre</th>
                        <th class="has-text-black" style="text-align: center">RIF</th>
                        <th class="has-text-black" style="text-align: center">Dirección</th>
                        <th class="has-text-black" style="text-align: center">Teléfono</th>
                        <th class="has-text-black" style = "text-align: center" colspan="4">Opciones</th>
                    </tr>
                </thead>
                <tbody>
    ';
    
    if ($total >= 1 && $pagina <= $Npaginas) {
        $contador = $inicio + 1;
        $pag_inicio = $inicio + 1;
        foreach ($datos as $rows) {
            $tabla .= '
                <tr class="has-text-centered has-background-link-100">
                    <td class="has-text-black has-text-weight-bold">' . $contador . '</td>
                    <td class="has-text-black">' . htmlspecialchars($rows['proveedor_nombre']) . '</td>
                    <td class="has-text-black">J - ' . htmlspecialchars($rows['proveedor_rif']) . '</td>
                    <td class="has-text-black">' . htmlspecialchars($rows['proveedor_direccion']) . '</td>
                    <td class="has-text-black">' . htmlspecialchars($rows['proveedor_telefono']) . '</td>
                    <td>
                        <a href="index.php?view=supplier_view&supplier_id='.$rows['proveedor_id'].'" class="button is-link is-rounded is-small has-text-white">Ver Proveedor</a>
                    </td>
                    <td>
                        <a href="index.php?view=product_supplier&supplier_id='.$rows['proveedor_id'].'" class="button is-info is-rounded is-small has-text-white">Ver Productos</a>
                    </td>
                    <td>
                        <a href="index.php?view=supplier_update&supplier_id_up='.$rows['proveedor_id'].'" class="button is-success is-rounded is-small has-text-white js-confirm-trigger" data-target="modal-js-confirm-1">Actualizar</a>
                    </td>
                    <td>
                        <a href="'.$url.$pagina.'&supplier_id_del='.$rows['proveedor_id'].'" class="button is-danger is-rounded is-small has-text-white js-confirm-trigger" data-target="modal-js-confirm-2">Eliminar</a>
                    </td>
                </tr>
            ';
            $contador++;
        }
        $pag_final = $contador - 1;
    } else {
        if ($total >= 1) {
            $tabla .= '
                <tr class="has-text-centered">
                    <td colspan="5">
                        !!Error!! Esta página no tiene registros
                    </td>
                </tr>
                <tr class="has-text-centered">
                    <td colspan="5">
                        <a href="' . $url . '1" class="button is-link is-rounded is-small mt-4 mb-4">
                            Haga clic acá para ir a la primera página
                        </a>
                    </td>
                </tr>
            ';
        } else {
            $tabla .= '
                <tr class="has-text-centered">
                    <td colspan="5">
                        No hay registros en el sistema
                    </td>
                </tr>
            ';
        }
    }
    $tabla .= '</tbody></table></div>';

    if ($total >= 1 && $pagina <= $Npaginas) {
        $tabla .= '<p class="has-text-right">Mostrando proveedores <strong>' . $pag_inicio . '</strong> al <strong>' . $pag_final . '</strong> de un <strong>' . $total . '</strong></p>';
    }

    $conexion = null;

    echo $tabla;

    if ($total >= 1 && $pagina <= $Npaginas) {
        echo pagininador_tablas($pagina, $Npaginas, $url, 3);
    }
?>
