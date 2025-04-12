<?php
    
    $modulo_buscador = limpiar_cadena($_POST['modulo_buscador']);

    $modulos=["producto_stock_price","factura_3"];

    if(in_array($modulo_buscador,$modulos)){

        $modulos_url=[
            "producto_stock_price"=>"product_stock_price",
            "factura_3"=> "bill_search_op_3"
        ];
        $modulos_url = $modulos_url[$modulo_buscador];

        $modulo_buscador="busqueda_".$modulo_buscador;

        if(isset($_POST['txt_buscador_min']) && isset($_POST['txt_buscador_max'])){
            $txt_min = limpiar_cadena($_POST['txt_buscador_min']);
            $txt_max = limpiar_cadena($_POST['txt_buscador_max']);

            if($txt_max!="" && $txt_min != ""){
                $_SESSION["txt_min"] = $txt_min;
                $_SESSION["txt_max"] = $txt_max;
                    
                    if (headers_sent()) {
                        // Redirección con JavaScript
                        echo '<script type="text/javascript">';
                        echo 'window.location.href="index.php?view='.$modulos_url.'";';
                        echo '</script>';
                        exit();
                    } else {
                        // Redirección con PHP
                        header('Location: index.php?view='.$modulos_url.'',true,303);
                        exit();
                    }
                exit();
            }                   
        }

        if(isset($_POST['eliminar_buscador'])){

            unset($_SESSION["txt_min"]);
            unset($_SESSION["txt_max"]);
            unset($_SESSION['rango_valor']);
            unset($_SESSION['search_op']);
            unset($_SESSION[$modulo_buscador]);

            if (headers_sent()) {
                // Redirección con JavaScript
                echo '<script type="text/javascript">';
                echo 'window.location.href="index.php?view='.$modulos_url.'";';
                echo '</script>';
                exit();
            } else {
                // Redirección con PHP
                header('Location: index.php?view='.$modulos_url.'',true,303);
                exit();
            }
            exit();
        }
    }

?>