<?php 

  require_once "php/main.php";

  $id = (isset($_GET['product_id_up'])) ? $_GET['product_id_up'] : 0 ;
  $id = limpiar_cadena($id);
  $check_producto = conexion();
  $check_producto = $check_producto->query("SELECT * FROM producto WHERE producto_id = '$id'");

  if($check_producto->rowCount()>0){
    $datos = $check_producto->fetch();
    
?>
<div class = "background-image" style="height: 100%;min-height: 100vh;">
  <div class="box is-inline-block has-background-link-95 ml-3 mb-3 mt-2 p-4"  >
    <h1 class="title is-4 has-text-black has-text-centered">Productos</h1>
    <h2 class="subtitle has-text-black has-text-centered">Actualizar Productos</h2>
  </div>
  <section class="hero ">
    <div class="hero-body" style="flex-grow:0; padding-top: 0;padding-bottom: 10px;">
      <div class="container">
        <div class="columns is-centered">
          <div class="column is-three-quarters-desktopis-two-thirds-tablet">

            <form action="./php/producto_actualizar.php" class="FormularioAjax box has-background-link-light" autocomplete="off" method="POST" id="myForm" onsubmit="return confirmSubmit()" data-confirm="false" enctype="multipart/form-data">
              <input type="hidden" value="<?php echo $datos['producto_id'];?>" name="producto_id" required >
              <div class="title has-text-centered is-size-2 has-text-black">Actualizar Producto</div>
              <div class="columns is-multiline  ">
                <div class="column is-half">
                  <div class="field">
                    <label for="nombre" class="subtitle is-12 has-text-weight-bold has-text-black">Nombre</label>
                    <div class="control has-icons-left">
                      <input type="text" class="input" required id="nombre" maxlength="40" name="producto_nombre" value="<?php echo $datos['producto_nombre'];?>">
                      <span class="icon is-small is-left">
                        <i class="fa-solid fa-box"></i>
                      </span>
                    </div>
                  </div>
                </div>
                <div class="column is-half">
                  <div class="field">
                    <label for="precio" class="subtitle is-12 has-text-weight-bold has-text-black">Precio C/U en Dolares</label>
                    <div class="control has-icons-left">
                      <input type="number" class="input" required id="precio" pattern="[0-9]{1,25}" step="0.01"  maxlength="40" name="producto_precio" value="<?php echo $datos['producto_precio'];?>">
                      <span class="icon is-small is-left">
                        <i class="fa-solid fa-dollar-sign"></i>
                      </span>
                    </div>
                  </div>
                </div>
                <div class="column is-half">
                  <div class="field">
                    <label for="producto" class="subtitle is-12 has-text-weight-bold has-text-black">Cantidad (Inventario Total)</label>
                    <div class="control has-icons-left">
                      <input type="text" class="input" required id="producto" pattern="[0-9]{1,25}"  maxlength="40" name="producto_stock" value="<?php echo $datos['producto_stock'];?>">
                      <span class="icon is-small is-left">
                        <i class="fa-solid fa-arrow-up-wide-short"></i>
                      </span>
                    </div>
                  </div>
                </div>
                <div class="column is-half">
                  <div class="field">
                    <label for="producto_categoria" class="subtitle is-12 has-text-weight-bold has-text-black">Categoría</label><br>
                    <div class="select is-rounded" >
                        <select name="producto_categoria" id="producto_categoria">
                            <option value="">Seleccione una opción</option>
                            <?php
                                $datos_categorias = conexion();
                                $datos_categorias = $datos_categorias->query("SELECT * FROM categoria");
                                if($datos_categorias->rowCount()>0 ){
                                    $datos_categorias = $datos_categorias->fetchAll();
                                    foreach($datos_categorias as $rows){
                                        if($rows['categoria_id'] == $datos["categoria_id"]){
                                            echo '<option selected value="'.$rows['categoria_id'].'" >'.$rows['categoria_nombre'].'</option>';
                                        }
                                        else{
                                            echo '<option value="'.$rows['categoria_id'].'" >'.$rows['categoria_nombre'].'</option>';
                                        }

                                    }
                                    
                                }
                               $datos_categorias=null;   
                            ?>
                        </select>
                    </div>
                  </div>
                </div>
                <div class="column is-full">
                  <div class="field">
                    <label for="producto_proveedor" class="subtitle is-12 has-text-weight-bold has-text-black">Proveedor</label><br>
                    <div class="select is-rounded" >
                        <select name="producto_proveedor" id="producto_proveedor">
                            <option value="" >Seleccione una opción</option>
                            <?php
       
                                $datos_categorias = conexion();
                                $datos_categorias = $datos_categorias->query("SELECT * FROM proveedor");
                                if($datos_categorias->rowCount()>0 ){
                                    $datos_categorias = $datos_categorias->fetchAll();
                                    foreach($datos_categorias as $rows){
                                        if($rows['proveedor_id'] == $datos["proveedor_id"]){
                                            echo '<option selected value="'.$rows['proveedor_id'].'" >'.$rows['proveedor_nombre'].'</option>';
                                        }
                                        else{
                                            echo '<option value="'.$rows['proveedor_id'].'" >'.$rows['proveedor_nombre'].'</option>';
                                        }

                                    }                                   
                                }
                               $datos_categorias=null;   
                            ?>
                        </select>
                    </div>
                  </div>
                </div>
                <div class="column is-half">     
                  <div class="field">
                    <label class="subtitle is-12 has-text-weight-bold has-text-black">Foto o imagen del producto</label><br>
                  </div>
                  <div class="file is-black has-name mb-1">
                    <label class="file-label">
                        <input id="fileInput" class="file-input" type="file" name="producto_foto" accept=".jpg, .png, .jpeg">
                        <span class="file-cta">
                        <span class="file-icon">
                            <i class="fas fa-upload"></i>
                        </span>
                        <span class="file-label">Imagen</span>
                        </span>
                        <span class="file-name">JPG, JPEG, PNG. (MAX 10MB)</span>
                        
                    </label>   
                  </div>
                  <p id="fileName" class="has-text-black is-small-label is-small is-size-12">El nombre de la Imagen sera Igual al nombre del Producto</p>
                </div>
                <?php 
                    $url_img = "./img/productos/".$datos['producto_foto'];
                    if(!file_exists("./img/productos/".$datos['producto_foto']) || empty($datos['producto_foto'])){
                        $url_img = "./img/producto.png";
                    }                   
                    echo '
                        <div class="column is-half">                          
                            <p class="file-label has-text-black">Previsualizacion de Imagen</p>
                            <figure class="media-left id="imagePreviewContainer">
                                <p class="image is-128x128">
                                    <img id="imagePreview" src="'.$url_img.'">
                                </p>
                            </figure>
                        </div>
                    ';
                ?>
              </div>
              <div class="columns">
                <div class="column has-text-centered">
                    <button type="submit" class="button is-warning is-large is-responsive" name="Enviar">Guardar</button>
                </div>
                <div class="field" style="position: absolute; top: 12px; left: 0;">
                    <a href="#" class="button is-link is-responsive btn-back" name="IrLogin">
                        <i class="fas fa-arrow-left" style="margin-right: 7px;"></i>Regresar atrás
                    </a>
                </div>
                
                <?php include "inc/btn_back.php" ?>
              </div>
              <div class="field">
                <p id = "resultado" class="subtitle container is-fluid"></p>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>
<?php 
  }else{
    echo '<div class="column notification is-danger my-2">
            <strong>¡Ocurrio un error inesperado!</strong><br>
            No podemos obtener la información solicitada
          </div> ';
  }
  $check_producto = null;
?>

<div id="myModal" class="modal-css">
    <div class="modal-content-css">
        <span class="close-css" onclick="closeModal()">&times;</span>
        <p style="color:black">¿Estás seguro de que quieres enviar el formulario?</p>
        <button class="btn btn-confirm" onclick="submitForm()">Sí</button>
        <button class="btn btn-cancel" onclick="closeModal()">No</button>
    </div>
</div>
