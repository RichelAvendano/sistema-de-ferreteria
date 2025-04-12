<?php

$category_id_del = limpiar_cadena($_GET['category_id_del']);

$check_categoria = conexion();
$chek_categoria_nombre = conexion();

$check_categoria = $check_categoria->query("SELECT categoria_id FROM categoria WHERE categoria_id='$category_id_del'");

$chek_categoria_nombre = $chek_categoria_nombre->query("SELECT categoria_nombre FROM categoria WHERE categoria_id='$category_id_del'");
$chek_categoria_nombre = $chek_categoria_nombre->fetchColumn();

if($check_categoria->rowCount() == 1){

    $check_productos = conexion();
    $check_productos = $check_productos->query("SELECT categoria_id FROM producto WHERE categoria_id='$category_id_del' LIMIT 1");

    if($check_productos->rowCount() <= 1){

        $eliminar_categoria = conexion();
        $eliminar_categoria = $eliminar_categoria->prepare("DELETE FROM categoria WHERE categoria_id=:id");

        $eliminar_categoria->execute([":id"=>$category_id_del]);

        if($eliminar_categoria->rowCount() == 1){
            echo '  <div class="notification is-success is-light animate-bounce" style="margin-top: 15px;">
                        <strong class="is-size-4">!Eliminado Exitosamente!</strong><br>
                        Se ha eliminado el categoria de nombre: '.$chek_categoria_nombre.'
                    </div>';
            $chek_categoria_nombre = null;
        }else{
            echo '  <div class="notification is-danger is-light animate-bounce" style="margin-top: 15px;">
                        <strong class="is-size-4">!!!Ocurrio un Error!!!</strong><br>
                        La categoria no se pudo Eliminar
                    </div>';
        }
        $eliminar_categoria = null;
    }else{
        echo '  <div class="notification is-danger is-light animate-bounce" style="margin-top: 15px;">
                    <strong class="is-size-4">!!!Ocurrio un Error!!!</strong><br>
                    No podemos eliminar la categoria ya que tiene productos registrados
                </div>';
    }
    $check_productos = null;
}else{
    echo '  <div class="notification is-danger is-light animate-bounce" style="margin-top: 15px;">
                <strong class="is-size-4">!!!Ocurrio un Error!!!</strong><br>
                La categoria que intentas eliminar no existe.
            </div>';
}

$check_categoria = null;