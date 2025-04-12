<?php 
    
    $inicio = ($pagina>0) ? (($registros * $pagina) - $registros) : 0;
    $tabla = "";

    if(isset($busqueda) && $busqueda != ""){
        
        $consulta_datos = "SELECT cliente.cliente_cedula, cliente.cliente_nombre, factura.factura_monto, factura.factura_fecha, factura.factura_id FROM factura INNER JOIN cliente ON factura.cliente_id = cliente.cliente_id WHERE cliente_" . $search_op . " LIKE '%" . $busqueda . "%' ORDER BY factura_fecha DESC LIMIT $inicio, $registros";

        // Consulta total
        $consulta_total = "SELECT COUNT(factura_id) FROM factura INNER JOIN cliente ON factura.cliente_id = cliente.cliente_id WHERE cliente_" . $search_op . " LIKE '%" . $busqueda . "%'";


    }else if(isset($fecha) && !empty($fecha)){

        $consulta_datos="SELECT cliente.cliente_cedula, cliente.cliente_nombre, factura.factura_monto, factura.factura_fecha, factura.factura_id FROM factura INNER JOIN cliente ON factura.cliente_id = cliente.cliente_id WHERE DATE(factura.factura_fecha) = '$fecha' ORDER BY factura.factura_fecha $busqueda1 LIMIT $inicio,$registros";
        
        $consulta_total="SELECT COUNT(factura_id) FROM factura INNER JOIN cliente ON factura.cliente_id = cliente.cliente_id WHERE DATE(factura.factura_fecha) = '$fecha' ORDER BY factura.factura_fecha $busqueda1";
    }else if(isset($busqueda_max) && $busqueda_max != "" && isset($busqueda_min) && $busqueda_min != ""){
        
        $consulta_datos = "SELECT cliente.cliente_cedula, cliente.cliente_nombre, factura.factura_monto, factura.factura_fecha, factura.factura_id FROM factura INNER JOIN cliente ON factura.cliente_id = cliente.cliente_id WHERE factura_" . $search_op . " >= " . $busqueda_min . " AND factura_" . $search_op . " <= " . $busqueda_max . " ORDER BY factura_fecha DESC LIMIT $inicio, $registros";

        $consulta_total = "SELECT COUNT(factura_id) FROM factura INNER JOIN cliente ON factura.cliente_id = cliente.cliente_id WHERE factura_" . $search_op . " >= " . $busqueda_min . " AND factura_" . $search_op . " <= " . $busqueda_max . " ORDER BY factura_fecha DESC";
      
    }else if(isset($fecha2) && !empty($fecha2)){

        $consulta_datos="SELECT cliente.cliente_cedula, cliente.cliente_nombre, factura.factura_monto, factura.factura_fecha, factura.factura_id FROM factura INNER JOIN cliente ON factura.cliente_id = cliente.cliente_id WHERE factura.factura_fecha LIKE '%$fecha2%' ORDER BY factura.factura_fecha $busqueda1 LIMIT $inicio,$registros";
        
        $consulta_total="SELECT COUNT(factura_id) FROM factura INNER JOIN cliente ON factura.cliente_id = cliente.cliente_id WHERE factura.factura_fecha LIKE '%$fecha2%' ORDER BY factura.factura_fecha $busqueda1";
    }else{
        $consulta_datos="SELECT cliente.cliente_cedula, cliente.cliente_nombre, factura.factura_monto, factura.factura_fecha, factura.factura_id FROM factura INNER JOIN cliente ON factura.cliente_id = cliente.cliente_id ORDER BY factura.factura_id DESC LIMIT $inicio,$registros";

        $consulta_total="SELECT COUNT(factura_id) FROM factura INNER JOIN cliente ON factura.cliente_id = cliente.cliente_id";
    }

    $conexion = conexion();

    $datos = $conexion->query($consulta_datos);
    $datos = $datos->fetchAll();

    $total=$conexion->query($consulta_total);
    $total = (int) $total->fetchColumn();

    $Npaginas = ceil($total/$registros);

    

    $tabla.='
        <div class="table-container">
            <table class="table table is-bordered is-fullwidth table-custom-bordered ">
                <thead>
                    <tr class="has-background-link-90">
                        <th class="has-text-black" style = "text-align: center">#</th>
                        <th class="has-text-black" style = "text-align: center">Cedula</th>
                        <th class="has-text-black" style = "text-align: center">Nombre</th>
                        <th class="has-text-black" style = "text-align: center">Monto</th>
                        <th class="has-text-black" style = "text-align: center">Fecha</th>
                        <th class="has-text-black" style = "text-align: center" colspan="4">Opciones</th>
                    </tr>
                </thead>
                <tbody>
    ';
    
    if($total>= 1 && $pagina<=$Npaginas){
        $contador=$inicio+1;
        $pag_inicio=$inicio+1;
        foreach($datos as $rows){
            $factura_monto = number_format($rows['factura_monto'], 2, ',', '.');
            $tabla.='
                <tr class="has-text-centered has-background-link-100" >
                    <td class="has-text-black has-text-weight-bold" >'.$contador.'</td>
					<td class="has-text-black " >'.$rows['cliente_cedula'].'</td>
                    <td class="has-text-black" >'.$rows['cliente_nombre'].'</td>
                    <td class="has-text-black" >$'.$factura_monto.'</td>
                    <td class="has-text-black" >'.$rows['factura_fecha'].'</td>
                    <td>
                        <a href="index.php?view=bill_view&bill_id='.$rows['factura_id'].'" class="button is-link is-rounded is-small has-text-white">Ver Factura</a>
                    </td>
                    <td>
                        <a href="php/invoice.php?bill_id='.$rows['factura_id'].'" class="button is-primary is-rounded is-small has-text-white" target="_blank">Imprimir</a>
                    </td>
                    <td>
                        <a href="index.php?view=bill_update&bill_id_up='.$rows['factura_id'].'" class="button is-success is-rounded is-small has-text-white js-confirm-trigger" data-target="modal-js-confirm-1">Actualizar</a>
                    </td>
                    <td>
                        <a href="'.$url.$pagina.'&bill_id_del='.$rows['factura_id'].'" class="button is-danger is-rounded is-small has-text-white js-confirm-trigger" data-target="modal-js-confirm-2">Eliminar</a>
                    </td>
                </tr>
            ';
            $contador++;
        }
        $pag_final=$contador-1;
    }else{
        if($total>=1){
            $tabla.='
                <tr class="has-text-centered" >
					<td colspan="7">
						!!Error!! Esta Pagina No tiene Registros
					</td>
				</tr>
                <tr class="has-text-centered" >
					<td colspan="7">
						<a href="'.$url.'1" class="button is-link is-rounded is-small mt-4 mb-4">
							Haga clic acá para ir a la Primera Pagina
						</a>
					</td>
				</tr>
            ';
        }else{
            $tabla.='
                <tr class="has-text-centered" >
					<td colspan="7">
						No hay registros en el sistema
					</td>
				</tr>
            ';
        }
    }
    $tabla.='</tbody></table> </div> ';

    if($total>=1 && $pagina<=$Npaginas){
        $tabla.='<p class="has-text-right">Mostrando Facturas <strong>'.$pag_inicio.'</strong> al <strong>'.$pag_final.'</strong> de un <strong>'.$total.'</strong></p>';
    }

    $conexion = null;

    echo $tabla;

    if($total>=1 && $pagina<=$Npaginas){
        echo pagininador_tablas($pagina,$Npaginas,$url,3);
    }
