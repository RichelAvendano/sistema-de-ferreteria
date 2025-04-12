<?php

    function conexion(){
        $pdo = new PDO('mysql:host=localhost;dbname=inventario_practica', 'root', '');
        return $pdo;
    }
    
    function verificar_datos($filter, $string){
        if(preg_match("/" . $filter . "/", $string)){
            return false;
        }else{
            return true;
        }
    }

    function limpiar_cadena($string){
        //elimina espacios en blanco al principio y al final de la cadena
        $string = trim($string);
        //elimina barras invertidas
        $string = stripslashes($string);
        // Eliminar etiquetas de script
        $string = str_replace("<script>", "", $string);
        $string = str_replace("</script>", "", $string);
        // Eliminar etiquetas de estilo
        $string = str_replace("<style>", "", $string);
        $string = str_replace("</style>", "", $string);
        // Eliminar eventos de JavaScript
        $string = str_replace("onload=", "", $string);
        $string = str_replace("onclick=", "", $string);
        $string = str_replace("onmouseover=", "", $string);
        $string = str_replace("onerror=", "", $string);
        $string = str_replace("onfocus=", "", $string);
        // Ejemplo de "limpieza" muy básica con str_replace
        $string = str_replace("'", "", $string); // Eliminar comillas simples
        $string = str_replace(";", "", $string); // Eliminar punto y coma
        $string = str_replace("--", "", $string); // Eliminar comentarios de línea en SQL
        $string = str_replace("/*", "", $string); // Eliminar comentarios de bloque en SQL
        $string = str_replace("*/", "", $string); // Eliminar comentarios de bloque en SQL
        // Algunos patrones SQL peligrosos
        $patrones = array(
            '/UNION/i', // Eliminar UNION
            '/SELECT/i', // Eliminar SELECT
            '/INSERT/i', // Eliminar INSERT
            '/UPDATE/i', // Eliminar UPDATE
            '/DELETE/i', // Eliminar DELETE
            '/DROP/i',   // Eliminar DROP
            '/;/',       // Eliminar punto y coma
            '/--/',      // Eliminar comentarios de línea en SQL
            '/\/\*/',    // Eliminar comentarios de bloque en SQL
            '/\*\//'     // Eliminar comentarios de bloque en SQL
        );
        $string = preg_replace($patrones, "", $string);
        //elimina espacios en blanco al principio y al final de la cadena
        $string = trim($string);
        //elimina barras invertidas
        $string = stripslashes($string);
        return $string;
    }

    function renombrar_fotos($nombre_foto){
        $caracteres_no_permitidos = array(" ", "/", "\\", "<", ">", "*", "?", "\"", ":", "|",".",",",";");
        $nombre_foto = str_replace($caracteres_no_permitidos, "_", $nombre_foto);
        $nombre_foto = $nombre_foto . "_".rand(1, 1000);
        return $nombre_foto;
    }

    function pagininador_tablas($pagina_actual,$total_paginas,$url,$botones){
        $tabla = '
            <nav class="pagination is-centered" role="navigation" aria-label="pagination">
        ';

        //boton anterior
        if($pagina_actual == 1){
            $tabla.='
                <a href="'.$url.($pagina_actual-1).'" class="pagination-previous is-disabled" disabled>Anterior</a>
                <ul class="pagination-list">';
            
        }else{
            $tabla.='
                <a href="'.$url.($pagina_actual-1).'" class="pagination-previous custom-background" >Anterior</a>
                <ul class="pagination-list">
                    <li><a href="'.$url.'1" class="pagination-link" style="background-color:rgba(255, 255, 255)" aria-label="Goto page 1">1</a></li>
                    <li><span class="pagination-ellipsis">&hellip;</span></li>
            ';
        }
        $band=0;
        for($i=$pagina_actual; $i<=$total_paginas;$i++){
            if($band>=$botones){
                break;
            }
            if($pagina_actual == $i){
                $tabla.='
                    <li>
                        <a href="#" class="pagination-link is-current" aria-label="Page '.$i.'" aria-current="page">'.$i.'</a>
                    </li>
                ';
            }else{
                $tabla.='
                    <li>
                        <a href="'.$url.$i.'" class="pagination-link" aria-label="Goto page" style="background-color:rgba(255, 255, 255)" '.$i.'">'.$i.'</a>
                    </li>
                ';
            }
            $band++;
        }
        //boton siguiente
        if($pagina_actual == $total_paginas){
            $tabla.='
                </ul>
                <a href="'.$url.($pagina_actual+1).'" class="pagination-next is-disabled " disabled>Siguiente</a>
            ';
            
        }else{
            $tabla.='
                    <li><span class="pagination-ellipsis">&hellip;</span></li>
                    <li><a href="'.$url.$total_paginas.'" class="pagination-link" aria-label="Goto page 86" style="background-color:rgba(255, 255, 255)">'.$total_paginas.'</a></li>
                </ul>
                <a href="'.$url.($pagina_actual+1).'" class="pagination-next custom-background">Siguiente</a>
            ';
            
        }
        $tabla.='</nav>';

        return $tabla;

    }


    function formatear_dinero($numero) {
        return number_format($numero, 2, ',', '.');
    }


