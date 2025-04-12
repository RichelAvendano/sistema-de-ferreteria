<?php 
    

    $inicio = ($pagina>0) ? (($registros * $pagina) - $registros) : 0;
    $tabla = "";

    if(isset($busqueda) && $busqueda != ""){
        
        if($busqueda == 0){
            $consulta_datos = "SELECT producto.producto_id, producto.producto_nombre, producto.producto_precio, producto.producto_stock, producto.producto_foto,proveedor.proveedor_nombre, categoria.categoria_nombre 
            FROM producto 
            INNER JOIN categoria ON producto.categoria_id = categoria.categoria_id 
            INNER JOIN proveedor ON producto.proveedor_id = proveedor.proveedor_id 
            WHERE producto_" . $search_op . " LIKE '" . $busqueda . "%'" . " ORDER BY producto.producto_id ASC LIMIT $inicio, $registros"; 
        }else{
            $consulta_datos = "SELECT producto.producto_id, producto.producto_nombre, producto.producto_precio, producto.producto_stock, producto.producto_foto,proveedor.proveedor_nombre, categoria.categoria_nombre 
            FROM producto 
            INNER JOIN categoria ON producto.categoria_id = categoria.categoria_id 
            INNER JOIN proveedor ON producto.proveedor_id = proveedor.proveedor_id  
            WHERE producto_" . $search_op . " LIKE '%" . $busqueda . "%'" . " ORDER BY producto.producto_id ASC LIMIT $inicio, $registros"; 
        }

        // Consulta total

        $consulta_total = "SELECT COUNT(producto_id) FROM producto WHERE (producto_" . $search_op . " LIKE '%" . $busqueda . "%')";


    }else if(isset($busqueda_categoria) && $busqueda_categoria!=""){

        $consulta_datos = "SELECT producto.producto_id, producto.producto_nombre, producto.producto_precio, producto.producto_stock, producto.producto_foto,proveedor.proveedor_nombre, categoria.categoria_nombre 
        FROM producto 
        INNER JOIN categoria ON producto.categoria_id = categoria.categoria_id 
        INNER JOIN proveedor ON producto.proveedor_id = proveedor.proveedor_id 
        WHERE producto.categoria_id = " . $busqueda_categoria . "";

        $consulta_total = "SELECT COUNT(producto_id)
        FROM producto 
        INNER JOIN categoria ON producto.categoria_id = categoria.categoria_id 
        INNER JOIN proveedor ON producto.proveedor_id = proveedor.proveedor_id 
        WHERE producto.categoria_id = " . $busqueda_categoria . "";

    }else if(isset($busqueda_proveedor) && $busqueda_proveedor!=""){

        $consulta_datos = "SELECT producto.producto_id, producto.producto_nombre, producto.producto_precio, producto.producto_stock, producto.producto_foto,proveedor.proveedor_nombre, categoria.categoria_nombre 
        FROM producto 
        INNER JOIN categoria ON producto.categoria_id = categoria.categoria_id 
        INNER JOIN proveedor ON producto.proveedor_id = proveedor.proveedor_id 
        WHERE producto.proveedor_id = " . $busqueda_proveedor . "";

        $consulta_total = "SELECT COUNT(producto_id)
        FROM producto 
        INNER JOIN categoria ON producto.categoria_id = categoria.categoria_id 
        INNER JOIN proveedor ON producto.proveedor_id = proveedor.proveedor_id 
        WHERE producto.proveedor_id = " . $busqueda_proveedor . "";
    }else{
        $consulta_datos="SELECT producto.producto_id,producto.producto_nombre,producto.producto_precio,producto.producto_stock,producto.producto_foto,proveedor.proveedor_nombre,categoria.categoria_nombre
         FROM producto 
         INNER JOIN categoria ON producto.categoria_id = categoria.categoria_id 
         INNER JOIN proveedor ON producto.proveedor_id = proveedor.proveedor_id 
         ORDER BY producto.producto_id ASC LIMIT $inicio, $registros";

        $consulta_total="SELECT COUNT(producto_id) FROM producto INNER JOIN categoria ON producto.categoria_id = categoria.categoria_id";
    }

    $conexion = conexion();

    $datos = $conexion->query($consulta_datos);
    $datos = $datos->fetchAll();

    $total=$conexion->query($consulta_total);
    $total = (int) $total->fetchColumn();

    $Npaginas = ceil($total/$registros);

    $url_img = "./img/producto.png";

    $tabla.='
        <div class="table-container" style="overflow-x:scroll">
            <table class="table table is-bordered is-fullwidth table-custom-bordered ">
                <thead>
                    <tr class="has-background-link-90">
                        <th class="has-text-black" style = "text-align: center">#</th>
                        <th class="has-text-black" style = "text-align: center">Nombre</th>
                        <th class="has-text-black" style = "text-align: center">Imagen</th>
                        <th class="has-text-black" style = "text-align: center">Precio</th>
                        <th class="has-text-black" style = "text-align: center">Precio en Bs</th>
                        <th class="has-text-black" style = "text-align: center">Inventario</th>
                        <th class="has-text-black" style = "text-align: center">Categoria/Proveedor</th>
                        <th class="has-text-black" style = "text-align: center" colspan="3">Opciones</th>
                    </tr>
                </thead>
                <tbody>
        ';

    if($total>= 1 && $pagina<=$Npaginas){
        $contador=$inicio+1;
        $pag_inicio=$inicio+1;
                

        foreach($datos as $rows){
            
            $precio_paralelo = formatear_dinero( $rows['producto_precio'] *((float) $_SESSION['dolar_valor_paralelo']) );
            $precio_bcv = formatear_dinero( $rows['producto_precio'] *((float) $_SESSION['dolar_valor_bcv']));

            $url_img = "./img/productos/".$rows['producto_foto'];
            if(!file_exists("./img/productos/".$rows['producto_foto']) || empty($rows['producto_foto'])){
                $url_img = "./img/producto.png";
            }

            if($rows['producto_stock'] == 0){
                $alerta_producto = '<i class="fa-solid fa-circle-exclamation has-text-danger mr-1"></i>';
            }else{
                $alerta_producto = "";
            }

            $producto_precio = number_format($rows['producto_precio'], 2, ',', '.');

            $tabla.='
                <tr class="has-text-centered has-background-link-100" >
                                       
                    <td class="has-text-black has-text-weight-bold" >'.$contador.'</td>
                    <td class="has-text-black" >'.$rows['producto_nombre'].'</td>
                    <td class="has-text-black has-text-weight-bold" >
                        <figure class="media-left">
                            <p class="image is-96x96">
                                <img src="'.$url_img.'">
                            </p>
                        </figure>
                    </td>
                    <td class="has-text-black" >$'.$producto_precio.'</td>
                    <td class="has-text-black" >BCV: '.$precio_bcv.'bs <br> Paralelo: '.$precio_paralelo.'bs</td>
                    <td class="has-text-black" >'.$alerta_producto.$rows['producto_stock'].'</td>
                    <td class="has-text-black" >Categ.: '.$rows['categoria_nombre'].'<br>Prov.: '.$rows['proveedor_nombre'].'</td>
                    <td>
                        <div class="media_right has-text-right"> 
                            <a class="button is-link is-rounded is-small mb-3 js-modal-trigger-img" data-target="modal-js-img-'.$contador.'">Imagen</a>

                            <div class="modal" id="modal-js-img-'.$contador.'">
                                <div class="modal-background"></div>
                                <div class="modal-content">
                                    <p class="image is-4by3">
                                    <img src="'.$url_img.'" alt="">
                                    </p>
                                </div>
                                <button class="modal-close is-large" aria-label="close"></button>
                            </div>
                        </div>
                    </td>
                    <td>
                        <a href="index.php?view=product_update&product_id_up='.$rows['producto_id'].'" class="button is-success is-rounded is-small mb-3 js-confirm-trigger" data-target="modal-js-confirm-1">Actualizar</a>
                    </td>
                    <td>
                        <a href="'.$url.$pagina.'&product_id_del='.$rows['producto_id'].'" class="button is-danger is-rounded is-small mb-3 js-confirm-trigger" data-target="modal-js-confirm-2">Eliminar</a>
                    </td>
                </tr>
            ';
            $contador++;
        }
        $pag_final=$contador-1;
    }else{
        if($total>=1){
            $tabla.='
                <div class="notification is-danger is-light" style="margin-top: 15px;">
                    <strong class="is-size-4">!!!Ocurrio un Error!!!</strong><br>
                    La Imagen no se pudo Mover
                </div>
                <div class="has-text-centered" >
					<div>
						<a href="'.$url.'1" class="button is-link is-rounded is-small mt-4 mb-4">
							Haga clic acá para ir a la Primera Pagina
						</a>
					</div>
				</div>
            ';
        }else{
            $tabla.='
                <div class="notification is-danger is-light animate-bounce" style="margin-top: 15px;">
                    <strong class="is-size-4">!!!Parece que no Hay Productos!!!</strong><br>
                    No hay Registros en el Sistema
                </div>
            ';
        }
    }
    $tabla.='</tbody></table></div> ';

    if($total>=1 && $pagina<=$Npaginas){
        $tabla.='<p class="has-text-right">Mostrando Productos <strong>'.$pag_inicio.'</strong> al <strong>'.$pag_final.'</strong> de un <strong>'.$total.'</strong></p>';
    }

    $conexion = null;

    echo $tabla;

    if($total>=1 && $pagina<=$Npaginas){
        echo pagininador_tablas($pagina,$Npaginas,$url,3);
    }
