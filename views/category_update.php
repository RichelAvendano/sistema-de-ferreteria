<?php 

  require_once "php/main.php";

  $id = (isset($_GET['category_id_up'])) ? $_GET['category_id_up'] : 0 ;
  $id = limpiar_cadena($id);
  $check_categoria = conexion();
  $check_categoria = $check_categoria->query("SELECT * FROM categoria WHERE categoria_id = '$id'");

  if($check_categoria->rowCount()>0){
    $datos = $check_categoria->fetch();


  ?>
<div class=" background-image" style="height:100%;min-height: 100vh;">
  <div class="box is-inline-block has-background-link-95 ml-3 mb-0 mt-2 p-4"  >
    <h1 class="title is-4 has-text-black has-text-centered">Categoria</h1>
    <h2 class="subtitle has-text-black has-text-centered">Actualizar Categoria</h2>
  </div>
  <section class="hero " >
    <div class="hero-body pt-5 pb-2">
      <div class="container">
        <div class="columns is-centered">
          <div class="column is-three-quarters-desktopis-two-thirds-tablet">

            <form action="php/categoria_actualizar.php" class="FormularioAjax box has-background-link-light" autocomplete="off" method="POST" id="myForm" onsubmit="return confirmSubmit()" data-confirm="true">
              <input type="hidden" value="<?php echo $datos['categoria_id'];?>" name="categoria_id" required >

              <div class="title has-text-centered is-size-2 has-text-weight-bold has-text-black">Actualizar Datos</div>
              <div class="columns is-multiline">
                <div class="column is-half">
                  <div class="field">
                    <label for="nombre" class="subtitle is-12 has-text-weight-bold has-text-black">Categoria</label>
                    <div class="control has-icons-left">
                      <input type="text" class="input" value="<?php echo $datos['categoria_nombre'];?>" required id="nombre" maxlength="40" name="categoria_nombre">
                      <span class="icon is-small is-left">
                        <i class="fas fa-user"></i>
                      </span>
                    </div>
                  </div>
                </div>
                <div class="column is-half">
                  <div class="field">
                    <label for="apellidos" class="subtitle is-12 has-text-weight-bold has-text-black">Ubicacion</label>
                    <div class="control has-icons-left">
                      <input type="text" class="input" value="<?php echo $datos['categoria_ubicacion'];?>" id="ubicacion" maxlength="40" name="categoria_ubicacion">
                      <span class="icon is-small is-left">
                        <i class="fas fa-user"></i>
                      </span>
                    </div>
                  </div>
                </div>   
              <div class="field px-2 pb-4" style="width:100%;margin:0">
                <p id = "resultado" class="subtitle container is-fluid"></p>    
              </div>        
              
              </div>
              <div class="field">
                <div class="control has-text-centered">
                  <button type="submit" class="button is-warning is-medium is-responsive" name="Enviar">Actualizar</button>
                
                </div>
              </div>
              <div class="field" style="position: absolute; top: 12px; left: 0;">
                  <a href="#" class="button is-link is-responsive btn-back" name="IrLogin">
                      <i class="fas fa-arrow-left" style="margin-right: 7px;"></i>Regresar atrás
                  </a>
              </div>
              <?php include "inc/btn_back.php" ?>
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
            Esa Categoria no existe, vaya hacia atras
          </div> 
          <div class="field">
            <div class="control has-text-centered">
                <div class="field" style="position: absolute; top: 0; left: 0;">
                    <a href="#" class="button is-link is-responsive btn-back" name="IrLogin">
                        <i class="fas fa-arrow-left" style="margin-right: 7px;"></i>Regresar atrás
                    </a>
                </div>
            </div>
            </div>
              ';
    include "inc/btn_back.php";
  }
  $check_categoria = null;
?>
<div id="myModal" class="modal-css">
    <div class="modal-content-css">
        <span class="close-css" onclick="closeModal()">&times;</span>
        <p style="color:black">¿Estás seguro de que quieres enviar el formulario?</p>
        <button class="btn btn-confirm" onclick="submitForm()">Sí</button>
        <button class="btn btn-cancel" onclick="closeModal()">No</button>
    </div>
</div>
