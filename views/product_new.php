<div class = "background-image" style="height: 100%;min-height: 100vh;">
  <div class="box is-inline-block has-background-link-95 ml-3 mb-3 mt-2 p-4"  >
    <h1 class="title is-4 has-text-black has-text-centered">Producto</h1>
    <h2 class="subtitle has-text-black has-text-centered">Nuevo Productos</h2>
  </div>
  <section class="hero ">

    <?php
        require_once "php/main.php";
        $conexion = conexion();
        $datos_categorias = $conexion->query("SELECT categoria_nombre FROM categoria");
        $datos_categorias = $datos_categorias->fetchAll();
        $cont=0;
    ?>

    <div class="hero-body" style="flex-grow:0; padding-top: 0;padding-bottom: 10px;">
      <div class="container">
        <div class="columns is-centered">
          <div class="column is-three-quarters-desktopis-two-thirds-tablet">

            <form action="./php/producto_guardar.php" class="FormularioAjax box has-background-link-light" autocomplete="off" method="POST" id="myForm" onsubmit="return confirmSubmit()" data-confirm="true" enctype="multipart/form-data">

              <div class="title has-text-centered is-size-2 has-text-black">Nuevo producto</div>
              <div class="columns is-multiline  ">
                <div class="column is-half">
                  <div class="field">
                    <label for="nombre" class="subtitle is-12 has-text-weight-bold has-text-black">Nombre</label>
                    <div class="control has-icons-left">
                      <input type="text" class="input" required id="nombre" maxlength="40" name="producto_nombre">
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
                      <input type="number" class="input" required id="precio" pattern="[0-9]{1,25}" step="0.01"  maxlength="40" name="producto_precio">
                      <span class="icon is-small is-left">
                        <i class="fa-solid fa-dollar-sign"></i>
                      </span>
                    </div>
                    <p class="help is-success">Nota: para indicar el comienzo de decimales utilice el signo de punto (ejemplo: 123.45)</p>
                  </div>
                </div>
                <div class="column is-half">
                  <div class="field">
                    <label for="producto" class="subtitle is-12 has-text-weight-bold has-text-black">Cantidad (Inventario Total)</label>
                    <div class="control has-icons-left">
                      <input type="number" class="input" required id="producto" pattern="[0-9]{1,25}"  maxlength="40" name="producto_stock">
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
                            <option value="" selected="" >Seleccione una opción</option>
                            <?php
                                $datos_categorias = conexion();
                                $datos_categorias = $datos_categorias->query("SELECT * FROM categoria");
                                if($datos_categorias->rowCount()>0){
                                    $datos_categorias = $datos_categorias->fetchAll();
                                    foreach($datos_categorias as $rows){
                                        $cont++;
                                        echo '<option value="'.$rows['categoria_id'].'" >'.$rows['categoria_nombre'].'</option>';
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
                    <label for="producto_categoria" class="subtitle is-12 has-text-weight-bold has-text-black">Proveedor</label><br>
                    <div class="select is-rounded" >
                        <select name="producto_proveedor" id="producto_categoria">
                            <option value="" selected="" >Seleccione una opción</option>
                            <?php
                                $datos_categorias = conexion();
                                $datos_categorias = $datos_categorias->query("SELECT proveedor_nombre, proveedor_id FROM proveedor");
                                if($datos_categorias->rowCount()>0){
                                    $datos_categorias = $datos_categorias->fetchAll();
                                    foreach($datos_categorias as $rows){
                                        $cont++;
                                        echo '<option value="'.$rows['proveedor_id'].'" >'.$rows['proveedor_nombre'].'</option>';
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
                        <input class="file-input" type="file" id="fileInput" name="producto_foto" accept=".jpg, .png, .jpeg">
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
                <div class="column is-half">
                    <p class="file-label has-text-black">Previsualizacion de Imagen</p>
                    <figure class="media-left" id="imagePreviewContainer" style="display: none;">
                        <p class="image is-128x128">
                            <img id="imagePreview" alt="Previsualización de la imagen">
                        </p>
                    </figure>
                </div>
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
              <div class="columns">
                <div class="column has-text-centered">
                    <a href="index.php?view=product_new" class="button is-link is-small is-responsive">Nuevo Producto</a>
                </div>
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


<div id="myModal" class="modal-css">
    <div class="modal-content-css">
        <span class="close-css" onclick="closeModal()">&times;</span>
        <p style="color:black">¿Estás seguro de que quieres enviar el formulario?</p>
        <button class="btn btn-confirm" onclick="submitForm()">Sí</button>
        <button class="btn btn-cancel" onclick="closeModal()">No</button>
    </div>
</div>
