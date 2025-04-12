<?php
    if(isset($_POST['date-time'])){
        $_SESSION['fecha'] = $_POST['date-time'];
    }  

    $modulo_buscador = limpiar_cadena($_POST['modulo_buscador']);

    $modulos=["usuario","categoria","producto","cliente","factura_1","factura_2","proveedor"];

    if(in_array($modulo_buscador,$modulos)){

        $modulos_url=[
            "usuario"=>"user_search",
            "categoria"=>"category_search",
            "producto"=>"product_search",
            "cliente"=>"client_search",
            "factura_1"=>"bill_search_op_1",
            "factura_2"=>"bill_search_op_2",
            "proveedor"=>"supplier_search"
        ];
        $modulos_url = $modulos_url[$modulo_buscador];

        $modulo_buscador="busqueda_".$modulo_buscador;

        if(isset($_POST['txt_buscador'])){
            $txt = limpiar_cadena($_POST['txt_buscador']);

            if($txt==""){
                echo '<div class="notification is-danger is-light animate-bounce" style="margin-top: 15px;">
                        <strong class="is-size-4">!!!Ocurrio un Error!!!</strong><br>
                        Debe introducir un término de búsqueda.
                    </div>';
            }else{
                if(verificar_datos('[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ ]{1,30}',$txt)){
                    echo '<div class="notification is-danger is-light animate-bounce" style="margin-top: 15px;">
                        <strong class="is-size-4">!!!Ocurrio un Error!!!</strong><br>
                        No coincide con el formato solicitado
                    </div>';
                }else{
                    $_SESSION[$modulo_buscador] = $txt;
                    if (headers_sent()) {
                        // Redirección con JavaScript
                        echo '<script type="text/javascript">';
                        echo 'window.location.href="index.php?view=' . $modulos_url . '";';
                        echo '</script>';
                        exit();
                    } else {
                        // Redirección con PHP
                        header('Location: index.php?view=' . $modulos_url, true, 303);
                        exit();
                    }
                    
                    exit();
                }
            }
        }

        if(isset($_POST['eliminar_buscador'])){
            unset($_SESSION['fecha']);
            unset($_SESSION[$modulo_buscador]);
            unset($_SESSION['search_op']);

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
    }else{
        echo '<div class="notification is-danger is-light animate-bounce" style="margin-top: 15px;">
                    <strong class="is-size-4">!!!Ocurrio un Error!!!</strong><br>
                    No pudimos procesar la busqueda
                </div>';
    }

?>